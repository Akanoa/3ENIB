<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

        <title>3ENIB | {{Session::get("headerTitle", "")}}</title>

        <!-- Bootstrap core CSS -->
        {{HTML::style("css/bootstrap.min.css")}}

        <!-- Bootstrap theme CSS -->
        <!--{{HTML::style("css/bootstrap-theme.min.css")}}-->
        
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
                    <li class="active"><a href="{{URL::to('/')}}">Accueil</a></li>
                    <li><a href="{{URL::to('company')}}">Entreprises</a></li>
                    <li><a href="{{URL::to('project/list')}}">Projets</a></li>
                    @if (App::make("3enib_authz")->isAdmin())
                        <li><a href="{{URL::to('student/list')}}">Étudiants</a></li>
                    @endif
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @if(!Auth::guest())
                        <li>
                            <img class="navbar-brand img-circle" src="{{$_ENV['root_site']}}/document/avatar/{{Auth::user()->id}}/{{Auth::user()->own->avatar_filepath}}" alt="">
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{App::make("3enib_user")->formatedUserName()}}<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                @if(Auth::user()->own_type == "company")
                                    <li><a href="{{URL::to('company')}}/{{Auth::user()->own->id}}">Accéder à mon entreprise</a></li>
                                    <li><a href="#">Something else here</a></li>
                                @endif
                                <li class="divider"></li>
                                <li class="dropdown-header">Mon profil</li>
                                <li><a href="{{URL::to('user/edit')}}">Editer mon profil</a></li>
                                <li><a href="{{URL::to('user/signout')}}">Se Deconnecter</a></li>
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
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                @foreach (Session::get("notifications_errors") as $e)
                    <p>{{$e}}</p>
                @endforeach
            </div>
            <br>
        @endif


        @if (Session::get("notifications_infos"))
          <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            @foreach (Session::get("notifications_infos") as $e)
              <p>{{$e}}</p>
            @endforeach
          </div>
          <br>
        @endif

        @if (Session::get("notifications_success"))
          <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
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
    <script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
    {{HTML::script("js/bootstrap.min.js")}}
    {{HTML::script("js/custom.js")}}
    {{HTML::script("js/filestyle.js")}}
    {{HTML::script("js/tinyMCE_fr_FR.js")}}

    @yield("scripts")

</html>