<?php

namespace App\Http\Controllers;

use App\Stock;
use Illuminate\Http\Request;

class StockDataController extends Controller
{
    public function getStockData(){
        $client = new \GuzzleHttp\Client();
        $pageNum = 1;
        $startDate = '2017-06-16';
        $endDate = '2018-06-15';

        for($i = 0; $i < $pageNum; $i++){
            //retrieve the stock data from the end date to the start date (the first page, second page and third page)
            $res = $client->request('Get','https://api.intrinio.com/prices?identifier=QCOM&page_number='.$pageNum, ['auth' => ['e7b81e9b061c34f973ccb8ae084c57c5', 'c43aa0d06f31853c1f54a81bf4e92a22']]);
            $response = $res->getBody()->getContents();
            $jData = json_decode($response); //decode the date to json format

            $numItems = count($jData->data); //calculate the length
            $dataIndexer = 0;
            foreach($jData->data as $data){ //store each data to the database "stock table"
                if($data->date <= $endDate && $data->date >= $startDate){
                    Stock::create([
                        'date' => $data->date,
                        'open' => $data->open,
                        'high' => $data->high,
                        'low' => $data->low,
                        'close' => $data->close,
                    ]);
                }
                if(++$dataIndexer === $numItems) {
                    $pageNum++;
                }
                if($data->date == $startDate){ //if find the start date the loop stops
                    break;
                }

            }
        }
    }

}
