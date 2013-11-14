@extends('layouts/modpack')
@section('content')
<h1>Modpack Management</h1>
<hr>
<h2>Create New Build ({{ $modpack->name }})</h2>
<p>All new builds by default will not be available in the API. They need to be published before they will show up.</p>
@if ($errors->all())
	<div class="alert alert-error">
	@foreach ($errors->all() as $error)
		{{ $error }}<br />
	@endforeach
	</div>
@endif
{{ Former::horizontal_open(route('modpack.build.store', $modpack->id)) }}
{{ Former::text('version')->addClass('input-large')->label('Build Number')->style('width: 35%') }}
{{ Former::select('minecraft')->options($minecraft)->label('Minecraft Version', array('class' => 'control-label'))->style('width: 35%') }}
{{ Former::select('clone')->options($build)->label('Clone Build')->inlineHelp('This will clone all the mods and mod versions of another build in this pack.')->style('width: 35%') }}
{{ Former::actions(Button::primary_submit('Add New Build')) }}
{{ Former::close() }}
@endsection