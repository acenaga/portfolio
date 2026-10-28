<?php

namespace Database\Seeders;

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
            AdminUserSeeder::class,
            SiteStatSeeder::class,
            StackSeeder::class,
            CourseSeeder::class,
            ProjectSeeder::class,
            VideoSeeder::class,
            SocialLinkSeeder::class,
        ]);
    }
}
