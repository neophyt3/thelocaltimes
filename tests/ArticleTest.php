<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ArticleTest extends TestCase
{
	use DatabaseTransactions;

    public function testArticleIsInsertedIntoDatabse()
    {
       	$user_demo = factory(App\Models\User::class, 1)->make();
    				$user_demo->save();

    	$article_demo = factory(App\Models\Article::class, 1)->make();
    	$article_demo->slug = str_slug($article_demo->title);
    	$article_demo->excerpt = \App\Helpers\Helpers::excerpt($article_demo->article_body,100);

    	$user_demo->articles()->save($article_demo);

        $this->seeInDatabase('articles', ['slug' => $article_demo->slug]);
    }

}
