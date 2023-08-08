<?php

declare(strict_types=1);

namespace App\Exception\Http;

use App\Exception\AbstractException;
use Symfony\Component\HttpFoundation\Response;

class NotFoundException extends AbstractException
{
    public function getErrorCode(): string
    {
        return 'PAHE003';
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
