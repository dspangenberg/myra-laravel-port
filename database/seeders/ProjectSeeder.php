<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::truncate();
        $projects = Storage::disk('private')->json('projects.json');
        foreach ($projects as $key => $value) {
            Project::create([
                'id' => $value['id'],
                'name' => $value['name'],
                'owner_contact_id' => $value['owner_contact_id'] ?: 0,
                'lead_user_id' => $value['lead_user_id'] ?: 0,
                'manager_contact_id' => $value['manager_contact_id'] ?: 0,
                'invoice_contact_id' => $value['invoice_contact_id'] ?: 0,
                'project_category_id' => $value['project_category_id'] ?: 0,
                'parent_project_id' => $value['parent_project_id'] ?: 0,
                'is_archived' => $value['is_archived'],
                'begin_on' => $value['begin_on'],
                'end_on' => $value['end_on'],
                'hourly' => $value['hourly'] ?: 0,
                'budget_hours' => $value['budget_hours'] ?: 0,
                'budget_costs' => $value['budget_costs'] ?: 0,
                'budget_period' => $value['budget_period'] ?: '',
                'website' => $value['website'] ?: '',
                'avatar' => $value['avatar'] ?: '{}',
                'note' => $value['note'] ?: '',
            ]);
        }
    }
}
