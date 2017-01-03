<!-- resources/views/cliches/edit.blade.php -->

@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body" id="editClichePage">
        <!-- Display Validation Errors -->
        @include('common.errors')

        <!-- New / Edit Cliche Form -->

        @if (isset ($cliche))
        <form action="{{ url('cliche') }}/{{ $cliche->id }}" method="POST" class="form-horizontal">
        @else
        <form action="{{ url('cliche') }}" method="POST" class="form-horizontal">
        @endif
            {{ csrf_field() }}

            <!-- Cliche Name -->
            <div class="form-group">
                <div class="col-sm-3 pull-left">
                    <label for="display_name" class="control-label">Primary form (display name)</label>
                </div>

                <div class="clearfix hidden-sm-up"></div>
                <div class="col-sm-9">
                    @if (isset($cliche) && isset($cliche->display_name))
                        <input type="text" name="display_name" id="display_name" class="form-control" value="{{ old('display_name', $cliche->display_name) }}">
                    @else
                        <input type="text" name="display_name" id="display_name" class="form-control" value="{{ old('display_name', '') }}">
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-3 pull-left">
                    <label for="pattern" class="control-label">Regular Expression</label>
                </div>
                <div class="clearfix hidden-sm-up"></div>
                <div id="variants">
                    @if (sizeof(old('pattern')) > 0)
                        @foreach (old('pattern') as $index => $pattern)
                            <div class="row">
                                <div class="col-sm-9">
                                    <input type="text" name="pattern[{{ $index }}]" id="pattern[{{ $index }}]" class="form-control" value="{{ $pattern }}">
                                </div>
                            </div>
                        @endforeach
                    @elseif (isset($cliche) && isset($cliche->variants))
                        @foreach ($cliche->variants as $variant)
                            <div class="row">
                                <div class="col-sm-9">
                                    <input type="text" name="pattern[{{$loop->index}}]" id="pattern[{{$loop->index}}]" class="form-control" value="{{ $variant->pattern }}">
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="row">
                            <div class="col-sm-9">
                                <input type="text" name="pattern[0]" id="pattern[0]" class="form-control">
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-sm-1">
                    <button id="addVariant" type="button" class="btn btn-default">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-3 pull-left">
                    <label for="description" class="control-label">Description</label>
                </div>

                <div class="clearfix hidden-sm-up"></div>
                <div class="col-sm-9">
                    @if (isset($cliche) && isset($cliche->description))
                        <textarea type="text" name="description" id="description" class="form-control">{{ old('description', $cliche->description) }}</textarea>
                    @else
                        <textarea type="text" name="description" id="description" class="form-control">{{ old('description', '') }}</textarea>
                    @endif
                </div>
            </div>

            <!-- Add Cliche Button -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i>
                            @if (isset($cliche))
                                Save
                            @else
                                Add Cliche
                            @endif
                    </button>
                </div>
            </div>
        </form>


        @if (isset($cliche))
            <form action="/cliche/{{ $cliche->id }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button class="fa fa-btn fa-trash debutton"> Delete Cliche</button>
            </form>
        @endif

    </div>

@endsection

@section('footer_scripts')
    <script src="/js/cliches.js"></script>
@endsection
