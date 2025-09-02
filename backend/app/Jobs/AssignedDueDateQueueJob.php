<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\AssignToolboxTalk;
use App\Models\ToolboxTalk;
use Carbon\Carbon;

class AssignedDueDateQueueJob implements ShouldQueue
{
    use Queueable;

    protected $data;
    protected $type;
    
    /**
     * Create a new job instance.
     */
    public function __construct($data, $type)
    {
         $this->data = $data;
         $this->type = $type;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $currentDate = Carbon::now();
        
        if($this->type == 'ToolboxTalk'){
             if((!empty($this->data->due_date) && isset($this->data->due_date)) && ($this->data->due_date != null || $this->data->due_date != '')){
                    ToolboxTalk::where('id', $this->data->id)->where('due_date', '<', $currentDate)->where('due_date', '!=', null)->where('status', '!=', 2)->update(['status' => '2']); 
             } else {
                if(($this->data->get_assigned_users_count != 0 && $this->data->get_count_completed_count != 0) && ($this->data->get_assigned_users_count == $this->data->get_count_completed_count)){
                    ToolboxTalk::where('id', $this->data->id)->where('id', $this->data->id)->where('status', '!=', 2)->update(['status' => '2']);
                }
             }
        } else if($this->type == 'AssignedboxTalk'){
             if((!empty($this->data->due_date) && isset($this->data->due_date)) && ($this->data->due_date != null || $this->data->due_date != '')){
                 AssignToolboxTalk::where('id', $this->data->id)->where('due_date', '!=', null)->where('due_date', '<', $currentDate)->where('status', '!=', 1)->update(['status' => '1']);
             } else {
                 if($this->data->status == 2){
                    AssignToolboxTalk::where('id', $this->data->id)->where('status', '!=', 1)->update(['status' => '1']); 
                 }
             }
        }
        
        
        // if(!empty($this->data) && ($this->data != null || $this->data != '')){
        //     if((!empty($this->data->due_date) && isset($this->data->due_date)) && ($this->data->due_date != null || $this->data->due_date != '')){
        //         ToolboxTalk::where('due_date', '<', $currentDate)->where('status', '!=', 2)->update(['status' => '2']);
        //         AssignToolboxTalk::where('due_date', '<', $currentDate)->where('status', '!=', 1)->update(['status' => '1']);
        //     } else {
        //         if(isset($this->data->get_assigned_users_count) && isset($this->data->get_count_completed_count)){
        //             if(($this->data->get_assigned_users_count != 0 && $this->data->get_count_completed_count != 0) && ($this->data->get_assigned_users_count == $this->data->get_count_completed_count)){
        //                 ToolboxTalk::where('id', $this->data->id)->where('status', '!=', 2)->update(['status' => '2']);
        //             }
        //         }
        //         if(!isset($this->data->get_assigned_users_count) && !isset($this->data->get_count_completed_count)){
        //             AssignToolboxTalk::where('id', $this->data->id)->where('status', '!=', 1)->update(['status' => '1']);
        //         }
        //     }
        // }
        
        
        // if ((!empty($this->data)) && ($this->data->due_date != null || $this->data->due_date != '')) {
        //     ToolboxTalk::where('due_date', '<', $currentDate)->where('status', '!=', 2)->update(['status' => '2']);
        //     AssignToolboxTalk::where('due_date', '<', $currentDate)->where('status', '!=', 1)->update(['status' => '1']);
        // } else {
        //     if ((!empty($this->data)) && (($this->data->get_assigned_users_count != 0 && $this->data->get_count_completed_count != 0) && ($this->data->get_assigned_users_count == $this->data->get_count_completed_count))) {
        //         dd("else ifffffff");
                
        //     } else if ((!empty($this->data)) && (!isset($this->data->getAssignedUsers) && !isset($this->data->getCountCompleted)) && $this->data->status == 2) {
        //         dd("else assigned");
        //         AssignToolboxTalk::where('id', $this->data->id)->where('status', '!=', 1)->update(['status' => '1']);
        //     }
        // }
    }
}
