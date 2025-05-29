<?php

namespace App\Scheduler;

use App\Services\ApiSyncProductService;
use Illuminate\Support\Facades\DB;

class ApiClientSynchronization{

    public function __invoke()
    {
        \App\Jobs\SyncProductsFromEndpoint::dispatch();
    }

}
