<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ["name" => "Sembako (Sembilan Bahan Pokok)"],
            ["name" => "Bumbu Dapur"],
            ["name" => "Minuman"],
            ["name" => "Makanan Ringan"],
            ["name" => "Produk Kesehatan dan Kebersihan"],
            ["name" => "Perlengkapan Rumah Tangga"],
            ["name" => "Rokok dan Tembakau"],
            ["name" => "Produk Bayi dan Anak"],
            ["name" => "Gas LPG dan Minyak Tanah"],
            ["name" => "Aneka Jajanan dan Kue Tradisional"],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
