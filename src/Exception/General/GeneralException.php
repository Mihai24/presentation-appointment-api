<?php

declare(strict_types=1);

namespace App\Exception\General;

use App\Exception\AbstractException;
use Symfony\Component\HttpFoundation\Response;

class GeneralException extends AbstractException
{
    public function getErrorCode(): string
    {
        return 'PAGE000';
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}
