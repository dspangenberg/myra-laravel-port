<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

/**
 * 
 *
 * @property int $id
 * @property string $currency_code
 * @property int $year
 * @property int $month
 * @property float $rate
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|ConversionRate newModelQuery()
 * @method static Builder|ConversionRate newQuery()
 * @method static Builder|ConversionRate query()
 * @method static Builder|ConversionRate whereCreatedAt($value)
 * @method static Builder|ConversionRate whereCurrencyCode($value)
 * @method static Builder|ConversionRate whereId($value)
 * @method static Builder|ConversionRate whereMonth($value)
 * @method static Builder|ConversionRate whereRate($value)
 * @method static Builder|ConversionRate whereUpdatedAt($value)
 * @method static Builder|ConversionRate whereYear($value)
 * @mixin Eloquent
 */
class ConversionRate extends Model
{
    protected $fillable = [
        'currency_code',
        'year',
        'month',
        'rate',
    ];

    public static function convertAmountToEUR($amount, $currencyCode, $date): float
    {

        $month = Carbon::parse($date)->month;
        $year = Carbon::parse($date)->year;

        $apiKey = config('services.conversion-api.key');

        $rate = ConversionRate::query()
            ->where('currency_code', $currencyCode)
            ->where('year', $year)->where('month', $month)
            ->first();

        if (! $rate) {
            $url = "https://umsatzsteuer-umrechnungskurse.org/api/?k=$apiKey&f=json&y=$year";
            $response = Http::get($url);
            $y = collect($response->json())->get($year);
            $r = collect($y)->get(strtoupper($currencyCode));
            $rate = ConversionRate::create([
                'currency_code' => strtoupper($currencyCode),
                'year' => $year,
                'month' => $month,
                'rate' => $r[$month],
            ]);
        }

        return round($amount / $rate->rate, 2);
    }
}
