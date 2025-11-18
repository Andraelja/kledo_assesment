<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'task';
    protected $fillable = [
        'title',
        'description',
        'status_id',
        'creator_id',
        'assignee_id',
        'report',
    ];

    public function status() {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function creator() {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function assignee() {
        return $this->belongsTo(User::class, 'assignee_id');
    }
}
