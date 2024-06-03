<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Project;
use App\Models\TimeCategory;
use App\Models\User;

class TimeCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'projects' => Project::orderBy('name')->get()->toArray(),
            'categories' => TimeCategory::orderBy('name')->get()->toArray(),
            'users' => User::orderBy('last_name')->get()->toArray(),
        ];
    }
}
