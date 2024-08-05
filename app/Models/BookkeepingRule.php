<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
