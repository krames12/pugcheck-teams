@extends('layouts.app')

@section('content')
    <div>
        <h1 class="inline-block">All Rosters</h1>
        <a href="rosters/create" class="float-right">
            <button class=" btn bg-blue hover:bg-blue-dark rounded border border-blue text-white px-2 py-2">
                New Roster
            </button>
        </a>
    </div>
    <div class="row">
        <div class="mt-4 p-2 col-sm-12 mx-auto">
            <ul class="list-reset">
                @foreach($rosters as $roster)
                    <li class="border-bottom  p-2 mx-4 hover:bg-grey-lighter">
                        <a href="{{ route('rosterShow', $roster->id) }}">{{ $roster->name }} - {{ $roster->realm->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
