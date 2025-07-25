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

    public function getRole()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function getPermission()
    {
        return $this->belongsTo(Permission::class, 'permission_id', 'id');
    }

    public function assignedUsers()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // public function assignedUsersAll() { 
    //     return $this->hasMany(User::class, 'id', 'user_id'); 
    // }

    public function getToolboxTalk()
    {
        return $this->belongsTo(ToolboxTalk::class, 'toolbox_talk_id', 'id')->with('getCreatedByUser', 'questions', 'getAssignedUsers', 'resourceUrlData', 'attachmentsPdfData');
    }

    public function scopeSearchingAssignedMeFilter($query, $req)
    {
        $startDate = \Carbon\Carbon::parse($req->start_date)->startOfDay();
        $endDate = \Carbon\Carbon::parse($req->end_date)->endOfDay();
        $search = $req->search;
        $status = $req->status;
        $lastUpdated = $req->last_updated;
        $authUserId = Auth::user()->id ?? 1;
        // $createdByMe = $req->created_by;
        if ((isset($req->search) && $req->search != null || $req->search != '') && (isset($req->status) && ($req->status != null || $req->status != '')) && (isset($req->start_date) && isset($req->end_date))) {
            return $query->where('user_id', $authUserId)->where(function ($q) use ($search, $status, $startDate, $endDate) {
                $q->where('title', 'like', '%' . $search . '%')->where('status', $status)->whereBetween('due_date', [$startDate, $endDate]);
            });
        } else if ((isset($req->search) && $req->search != null || $req->search != '') && (isset($req->status) && ($req->status != null || $req->status != ''))) {
            return $query->where('user_id', $authUserId)->where(function ($q) use ($search, $status) {
                $q->where('title', 'like', '%' . $search . '%')->where('status', $status);
            });
        } else if ((isset($req->search) && $req->search != null || $req->search != '') && (isset($req->start_date) && isset($req->end_date))) {
            return $query->where('user_id', $authUserId)->where(function ($q) use ($search, $startDate, $endDate) {
                $q->where('title', 'like', '%' . $search . '%')->whereBetween('due_date', [$startDate, $endDate]);
            });
        } else if ((isset($req->status) && $req->status != null || $req->status != '') && (isset($req->start_date) && isset($req->end_date))) {
            return $query->where('user_id', $authUserId)->where(function ($q) use ($status, $startDate, $endDate) {
                $q->where('status', $status)->whereBetween('due_date', [$startDate, $endDate]);
            });
        } else if ((isset($req->search)) && ($req->search != null || $req->search != '')) {
            return $query->where('user_id', $authUserId)->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%');
            });
        } else if ((isset($req->status)) && ($req->status != null || $req->status != '')) {
            return $query->where('user_id', $authUserId)->where(function ($q) use ($status) {
                $q->where('status', $status);
            });
        } else if ((isset($req->start_date) && isset($req->end_date))) {
            return $query->where('user_id', $authUserId)->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('due_date', [$startDate, $endDate]);
            });
        } else if ((isset($req->last_updated)) && ($req->last_updated != null || $req->last_updated != '')) {
            return $query->where('user_id', $authUserId)->where(function ($q) use ($lastUpdated) {
                $q->where('updated_at', $lastUpdated);
            });
        }
        // else if ((isset($req->created_by)) && ($req->created_by != null || $req->created_by != '')) {
        //     return $query->whereHas('getCreatedByUser', function ($q) use ($authUserId, $createdByMe) {
        //         $q->where('user_id', $authUserId)->where(function ($q) use ($createdByMe) {
        //             $q->where('name', 'like', '%' . $createdByMe . '%');
        //         });
        //     });
        // }
    }
}
