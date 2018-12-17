<?php
namespace App;

class ReportInfo
{
    public $clientName;

    public $reportName;

    public $dateFrom;

    public $dateTo;

    public function __construct($clientName, $reportName, $dateFrom, $dateTo)
    {
        $this->clientName = $clientName;
        $this->reportName = $reportName;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

}
