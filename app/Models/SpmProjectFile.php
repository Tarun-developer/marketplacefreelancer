<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpmProjectFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'task_id',
        'uploaded_by',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'category',
        'description',
        'version',
        'replaces_file_id',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(SpmProject::class, 'project_id');
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(SpmTask::class, 'task_id');
    }

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function replacesFile(): BelongsTo
    {
        return $this->belongsTo(SpmProjectFile::class, 'replaces_file_id');
    }
}