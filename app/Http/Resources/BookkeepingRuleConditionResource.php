<?php

namespace App\Http\Resources;

use App\Models\BookkeepingRuleCondition;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin BookkeepingRuleCondition */ class BookkeepingRuleConditionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'bookkeeping_rule_id' => $this->bookkeeping_rule_id,
            'priority' => $this->priority,
            'table' => $this->table,
            'field' => $this->field,
            'logical_condition' => $this->logical_condition,
            'value' => $this->value,
        ];
    }
}
