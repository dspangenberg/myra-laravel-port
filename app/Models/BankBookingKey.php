<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BankBookingKey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankBookingKey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankBookingKey query()
 * @method static \Illuminate\Database\Eloquent\Builder|BankBookingKey whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankBookingKey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankBookingKey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankBookingKey whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankBookingKey whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BankBookingKey extends Model
{
    protected $fillable = [
        'name',
        'code',
    ];
}
