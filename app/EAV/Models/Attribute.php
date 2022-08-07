<?php

namespace App\EAV\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\EAV\Models\Attribute
 *
 * @property int $id
 * @property string $name
 * @property string $model
 * @property string $slug
 * @property string $type
 * @property string $settings
 * @property string|null $external_id
 * @property int $sort
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereExternalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Attribute extends Model
{
    use HasFactory;

    /**
     * An array to map class names to their type names in database.
     *
     * @var array
     */
    protected static $typeMap = [
        'varchar' => Rinvex\Attributes\Models\Type\Varchar::class,
    ];

    protected $fillable = ['name', 'slug', 'model'];

    /**
     * Get the model associated with a custom attribute type.
     *
     * @param string $alias
     *
     * @return string|null
     */
    public static function getTypeModel($alias)
    {
        return self::$typeMap[$alias] ?? null;
    }
}
