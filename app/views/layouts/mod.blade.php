@stylesheets('bootstrapper')
@javascripts('bootstrapper', 'application')
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>TechnicSolder v{{ $solderVersion }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }

      @media (max-width: 980px) {
        /* Enable use of floated navbar text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
.my-fluid-container {
  padding-left: 15px;
  padding-right: 15px;
  margin-left: auto;
  margin-right: auto;
}
    </style>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
  </head>

  <body>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="my-fluid-container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="{{ action('DashboardController@getIndex') }}">TechnicSolder</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="{{ action('DashboardController@getIndex') }}">Dashboard</a></li>
            <li><a href="{{ route('modpack.index') }}">Modpacks</a></li>
            <li class="active"><a href="{{ route('mod.index') }}">Mod Library</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-text navbar-right navbar-user">
            Logged in as <a href="#" class="navbar-link">{{ Auth::user()->email }}</a>. ({{ HTML::link('logout','Logout') }})
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
    <div class="my-fluid-container">
      <div class="row">
        <div class="col-md-3 col-lg-2">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="dropdown-header"><strong>MOD LIBRARY</strong></li>
              @section('navigation')
              <li{{ $active = (Request::is('mod') ? ' class="active"' : null) }}><a href="{{ URL::to('mod') }}"><i class="glyphicon glyphicon-book"></i> Mod List</a></li>
              <li{{ $active = (Request::is('mod/create') ? ' class="active"' : null) }}><a href="{{ URL::to('mod/create') }}"><i class="glyphicon glyphicon-plus"></i> Add a Mod</a></li>
              @show
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
        <div class="col-md-9 col-lg-10">
          @yield('content')
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>TechnicSolder v{{ $solderVersion }}-{{ $solderStream }}</p>
        <p style="font-size: smaller">TechnicSolder is an open source project. It is under the MIT license. Feel free to do whatever you want!</p>
      </footer>

    </div><!--/.fluid-container-->

  </body>
</html>
