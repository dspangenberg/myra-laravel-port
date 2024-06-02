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
 * @property int $email_category_id
 * @property int $pos
 * @property string $email
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|ContactMail newModelQuery()
 * @method static Builder|ContactMail newQuery()
 * @method static Builder|ContactMail query()
 * @method static Builder|ContactMail whereContactId($value)
 * @method static Builder|ContactMail whereCreatedAt($value)
 * @method static Builder|ContactMail whereEmail($value)
 * @method static Builder|ContactMail whereEmailCategoryId($value)
 * @method static Builder|ContactMail whereId($value)
 * @method static Builder|ContactMail wherePos($value)
 * @method static Builder|ContactMail whereUpdatedAt($value)
 * @mixin Eloquent
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
