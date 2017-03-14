<!-- resources/views/clicheOfTheDay/index.blade.php -->

@extends('layouts.app')

@section('content')

    <div class="panel-body">

        <div style="font-size: 14px;">
            <table class="table table-striped table-condensed">
                @foreach ($cliches as $cliche)
                    <tr class="row">
                        <td class="col-md-5">{{ $cliche->display_name }}</td>
                        <td class="col-md-1">
                            @if($cliche->clicheOfTheDay)
                                <input type="checkbox" id="cbox{{ $cliche->id }}" value="second_checkbox" checked="checked">
                            @else
                                <input type="checkbox" id="cbox{{ $cliche->id }}" value="second_checkbox">
                            @endif
                        </td>
                        <td class="col-md-2">
                            @if($cliche->clicheOfTheDay)
                                {{ $cliche->clicheOfTheDay->date }}
                            @else

                            @endif
                        </td>
                        <td class="col-md-4">
                            @if($cliche->clicheOfTheDay)
                                {{ $cliche->clicheOfTheDay->note }}
                            @else

                            @endif
                        </td>
                    </tr> <!-- row -->
                @endforeach
            </table>
        </div>

    </div>

@endsection

@section('footer_scripts')
<script src="/js/clicheOfTheDay.js"></script>
@endsection
