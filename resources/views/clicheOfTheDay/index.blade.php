<!-- resources/views/clicheOfTheDay/index.blade.php -->

@extends('layouts.app')

@section('content')

    <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors')

        <form action="{{ url('clichesOfTheDay') }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}
            <table class="table table-striped table-condensed">
                @foreach ($cliches as $cliche)
                    <tr class="row cotd-cliche-row" id="cotd-cliche-{{ $cliche->id }}">
                        <td class="col-md-4">{{ $cliche->display_name }}</td>
                        <td class="col-md-1">
                            @if($cliche->clicheOfTheDay)
                                <input type="checkbox" class="cotd-list-cbox" id="cotd-cbox-{{ $cliche->id }}" name="cotd[{{ $cliche->id }}][cbox]" checked="checked">
                            @else
                                <input type="checkbox" class="cotd-list-cbox" id="cotd-cbox-{{ $cliche->id }}" name="cotd[{{ $cliche->id }}][cbox]">
                            @endif
                        </td>
                        <td class="col-md-1 cotd-list-date">
                            <input type="text" id="cotd-date-{{ $cliche->id }}" name="cotd[{{ $cliche->id }}][date]" role="search" style="width: 100%; background-color:inherit; border: none;" value="{{ isset($cliche->clicheOfTheDay) ? $cliche->clicheOfTheDay->date : '' }}">
                        </td>
                        <td class="col-md-6 cotd-list-note">
                            <input type="text" id="cotd-note-{{ $cliche->id }}" name="cotd[{{ $cliche->id }}][note]" role="search" style="width: 100%; background-color:inherit; border: none; border-bottom: 1px dotted #ccc;" value="{{ isset($cliche->clicheOfTheDay) ? $cliche->clicheOfTheDay->note : '' }}">
                        </td>
                    </tr> <!-- row -->
                @endforeach
            </table>


            <div class="form-group">
                <div class="col-sm-offset-9 col-sm-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check"></i>
                            Save
                    </button>
                    <a class="btn btn-default" href="clichesOfTheDay">Cancel</a>
                </div>
            </div>
        </form>

    </div>

@endsection

@section('footer_scripts')
<script src="/js/clicheOfTheDay.js"></script>
@endsection
