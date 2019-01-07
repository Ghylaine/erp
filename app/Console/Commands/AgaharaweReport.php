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
    // private $query = "SELECT  p.label as Article,
    //     SUM(COALESCE(CASE WHEN type_mouvement = 3 THEN value END,0)) as 'IN',
    //     SUM(COALESCE(CASE WHEN type_mouvement = 2 THEN value END,0)) * -1 as 'OUT',
    //     sm.price as 'PU',
    //     (SUM(COALESCE(CASE WHEN type_mouvement = 2 THEN value END,0)) * -1 * sm.price) as 'CASH',
    //     ps.reel as Quantite, p.price as 'PrixUnitaireAchat',
    //     (ps.reel * p.price) as 'PrixTotalAchat'
    //     FROM llx_product_stock ps
    //     INNER JOIN llx_product p ON ps.fk_product = p.rowid
    //     INNER JOIN llx_stock_mouvement sm ON sm.fk_product = p.rowid
    //     INNER JOIN llx_entrepot e ON ps.fk_entrepot = e.rowid
    //     WHERE date(sm.datem) = date_sub(curdate(), INTERVAL 3 DAY)
    //     GROUP BY p.rowid";
    private $query = "SELECT *, (a.OUT * a.GainU) as 'GainTotal' FROM (SELECT  p.label as Article,
    SUM(COALESCE(CASE WHEN type_mouvement = 3 THEN value END,0)) as 'APPROVISIONEMENT',
    ps.reel as 'STAY',
    SUM(COALESCE(CASE WHEN type_mouvement = 2 THEN value END,0)) * -1 as 'OUT',
    sm.price as 'PU',
    (SUM(COALESCE(CASE WHEN type_mouvement = 2 THEN value END,0)) * -1 * sm.price) as 'CASH',
    (sm.price - pfp.price) as 'GainU'
    FROM llx_product p
    LEFT JOIN llx_product_stock ps ON ps.fk_product = p.rowid
    LEFT JOIN llx_product_fournisseur_price pfp on pfp.fk_product = p.rowid
    LEFT JOIN llx_stock_mouvement sm ON sm.fk_product = p.rowid
    WHERE (date(sm.datem) BETWEEN '2019-01-04 00:00:00' AND '2019-01-05 00:00:00')
    GROUP BY p.rowid) as a";

    /**
     * Report Recipients emails.
     *
     * @var string
     */
    // private $recipients = ['ppascal.sibomana@gmail.com', 'bigighylaine@gmail.com'];
    private $recipients = ['ppascal.sibomana@gmail.com'];

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
        // $this->dateFrom = date('d.m.Y',strtotime("-1 days"));
        // $this->dateTo = date('d.m.Y');
        $this->dateFrom = "2019-01-04";
        $this->dateTo = "2019-01-05";
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
            "Article",
            "APPROVISIONEMENT",
            "STAY",
            "OUT",
            "PU",
            "CASH",
            "GainU",
            "GainTotal"
        ]);

        $articles = DB::select($this->query);
        foreach ($articles as $article) {
            fputcsv($handle, [
                $article->Article,
                $article->APPROVISIONEMENT,
                $article->STAY,
                $article->OUT,
                $article->PU,
                $article->CASH,
                $article->GainU,
                $article->GainTotal,
            ]);
        }

        fclose($handle);

        $reportInfo = new ReportInfo($this->clientName,
                        $this->reportName, $this->dateFrom, $this->dateTo, $fullName, $filename);

        $result = Mail::to($this->recipients)->send(new Report($reportInfo));
        // Mail::to($this->recipients)->queue(new Report($reportInfo));

    }
}
