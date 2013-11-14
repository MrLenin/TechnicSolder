@extends('layouts/modpack')
@section('content')
<h1>Modpack Management</h1>
<hr>
<h2>Delete request for build {{ $build->version }} ({{ $build->modpack->name }})</h2>
<hr>
<p>Are you sure you want to delete this build? This action is irreversible!</p>
{{ Former::open(route('modpack.build.destroy', array('modpack' => $build->modpack->id, 'build' => $build->id)))->method('delete') }}
{{ Former::hidden('confirm-delete', 1) }}
{{ Former::actions(Button::danger_submit('Delete Build'), Button::link('modpack/'.$build->modpack->id,'Go Back')) }}
{{ Former::close() }}
@endsection