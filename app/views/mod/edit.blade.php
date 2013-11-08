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
{{ Form::model($mod, array('route' => array('mod.update', $mod->id), 'method' => 'put')) }}
  <div class="form-group" style="width: 33%">
    {{ Form::label('pretty_name', 'Mod Name') }}
    {{ Form::text('pretty_name', null, array('class' => 'input-xxlarge')) }}
  </div>
  <div class="form-group" style="width: 33%">
    {{ Form::label('name', 'Mod Slug') }}
    {{ Form::text('name', null, array('class' => 'input-xxlarge')) }}
  </div>
  <div class="form-group" style="width: 33%">
    {{ Form::label('author', 'Author') }}
    {{ Form::text('author', null, array('class' => 'input-xxlarge')) }}
  </div>
  <div class="form-group" style="width: 100%">
    {{ Form::label('description', 'Description') }}
    {{ Form::textarea('description', null, array('class' => 'input-xxlarge', 'rows' => '5')) }}
  </div>
  <div class="form-group" style="width: 100%">
    {{ Form::label('link', 'Mod Website') }}
    {{ Form::text('link', null, array('class' => 'input-xxlarge')) }}
  </div>
  <div class="form-group">
    {{ Button::primary_submit('Save changes') }} {{ Button::danger_link('mod/'.$mod->id.'/delete','Delete Mod') }}
  </div>
{{ Form::close() }}
@endsection