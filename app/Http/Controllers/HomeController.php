<?php

namespace App\Http\Controllers;

use App\Stock;
use Illuminate\Http\Request;
use App\Charts\StockChart;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chart =new StockChart;
        $closePrice = Stock::orderby('date')->pluck('close'); //chart display close price
        $date = Stock::orderby('date')->pluck('date'); //date array
//        $lowPrice = Stock::pluck('low'); //low price array
//        $highPrice = Stock::pluck('high'); //high price array


        $lowValue = 0; //the lowest price
        $highValue = 0; //the highest price
        $highIndex = 0; //the highest price index
        $lowestPointer = 0; //the lowest price index of the whole array
        $lowIndex = 0; //the lowest price index
        $profit = 0; //the maximum profit

        for($i = 0; $i < sizeof($closePrice); $i++){ //go through the array, all arrays have same array size
            if($closePrice[$i] - $closePrice[$lowestPointer] > $profit){
                $profit = $closePrice[$i] - $closePrice[$lowestPointer]; //find the maximum profit
                $highValue = $closePrice[$i]; //the highest close price
                $lowValue = $closePrice[$lowestPointer]; //the lowest close price
                $lowIndex = $lowestPointer; //the primary key for the lowest close price within the maximum profit range in stock table
                $highIndex = $i; //the primary key for the highest close price within the maximum profit range in stock table
            }
            if($closePrice[$i] < $closePrice[$lowestPointer]){ //find out the lowest close price
                $lowestPointer = $i;
            }
        }

        $lowValueDate = $date[$lowIndex]; //the date of the lowest close price appeared
        $highValueDate = $date[$highIndex]; //the date of the highest close price appeared
        //dd($lowValueDate);
        $chart->dataset('Close Price', 'line', $closePrice); //create the stock chart
        //pass values to the home view
        return view('home', [
            'chart' => $chart,
            'profit' => $profit,
            'lowPrice' => $lowValue,
            'highPrice' => $highValue,
            'highPriceDate' => $highValueDate,
            'lowPriceDate' => $lowValueDate,
        ]);
    }
}
