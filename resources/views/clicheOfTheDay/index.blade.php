<!-- resources/views/clicheOfTheDay/index.blade.php -->

@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">

        <div style="font-size: 28px;">
            @if (isset($clicheOfTheDay))
                {{ $clicheOfTheDay->date }}
            @else
                no cliche of the day
            @endif
        </div>

        <div style="font-size: 20px;"><a href="search/index">Search your text for cliches</a></div>
    </div>


@endsection

