<?php

declare(strict_types=1);

namespace App\Tests\Security\Authenticator;

use App\Security\Authenticator\ApiKeyTokenExtractor;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

final class ApiKeyTokenExtractorTest extends TestCase
{
    public function testExtractAccessToken(): void
    {
        $request = $this->createMock(Request::class);
        $request->headers = new HeaderBag();
        $request->headers->add([ApiKeyTokenExtractor::HEADER_TOKEN_KEY => '123456']);

        $subject = new ApiKeyTokenExtractor();

        $this->assertEquals('123456', $subject->extractAccessToken($request));
    }

    public function testExtractAccessTokenWithNull(): void
    {
        $this->expectException(AccessDeniedException::class);

        $request = $this->createMock(Request::class);
        $request->headers = new HeaderBag();

        $subject = new ApiKeyTokenExtractor();
        $subject->extractAccessToken($request);
    }
}
