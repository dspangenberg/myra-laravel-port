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
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneCategory whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PhoneCategory extends Model
{

    protected $fillable = [
      'name',
      'type'
    ];
}
