@extends('layouts/modpack')
@section('content')
<h1>Modpack Management</h1>
<hr>
<h2>Edit Modpack: {{ $modpack->name }}</h2>
<p>Editing a modpack requires that the resources exist just like when you create them. If the slug is changed, make sure to move the resources to the new area.</p>
@if ($errors->all())
	<div class="alert alert-error">
	@foreach ($errors->all() as $error)
		{{ $error }}<br />
	@endforeach
	</div>
@endif
{{ Former::horizontal_open(route('modpack.update', $modpack->id))->method('put') }}
  {{ Former::populate($modpack) }}
  {{ Former::text('name')->label('Modpack Name')->addClass('input-xxlarge')->style('width: 75%') }}
  {{ Former::text('slug')->label('Modpack Slug')->addClass('input-xxlarge')->style('width: 75%') }}
  {{ Former::checkbox('hidden')->text(' ')->label('Hide Modpack') }}
  {{ Former::actions(Button::primary_submit('Edit Modpack'), Button::danger_link(route('modpack.delete', $modpack->id),'Delete Modpack')) }}
{{ Former::close() }}
<script type="text/javascript">
$("#slug").slugify('#name');
</script>
@endsection