<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $currency_code
 * @property int $year
 * @property int $month
 * @property float $rate
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ConversionRate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConversionRate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConversionRate query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConversionRate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConversionRate whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConversionRate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConversionRate whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConversionRate whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConversionRate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConversionRate whereYear($value)
 * @mixin \Eloquent
 */
class ConversionRate extends Model
{
    use HasFactory;
}
