<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\DB;

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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Command::comment(Inspiring::quote());
        $users = DB::select('select * from llx_user');
        foreach ($users as $user) {
            $this->comment($user->lastname);
        }
    }
}
