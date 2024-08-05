<?php

namespace App\Http\Resources;

use App\Models\BookkeepingRuleAction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin BookkeepingRuleAction */ class BookkeepingRuleActionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'bookkeeping_rule_id' => $this->bookkeeping_rule_id,
            'priority' => $this->priority,
            'field' => $this->field,
            'value' => $this->value,
        ];
    }
}
