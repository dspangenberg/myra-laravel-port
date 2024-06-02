<?php

namespace App\Http\Resources;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Project
 */
class ProjectResource extends JsonResource
{
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'project_category_id' => $this->project_category_id,
      'category' => $this->category,
      'owner_contact_id' => $this->owner_contact_id,
      'owner' => $this->owner,
      'lead_user_id' => $this->lead_user_id,
      'lead' => $this->lead,
    ];
  }
}
