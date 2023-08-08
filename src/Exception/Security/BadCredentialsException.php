<?php

declare(strict_types=1);

namespace App\Exception\Security;

use App\Exception\AbstractException;
use Symfony\Component\HttpFoundation\Response;

class BadCredentialsException extends AbstractException
{
    public function getErrorCode(): string
    {
        return 'PASE000';
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_UNAUTHORIZED;
    }
}
