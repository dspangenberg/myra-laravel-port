<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */

class UserResource extends JsonResource
{

  public function toArray(Request $request): array
  {
    return [
      'id' => $this->id,
      'first_name' => $this->first_name,
      'last_name' => $this->first_name,
      'full_name' => $this->full_name,
      'email' => $this->email,
      'avatar_url' => $this->avatar_url,
      'reverse_full_name' => $this->reverse_full_name,
      'initials' => $this->initials,
      'is_admin' => $this->is_admin,
    ];
  }
}

