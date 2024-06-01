<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property int $project_id
 * @property int $time_category_id
 * @property int $subproject_id
 * @property int $task_id
 * @property int $user_id
 * @property int $invoice_id
 * @property string $note
 * @property string|null $begin_at
 * @property string|null $end_at
 * @property int $is_locked
 * @property int $is_billable
 * @property int $is_timer
 * @property int $minutes
 * @property string|null $dob
 * @property string|null $deleted_at
 * @property string|null $ping_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Time newModelQuery()
 * @method static Builder|Time newQuery()
 * @method static Builder|Time query()
 * @method static Builder|Time whereBeginAt($value)
 * @method static Builder|Time whereCreatedAt($value)
 * @method static Builder|Time whereDeletedAt($value)
 * @method static Builder|Time whereDob($value)
 * @method static Builder|Time whereEndAt($value)
 * @method static Builder|Time whereId($value)
 * @method static Builder|Time whereInvoiceId($value)
 * @method static Builder|Time whereIsBillable($value)
 * @method static Builder|Time whereIsLocked($value)
 * @method static Builder|Time whereIsTimer($value)
 * @method static Builder|Time whereMinutes($value)
 * @method static Builder|Time whereNote($value)
 * @method static Builder|Time wherePingAt($value)
 * @method static Builder|Time whereProjectId($value)
 * @method static Builder|Time whereSubprojectId($value)
 * @method static Builder|Time whereTaskId($value)
 * @method static Builder|Time whereTimeCategoryId($value)
 * @method static Builder|Time whereUpdatedAt($value)
 * @method static Builder|Time whereUserId($value)
 * @mixin Eloquent
 */
class Time extends Model
{
  protected $fillable = [
    'project_id',
    'time_category_id',
    'subproject_id',
    'task_id',
    'user_id',
    'invoice_id',
    'note',
    'begin_at',
    'end_at',
    'is_locked',
    'is_billable',
    'is_timer',
    'minutes',
    'dob',
    'ping_at',
    'note',
    'avatar'
  ];

  public function category(): HasOne
  {
    return $this->hasOne(TimeCategory::class, 'id', 'time_category_id');
  }

  public function user(): HasOne
  {
    return $this->hasOne(User::class, 'id', 'user_id');
  }

  public function project(): HasOne
  {
    return $this->hasOne(Project::class, 'id', 'project_id');
  }
}
