<?php

namespace App\Services;

use App\Models\Task;
use App\Models\Status;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    public function createTask(array $data, User $user) {
        // untuk mengetahui siapa yang membuat task
        $data['creator_id'] = $user->id;
        // saat membuat task pertama kali, status todo, dan firstOrFail itu untuk melempar jika tidak ada status maka error
if (!isset($data['status_id'])) {
    $data['status_id'] = Status::where('name', 'To Do')->firstOrFail()->id;
}

        // jika tidak ada yang menugaskan ke dia, maka task tersebut untuk dia sendiri
        if(!isset($data['assignee_id'])) {
            $data['assignee_id'] = $user->id;
        }

        // tambahkan data
        return Task::create($data);
    }
}
