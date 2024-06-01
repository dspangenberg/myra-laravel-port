<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $short_name
 * @property int $pos
 * @property int $is_default
 * @property string $hourly
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TimeCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TimeCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TimeCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|TimeCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeCategory whereHourly($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeCategory whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeCategory wherePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeCategory whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TimeCategory extends Model
{
    protected $fillable = [
      'name',
      'short_name',
      'pos',
      'is_default',
      'hourly'
    ];
}
