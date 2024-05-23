<?php

namespace App\Console\Commands;

use App\Program;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExpirePrograms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:expire-programs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire programs whose expiry date has been reached';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredPrograms = Program::where('expiry_date', '<=', Carbon::now())
            ->where('status', 'active')
            ->get();

        foreach ($expiredPrograms as $program) {
            $program->status = 'inactive';
            $program->save();
        }

        $this->info('Expired programs have been marked as inactive.');
    }
}
