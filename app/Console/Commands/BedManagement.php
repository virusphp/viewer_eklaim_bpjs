<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\Bed\ServiceBed;
use App\Repository\Bed\Bed;
ini_set('max_execution_time', 800);

class BedManagement extends Command
{
    protected $bed, $serviceBed;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:bed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Tempat Tidur';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->bed = new Bed;
        $this->serviceBed = new ServiceBed;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       $data = json_decode($this->bed->getSearch());
       $result = [];
       foreach($data as $key => $v)
       {
           count($data) and print "Inserting data... \n".json_encode($v)."\n\n\n" and  $this->serviceBed->updateBed(json_encode($v));
       }
   
       return;
    }
}
