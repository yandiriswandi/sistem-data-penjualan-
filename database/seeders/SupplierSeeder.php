<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            ["name" => "Teti Sudarti", "email" => "tetisudarti@gmail.com", "phone" => "0850951393322", "address" => "jalan cibungkul"],
            ["name" => "Rina Munisa", "email" => "rinamunisa@gmail.com", "phone" => "086578908900", "address" => "jalan maribaya"],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
