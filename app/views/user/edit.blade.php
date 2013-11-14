@extends('layouts/main');
@section('content')
<h1>User Management</h1>
<hr>
<h2>Edit User: {{ $user->email }}</h2>
<hr>
@if ($errors->all())
	<div class="alert alert-error">
	@foreach ($errors->all() as $error)
		{{ $error }}<br />
	@endforeach
	</div>
@endif
@if (Session::has('success'))
	<div class="alert alert-success">
		{{ Session::get('success') }}
	</div>
@endif
{{ Former::horizontal_open(route('user.update', $user->id))->method('put') }}
  {{ Former::populate($user) }}
  {{ Former::text('email')->label('Email Address')->addClass('input-xxlarge')->style('width: 75%') }}
  {{ Former::text('username')->label('Username')->addClass('input-xxlarge')->style('width: 75%') }}
  <hr>
  <p>If you would like to change this accounts password you may include new passwords below. This is not required to edit an account</p>
  {{ Former::password('password1')->label('Password')->addClass('input-xxlarge')->style('width: 75%') }}
  {{ Former::password('password2')->label('Password Again')->addClass('input-xxlarge')->style('width: 75%') }}
  <hr>
  @if (Auth::user()->permission->solder_full || Auth::user()->permission->solder_users)
  <h3>Permissions</h3>
  <p>
    Please select the level of access this user will be given. The "Solderwide" permission is required to access a specific section. (Ex. Manage Modpacks is required for anyone to access even the list of modpacks. They will also need the respective permission for each modpack they should have access to.)
  </p>
  {{ Former::checkbox('permission.solder_full')->text('Full Solder Access (Blanket permission)')->label('Solderwide') }}
  {{ Former::checkbox('permission.manage_users')->text('Manage Users')->label(' ') }}
  {{ Former::checkbox('permission.manage_packs')->text('Manage Modpacks')->label(' ') }}
  {{ Former::checkbox('permission.manage_mods')->text('Manage Mods')->label(' ') }}
  {{ Former::checkbox('permission.mod_create')->text('Create Mods')->label('Mod Library') }}
  {{ Former::checkbox('permission.mod_manage')->text('Manage Mods')->label(' ') }}
  {{ Former::checkbox('permission.mod_delete')->text('Delete Mods')->label(' ') }}
  {{ Former::checkbox('permission.solder_create')->text('Create Modpacks')->label('Modpack Access') }}
  @foreach (Modpack::all() as $modpack)
    {{ Former::checkbox($modpack->slug)->name($modpack->name)->text($modpack->name)->label(' ')->setAttribute('value', $modpack->id) }}
  @endforeach
  @endif
  {{ Former::actions(Button::primary_submit('Save changes'), Button::link(URL::to('/user'),'Go Back')) }}
{{ Former::close() }}
@endsection