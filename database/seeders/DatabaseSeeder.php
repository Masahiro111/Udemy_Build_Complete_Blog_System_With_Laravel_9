<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Role;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $role1 = Role::query()->create([
            'name' => 'user',
        ]);

        $role2 = Role::query()->create([
            'name' => 'author',
        ]);

        $role3 = Role::query()->create([
            'name' => 'admin',
        ]);

        $tag1 = Tag::query()->create([
            'name' => 'php',
        ]);

        $tag2 = Tag::query()->create([
            'name' => 'c++',
        ]);

        $tag3 = Tag::query()->create([
            'name' => 'ruby',
        ]);

        $user = $role2->users()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'status' => 1,
        ]);

        $category = Category::create([
            'name' => 'Education',
            'slug' => 'education',
            'user_id' => $user->id,
        ]);

        $post = $user->posts()->create([
            'title' => 'This is title',
            'slug' => 'This is slug',
            'excerpt' => 'This is excerpt',
            'body' => 'This is content',
            'category_id' => 1,
        ]);

        $post->comments()->create([
            'the_comment' => '1st subaru',
            'user_id' => $user->id,
        ]);

        $post->comments()->create([
            'the_comment' => '2st subaru',
            'user_id' => $user->id,
        ]);

        $post->image()->create([
            'name' => 'post file',
            'extension' => 'jpg',
            'path' => 'images/' . rand(0, 10) . '.jpg',
        ]);

        $user->image()->create([
            'name' => 'user file',
            'extension' => 'jpg',
            'path' => 'images/' . rand(0, 10) . '.jpg',
        ]);

        $post->tags()->attach([
            $tag1->id, $tag2->id, $tag3->id
        ]);
    }
}
