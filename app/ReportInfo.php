<?php
namespace App;

class ReportInfo
{
    public $clientName;

    public $reportName;

    public $dateFrom;

    public $dateTo;

    public $filePath;

    public $fileName;

    public function __construct($clientName, $reportName, $dateFrom, $dateTo, $filePath, $fileName)
    {
        $this->clientName = $clientName;
        $this->reportName = $reportName;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->filePath = $filePath;
        $this->fileName = $fileName;
    }

}
