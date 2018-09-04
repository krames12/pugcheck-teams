@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="">
            <h1>Raid Roster</h1>
            <a href="{{ route('createRoster') }}" class="btn bg-blue rounded text-white px-2 py-2">New Roster</a>
        </div>
    </div>
@endsection
