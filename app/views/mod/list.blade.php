@extends('layouts/mod')
@section('navigation')
@parent
              <li class="dropdown-header"><strong>MOD: NONE SELECTED</strong></li>
@endsection
@section('content')
<h1>Mod Library</h1>
<hr>
@if (Session::has('deleted'))
<div class="alert alert-error">
	{{ Session::get('deleted') }}
</div>
@endif
<div>
	<form class="form-search" method="get" action="{{ URL::current() }}">
	  <input type="text" name="search" value="{{ $search }}" class="input-medium search-query">
	  <button type="submit" class="btn">Search</button>
	</form>
	{{ $mods->appends(array('search' => $search))->links(3, null, Paginator::SIZE_SMALL) }}
</div>
{{ Table::open() }}
{{ Table::headers('#','Mod Name', 'Author', '') }}
@foreach ($mods->getItems() as $mod)
	<tr>
		<td>{{ $mod->id }}</td>
		@if (!empty($mod->pretty_name))
			<td>{{ $mod->pretty_name }} ({{ $mod->name }})</td>
		@else
			<td>{{ $mod->name }}</td>
		@endif
		<td>{{ $mod->author }}
		<td>{{ HTML::link('mod/'.$mod->id.'/edit','Manage') }}</td>
	</tr>
@endforeach
{{ Table::close() }}
{{ $mods->appends(array('search' => $search))->links(3, null, Paginator::SIZE_SMALL) }}
@endsection