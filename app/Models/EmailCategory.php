<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|EmailCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailCategory whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EmailCategory extends Model
{
    protected $fillable = [
      'name',
      'days',
      'is_immediately',
      'is_default',
    ];
}
