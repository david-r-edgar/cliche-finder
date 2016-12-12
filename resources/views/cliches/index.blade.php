<!-- resources/views/cliches/index.blade.php -->

@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <div style="font-size: 22px;"><a href="cliche/new">Add new cliche</a></div>

        @foreach ($cliches as $cliche)
            <div><a href="cliche/{{ $cliche->id }}"> {{ $cliche->display_name }}</a></div>
        @endforeach
    </div>


@endsection

@section('footer_scripts')
<script src="/js/cliches.js"></script>
@endsection
