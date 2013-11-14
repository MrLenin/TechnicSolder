@extends('layouts/main')
@section('content')
<h1>User Management</h1>
<hr>
<div class="navbar-right">
    <a href="{{ URL::to('user/create') }}" class="btn btn-success">Create User</a>
</div>
<h2>User List</h2>
{{ Table::open() }}
{{ Table::headers('#', 'Email', 'Username', 'Created', '') }}
@foreach ($users as $user)
	<tr>
		<td>{{ $user->id }}</td>
		<td>{{ $user->email }}</td>
		<td>{{ $user->username }}</td>
		<td>{{ $user->created_at }}</td>
		<td>{{ HTML::link('/user/'.$user->id.'/edit','Edit') }} - {{ HTML::linkRoute('user.delete', 'Delete', array('id' => $user->id, 'user' => $user)) }}</td>
	</tr>
@endforeach
{{ Table::close() }}
@endsection