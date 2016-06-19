<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
	use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserIsinsertedInDatabase()
    {
    	$user_demo = factory(App\Models\User::class, 1)->make();
    	$user_demo->save();
        $this->seeInDatabase('users', ['email' => $user_demo->email]);
	}
}
