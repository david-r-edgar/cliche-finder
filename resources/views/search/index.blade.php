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

                <div class="col-sm-12 searchFormContainer">
                    <div contenteditable type="text" id="inputSearchText" class="form-control">{!! old("haystackText",
                        (isset($haystackText) ? $haystackText : '') )!!}</div>
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

        // Returns a function, that, as long as it continues to be invoked, will not
        // be triggered. The function will be called after it stops being called for
        // N milliseconds. If `immediate` is passed, trigger the function on the
        // leading edge, instead of the trailing.
        function debounce(func, wait, immediate) {
            var timeout;
            return function() {
                var context = this, args = arguments;
                var later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                var callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        };

        var submitSearchRequest = debounce(function() {
            var xhr = new XMLHttpRequest();
            var url = "api/search";
            var inputSearchText = encodeURIComponent(
                document.getElementById("inputSearchText").innerHTML).replace(/%20/g, "+");
            var params = "input=" + inputSearchText + "&content-type=text/plain";
            xhr.open("POST", url, true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if(xhr.readyState == 4 && xhr.status == 200) {
                    console.log(xhr.responseText);
                }
            }
            xhr.send(params);
        }, 500);

        document.getElementById("inputSearchText").addEventListener("paste", submitSearchRequest);
        document.getElementById("inputSearchText").addEventListener("keyup", submitSearchRequest);
    </script>
@endsection