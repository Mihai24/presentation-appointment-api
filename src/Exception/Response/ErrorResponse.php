<?php

declare(strict_types=1);

namespace App\Exception\Response;

use App\Exception\AbstractException;
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

        parent::__construct(
            $body,
            $abstractException->getStatusCode(),
            $abstractException->getHeaders()
        );
    }
}
