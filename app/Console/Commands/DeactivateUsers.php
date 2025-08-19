<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MembershipService;

class DeactivateUsers extends Command
{
    protected $signature = 'users:deactivate';
    protected $description = 'Desactivar usuarios sin pagos vigentes';

    public function handle()
    {
        (new MembershipService)->desactivarUsuarios($this);
    }
}
