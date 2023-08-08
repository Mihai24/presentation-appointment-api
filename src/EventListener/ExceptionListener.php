<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Exception\ExceptionFactoryInterface;
use App\Exception\Response\ErrorResponse;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

#[AsEventListener]
class ExceptionListener
{
    protected ExceptionFactoryInterface $exceptionFactory;

    public function __construct(ExceptionFactoryInterface $exceptionFactory)
    {
        $this->exceptionFactory = $exceptionFactory;
    }

    public function __invoke(ExceptionEvent $exceptionEvent): void
    {
        $exceptionEvent->setResponse(
            new ErrorResponse($this->exceptionFactory->create($exceptionEvent->getThrowable()))
        );
    }
}
