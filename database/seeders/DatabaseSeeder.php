<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Создаем теги
        $tags = Tag::factory(10)->create();

        // Создаем статьи с связанными данными
        Article::factory(20)
            ->create()
            ->each(function ($article) use ($tags) {

                // Привязываем случайные теги к статье
                $article->tags()->attach(
                    $tags->random(rand(1, 3))->pluck('id')->toArray()
                );

                // Создаем лайки для статьи
                $article->likes()->create([
                    'count' => rand(0, 1000)
                ]);

                // Создаем просмотры для статьи
                $article->views()->create([
                    'count' => rand(0, 5000)
                ]);

                // Создаем корневые комментарии
                Comment::factory(rand(1, 5))
                    ->create([
                        'article_id' => $article->id,
                        'parent_id' => null
                    ])
                    ->each(function ($comment) {
                        // Создаем ответы на комментарии
                        Comment::factory(rand(0, 3))
                            ->create([
                                'article_id' => $comment->article_id,
                                'parent_id' => $comment->id
                            ]);
                    });
            });
    }
}
