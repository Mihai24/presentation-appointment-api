<?php

declare(strict_types=1);

namespace App\Exception;

interface ValidationListContextExceptionInterface
{
    public function getErrorList(): array;
}
