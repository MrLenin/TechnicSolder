@extends('layouts/mod')
@section('navigation')
@parent
<li class="nav-header">Mod: {{ $mod->name }}</li>
<li class="active"><a href="{{ route('mod.edit', array($mod->id)) }}"><i class="icon-align-left"></i> Mod Details</a>
<li><a href="{{ route('mod.show', array($mod->id)) }}"><i class="icon-tag"></i> Mod Versions</a></li>
@endsection
@section('content')
<h1>Mod Library</h1>
<hr>
<h2>
	@if (!empty($mod->pretty_name))
		{{ $mod->pretty_name }} <small>{{ $mod->name }}</small>
	@else
		{{ $mod->name }}
	@endif
</h2>
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
{{ Form::model($mod, array('route' => array('mod.update', $mod->id), 'method' => 'put')) }}
{{ Form::label('pretty_name', 'Mod Name') }}
{{ Form::text('pretty_name', null, array('class' => 'input-xxlarge')) }}
{{ Form::label('name', 'Mod Slug') }}
{{ Form::text('name', null, array('class' => 'input-xxlarge')) }}
{{ Form::label('author', 'Author') }}
{{ Form::text('author', null, array('class' => 'input-xxlarge')) }}
{{ Form::label('description', 'Description') }}
{{ Form::text('description', null, array('class' => 'input-xxlarge', 'rows' => '5')) }}
{{ Form::label('link', 'Mod Website') }}
{{ Form::text('link', null, array('class' => 'input-xxlarge')) }}
{{ Form::submit('Save changes') }} {{ Form::btnLink('Delete Mod', 'mod.delete', $mod->id, array('class'=>'btn btn-large')) }}
{{ Form::close() }}
@endsection