<?php

namespace App\Http\Resources;

use App\Models\BookkeepingRule;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin BookkeepingRule */ class BookkeepingRuleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'priority' => $this->priority,
            'logical_operator' => $this->logical_operator,
            'table' => $this->table,
            'is_active' => $this->is_active,
            'action_type' => $this->action_type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'rules' => BookkeepingRuleConditionResource::collection($this->whenLoaded('rules')),
            'actions' => BookkeepingRuleActionResource::collection($this->whenLoaded('actions')),
        ];
    }
}
