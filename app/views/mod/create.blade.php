@extends('layouts/mod')
@section('content')
<h1>Mod Library</h1>
<hr>
<h2>Add a new mod</h2>
<p>Because Solder doesn't do any file handling yet you will need to manually manage your set of mods in your repository. The mod repository structure is very strict and must match your Solder data exact. An example of your mod directory structure will be listed below:</p>
<blockquote>/mods/<span class="modslug">[modslug]</span>/<br>
	/mods/<span class="modslug">[modslug]</span>/<span class="modslug">[modslug]</span>-[version].zip
</blockquote>
@if ($errors->all())
	<div class="alert alert-error">
	@foreach ($errors->all() as $error)
		{{ $error }}<br />
	@endforeach
	</div>
@endif
{{ Form::open(array('route' => 'mod.store')) }}
  {{ Form::label('pretty_name', 'Mod Name') }}
  {{ Form::text('pretty_name', null, array('class' => 'input-xxlarge')) }}
  {{ Form::label('name', 'Mod Slug') }}
  {{ Form::text('name', null, array('class' => 'input-xxlarge')) }}
  {{ Form::label('author', 'Author') }}
  {{ Form::text('author', null, array('class' => 'input-xxlarge')) }}
  {{ Form::label('description', 'Description') }}
  {{ Form::textarea('description', null, array('class' => 'input-xxlarge', 'rows' => '5')) }}
  {{ Form::label('link', 'Mod Website') }}
  {{ Form::text('link', null, array('class' => 'input-xxlarge')) }}
  {{ Button::primary_submit('Add Mod') }}
{{ Form::close() }}
<script type="text/javascript">
$("#name").slugify('#pretty_name');
$(".modslug").slugify("#pretty_name");
$("#name").keyup(function() {
	$(".modslug").html($(this).val());
});
</script>
@endsection