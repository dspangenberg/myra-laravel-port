<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $priority
 * @property string $logical_operator
 * @property string $table
 * @property int $is_active
 * @property string $action_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BookkeepingRuleAction> $actions
 * @property-read int|null $actions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BookkeepingRuleCondition> $conditions
 * @property-read int|null $conditions_count
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRule onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRule query()
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRule whereActionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRule whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRule whereLogicalOperator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRule whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRule wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRule whereTable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRule withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRule withoutTrashed()
 * @mixin \Eloquent
 */
class BookkeepingRule extends Model
{
    use SoftDeletes;

    public function conditions(): HasMany
    {
        return $this->hasMany(BookkeepingRuleCondition::class, 'bookkeeping_rule_id', 'id');
    }

    public function actions(): HasMany
    {
        return $this->hasMany(BookkeepingRuleAction::class, 'bookkeeping_rule_id', 'id');
    }
}
