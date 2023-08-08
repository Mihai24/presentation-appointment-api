<?php

declare(strict_types=1);

namespace App\Tests\Exception\Response;

use App\Exception\General\GeneralException;
use App\Exception\Http\BadRequestException;
use App\Exception\Response\ErrorResponse;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

final class ErrorResponseTest extends TestCase
{
    public function testErrorResponseStructure(): void
    {
        $subject = new ErrorResponse(new GeneralException());

        $this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $subject->getStatusCode());
        $this->assertEquals(
            '{"error":{"code":"PAGE000","message":"An error has occurred while processing the request"},"context":[]}',
            $subject->getContent()
        );
    }

    public function testErrorResponseStructureWithValidationContext(): void
    {
        $errorList = ['error' => 'message'];
        $subject = new ErrorResponse(new BadRequestException($errorList));

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $subject->getStatusCode());
        $this->assertEquals(
            \json_encode(
                [
                    'error' => [
                        'code' => 'PAHE001',
                        'message' => 'An error has occurred while processing the request'
                    ],
                    'context' => [
                        'invalidInputs' => ['error' => 'message']
                    ]
                ],
                JSON_THROW_ON_ERROR
            ),
            $subject->getContent()
        );
    }
}
