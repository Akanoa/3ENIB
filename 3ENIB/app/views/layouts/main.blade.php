<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

        <title>3ENIB | {{isset($headerTitle)?$headerTitle:""}}</title>

        <!-- Bootstrap core CSS -->
        {{HTML::style("css/bootstrap.min.css")}}

        <!-- Bootstrap theme CSS -->
        {{HTML::style("css/bootstrap-theme.min.css")}}
        
        <!-- Mine custom style -->
        {{HTML::style("css/3ENIB.css")}}
        
        <style>

        </style>

    </head>

    <body role="document">

    <!-- Fixed navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="{{URL::to('/')}}">Home</a></li>
                    <li><a href="{{URL::to('company')}}">Entreprises</a></li>
                    <li><a href="{{URL::to('project')}}">Projets</a></li>
                    <li><a href="#contact">Étudiants</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @if(!Auth::guest())
                        <li>
                            <img class="navbar-brand img-circle" src="{{asset(Auth::user()->own->photo_filepath)}}" alt="">
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Espace Utilisateur<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li class="dropdown-header">Nav header</li>
                                <li><a href="#">Separated link</a></li>
                                <li><a href="user/signout">Se Deconnecter</a></li>
                            </ul>
                        </li>
                    @else
                        <li><a href="{{URL::to('user/signin')}}">Se connecter</a></li>
                        <li><a href="{{URL::to('user/signup')}}">S'inscrire</a></li>
                    @endif
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>

    <div class="container theme-showcase" role="main">

        @if (Session::get("notifications_errors"))
            <div class="alert alert-danger alert-dismissable">
                @foreach (Session::get("notifications_errors") as $e)
                    <p>{{$e}}</p>
                @endforeach
            </div>
            <br>
        @endif


        @if (Session::get("notifications_infos"))
          <div class="alert alert-info alert-dismissable">
            @foreach (Session::get("notifications_infos") as $e)
              <p>{{$e}}</p>
            @endforeach
          </div>
          <br>
        @endif

        @if (Session::get("notifications_success"))
          <div class="alert alert-success alert-dismissable">
            @foreach (Session::get("notifications_success") as $e)
              <p>{{$e}}</p>
            @endforeach
          </div>
          <br>
        @endif


        @yield("content")
    </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    {{HTML::script("js/bootstrap.min.js")}}
    {{HTML::script("js/signup.js")}}
    {{HTML::script("js/filestyle.js")}}
</html>