<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HelpersTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTheExcerptStringMatches()
    {
    	$text = "The quick brown fox jumps over the lazy dog.";

    	$excerpt = \App\Helpers\Helpers::excerpt($text, 20);

        $this->assertEquals('The quick brown fox ...', $excerpt);
    }
}
