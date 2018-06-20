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
        $closePrice = Stock::pluck('close'); //chart display close price
        $lowPrice = Stock::pluck('low'); //low price array
        $highPrice = Stock::pluck('high'); //high price array
        $date = Stock::pluck('date'); //date array

        $lowValue = 0; //the lowest price
        $highValue = 0; //the highest price
        $highIndex = 0; //the highest price index
        $lowestPointer = 0; //the lowest price index of the whole array
        $lowIndex = 0; //the lowest price index
        $profit = 0; //the maximum profit

        for($i = 0; $i < sizeof($lowPrice); $i++){ //go through the array, all arrays have same array size
            if($highPrice[$i] - $lowPrice[$lowestPointer] > $profit){ //find the maximum profit
                $profit = $highPrice[$i] - $lowPrice[$lowestPointer]; //store data to the variables
                $highValue = $highPrice[$i]; //the highest price
                $lowValue = $lowPrice[$lowestPointer]; //the lowest price
                $lowIndex = $lowestPointer + 1; //the primary key for the lowest price within the maximum profit range in stock table
                $highIndex = $i + 1; //the primary key for the highest price within the maximum profit range in stock table
            }
            if($lowPrice[$i] < $lowPrice[$lowestPointer]){ //find out the lowest price
                $lowestPointer = $i;
            }
        }

        $lowValueDate = $date[$lowIndex]; //the date of the lowest price appeared
        $highValueDate = $date[$highIndex]; //the date of the highest price appeared

        $chart->dataset('Close Price', 'line', $closePrice); //create the stock chart
        //pass values to the home view
        return view('home', [
            'chart' => $chart,
            'profit' => $profit,
            'lowPrice' => $lowValue,
            'highPrice' => $highValue,
            'highPriceDate' => $lowValueDate,
            'lowPriceDate' => $highValueDate,
        ]);
    }
}
