<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="{{ URL::asset('favicon.ico') }}">
        <link href='https://fonts.googleapis.com/css?family=UnifrakturMaguntia' rel='stylesheet' type='text/css'>
        <title>
            @hasSection('title')
                @yield('title') - The Local Times
            @else
                The Local Times
            @endif
        </title>

        <!-- Bootstrap core CSS -->
        <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
        <link rel="stylesheet" href="https://bootswatch.com/lumen/bootstrap.min.css">
        
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="{{ URL::asset('css/ie10-viewport-bug-workaround.css') }}" rel="stylesheet">
        
        <!-- Custom styles for this template -->
        <link href="{{ URL::asset('css/jumbotron-narrow.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">
        
        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="js/ie8-responsive-file-warning.js"></script><![endif]-->
        <script src="{{ URL::asset('js/ie-emulation-modes-warning.js') }}"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container">
            <div class="header clearfix">
                <nav>
                    <ul class="nav nav-pills pull-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li role="presentation" class="{{  Route::is('home') ? 'active' : '' }}"><a href="{{ route('home') }}">Home</a></li>
                            <li class="{{  Route::is('login_form') ? 'active' : '' }}"><a href="{{ route('login_form') }}">Login</a></li>
                            <li class="{{  Route::is('register_form') ? 'active' : '' }}"><a href="{{ route('register_form') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->email }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ route('home') }}">Home</a></li>
                                    <li><a href="{{ route('new_article') }}">Write an article</a></li>
                                    <li><a href="{{ route('list_articles') }}">View my articles</a></li>
                                    <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </nav>

                <h3 class="text-muted">The Local Times</h3>
            </div>

            @yield('content')

            <footer class="footer">
                <p>&copy; 2016 Company, Inc.</p>
            </footer>

        </div> <!-- /container -->

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="{{ URL::asset('js/ie10-viewport-bug-workaround.js') }}"></script>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <!-- Scripts here -->
        @yield('script')
    </body>
</html>
