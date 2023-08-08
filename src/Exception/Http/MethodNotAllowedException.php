<?php

declare(strict_types=1);

namespace App\Exception\Http;

use App\Exception\AbstractException;
use Symfony\Component\HttpFoundation\Response;

class MethodNotAllowedException extends AbstractException
{
    public function getErrorCode(): string
    {
        return 'PAHE002';
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_METHOD_NOT_ALLOWED;
    }
}
