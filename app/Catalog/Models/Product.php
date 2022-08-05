<?php

namespace App\Catalog\Models;

use Illuminate\Database\Eloquent\Model;
use SertxuDeveloper\Media\HasMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * App\Catalog\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $external_id
 * @property string $description
 * @property int $preview_image_id
 * @property int $detail_picture_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDetailPictureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereExternalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePreviewImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $sort
 * @property-read \Illuminate\Database\Eloquent\Collection|\SertxuDeveloper\Media\Media[] $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSort($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Properties\Value[] $values
 * @property-read int|null $values_count
 */
class Product extends Model
{
    use HasSlug, HasMedia;

    protected $table = 'catalog_products';

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
