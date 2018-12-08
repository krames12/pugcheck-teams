@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto max-w-sm">
        <h1 class="mb-3">Import Character</h1>
        <form
            method="POST"
            {{ action('CharactersController@importCharacter', [ 'id' => $roster->id ]) }}
            class="bg-white shadow-md rounded px-4 py-6"
            onSubmit="awaitResponse('Importing')"
        >
            {{ csrf_field() }}
            <input type="hidden" name="roster" value="{{ $roster->id }}">
            <div class="mb-3">
                <label for="name" class="block">Character Name</label>
                <input type="text" id="name" name="name" class="w-full border py-2 px-2 rounded" />
            </div>
            <div class="mb-3">
                <label for="realm" class="block">Realm</label>
                <select name="realm" id="realm" class="w-full bg-white border  py-2 px-2 rounded">
                    @foreach($realms as $realm)
                        <option value="{{ $realm->id }}" {{ $roster->realm->id == $realm->id ? 'selected="selected"' : '' }}>
                            {{ $realm->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <button
                    type="submit"
                    id="import-character-submit"
                    class="btn bg-blue rounded text-white"
                >
                    Import Character
                </button>
            </div>
        </form>

        @include ('layouts.errors')
    </div>

    <script src="/js/buttonDisableOnApiRequest.js"></script>
@endsection
