<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $days
 * @property int $is_immediately
 * @property int $is_default
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDeadline newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDeadline newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDeadline query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDeadline whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDeadline whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDeadline whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDeadline whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDeadline whereIsImmediately($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDeadline whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDeadline whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PaymentDeadline extends Model
{
    protected $fillable = [
      'name',
      'days',
      'is_default',
      'is_immediately'
    ];
}
