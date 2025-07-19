<?php

namespace App\Models;

require_once __DIR__ . '/../../bootstrap/helpers.php';

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'sale_price',
        'sku',
        'stock_quantity',
        'manage_stock',
        'in_stock',
        'is_featured',
        'status',
        'weight',
        'dimensions',
        'category_id',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'manage_stock' => 'boolean',
        'in_stock' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the product images.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Get the cart items for the product.
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the order items for the product.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the product's main image.
     */
    public function getMainImageAttribute()
    {
        // For demo purposes, return a mock image path
        $mockImages = [
            '/images/chair-1.jpg',
            '/images/desk-1.jpg', 
            '/images/sofa-1.jpg',
            '/images/table-1.jpg',
            '/images/cabinet-1.jpg'
        ];
        
        return $mockImages[array_rand($mockImages)];
    }

    /**
     * Get the featured image URL
     */
    public function getFeaturedImageAttribute()
    {
        return $this->getMainImageAttribute();
    }

    /**
     * Get the product's sale price or regular price.
     */
    public function getPriceForDisplayAttribute()
    {
        return $this->sale_price && $this->sale_price < $this->price 
            ? $this->sale_price 
            : $this->price;
    }

    /**
     * Check if product is on sale.
     */
    public function getIsOnSaleAttribute()
    {
        return $this->sale_price && $this->sale_price < $this->price;
    }

    /**
     * Get discount percentage.
     */
    public function getDiscountPercentageAttribute()
    {
        if (!$this->is_on_sale) {
            return 0;
        }

        return round((($this->price - $this->sale_price) / $this->price) * 100);
    }

    /**
     * Scope for featured products.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for active products.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for in stock products.
     */
    public function scopeInStock($query)
    {
        return $query->where('in_stock', true);
    }
}
