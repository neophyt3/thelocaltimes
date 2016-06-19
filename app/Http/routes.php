<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Authentication routes...
Route::get('login', 'Auth\AuthController@showLoginForm')->name('login_form');
Route::post('login', 'Auth\AuthController@login');
Route::get('logout', 'Auth\AuthController@logout');

// Registration Routes...
Route::get('register', 'Auth\AuthController@showRegistrationForm')->name('register_form');
Route::post('register', 'Auth\AuthController@register');

// Registration Confirmation Routes...
Route::get('account-verification/{token}', 'Auth\AuthController@verifyTokenAndShowConfirmationForm')
	->where(['token' => '[A-Za-z0-9]{30}'])
	->name('email_verify');
	
Route::post('account-confirmation/{token}', 'Auth\AuthController@completeUserRegistrationAndLogin')
	->where(['token' => '[A-Za-z0-9]{30}']);


Route::get('/', function () {

	$articles = App\Models\Article::orderBy('created_at', 'desc')->take(10)->get();

    return view('welcome')->with('articles', $articles);

})->name('home');

// view complete article url route
Route::get('/{slug}', function ($slug) {

	$article = App\Models\Article::where('slug', '=', $slug)->first();
    return view('single')->with('article' , $article);

})->where(['slug' => '[A-Za-z0-9-]{1,150}'])->name('view_article');

// download the article as PDF
Route::get('/{slug}/download', function ($slug) {

	$article = App\Models\Article::where('slug', '=', $slug)->first();
    $pathToFile = storage_path().'/pdfs/'.$article->slug.'.pdf';

	if(file_exists($pathToFile)){
		return response()->file($pathToFile);
	}

	$pdf = \PDF::loadView('pdf.article', ['article' => $article]);
	$pdf->save($pathToFile);
	return response()->file($pathToFile);

})->where(['slug' => '[A-Za-z0-9-]{1,150}'])->name('download_article');


// user dashboard area
Route::get('/article/new', 'ArticleController@showNewArticleForm')->name('new_article');
Route::post('/article/new', 'ArticleController@createArticle');
Route::get('/article/delete/{slug}', 'ArticleController@deleteArticle')->name('delete_article');
Route::get('/article/my-articles', 'ArticleController@showMyArticles')->name('list_articles');
