<?php

namespace App\Charts;

use App\Stock;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class StockChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $date = Stock::pluck('date');
        $this->labels($date)
            ->options([
                'legend' => ['display' => false],
                'title' => ['display' => true, 'text' => 'QCOM', 'fontSize' => 20],
                ]);
    }
}
