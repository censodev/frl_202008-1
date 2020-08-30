<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;

class LandingPageItem extends Model
{
    protected $table = 'landing_items';

    protected $fillable = [
        'id_landing',
        'name',
        'type',
        'ordering',
        'images',
        'title_image',
        'alt_image',
        'images_mobile',
        'title_image_mobile',
        'alt_image_mobile',
        'description',
        'items',
        'created_by',
        'updated_by',
        'status'
    ];
}
