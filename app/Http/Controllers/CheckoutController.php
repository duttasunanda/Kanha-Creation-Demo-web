<?php

namespace App\Http\Controllers;

require_once __DIR__ . '/../../../bootstrap/helpers.php';

use App\Models\Address;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function index(): View
    {
        $cartItems = auth()->user()->cartItems()
            ->with(['product.images', 'product.category'])
            ->get();

        if ($cartItems->isEmpty()) {
            // Instead of redirect, show the checkout page with an error message
            $subtotal = 0;
            $taxAmount = 0;
            $shippingAmount = 0;
            $total = 0;
            $addresses = auth()->user()->addresses()->get();
            $error = 'Your cart is empty.';
            return view('checkout.index', compact(
                'cartItems', 
                'subtotal', 
                'taxAmount', 
                'shippingAmount', 
                'total',
                'addresses',
                'error'
            ));
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        $taxRate = 0.18; // 18% GST
        $taxAmount = $subtotal * $taxRate;
        $shippingAmount = $subtotal > 5000 ? 0 : 200; // Free shipping above ₹5000
        $total = $subtotal + $taxAmount + $shippingAmount;

        $addresses = auth()->user()->addresses()->get();

        return view('checkout.index', compact(
            'cartItems', 
            'subtotal', 
            'taxAmount', 
            'shippingAmount', 
            'total',
            'addresses'
        ));
    }

    /**
     * Process the checkout.
     */
    public function process(Request $request): RedirectResponse
    {
        $request->validate([
            'shipping_address_id' => 'required|exists:addresses,id',
            'billing_same_as_shipping' => 'boolean',
            'billing_address_id' => 'required_if:billing_same_as_shipping,false|exists:addresses,id',
            'payment_method' => 'required|in:stripe,razorpay,cod',
            'terms_accepted' => 'required|accepted',
        ]);

        $cartItems = auth()->user()->cartItems()
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        // Calculate totals
        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        $taxRate = 0.18;
        $taxAmount = $subtotal * $taxRate;
        $shippingAmount = $subtotal > 5000 ? 0 : 200;
        $total = $subtotal + $taxAmount + $shippingAmount;

        // Get addresses
        $shippingAddress = Address::findOrFail($request->shipping_address_id);
        $billingAddress = $request->billing_same_as_shipping 
            ? $shippingAddress 
            : Address::findOrFail($request->billing_address_id);

        DB::beginTransaction();

        try {
            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => $this->generateOrderNumber(),
                'status' => 'pending',
                'total_amount' => $total,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'shipping_amount' => $shippingAmount,
                'payment_status' => $request->payment_method === 'cod' ? 'pending' : 'processing',
                'payment_method' => $request->payment_method,
                'shipping_address' => $shippingAddress->toArray(),
                'billing_address' => $billingAddress->toArray(),
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'total' => $cartItem->quantity * $cartItem->price,
                ]);

                // Update product stock if managed
                if ($cartItem->product->manage_stock) {
                    $cartItem->product->decrement('stock_quantity', $cartItem->quantity);
                }
            }

            // Clear cart
            CartItem::where('user_id', auth()->id())->delete();

            DB::commit();

            // Handle payment processing
            if ($request->payment_method === 'stripe') {
                return $this->processStripePayment($order);
            } elseif ($request->payment_method === 'razorpay') {
                return $this->processRazorpayPayment($order);
            } else {
                // Cash on Delivery
                return redirect()->route('checkout.success', $order)
                    ->with('success', 'Order placed successfully! You will pay on delivery.');
            }

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Display order success page.
     */
    public function success($orderId): View
    {
        $order = Order::findOrFail($orderId);
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('checkout.success', compact('order'));
    }

    /**
     * Display order cancel page.
     */
    public function cancel(): View
    {
        return view('checkout.cancel');
    }

    /**
     * Generate unique order number.
     */
    private function generateOrderNumber(): string
    {
        return 'ORD' . date('Ymd') . rand(1000, 9999);
    }

    /**
     * Process Stripe payment.
     */
    private function processStripePayment(Order $order): RedirectResponse
    {
        // Stripe payment processing logic would go here
        // For now, we'll mark as paid and redirect to success
        
        $order->update([
            'payment_status' => 'paid',
            'status' => 'confirmed'
        ]);

        return redirect()->route('checkout.success', $order)
            ->with('success', 'Payment successful! Your order has been confirmed.');
    }

    /**
     * Process Razorpay payment.
     */
    private function processRazorpayPayment(Order $order): RedirectResponse
    {
        // Razorpay payment processing logic would go here
        // For now, we'll mark as paid and redirect to success
        
        $order->update([
            'payment_status' => 'paid',
            'status' => 'confirmed'
        ]);

        return redirect()->route('checkout.success', $order)
            ->with('success', 'Payment successful! Your order has been confirmed.');
    }
}
