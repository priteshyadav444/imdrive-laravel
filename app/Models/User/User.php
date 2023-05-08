<?php

namespace App\Models\User;

use App\Models\Master\Deliverable;
use App\Models\Master\TaskType;
use App\Models\Master\Team;
use App\Models\Master\TicketReason;
use App\Models\Project\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;    
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable

{
    use HasFactory, Notifiable, HasApiTokens;

    protected $guarded = ['created_at', 'updated_at', 'id', 'account_status'];
    protected $apppend = ['fullname'];
    protected $guard = "user";

    # Scopes

    // scope to get only active users
    public function scopeActive($query): void
    {
        $query->where('account_status', 'active');
    }

    // scope for  dynamic type user
    public function scopeOfType($query, $type = "inactive")
    {
        $query->where('account_status', "=", $type);
    }

    # Reletionships with teams

    public function createdTeams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    public function createdDeliverable(): HasMany
    {
        return $this->hasMany(Deliverable::class);
    }

    public function createdTicketReason(): HasMany
    {
        return $this->hasMany(TicketReason::class);
    }

    public function createdTaskType(): HasMany
    {
        return $this->hasMany(TaskType::class);
    }

    public function createdProjects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
    /**
     * getFullNameAttribute : attributes method return full name
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->firstname . " " . $this->lastname;
    }
}
