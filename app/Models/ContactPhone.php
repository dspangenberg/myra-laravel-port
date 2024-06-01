<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $contact_id
 * @property int $phone_category_id
 * @property int $pos
 * @property string $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPhone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPhone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPhone query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPhone whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPhone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPhone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPhone wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPhone wherePhoneCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPhone wherePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPhone whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ContactPhone extends Model
{
    protected $fillable = [
      'contact_id',
      'phone_category_id',
      'pos',
      'phone'
    ];
}
