<?php

namespace App\Models\Project;

use App\Models\Master\Deliverable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasFactory;

    public function deliverables(): belongsToMany
    {
        return $this->belongsToMany(Deliverable::class)->as('project_deliverables')
            ->withPivot('id');
    }
}
