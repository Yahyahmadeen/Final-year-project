<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'path', 'is_primary', 'alt_text', 'sort_order'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the URL for the image
     *
     * @param string $size The size variant of the image (e.g., 'thumb', 'large')
     * @return string
     */
    public function getUrl($size = '')
    {
        if (empty($this->path)) {
            return asset('images/placeholder.jpg');
        }

        // If size is specified, check if the sized version exists
        if (!empty($size)) {
            $pathInfo = pathinfo($this->path);
            $sizedPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . "_{$size}." . $pathInfo['extension'];
            
            if (Storage::exists($sizedPath)) {
                return Storage::url($sizedPath);
            }
        }

        // Return the original path if no size specified or sized version doesn't exist
        return Storage::url($this->path);
    }
}

