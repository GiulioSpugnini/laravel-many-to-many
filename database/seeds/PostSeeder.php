<?php

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        $category_ids = Category::pluck('id')->toArray();
        for ($i = 0; $i < 20; $i++) {
            $post = new Post();
            $post->category_id = Arr::random($category_ids);
            $post->title = $faker->text(50);
            $post->content = $faker->paragraph(2, false);
            $post->image = $faker->imageUrl(250, 250);
            $post->slug = Str::slug($post->title, '-');
            $post->save();
        }
    }
}
