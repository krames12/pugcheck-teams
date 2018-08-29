@extends('layouts.app')

@section('content')
    <h1>All Roster</h1>

    <ul>
        @foreach($rosters as $roster)
            <li>{{ $roster->name }}</li>
        @endforeach
    </ul>
@endsection