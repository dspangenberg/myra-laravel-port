<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use DateTimeInterface;

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
 * @property-read TimeCategory|null $category
 * @property-read Project|null $project
 * @property-read User|null $user
 * @method static Builder|Time withMinutes()
 * @method static Builder|Time byWeekOfYear(int $week, int $year)
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

  protected $attributes = [
    'project_id' => 0,
    'time_category_id' => 0,
    'subproject_id' => 0,
    'user_id' => 0,
    'invoice_id' => 0,
    'begin_at' => '',
    'end_at' => '',
    'note' => '',
    'minutes' => 0,
    'is_timer' => false,
    'is_locked' => false,
    'is_billable' => false,
  ];

  protected function serializeDate(DateTimeInterface $date): string
  {
    return $date->format('d.m.Y H:i');
  }
  protected function casts(): array
  {
    return [
      'is_timer' => 'boolean',
      'is_locked' => 'boolean',
      'is_billable' => 'boolean',
      'begin_at' => 'datetime',
      'end_at' => 'datetime',
    ];
  }

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

  public function scopeByWeekOfYear(Builder $query, Int $week, Int $year): void
  {
    //       query.whereRaw('WEEK(begin_at, 1) = ?', [week]).whereRaw('YEAR(begin_at)=?', [year])
    $query
      ->whereRaw('WEEK(begin_at, 1) = ? AND YEAR(begin_at) = ?', [$week, $year]);
  }
  public function scopeWithMinutes(Builder $query): void
  {
    $query
      ->select(DB::raw('*, TIMESTAMPDIFF(MINUTE, begin_at, end_at) as mins, DATE(begin_at) as ts'));
  }
}
