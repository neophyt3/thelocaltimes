@extends('layouts.app')

@section('content')

	@if (count($articles) > 0)
		@foreach ($articles as $article)
		    <div class="row article">
			    <div class="col-md-12">
			    	<div class="article-header">
						<span class="title">{{ $article->title }}</span>,
						<span><i>by</i></span>
						<span class="name">{{ $article->user->name }}</span>
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
					</div>
				</div>
			</div>
		@endforeach
	@else
		<div class="row article">
		    <div class="col-md-12">
		    	<h3>No Article Found</h3>
			</div>
		</div>
	@endif
@endsection
