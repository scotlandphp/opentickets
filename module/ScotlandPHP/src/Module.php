<?php

declare(strict_types=1);

namespace OpenTickets\ScotlandPHP;

final class Module
{
    public function getConfig() : array
    {
        return require __DIR__.'/../config/module.config.php';
    }
}
