<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Auth;

class ToolboxTalk extends Model
{
    use HasFactory, HasRoles, SoftDeletes;

    protected $guarded = [];

    public function questions()
    {
        return $this->hasMany(Question::class, 'toolbox_talk_id', 'id')->with('options', 'correctAnswer');
    }

    public function resourceUrlData()
    {
        return $this->hasMany(ResourceVideoLink::class, 'toolbox_talk_id', 'id');
    }

    public function attachmentsPdfData()
    {
        return $this->hasMany(MediaFile::class, 'toolbox_talk_id', 'id');
    }

    public function getCreatedByUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->with('roles');
    }

    public function getAssignRole()
    {
        return $this->hasMany(AssignToolboxTalk::class, 'toolbox_talk_id', 'id')->with('getRole', 'getPermission');
    }

    public function getAssignedUsers()
    {
        return $this->hasMany(AssignToolboxTalk::class, 'toolbox_talk_id', 'id')->with('assignedUsers');
    }

    public function getCountCompleted()
    {
        return $this->hasMany(AssignToolboxTalk::class, 'toolbox_talk_id', 'id')
            ->where('status', 2);
    }


    public function scopeSearchingCreatedByAndLibraryFilter($query, $req)
    {
        $startDate = \Carbon\Carbon::parse($req->start_date)->startOfDay();
        $endDate = \Carbon\Carbon::parse($req->end_date)->endOfDay();
        $search = $req->search;
        $searchCms = $req->search_cms;
        $createdAtCms = $req->created_at_cms;
        $status = $req->status;
        $lastUpdated = $req->last_updated;
        $authUserId = Auth::user()->id ?? 1;
        // $createdByMe = $req->created_by;
        if ((isset($req->search) && $req->search != null || $req->search != '') && (isset($req->status) && ($req->status != null || $req->status != '')) && (isset($req->start_date) && isset($req->end_date))) {
            return $query->where('user_id', $authUserId)->where(function ($q) use ($search, $status, $startDate, $endDate) {
                $q->where('title', 'like', '%' . $search . '%')->where('status', $status)->whereBetween('created_at', [$startDate, $endDate]);
            });
        } else if ((isset($req->search) && $req->search != null || $req->search != '') && (isset($req->status) && ($req->status != null || $req->status != ''))) {
            return $query->where('user_id', $authUserId)->where(function ($q) use ($search, $status) {
                $q->where('title', 'like', '%' . $search . '%')->where('status', $status);
            });
        } else if ((isset($req->search) && $req->search != null || $req->search != '') && (isset($req->start_date) && isset($req->end_date))) {
            return $query->where('user_id', $authUserId)->where(function ($q) use ($search, $startDate, $endDate) {
                $q->where('title', 'like', '%' . $search . '%')->whereBetween('created_at', [$startDate, $endDate]);
            });
        } else if ((isset($req->status) && $req->status != null || $req->status != '') && (isset($req->start_date) && isset($req->end_date))) {
            return $query->where('user_id', $authUserId)->where(function ($q) use ($status, $startDate, $endDate) {
                $q->where('status', $status)->whereBetween('created_at', [$startDate, $endDate]);
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
                $q->whereBetween('created_at', [$startDate, $endDate]);
            });
        } else if ((isset($req->search_cms) && $req->search_cms != null || $req->search_cms != '')) {
            return $query->where('user_id', $authUserId)->where(function ($q) use ($searchCms) {
                $q->where('is_library', '1')->where('is_library_deleted', '2')->where('title', 'like', '%' . $searchCms . '%');
            });
        } else if ((isset($req->sort_by)) && ($req->sort_by != null || $req->sort_by != '') && ($req->sort_by == 2)) {
            return $query->where('user_id', $authUserId)->where(function ($q) {
                $q->where(function ($q) {
                    $q->where('is_library', '1')->orWhere('is_library', '2');
                })->where('is_library_deleted', '2');
            })->orderBy('updated_at', 'desc');
        } else if ((isset($req->sort_by)) && ($req->sort_by != null || $req->sort_by != '') && $req->sort_by == 1) {
            return $query->where('user_id', $authUserId)->where(function ($q) {
                $q->where(function ($q) {
                    $q->where('is_library', '1')->orWhere('is_library', '2');
                })->where('is_library_deleted', '2');
            })->orderBy('created_at', 'desc');
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
