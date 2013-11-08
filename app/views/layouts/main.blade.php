@stylesheets('bootstrapper')
@javascripts('bootstrapper')
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
    </style>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
  </head>

  <body>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
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
            <li class="active"><a href="{{ action('DashboardController@getIndex') }}">Dashboard</a></li>
            <li><a href="{{ route('modpack.index') }}">Modpacks</a></li>
            <li><a href="{{ route('mod.index') }}">Mod Library</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-text navbar-right navbar-user">
            Logged in as <a href="#" class="navbar-link">{{ Auth::user()->email }}</a>. ({{ HTML::link('logout','Logout') }})
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="dropdown-header"><strong>SOLDER</strong></li>
              <li{{ $active = (Request::is('dashboard') ? ' class="active"' : null) }}><a href="{{ action('DashboardController@getIndex') }}"><i class="glyphicon glyphicon-home"></i> Dashboard</a></li>
              <li{{ $active = (Request::is('user/edit/'.Auth::user()->id) ? ' class="active"' : null) }}><a href="{{ URL::to('user/edit/'.Auth::user()->id) }}"><i class="glyphicon glyphicon-edit"></i> Edit My Account</a></li>
              <li><a href="#"><i class="glyphicon glyphicon-info-sign"></i> Statistics</a></li>
              <li class="dropdown-header"><strong>MANAGE SOLDER</strong></li>
              <li{{ $active = (Request::is('solder/configure') ? ' class="active"' : null) }}><a href="{{ URL::to('solder/configure') }}"><i class="glyphicon glyphicon-cog"></i> Configuration</a></li>
              <li{{ $active = (Request::is('user/*') && !Request::is('user/edit/'.Auth::user()->id) ? ' class="active"' : null) }}><a href="{{ URL::to('user/list') }}"><i class="glyphicon glyphicon-user"></i> Manage Users</a></li>
            </ul>
          </div>
        </div><!--/span-->
        <div class="col-md-9">
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
