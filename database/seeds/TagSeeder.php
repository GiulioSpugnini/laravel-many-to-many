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
        $tag_names = ['Front-end', 'Back-end', 'Full-stack', 'Designer', 'Admin'];
        foreach ($tag_names as $name) {
            $newTag = new Tag();
            $newTag->label = $name;
            $newTag->color = $faker->hexColor();
            $newTag->save();
        }
    }
}
