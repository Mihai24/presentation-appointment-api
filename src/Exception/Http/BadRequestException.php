<?php

declare(strict_types=1);

namespace App\Exception\Http;

use App\Exception\AbstractException;
use App\Exception\ValidationListContextExceptionInterface;
use Symfony\Component\HttpFoundation\Response;

class BadRequestException extends AbstractException implements ValidationListContextExceptionInterface
{
    protected array $errorList;

    public function __construct(array $errorList = [])
    {
        parent::__construct();

        $this->errorList = $errorList;
    }

    public function getErrorCode(): string
    {
        return 'PAHE001';
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function getErrorList(): array
    {
        return $this->errorList;
    }
}
