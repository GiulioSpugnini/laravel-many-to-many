<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Tag;
use Illuminate\Support\Arr;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        //  la uso per collegare i tag ai post successivamente
        for ($i = 0; $i < 10; $i++) {
            $newTag = new Tag();
            $newTag->label = $faker->name('label');
            $newTag->color = $faker->hexColor();
            $newTag->save();
        }
    }
}
