@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="">
            <h1 class="inline-block">Raid Roster</h1>
            <a href="{{ route('createRoster') }}" class="float-right btn bg-blue rounded text-white px-2 py-2">New Roster</a>
        </div>
        <div class="mt-6">
            <h3 class="text-center m-2">Welcome to alpha!</h3>
            <div class="max-w-md mx-auto">
                <p>This is raid roster (help me get a better name plz)! The goal of this site is to help raid team leaders organize their teams.</p>
                <p>The end goal is to track whether members have their gear is gemmed or enchanted, as well as azerite level. Since this is the Alpha, the app currently allows users to create teams (rosters) and add characters to them. The characters and their gear are pulled in from Blizzard's servers.</p>
                <p class="mt-2"><strong>Upcoming Features</strong></p>
                <ul>
                    <li>Gems & Enchants</li>
                    <li>Interface improvements</li>
                    <li>Character management (i.e. My Characters)</li>
                </ul>
                <div class="shadow border rounded bg-white mt-2 p-2">
                    <h4 class="inline-block">Feedback</h4>
                    <p>
                        If have any feedback, such as suggestions or thing being broken, don't hesitate to reach out! Please contact me on Discord (Krames#4203), Battle Net (Krames#1425), or on Twitter (@krames12).
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
