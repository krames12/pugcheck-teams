@extends('layouts.app')

@section('content')
    <h1>View Roster</h1>
    <p>Name: {{ $roster->name }}</p>
    <p>Realm: {{ $roster->realm }}</p>
@endsection