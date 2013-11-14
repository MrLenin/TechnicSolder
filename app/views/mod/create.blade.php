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
{{ Former::vertical_open(route('mod.store')) }}
  {{ Former::text('pretty_name')->addClass('input-xxlarge')->label('Mod Name')->style('width: 60%') }}
  {{ Former::text('name')->addClass('input-xxlarge')->label('Mod Slug')->style('width: 60%') }}
  {{ Former::text('author')->addClass('input-xxlarge')->label('Author')->style('width: 30%') }}
  {{ Former::textarea('description')->addClass('input-xxlarge')->label('Description')->rows('5')->style('width: 60%') }}
  {{ Former::text('link')->addClass('input-xxlarge')->label('Mod Website')->style('width: 60%') }}
  {{ Former::actions(Button::primary_submit('Add Mod')) }}
{{ Former::close() }}
<script type="text/javascript">
$("#name").slugify('#pretty_name');
$(".modslug").slugify("#pretty_name");
$("#name").keyup(function() {
	$(".modslug").html($(this).val());
});
</script>
@endsection