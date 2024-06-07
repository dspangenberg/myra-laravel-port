<?php

namespace Database\Seeders;

use App\Models\ProjectCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProjectCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProjectCategory::truncate();

        $categories = Storage::disk('json')->json('project_categories.json');
        foreach ($categories as $key => $value) {
            ProjectCategory::create([
                'id' => $value['id'],
                'name' => $value['name'],
                'color' => $value['color'],
                'icon' => $value['icon'],
            ]);
        }
    }
}
