<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>TechnicSolder v{{ $solderVersion }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    {{ Basset::show('bootstrapper.css') }}
    {{ Basset::show('bootstrapper.js') }}
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
          <a class="navbar-brand" href="{{ URL::to('dashboard') }}">TechnicSolder</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="{{ URL::to('dashboard') }}">Dashboard</a></li>
            <li class="active"><a href="{{ URL::to('modpack') }}">Modpacks</a></li>
            <li><a href="{{ URL::to('mod') }}">Mod Library</a></li>
          </ul>
          <ul class="navbar-text navbar-right">
            Logged in as <a href="#" class="navbar-link">{{ Auth::user()->email }}</a>. ({{ HTML::link('logout','Logout') }})
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <div class="panel panel-default">
            <div class="panel-heading text-center">
              <h3 class="panel-title">Current Modpacks</h3>
            </div>
            <div class="list-group">
            @foreach (Modpack::all() as $modpack)
              <a href="{{ URL::to('modpack/view/'.$modpack->id) }}"{{ $active = (Request::is('modpack/view/'.$modpack->id) ? ' class="active list-group-item"' : ' class="list-group-item"') }}><img src="{{ Config::get('solder.mirror_url').$modpack->slug.'/resources/icon.png' }}" style="width: 16px; height: 16px;"> {{ $modpack->name }}{{ $hidden = ($modpack->hidden ? " (Hidden)" : "") }}</a>
            @endforeach
            <a href="{{ URL::to('modpack/create') }}"{{ $active = (Request::is('modpack/create') ? ' class="active list-group-item"' : ' class="list-group-item"') }}><i class="glyphicon glyphicon-plus"></i> Create New Modpack</a></li>
            </div>
          </div><!--/.well -->
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
