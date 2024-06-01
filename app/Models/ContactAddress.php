<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $contact_id
 * @property string|null $address
 * @property string $zip
 * @property string $city
 * @property int $address_category_id
 * @property int $country_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ContactAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactAddress whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactAddress whereAddressCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactAddress whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactAddress whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactAddress whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactAddress whereZip($value)
 * @mixin \Eloquent
 */
class ContactAddress extends Model
{
    protected $fillable = [
      'contact_id',
      'address',
      'zip',
      'city',
      'address_category_id',
      'country_id'
    ];
}
