<html>
	<body>
		<h3>{{ $article->title }} </h3>
		<p>
			{{ $article->article_body }}
		</p>

		<p><span>Author :- </span><span>{{ $article->user->name }}</span></p>
		<p><span>Created At :- </span><span>{{ $article->created_at }}</span></p>
		@if( extension_loaded('gd') )
			<img src="{{ url('/article/'.$article->article_banner) }} ">
		@endif

	</body>
</html>