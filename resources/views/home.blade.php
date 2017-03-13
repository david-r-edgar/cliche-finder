@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <!--
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!
                </div>
                -->

                <div class="panel-body">
                    <div style="font-size: 28px;">Cliche of the day goes here</div>
                    <div style="font-size: 16px;">Note about it</div>
                </div>

                <div style="font-size: 18px;"><a href="search/index">Search your text for cliches</a></div>

                @if (Auth::guest())
                    <div>guest</div>
                @else
                    <div>functions for logged in user</div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
