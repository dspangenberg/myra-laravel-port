<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $gender
 * @property int $is_hidden
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Salutation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Salutation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Salutation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Salutation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salutation whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salutation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salutation whereIsHidden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salutation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salutation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Salutation extends Model
{
    protected $fillable = [
      'name',
      'gender',
      'is_hidden'
    ];
}
