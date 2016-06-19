@extends('layouts.app')

@section('content')
	@if(Session::has('error'))
	    <div class="alert alert-danger">
	        <button type="button" class="close" data-dismiss="alert">&times;</button>
	        <strong>Oh snap!</strong>
	        {{ Session::get('error') }}
	    </div>
    @else
		<form class="form-horizontal" role="form" enctype="multipart/form-data" method="POST" action="{{ url('/article/new') }}">
		    {{ csrf_field() }}
			<fieldset>
				<legend>New Article</legend>

				<div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
					<label for="inputEmail" class="col-lg-2 control-label">Title</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="inputEmail" name="title" placeholder="Article Title" value="{{ old('title') }}">
                        @if ($errors->has('slug'))
                            <span class="help-block">
                                <strong>{{ $errors->first('slug') }}</strong>
                            </span>
                        @endif
					</div>
				</div>

				
				<div class="form-group{{ $errors->has('article_body') ? ' has-error' : '' }}">
					<label for="textArea" class="col-lg-2 control-label">Textarea</label>
					<div class="col-lg-10">
						<textarea class="form-control" name="article_body" rows="3" id="textArea">{{ old('article_body') }}</textarea>
					</div>
                    @if ($errors->has('article_body'))
                        <span class="help-block">
                            <strong>{{ $errors->first('article_body') }}</strong>
                        </span>
                    @endif
				</div>
				
				<div class="form-group{{ $errors->has('article_banner') ? ' has-error' : '' }}">
					<label for="article-banner" class="col-lg-2 control-label">Article Banner</label>
					<div class="col-lg-10">
						<input type="file" class="form-control" id="article-banner" name="article_banner">
					</div>
					@if ($errors->has('article_banner'))
                        <span class="help-block">
                            <strong>{{ $errors->first('article_banner') }}</strong>
                        </span>
                    @endif
				</div>

				<div class="form-group">
					<div class="col-lg-10 col-lg-offset-2">
						<button type="submit" class="btn btn-primary">Create</button>
					</div>
				</div>
			</fieldset>
		</form>
	@endif
@endsection