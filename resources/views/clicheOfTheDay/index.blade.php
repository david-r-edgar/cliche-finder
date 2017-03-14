<!-- resources/views/clicheOfTheDay/index.blade.php -->

@extends('layouts.app')

@section('content')

    <div class="panel-body">

        <div style="font-size: 14px;">
            <div class="container">
            @foreach ($cliches as $cliche)
                <div class="row">
                    <div class="col-md-5">{{ $cliche->display_name }}</div>
                    <div class="col-md-1">
                        @if($cliche->clicheOfTheDay)
                            <input type="checkbox" id="cbox{{ $cliche->id }}" value="second_checkbox" checked="checked">
                        @else
                            <input type="checkbox" id="cbox{{ $cliche->id }}" value="second_checkbox">
                        @endif
                    </div>
                    <div class="col-md-2">
                        @if($cliche->clicheOfTheDay)
                            {{ $cliche->clicheOfTheDay->date }}
                        @else

                        @endif
                    </div>
                    <div class="col-md-4">
                        @if($cliche->clicheOfTheDay)
                            {{ $cliche->clicheOfTheDay->note }}
                        @else

                        @endif
                    </div>
                </div> <!-- row -->
            @endforeach
        </div>

    </div>


@endsection

