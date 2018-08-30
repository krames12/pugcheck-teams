@extends('layouts.app')

@section('content')
    <h1>All Rosters</h1>
    <a href="rosters/create">
        <button class="float-right btn bg-transparent border border-blue">New Roster</button>
    </a>
    <ul>
        @foreach($rosters as $roster)
            <li>{{ $roster->name }}</li>
        @endforeach
    </ul>
@endsection