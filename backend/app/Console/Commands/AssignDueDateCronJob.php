<?php

namespace App\Console\Commands;

use App\Jobs\AssignedDueDateQueueJob;
use App\Models\AssignToolboxTalk;
use App\Models\ToolboxTalk;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AssignDueDateCronJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'asignedduedatecronjob:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expired toolbox talk due to expire due date.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $allToolBoxTalks = ToolboxTalk::where('status', '!=', 2)->withCount('getAssignedUsers', 'getCountCompleted')->where('deleted_at', null)->orderBy('id', 'DESC')->get();

        $allAssignedBoxTalks = AssignToolboxTalk::where('status', '!=', 1)->withCount('getToolboxTalk')->where('deleted_at', null)->orderBy('id', 'DESC')->get();

        if (!empty($allToolBoxTalks) && count($allToolBoxTalks) > 0) {
            foreach ($allToolBoxTalks as $key => $talks) {
                AssignedDueDateQueueJob::dispatch($talks, 'ToolboxTalk');
                $this->info('Job dispatched successfully!');
            }
        }
        if (!empty($allAssignedBoxTalks) && count($allAssignedBoxTalks) > 0) {
            foreach ($allAssignedBoxTalks as $key => $assignedTalk) {
                AssignedDueDateQueueJob::dispatch($assignedTalk, 'AssignedboxTalk');
                $this->info('Job dispatched successfully!');
            }
        }


        // $expiredAssignedTalks = AssignToolboxTalk::where('due_date', '<', $currentDate)->where('status', '!=', 1)->get();
        // foreach ($expiredAssignedTalks as $assignedTalk) {
        //     $assignedTalk->update(['status' => 1]);
        // }
        // $expiredToolTalks = ToolboxTalk::where('due_date', '<', $currentDate)->where('status', '!=', 2)->get();
        // foreach ($expiredToolTalks as $talkToolBox) {
        //     $talkToolBox->update(['status' => 2]);
        // }
        // $this->info('Expired toolbox talks updated successfully.');
    }
}
