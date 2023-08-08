<?php

declare(strict_types=1);

namespace App\Tests\Validator;

use App\Exception\Http\BadRequestException;
use App\Validator\ViolationListHandlerTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

final class TestViolationListHandler extends TestCase
{
    use ViolationListHandlerTrait;

    public function testNoViolations(): void
    {
        $violationList = $this->createMock(ConstraintViolationList::class);

        $violationList->expects($this->once())
            ->method('count')
            ->willReturn(0);

        $this->handleViolationList($violationList);
    }

    public function testHandleViolations(): void
    {
        $this->expectException(BadRequestException::class);

        $violation = $this->createMock(ConstraintViolation::class);
        $violation->expects($this->once())
            ->method('getMessage')
            ->willReturn('Error message');

        $violation->expects($this->once())
            ->method('getPropertyPath')
            ->willReturn('property');

        $violationList = $this->createMock(ConstraintViolationList::class);
        $violationList->expects($this->once())
            ->method('getIterator')
            ->willReturn(new \ArrayIterator([$violation]));

        $violationList->expects($this->once())
            ->method('count')
            ->willReturn(1);

        $this->handleViolationList($violationList);
    }
}
