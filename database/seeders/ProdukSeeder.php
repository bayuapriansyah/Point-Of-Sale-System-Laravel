<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Products;
use Faker\Factory as Faker;


class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 1; $i <= 10; $i++) {
            Products::create([
                'nama_produk' => $faker->word(),
                'kategori_id' => rand(1, 5),
                'harga_jual' => $faker->numberBetween(10000, 100000),
                'harga_beli' => $faker->numberBetween(5000, 90000),
                'stok' => $faker->numberBetween(10, 100),
                'stok_minimal' => $faker->numberBetween(1, 10),
                'is_active' => $faker->boolean(),
                'sku' => strtoupper($faker->bothify('???-########')),
            ]);
        }
    }
}
