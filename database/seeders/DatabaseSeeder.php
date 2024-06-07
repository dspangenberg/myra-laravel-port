<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $count = User::count();

        if ($count === 0) {
            User::factory()->create([
                'last_name' => 'Spangenberg',
                'first_name' => 'Danny',
                'email' => 'test@example.com',
            ]);
        }

        $this->call([
            AddressCategorySeeder::class,
            CountrySeeder::class,
            EmailCategorySeeder::class,
            PhoneCategorySeeder::class,
            ProjectCategorySeeder::class,
            SalutationSeeder::class,
            TaxSeeder::class,
            TimeCategorySeeder::class,
            TitleSeeder::class,
        ]);
    }
}
