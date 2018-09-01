@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto max-w-sm">
        <h1>Import Character</h1>
        <form method="POST" action="/characters/import" class="bg-white shadow-md rounded px-4 py-6">
            {{ csrf_field() }}
            <div class="mb-4">
                <label for="name" class="block">Character Name</label>
                <input type="text" id="name" name="name" class="w-full border py-2 px-2 rounded" />
            </div>
            <div class="mb-4">
                <label for="realm" class="block">Realm</label>
                <select name="realm" id="realm" class="w-full border py-2 px-2 rounded">
                    @foreach($realms as $realm)
                        <option value="{{ $realm->id }}">{{ $realm->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="btn bg-blue rounded text-white">Import Character</button>
            </div>
        </form>

        @include ('layouts.errors')
    </div>
@endsection
