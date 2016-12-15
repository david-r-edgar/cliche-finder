<!-- resources/views/search/index.blade.php -->

@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors')

        <form action="{{ url('search') }}" method="POST" class="form-horizontal" onsubmit="return getContent()">
            {{ csrf_field() }}
            <textarea id="haystackText" name="haystackText" style="display:none"></textarea>

            <div class="form-group">
                <!--<label for="haystackText" class="col-sm-3 control-label">Text to search</label>-->

                <div class="col-sm-12">
                    <div contenteditable type="text" id="inputSearchText" class="form-control" style="height: 75vh;">{!! old("haystackText",
                        (isset($haystackText) ? $haystackText : '') )!!}</div>
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


@section('footer_scripts')
    <script type="text/javascript">
        function getContent(){
            document.getElementById("haystackText").value = document.getElementById("inputSearchText").innerHTML;
        }
    </script>
@endsection