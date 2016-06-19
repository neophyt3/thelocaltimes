@extends('layouts.app')

@section('content')
	@if (!is_null($article))
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
					    	<p>{{ $article->article_body }}</p>
					   	</div>
				  	</div>
					<div class="panel-footer"><a href="{{ url('/'.$article->slug.'/download') }}" class="btn btn-info"><span class="glyphicon glyphicon-download" aria-hidden="true"></span>Download as PDF</a></div>
				</div>
			</div>
		</div>
	@else
		<div class="row article">
		    <div class="col-md-12">
		    	<h1>No Article Found</h1>
			</div>
		</div>
	@endif
@endsection
