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

    // Setiap task memiliki 1 status
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    // mengembalikan user yang membuat task
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    // relasi dengan user dan mengembalikan user yang mngerjakan task ini
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    // cek apakah user yang membuat task ini
    public function isCreator(User $user): bool
    {
        return $this->creator_id === $user->id;
    }

    // cek apakah user penerima task ini
    public function isAssignee(User $user): bool
    {
        return $this->assignee_id === $user->id;
    }

    // hanya creator yang dapat mengubah task, dan jika status doing atau done, tidak dapat diubah
    public function canBeUpdatedBy(User $user): bool
    {
        if (!$this->isCreator($user)) {
            return false;
        }

        $statusName = $this->status?->name ?? null;
        if ($statusName === 'Doing' || $statusName === 'Done') {
            return false;
        }

        return true;
    }

    // report diisi saat task ber status doing, dan creator dan assignee yang dapat mengisi repot
    public function canSetReportBy(User $user): bool
    {
        $statusName = $this->status?->name ?? null;
        if ($statusName !== 'Doing') {
            return false;
        }

        return $this->isCreator($user) || $this->isAssignee($user);
    }

    //  Mengecek apakah status task dapat diubah ke status tertentu oleh user
    public function canChangeStatusTo(\App\Models\Status $targetStatus, User $user): bool
    {
        $current = $this->status?->name ?? null;
        $target = $targetStatus->name;

        if ($current === $target) {
            return false;
        }

        $hasReport = !empty($this->report);

        switch ($target) {
            case 'To Do':
                if (in_array($current, ['Doing', 'Canceled']) && !$hasReport) {
                    return true;
                }
                return false;

            case 'Doing':
                return $current === 'To Do';

            case 'Done':
                return $current === 'Doing';

            case 'Canceled':
                if (!$this->isCreator($user)) {
                    return false;
                }
                if (!in_array($current, ['To Do', 'Doing'])) {
                    return false;
                }
                if ($hasReport) {
                    return false;
                }
                return true;

            default:
                return false;
        }
    }

}
