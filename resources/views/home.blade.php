@extends('layouts.app')

@section('content')
    <div class="container">
        <div style="float: right;">
            <p>The Maximum Profit: ${{ $profit }}</p> {{--display the maximum profit within the date range--}}
            <p>The lowest Price: ${{ $lowPrice }} | The Highest Price: ${{ $highPrice }}</p> {{--display the lowest price and the highest price--}}
            <p>Date Period: {{ $lowPriceDate }} to {{ $highPriceDate }}</p> {{--display the lowest price date and the highest price date--}}
        </div>
        <div>{!! $chart->container() !!}</div> {{--display the stock chat--}}
    </div>

    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
     {!! $chart->script() !!}
@endsection
