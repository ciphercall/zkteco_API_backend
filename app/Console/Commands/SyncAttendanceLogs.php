<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ZKTecoController;

class SyncAttendanceLogs extends Command
{
    protected $signature = 'attendance:sync';
    protected $description = 'Sync attendance logs from the device to the database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Call the sync method from ZKTecoController
        app(ZKTecoController::class)->syncAttendanceLogs();
        $this->info('Attendance logs synced successfully.');
    }
}
