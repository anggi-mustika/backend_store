<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // $this->call(UsersTableSeeder::class);
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('barang')->insert([
                'kd_brg' => $faker->unique()->md5,
                'nm_brg' => $faker->word,
                'hrg_brg' =>  $faker->numberBetween($min = 1, $max = 1000),
                'ket_brg' =>  $faker->text,
                'jenis_brg' =>  $faker->word,
                'image' =>  $faker->text,
                'berat_brg' =>  $faker->numberBetween($min = 1, $max = 1000),
                'stok' =>  $faker->numberBetween($min = 1, $max = 50),
            ]);
        }
    }
}
