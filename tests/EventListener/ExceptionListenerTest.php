<?php

declare(strict_types=1);

namespace App\Tests\EventListener;

use App\EventListener\Exception\ExceptionListener;
use App\Exception\ExceptionFactoryInterface;
use App\Exception\General\GeneralException;
use App\Exception\Response\ErrorResponse;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

final class ExceptionListenerTest extends TestCase
{
    private ExceptionFactoryInterface&MockObject $exceptionFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->exceptionFactory = $this->createMock(ExceptionFactoryInterface::class);
    }

    public function testHandleException(): void
    {
        $subject = new ExceptionListener($this->exceptionFactory);
        $generalException = new GeneralException();

        $throwable = $this->createMock(\Throwable::class);
        $request = $this->createMock(Request::class);
        $kernel = $this->createMock(HttpKernelInterface::class);

        $this->exceptionFactory->expects($this->once())
            ->method('create')
            ->with($throwable)
            ->willReturn($generalException);

        $event = new ExceptionEvent($kernel, $request, 1, $throwable);

        $subject($event);

        $this->assertEquals(new ErrorResponse($generalException), $event->getResponse());
    }
}
