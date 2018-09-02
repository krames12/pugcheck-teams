@extends('layouts.app')

@section('content')
    <h1>Import Guild</h1>
    @foreach($members->members as $member)
        {{ dd($member->character) }}
    @endforeach
@endsection