<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Product extends Model
{
    use HasFactory;

    /**
     * Override fillable property data.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'expiration_date',
        'image',
        'category_id',
        'user_id',
    ];

    /**
     * User
     *
     * Get User Uploaded By Product
     *
     * @return object
     */
    public function user(): object
    {
        return $this->belongsTo(User::class)->select('id', 'name', 'email');
    }

    /**
     * Category
     *
     * Get the category of the product
     *
     * @return object
     */
    public function category(): object
    {
        return $this->belongsTo(Category::class);
    }

    // Add New Attribute to get image address
    protected $appends = ['image_url'];

    /**
     * Get Added Image Attribute URL.
     *
     * @return string|null
     */
    public function getImageUrlAttribute(): ?string
    {
        if (is_null($this->image) || $this->image === "") {
            return null;
        }

        return URL::to('/images/products/' . $this->image);
    }

    /**
     * Override the boot method to add default values.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            // Ensure the expiration_date is not before today
            if ($product->expiration_date < now()->toDateString()) {
                throw new \Exception("The expiration date cannot be in the past.");
            }
        });
    }
}
