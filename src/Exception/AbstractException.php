<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

abstract class AbstractException extends \Exception implements HttpExceptionInterface
{
    protected const MESSAGE = 'An error has occurred while processing the request';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }

    public function getHeaders(): array
    {
        return [];
    }

    abstract public function getErrorCode(): string;

    abstract public function getStatusCode(): int;
}
