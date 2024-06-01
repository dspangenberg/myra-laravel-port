<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $correspondence_salutation_male
 * @property string $correspondence_salutation_female
 * @property string $correspondence_salutation_other
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Title newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Title newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Title query()
 * @method static \Illuminate\Database\Eloquent\Builder|Title whereCorrespondenceSalutationFemale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Title whereCorrespondenceSalutationMale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Title whereCorrespondenceSalutationOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Title whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Title whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Title whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Title whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Title extends Model
{
    protected $fillable = [
      'name',
      'correspondence_salutation_male',
      'correspondence_salutation_female',
      'correspondence_salutation_other'
    ];
}
