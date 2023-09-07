<?php

namespace App\Console\Commands;

use App\Mail\PollsClosedMail;
use App\Models\Election;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class UpdatePollsStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'elections:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the status of elections to "Closed" when the end date and time is reached';


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
     * @return int
     */
    public function handle()
    {
        $this->info('Updating election statuses...');

        $currentDateTime = Carbon::now();
        $closedElections = Election::where('status', 'open')
            ->where('end', '<=', $currentDateTime)
            ->get();

        foreach ($closedElections as $election) {
            $updateStatus = Election::where('status', 'open')
                ->where('end', '<=', $currentDateTime)
                ->update(['status' => 'closed']);
            // $updateStatus = $election->update(['status' => 'closed']);
            if ($updateStatus) {
                $users = User::get();
                foreach ($users as $user) {
                    // Send email notification to voters
                    $info = ([
                        'name' => $user->name,
                        'title' => $election->title
                    ]);
                    Mail::to($user->email)->send(new PollsClosedMail($info));
                }
            }
        }
        $this->info('Election statuses updated successfully.');
    }
}