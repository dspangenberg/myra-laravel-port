<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|ContactAddress newModelQuery()
 * @method static Builder|ContactAddress newQuery()
 * @method static Builder|ContactAddress query()
 * @method static Builder|ContactAddress whereAddress($value)
 * @method static Builder|ContactAddress whereAddressCategoryId($value)
 * @method static Builder|ContactAddress whereCity($value)
 * @method static Builder|ContactAddress whereContactId($value)
 * @method static Builder|ContactAddress whereCountryId($value)
 * @method static Builder|ContactAddress whereCreatedAt($value)
 * @method static Builder|ContactAddress whereId($value)
 * @method static Builder|ContactAddress whereUpdatedAt($value)
 * @method static Builder|ContactAddress whereZip($value)
 * @mixin Eloquent
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
