<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $contact_id
 * @property int $email_category_id
 * @property int $pos
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMail query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMail whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMail whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMail whereEmailCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMail wherePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ContactMail extends Model
{
    protected $fillable = [
      'contact_id',
      'email_category_id',
      'pos',
      'email'
    ];
}
