<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
class everyMinute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Daily';

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
        $totalView=DB::table('customers')->value('mstatus');
        $update=$totalView+1;
        DB::table('customers')->update(['mstatus'=>$update]);
    }
 
}
