<!-- resources/views/search/index.blade.php -->

@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors')

        <form action="{{ url('search') }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <div class="form-group">
                <!--<label for="haystackText" class="col-sm-3 control-label">Text to search</label>-->

                <div class="col-sm-offset-1 col-sm-8">
                    <textarea type="text" name="haystackText" id="haystackText" class="form-control" style="height: 28em;"></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-6 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-search"></i> Search text for cliches
                    </button>
                </div>
            </div>
        </form>
    </div>

@endsection
