<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class AssignToolboxTalk extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function getRole() {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
        
    public function getPermission() {
        return $this->belongsTo(Permission::class, 'permission_id', 'id');
    }

    public function assignedUsers() { 
        return $this->belongsTo(User::class, 'user_id', 'id'); 
    }
    
    // public function assignedUsersAll() { 
    //     return $this->hasMany(User::class, 'id', 'user_id'); 
    // }

    public function getToolboxTalk()
    {
        return $this->belongsTo(ToolboxTalk::class, 'toolbox_talk_id', 'id')->with('getCreatedByUser', 'questions', 'getAssignedUsers', 'resourceUrlData', 'attachmentsPdfData');
    }
    
    public function getTestToolboxTalk()
    {
        return $this->belongsTo(ToolboxTalk::class, 'toolbox_talk_id', 'id');
    }
    
    public function getOnlyToolboxTalk()
    {
        return $this->belongsTo(ToolboxTalk::class, 'toolbox_talk_id', 'id');
    }
    
    public function scopeSearchingAssignedMeFilter($query, $req)
    {
        // $startDate = \Carbon\Carbon::parse($req->start_date)->startOfDay();
        // $endDate = \Carbon\Carbon::parse($req->end_date)->endOfDay();
        // $search = $req->search;
        // $status = $req->status;
        // $authUserId = Auth::user()->id ?? '4392';

        // if ((isset($req->search) && $req->search != null || $req->search != '') && (isset($req->status) && ($req->status != null || $req->status != '')) && (isset($req->start_date) && isset($req->end_date))) {
        //     // dd("ifff1");
        //     return $query->where('user_id', $authUserId)->whereHas('getOnlyToolboxTalk', function ($q) use ($search, $startDate, $endDate) {
        //         $q->where('title', 'like', '%' . $search . '%')->whereBetween('due_date', [$startDate, $endDate]);
        //     })->where('status', $status);
        // } else if ((isset($req->search) && $req->search != null || $req->search != '') && (isset($req->status) && ($req->status != null || $req->status != ''))) {
        //     // dd("ifff2");
        //     return $query->where('user_id', $authUserId)->whereHas('getOnlyToolboxTalk', function ($q) use ($search) {
        //         $q->where('title', 'like', '%' . $search . '%');
        //     })->where('status', $status);
        // } else if ((isset($req->search) && $req->search != null || $req->search != '') && (isset($req->start_date) && isset($req->end_date))) {
        //     // dd("ifff3");
        //     return $query->where('user_id', $authUserId)->whereHas('getOnlyToolboxTalk', function ($q) use ($search, $startDate, $endDate) {
        //         $q->where('title', 'like', '%' . $search . '%')->whereBetween('due_date', [$startDate, $endDate]);
        //     });
        // } else if ((isset($req->status) && $req->status != null || $req->status != '') && (isset($req->start_date) && isset($req->end_date))) {
        //     // dd("ifff4");
        //     return $query->where('user_id', $authUserId)->whereHas('getOnlyToolboxTalk', function ($q) use ($startDate, $endDate) {
        //         $q->whereBetween('due_date', [$startDate, $endDate]);
        //     })->where('status', $status);
        // } else if ((isset($req->search)) && ($req->search != null || $req->search != '')) {
        //     // dd("ifff5");
        //     return $query->where('user_id', $authUserId)->whereHas('getOnlyToolboxTalk', function ($q) use ($search) {
        //         $q->where('title', 'like', '%' . $search . '%');
        //     });
        // } else if ((isset($req->status)) && ($req->status != null || $req->status != '')) {
        //     // dd("ifff6");
        //     return $query->where('user_id', $authUserId)->where('status', $status);
            
        // } else if ((isset($req->start_date) && isset($req->end_date)) && ($req->start_date != null || $req->start_date != '')  && ($req->end_date != null || $req->end_date != '')) {
        //     // dd("ifff7");
        //     return $query->where('user_id', $authUserId)->whereHas('getOnlyToolboxTalk', function ($q) use ($startDate, $endDate) {
        //         $q->whereBetween('due_date', [$startDate, $endDate]);
        //     });
        // }
        
        $startDate = \Carbon\Carbon::parse($req->start_date)->startOfDay();
        $endDate = \Carbon\Carbon::parse($req->end_date)->endOfDay();
        $search = $req->search;
        $status = $req->status;
        $authUserId = Auth::user()->id ?? '4392';

        if ((isset($req->search) && $req->search != null || $req->search != '') && (isset($req->status) && ($req->status != null || $req->status != '')) && (isset($req->start_date) && isset($req->end_date) && ($req->start_date != null || $req->start_date != '') && ($req->end_date != null || $req->end_date != '') )) {
            // dd("ifff1");
            return $query->whereHas('getOnlyToolboxTalk', function ($q) use ($search, $startDate, $endDate) {
                $q->where('title', 'like', '%' . $search . '%')->whereBetween('due_date', [$startDate, $endDate]);
            })->where('status', $status);
        } else if ((isset($req->search) && $req->search != null || $req->search != '') && (isset($req->status) && ($req->status != null || $req->status != ''))) {
            // dd("ifff2");
            return $query->whereHas('getOnlyToolboxTalk', function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%');
            })->where('status', $status);
        } else if ((isset($req->search) && $req->search != null || $req->search != '') && (isset($req->start_date) && isset($req->end_date)) && ($req->start_date != null || $req->start_date != '') && ($req->end_date != null || $req->end_date != '')) {
            // dd("ifff3");
            return $query->whereHas('getOnlyToolboxTalk', function ($q) use ($search, $startDate, $endDate) {
                $q->where('title', 'like', '%' . $search . '%')->whereBetween('due_date', [$startDate, $endDate]);
            });
        } else if ((isset($req->status) && $req->status != null || $req->status != '') && (isset($req->start_date) && isset($req->end_date)) && ($req->start_date != null || $req->start_date != '') && ($req->end_date != null || $req->end_date != '')) {
            // dd("ifff4");
            return $query->whereHas('getOnlyToolboxTalk', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('due_date', [$startDate, $endDate]);
            })->where('status', $status);
        } else if ((isset($req->search)) && ($req->search != null || $req->search != '')) {
            // dd("ifff5");
            return $query->whereHas('getOnlyToolboxTalk', function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%');
            });
        } else if ((isset($req->status)) && ($req->status != null || $req->status != '')) {
            // dd("ifff6");
            return $query->where('status', $status);
            
        } else if ((isset($req->start_date) && isset($req->end_date)) && ($req->start_date != null || $req->start_date != '')  && ($req->end_date != null || $req->end_date != '')) {
            // dd("ifff7");
            return $query->whereHas('getOnlyToolboxTalk', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('due_date', [$startDate, $endDate]);
            });
        }
    }
}
