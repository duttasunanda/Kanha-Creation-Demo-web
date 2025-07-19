<?php

namespace App\Http\Controllers;

require_once __DIR__ . '/../../../bootstrap/helpers.php';

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     */
    public function index(): View
    {
        $cartItems = auth()->user()->cartItems()
            ->with(['product.images', 'product.category'])
            ->get();

        $cartTotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        $cartQuantity = $cartItems->sum('quantity');

        return view('cart.index', compact('cartItems', 'cartTotal', 'cartQuantity'));
    }

    /**
     * Add product to cart.
     */
    public function add(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1|max:10'
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->input('quantity', 1);

        // Check if product is in stock
        if (!$product->in_stock || ($product->manage_stock && $product->stock_quantity < $quantity)) {
            return back()->with('error', 'Product is out of stock.');
        }

        // Check if item already exists in cart
        $cartItem = CartItem::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
            
            // Check stock limit
            if ($product->manage_stock && $product->stock_quantity < $newQuantity) {
                return back()->with('error', 'Not enough stock available.');
            }
            
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            CartItem::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price_for_display,
            ]);
        }

        return back()->with('success', 'Product added to cart successfully!');
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        // Ensure the cart item belongs to the authenticated user
        if ($cartItem->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $quantity = $request->input('quantity');
        $product = $cartItem->product;

        // Check stock availability
        if ($product->manage_stock && $product->stock_quantity < $quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cartItem->update(['quantity' => $quantity]);

        return back()->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove item from cart.
     */
    public function remove(CartItem $cartItem): RedirectResponse
    {
        // Ensure the cart item belongs to the authenticated user
        if ($cartItem->user_id !== auth()->id()) {
            abort(403);
        }

        $cartItem->delete();

        return back()->with('success', 'Item removed from cart!');
    }

    /**
     * Clear all items from cart.
     */
    public function clear(): RedirectResponse
    {
        CartItem::where('user_id', auth()->id())->delete();

        return back()->with('success', 'Cart cleared successfully!');
    }

    /**
     * Get cart count via AJAX.
     */
    public function count()
    {
        $count = CartItem::where('user_id', auth()->id())->sum('quantity');
        
        return response()->json(['count' => $count]);
    }
}
