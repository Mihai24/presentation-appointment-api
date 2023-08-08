<?php

declare(strict_types=1);

namespace App\Exception;

interface ExceptionFactoryInterface
{
    public function create(\Throwable $throwable): AbstractException;
}
