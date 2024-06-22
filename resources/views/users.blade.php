@extends('master')
@section('content')

<h2>Users2</h2>
<ul>
    @foreach ($users as $user )
        <li>{{ $user->name }}</li>
    @endforeach
</ul>
@endsection