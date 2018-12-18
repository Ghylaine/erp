<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\DB;

use Mail;
use App\ReportInfo;
use App\Mail\Report;

class AgaharaweReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:agaharawe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute Agaharawe Reports Process';

    /**
     * The report query.
     *
     * @var string
     */
    private $query = 'select rowid, lastname, firstname from llx_user';

    /**
     * Report Recipients emails.
     *
     * @var string
     */
    private $recipients = ['ppascal.sibomana@gmail.com', 'bigighylaine@gmail.com'];

    private $dateFrom;
    private $dateTo;
    private $clientName;
    private $reportName;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->dateFrom = date('d.m.Y',strtotime("-1 days"));
        $this->dateTo = date('d.m.Y');
        $this->clientName = 'Agaharawe';
        $this->reportName = 'Rapport-Agaharawe';
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dirname = env('DOWNLOAD_PATH', './');

        if (!is_dir($dirname))
        {
            mkdir($dirname, 0755, true);
        }

        $filename = $this->reportName . "-"
            . $this->dateFrom . "-" . $this->dateTo. ".csv";

        $fullName = $dirname . $filename;

        $handle = fopen($fullName, 'w');
        fputcsv($handle, [
            "id",
            "name"
        ]);

        $users = DB::select($this->query);
        foreach ($users as $user) {
            fputcsv($handle, [
                $user->rowid,
                $user->lastname
            ]);
        }

        fclose($handle);

        $reportInfo = new ReportInfo($this->clientName,
                        $this->reportName, $this->dateFrom, $this->dateTo, $fullName, $filename);

        $result = Mail::to($this->recipients)->send(new Report($reportInfo));
        // Mail::to($this->recipients)->queue(new Report($reportInfo));

        $this->comment($result);

    }
}
