<?php

namespace App\Support\Actions;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

final class ExecuteActionJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly Action $action,
        public readonly User $executor,
    ) {}

    public function handle(): void
    {
        $this->action->execute($this->executor);
    }
}
