@extends('layouts/modpack')
@section('content')
<h1>Modpack Management</h1>
<hr>
<h2>Create Modpack</h2>
<p>Creating a modpack is simple. Fill in the information here and make sure you have the corresponding folder created on your repository with the necessary files. Your resources will be verified on pack creation. The resources required are listed below.</p>
<blockquote>/<span class="modslug">[modslug]</span>/<br>
/<span class="modslug">[modslug]</span>/resources/<br>
/<span class="modslug">[modslug]</span>/resources/icon.png (32x32)<br>
/<span class="modslug">[modslug]</span>/resources/logo_180.png (180x110)<br>
/<span class="modslug">[modslug]</span>/resources/background.jpg (800x510)
</blockquote>
@if ($errors->all())
	<div class="alert alert-error">
	@foreach ($errors->all() as $error)
		{{ $error }}<br />
	@endforeach
	</div>
@endif
{{ Former::horizontal_open(route('modpack.create')) }}
  {{ Former::text('name')->label('Modpack Name')->addClass('input-xxlarge')->require() }}
  {{ Former::text('slug')->label('Modpack Slug')->addClass('input-xxlarge')->require() }}
  {{ Former::actions(Button::primary_submit('Create Modpack')) }}
{{ Former::close() }}
<script type="text/javascript">
$("#slug").slugify('#name');
$(".modslug").slugify("#name");
$("#slug").keyup(function() {
	$(".modslug").html($(this).val());
});
</script>
@endsection