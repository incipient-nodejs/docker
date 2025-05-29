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
        $this->call([
            UserTypeSeeder::class,
            UserSeeder::class,
            PermissionSeeder::class,
            CategorySeeder::class,
            FormalTypeSeeder::class,
            InformalTypeSeeder::class,
            ProductSeeder::class,
            ServiceSeeder::class,
            ApiTypeSeeder::class,
            ApiFieldSeeder::class,
            ApiEndpointSeeder::class,
            ApiEndpointFieldSeeder::class,

            PersonalDataSeeder::class,
            CompanyDataSeeder::class,
            BusinessDetailSeeder::class,
            WebsiteSeeder::class,
            CommentSeeder::class,
            BannerSeeder::class
        ]);
    }
}
