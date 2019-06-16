<?php

namespace App\Console\Commands;

use App\Library\Services\Contracts\NccServiceInterface;
use Illuminate\Console\Command;

class ImportCve extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:cve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import CVE\'s file to Mongo DB using Eloquent';

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
     * @param NccServiceInterface $ncc
     * @return mixed
     */
    public function handle(NccServiceInterface $ncc) {
        $value = $ncc->import_csv_file();
        $this->info($value);
    }
}
