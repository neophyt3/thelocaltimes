<?php

namespace App\Http\Controllers;

use Validator;
use App\Http\Requests;
use App\Models\Article;
use App\Helpers\Helpers;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('publisher');
    }


    /**
     * Get a validator for new article
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [
            'slug.unique' => 'The title must be unique',
        ];

        return Validator::make(
            $data, 
            [
                'title' => 'required|max:255|min:5',
                'slug' => 'required|max:255|unique:articles',
                'article_body' => 'required|max:1000',
                'article_banner' => 'required|image|max:51200',
            ], $messages);
    }

    public function showNewArticleForm(Request $request)
    {
        return view('article.newArticle');
    }

    /**
     * Create a new article
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $article = new Article();

        $article->title = $data['title'];
        $article->article_body = $data['article_body'];
        $article->slug = $data['slug'];

        return $article;
    }


    public function createArticle(Request $request)
    {

        $inputs = $request->all();

        $inputs['slug'] = str_slug($inputs['title']);
        $inputs['excerpt'] = '';
        //validate the input from the user
        $validator = $this->validator($inputs);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator->errors());
        }

        if($article = $this->create($inputs)){

            $article->excerpt = Helpers::excerpt($inputs['article_body'], 100);

            $file = $request->file('article_banner');
            $fileName = $file->getClientOriginalName();
            $fileName = md5($fileName.time()).'.'.pathinfo($fileName, PATHINFO_EXTENSION);
            $destinationPath = public_path().env('ARTICLE_BANNER_PATH','/article/');

            $file->move($destinationPath, $fileName);
            
            $article->article_banner = $fileName;

            if($request->user()->articles()->save($article)){
                return redirect()->route('list_articles')
                                ->with('new_article_success' , 'Article Successfully Inserted');
            }
        }

        return redirect()->route('list_articles')->with('new_article_error', "Could not add article, please contact Admin");
    }

    public function deleteArticle(Request $request, $slug)
    {
        
        $article = Article::where('slug', '=', $slug)->where('user_id', '=', $request->user()->id)->delete();

        if($article){
            return redirect()->route('list_articles')->with('deleted', 'Article Deleted Successfully');
        }

        return redirect()->route('list_articles')->with('deleted_error', 'Cannot delete the article, please contact admin');
    }

    public function showMyArticles(Request $request)
    {
        return view('article.myArticles')->with('articles', $request->user()->articles);
    }
}
