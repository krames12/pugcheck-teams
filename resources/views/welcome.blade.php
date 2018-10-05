@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="">
            <a href="{{ route('createRoster') }}" class="float-right btn bg-blue rounded text-white px-2 py-2">New Team</a>
        </div>
        <div class="mt-6">
            <h3 class="text-center m-2">Welcome to alpha!</h3>
            <div class="max-w-md mx-auto">
                <p>This is PugCheck Teams! The goal of this site is to help raid leaders organize their teams.</p>
                <p>The end goal is to track whether members have their gear is gemmed or enchanted, as well as azerite level and traits. Since this is the Alpha, the app currently allows users to create teams and add characters to them. The characters and their gear are pulled in from Blizzard's servers.</p>
                <p class="mt-2"><strong>Upcoming Features</strong></p>
                <ul>
                    <li>Gems & enchants</li>
                    <li>Interface improvements</li>
                    <li>Team groups (more info <a href="https://github.com/krames12/pugcheck-teams/issues/2">here</a>)</li>
                </ul>
                <p><a href="https://github.com/krames12/pugcheck-teams/issues">Click here</a> to see a list of current ideas and bugs that are being worked on.</p>
                <div class="shadow border rounded bg-white mt-2 p-2">
                    <h4 class="inline-block">Feedback</h4>
                    <p>
                        If you have any feedback, such as suggestions or things being broken, don't hesitate to reach out! Please contact me on Discord (Krames#4203), Battle.net (Krames#1425), or on Twitter (@krames12).
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
