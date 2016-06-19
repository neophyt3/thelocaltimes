@extends('layouts.app')

@section('content')
	
	@if(Session::has('new_article_success'))
	    <div class="alert alert-success">
	        <button type="button" class="close" data-dismiss="alert">&times;</button>
	        {{ Session::get('new_article_success') }}
	    </div>
	@elseif(Session::has('new_article_error'))
	    <div class="alert alert-danger">
	        <button type="button" class="close" data-dismiss="alert">&times;</button>
	        <strong>Oh snap!</strong>
	        {{ Session::get('new_article_error') }}
	    </div>
	@elseif(Session::has('deleted'))
	    <div class="alert alert-danger">
	        <button type="button" class="close" data-dismiss="alert">&times;</button>
	        <strong>Oh snap!</strong>
	        {{ Session::get('deleted') }}
	    </div>
	@elseif(Session::has('deleted_error'))
	    <div class="alert alert-danger">
	        <button type="button" class="close" data-dismiss="alert">&times;</button>
	        <strong>Oh snap!</strong>
	        {{ Session::has('deleted_error') }}
	    </div>
	@endif

	@if (count($articles) > 0)
		@foreach ($articles as $article)
		    <div class="row article">
			    <div class="col-md-12">
			    	<div class="article-header">
						<span class="title">{{ $article->title }}</span>,
						<span><i>by</i></span>
						<span class="name">{{ Auth::user()->name }}</span>
						<span><i>at</i></span>
						<span class="date">{{ \App\Helpers\Helpers::humanize($article->created_at) }}</span>
					</div>
				</div>
			    <div class="col-md-12">
					<div class="panel panel-default">   
					  	<div class="panel-body">
						    <div class="article-image col-md-12" style="text-align:center;">
						    	<img src="{{ url(env('ARTICLE_BANNER_PATH').$article->article_banner) }}" alt="article image" style="max-width:100%;">
						    </div>
						    <div class="col-md-12 article-excerpt">
						    	<p>{{ $article->excerpt }}</p>
						    	<span class="read-more"><a href="{{ route('view_article', $article->slug) }}"><i>Read More</i></a></span>
						    </div>
					  	</div>
					  	@if ( Auth::check() )
						  	<div class="panel-footer"><a href="{{ route('delete_article', $article->slug) }}" class="btn btn-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>Delete</a></div>
						@endif
					</div>
				</div>
			</div>
		@endforeach
	@else
		<div class="alert alert-danger">
	        <button type="button" class="close" data-dismiss="alert">&times;</button>
	        <strong>Oh snap!</strong>
	        No article found, add a article
	    </div>
	@endif
@endsection