<!-- resources/views/cliches/index.blade.php -->

@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!--<div style="font-size: 22px;"><a href="cliche/new">Add new cliche</a></div>-->

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

@section('footer_scripts')
<script src="/js/cliches.js"></script>
@endsection
