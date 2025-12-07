<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'category_id',
        'name',
        'slug',
        'description',
        'short_description',
        'sku',
        'price',
        'sale_price',
        'stock_quantity',
        'manage_stock',
        'stock_status',
        'weight',
        'dimensions',
        'attributes',
        'is_featured',
        'is_digital',
        'status',
        'average_rating',
        'review_count',
        'view_count',
        'sales_count',
        'seo',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'weight' => 'decimal:2',
            'average_rating' => 'decimal:2',
            'manage_stock' => 'boolean',
            'is_featured' => 'boolean',
            'is_digital' => 'boolean',
            'attributes' => 'array',
            'seo' => 'array',
            'stock_quantity' => 'integer',
            'review_count' => 'integer',
            'view_count' => 'integer',
            'sales_count' => 'integer',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            if (empty($product->sku)) {
                $product->sku = 'SKU-' . strtoupper(Str::random(8));
            }
        });
    }

    // Relationships
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Helper methods
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isArchived(): bool
    {
        return $this->status === 'archived';
    }

    public function isInStock(): bool
    {
        return $this->stock_status === 'in_stock' && (!$this->manage_stock || $this->stock_quantity > 0);
    }

    public function isOnSale(): bool
    {
        return $this->sale_price !== null && $this->sale_price < $this->price;
    }

    public function getCurrentPrice(): float
    {
        return $this->isOnSale() ? $this->sale_price : $this->price;
    }

    public function getDiscountPercentage(): int
    {
        if (!$this->isOnSale()) {
            return 0;
        }
        return round((($this->price - $this->sale_price) / $this->price) * 100);
    }

    public function getMainImage(): ?string
    {
        return $this->images[0] ?? null;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    

}
