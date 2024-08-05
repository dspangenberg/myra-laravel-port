<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property int $is_grouped_by_contact
 * @property int $is_grouped_by_year
 * @property int $is_grouped_by_month
 * @property int $is_default
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereIsGroupedByContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereIsGroupedByMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereIsGroupedByYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder withoutTrashed()
 * @property string $path
 * @property string $path_structure
 * @property string $file_name_structure
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereFileNameStructure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder wherePathStructure($value)
 * @mixin \Eloquent
 */
class DocumentFolder extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'parent_id',
        'name',
        'is_grouped_by_contact',
        'is_grouped_by_year',
        'is_grouped_by_month',
        'is_default',
    ];
}
