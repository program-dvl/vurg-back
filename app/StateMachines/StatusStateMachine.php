<?php

namespace App\StateMachines;

use Asantibanez\LaravelEloquentStateMachines\StateMachines\StateMachine;

class StatusStateMachine extends StateMachine
{
    public function recordHistory(): bool
    {
        return false;
    }

    public function transitions(): array
    {
        return [
            'pending' => ['wait', 'cancel', 'reject'],
            'wait' => ['payment_received', 'cancel', 'reject'],
            'payment_received' => ['payment_accept', 'cancel'],
            'payment_accept' => ['done']
        ];
    }

    public function defaultState(): ?string
    {
        return 'pending';
    }
}
