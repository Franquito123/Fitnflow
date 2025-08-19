<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MembershipService;

class ReactivateUsers extends Command
{
    protected $signature = 'users:reactivate';
    protected $description = 'Reactivar usuarios con pagos vigentes';

    public function handle()
    {
        (new MembershipService)->reactivarUsuarios($this);
    }
}
