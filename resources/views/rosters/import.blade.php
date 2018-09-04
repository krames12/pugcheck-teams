@extends('layouts.app')

@section('content')
    <h1 class="mb-3">Import Guild</h1>
    <form method="POST" action="{{ action() }}" class="">
        {{ csrf_field() }}
        <ul class="px-1 import-guild-members-list">
            @foreach($members as $member)
                <li class="list-reset leading-normal border-b py-1 px-2">
                    <img src="{{ asset('images').'/'.App\Http\Controllers\Lookups::classLookup($member->character->class).'.png' }}"
                         alt="{{ App\Http\Controllers\Lookups::classLookup($member->character->class) }}"
                         class="class-icon-small px-1"
                    >
                    {{ $member->character->name }}
                </li>
            @endforeach
        </ul>
    </form>
@endsection
