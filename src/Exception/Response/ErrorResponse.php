<?php

declare(strict_types=1);

namespace App\Exception\Response;

use App\Exception\AbstractException;
use App\Exception\ValidationListContextExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ErrorResponse extends JsonResponse
{
    public function __construct(AbstractException $abstractException)
    {
        $body = [
            'error' => [
                'code' => $abstractException->getErrorCode(),
                'message' => $abstractException->getMessage(),
            ],
            'context' => []
        ];

        if (
            $abstractException instanceof ValidationListContextExceptionInterface
            && \count($abstractException->getErrorList()) > 0
        ) {
            $body['context']['invalidInputs'] = $abstractException->getErrorList();
        }

        parent::__construct(
            $body,
            $abstractException->getStatusCode(),
            $abstractException->getHeaders()
        );
    }
}
