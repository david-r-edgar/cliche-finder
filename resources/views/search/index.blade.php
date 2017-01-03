<!-- resources/views/search/index.blade.php -->

@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors')

        <form class="form-horizontal">
            {{ csrf_field() }}
            <textarea id="haystackText" name="haystackText" style="display:none"></textarea>

            <div class="form-group">
                <!--<label for="haystackText" class="col-sm-3 control-label">Text to search</label>-->

                <div class="col-sm-12 searchFormContainer">
                    <div contenteditable type="text" id="inputSearchText" class="form-control">{!! old("haystackText",
                        (isset($haystackText) ? $haystackText : '') )!!}</div>
                </div>
            </div>
        </form>
    </div>



@endsection


@section('footer_scripts')
    <script src="/js/search.js"></script>
@endsection