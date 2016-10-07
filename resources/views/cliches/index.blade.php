<!-- resources/views/cliches/index.blade.php -->

@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors')

        <!-- New Cliche Form -->
        <form action="{{ url('cliche') }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <!-- Cliche Name -->
            <div class="form-group">
                <label for="display_name" class="col-sm-3 control-label">Primary form (display name)</label>

                <div class="col-sm-6">
                    <input type="text" name="display_name" id="display_name" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label for="pattern" class="col-sm-3 control-label">Regular Expression</label>

                <div class="col-sm-6">
                    <input type="text" name="pattern" id="pattern" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label for="description" class="col-sm-3 control-label">Description</label>

                <div class="col-sm-6">
                    <input type="text" name="description" id="description" class="form-control">
                </div>
            </div>

            <!-- Add Cliche Button -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> Add Cliche
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- TODO: Current Cliches -->
@endsection
