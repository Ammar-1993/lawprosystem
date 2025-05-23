<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;

class ResetDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is reset database on every 24 hours to make database as default.';

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
        $filename = 'advocatedairy_12-2-2019.sql';
        $restore_file  = storage_path() . '/dumps/'.$filename;
        $server_name   = "127.0.0.1";
        $username      = "root";
        $password      = "";
        $database_name = "advo";

        $cmd = "mysql -h {$server_name} -u {$username} -p{$password} {$database_name} < $restore_file";

        exec($cmd);
        $this->info('Database has been reset successfully');
    }
}
