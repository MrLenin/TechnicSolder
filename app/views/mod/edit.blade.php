@extends('layouts/mod')
@section('navigation')
@parent
              <li class="dropdown-header"><strong>MOD: {{ strtoupper($mod->pretty_name) }}</strong></li>
              <li class="active"><a href="{{ route('mod.edit', array($mod->id)) }}"><i class="glyphicon glyphicon-align-left"></i> Mod Details</a></li>
              <li><a href="{{ route('mod.show', array($mod->id)) }}"><i class="glyphicon glyphicon-tag"></i> Mod Versions</a></li>
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
{{ Former::vertical_open(route('mod.update', $mod->id))->method('put') }}
  {{ Former::populate($mod) }}
  {{ Former::text('pretty_name')->addClass('input-xxlarge')->label('Mod Name')->style('width: 60%') }}
  {{ Former::text('name')->addClass('input-xxlarge')->label('Mod Slug')->style('width: 60%') }}
  {{ Former::text('author')->addClass('input-xxlarge')->label('Author')->style('width: 30%') }}
  {{ Former::textarea('description')->addClass('input-xxlarge')->label('Description')->rows('5')->style('width: 60%') }}
  {{ Former::text('link')->addClass('input-xxlarge')->label('Mod Website')->style('width: 60%') }}
  {{ Former::actions(Button::primary_submit('Save changes'), Button::danger_link('mod/'.$mod->id.'/delete','Delete Mod')) }}
{{ Former::close() }}
@endsection