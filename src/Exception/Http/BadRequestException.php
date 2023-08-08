<?php

declare(strict_types=1);

namespace App\Exception\Http;

use App\Exception\AbstractException;
use Symfony\Component\HttpFoundation\Response;

class BadRequestException extends AbstractException
{
    public function getErrorCode(): string
    {
        return 'PAHE001';
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }
}
