<?php

namespace App\Models\User;

use App\Models\Master\Deliverable;
use App\Models\Master\TaskType;
use App\Models\Master\Team;
use App\Models\Master\TicketReason;
use GuzzleHttp\Promise\TaskQueue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use HasFactory;
    protected $guard = [];

    public function createdTeams(): HasMany
    {
        return $this->hasMany(Team::class, 'created_by_user_id', 'id');
    }

    public function createdDeliverable(): HasMany
    {
        return $this->hasMany(Deliverable::class, 'created_by_user_id', 'id');
    }

    public function createdTicketReason(): HasMany
    {
        return $this->hasMany(TicketReason::class, 'created_by_user_id', 'id');
    }

    public function createdTaskType(): HasMany
    {
        return $this->hasMany(TaskType::class, 'created_by_user_id', 'id');
    }
}
