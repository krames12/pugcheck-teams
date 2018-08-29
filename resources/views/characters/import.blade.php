@extends('layouts.app')

@section('content')
    <h1>Import Character</h1>
    <div>
    </div>
    <form method="POST" action="/characters/import">
        {{ csrf_field() }}
        <label for="name">Character Name</label>
        <input type="text" id="name" name="name" />
        <label for="realm">Realm</label>
        <input type="text" id="realm" name="realm"  />
        <button type="submit">Import Character</button>
    </form>

    @include ('layouts.errors')
@endsection