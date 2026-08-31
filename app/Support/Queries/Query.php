<?php

namespace App\Support\Queries;

use App\Models\User;

abstract readonly class Query
{
    abstract public function execute(User $executor): mixed;
}
