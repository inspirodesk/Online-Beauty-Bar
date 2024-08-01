<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class AboutUsSeeder extends Seeder
{
    public function run()
    {
        $aboutUsContent = "Welcome to our website! We are dedicated to providing high-quality services...";

        Page::create([
            'title' => 'About Us',
            'content' => $aboutUsContent,
            'status' => 'published', // Adjust status as needed
            'author' => 'Admin', // Replace with the author's name
        ]);
    }
}
