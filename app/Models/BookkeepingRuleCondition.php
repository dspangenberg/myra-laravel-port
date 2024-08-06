<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @property int $id
 * @property int $bookkeeping_rule_id
 * @property int $priority
 * @property string $table
 * @property string $field
 * @property string $logical_condition
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRuleCondition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRuleCondition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRuleCondition onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRuleCondition query()
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRuleCondition whereBookkeepingRuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRuleCondition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRuleCondition whereField($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRuleCondition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRuleCondition whereLogicalCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRuleCondition wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRuleCondition whereTable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRuleCondition whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRuleCondition whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRuleCondition withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingRuleCondition withoutTrashed()
 * @mixin \Eloquent
 */
class BookkeepingRuleCondition extends Model
{
    use SoftDeletes;
}
