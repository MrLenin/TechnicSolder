@extends('layouts/modpack')
@section('content')
<h1>Modpack Management</h1>
<hr>
<div class="row">
<div class="clearfix"></div>
<div class="pull-left">
<h2>{{ $modpack->name }}</h2>
</div>
<div class="pull-right">
	<a class="btn btn-primary" href="{{ route('modpack.build.create', array('modpack' => $modpack->id)) }}">Create New Build</a>
	<a class="btn" href="{{ route('modpack.edit', $modpack->id) }}">Edit Modpack</a>
</div>
</div>
<hr>
<div class="row">
<div class="alert alert-success" id="success-ajax" style="width: 500px;display: none">
</div>
@if (Session::has('success'))
<div class="alert alert-success">
	{{ Session::get('success') }}
</div>
@endif
@if (Session::has('deleted'))
<div class="alert alert-error">
	{{ Session::get('deleted') }}
</div>
@endif
</div>
<div class="row">
<div class="table-responsive table-condensed">
{{ Table::open() }}
{{ Table::headers('#', 'Build Number', 'MC Version', 'Mod Count', 'Rec', 'Latest', 'Published','Created', '') }}
@foreach ($modpack->builds as $build)
	<tr>
		<td>{{ $build->id }}</td>
		<td>{{ $build->version }}</td>
		<td>{{ $build->minecraft }}</td>
		<td>{{ count($build->modversions) }}</td>
		<td><input type="radio" name="recommended" value="{{ $build->version }}"{{ $checked = ($modpack->recommended == $build->version ? " checked" : "") }}></td>
		<td><input type="radio" name="latest" value="{{ $build->version }}"{{ $checked = ($modpack->latest == $build->version ? " checked" : "") }}></td>
		<td><input type="checkbox" name="published" value="1" class="published" rel="{{ $build->id }}"{{ $checked = ($build->is_published ? " checked" : "") }}></td>
		<td>{{ $build->created_at }}</td>
		<td>{{ HTML::linkRoute('modpack.build.edit', "Manage", array('modpack' => $modpack->id, 'build' => $build->id), array('class' => "btn btn-small btn-primary")) }} {{ HTML::linkRoute('modpack.build.delete', "Delete", array('id' => $build->id), array('class' => "btn btn-small btn-danger")) }}</td>
	</tr>
@endforeach
{{ Table::close() }}
</div>
</div>
<script type="text/javascript">

$("input[name=recommended]").change(function() {
	$.ajax({
		type: "GET",
		url: "{{ URL::to('modpack/modify/recommended?modpack='.$modpack->id) }}&recommended=" + $(this).val(),
		success: function (data) {
			$("#success-ajax").stop(true, true).html(data.success).fadeIn().delay(2000).fadeOut();
		}
	});
});

$("input[name=latest]").change(function() {
	$.ajax({
		type: "GET",
		url: "{{ URL::to('modpack/modify/latest?modpack='.$modpack->id) }}&latest=" + $(this).val(),
		success: function (data) {
			$("#success-ajax").stop(true, true).html(data.success).fadeIn().delay(2000).fadeOut();
		}
	});
});

$(".published").change(function() {
	var checked = 0;
	if (this.checked)
		checked = 1;
	$.ajax({
		type: "GET",
		url: "{{ URL::to('modpack/modify/published') }}?build=" + $(this).attr("rel") + "&published=" + checked,
		success: function (data) {
			$("#success-ajax").stop(true, true).html(data.success).fadeIn().delay(2000).fadeOut();
		}
	})
});

</script>
@endsection