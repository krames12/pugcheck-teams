@extends('layouts.app')

@section('content')
    <h1>View Roster</h1>
    <p>
        Name: {{ $roster->name }}
        <span class="text-right">
            <a href="{{ route('importView', $roster->id) }}" class="btn bg-blue text-white px-2 py-2 rounded">Import Guild</a>
        </span>
    </p>
    <p>Realm: {{ $roster->realm->name }}</p>

    <div class="flex">
        <div class="flex-col w-1/2">
            <div class="w-3/5 mx-auto my-3">
                <h3>Tanks</h3>
            </div>
            <div class="w-3/5 mx-auto my-3">
                <h3>Healers</h3>
            </div>
        </div>
        <div class="flex-col w-1/2">
            <div class="w-3/5 mx-auto my-3">
                <h3>Melee DPS</h3>
            </div>
            <div class="w-3/5 mx-auto my-3">
                <h3>Ranged DPS</h3>
            </div>
        </div>
    </div>

    <div>
        <ul class="px-1 import-guild-members-list mb-4">
            @foreach($roster->characters as $character)
                @php
                    $className = App\Http\Controllers\Lookups::classLookup($character->class);
                @endphp
                <li class=" list-reset leading-normal border-b py-1 px-2">
                    <img src="{{ asset('images').'/'.$className.'.png' }}"
                         alt="{{ $className}}"
                         class="class-icon-small px-1"
                    >
                    <span>{{ $character->name }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    <script>

    </script>

@endsection
