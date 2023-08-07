<?php

declare(strict_types=1);

namespace App\Tests\ArgumentResolver;

use App\ArgumentResolver\RequestArgumentResolver;
use App\Presentation\DataTransfer\PresentationDto;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;

final class RequestArgumentResolverTest extends TestCase
{
    private SerializerInterface&MockObject $serializer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->serializer = $this->createMock(SerializerInterface::class);
    }

    /**
     * @dataProvider validDtoData
     */
    public function testResolveWithValidArguments(string $dtoClass, string $content, mixed $expectedDto): void
    {
        $subject = new RequestArgumentResolver($this->serializer);

        $request = $this->createMock(Request::class);
        $argument = $this->createMock(ArgumentMetadata::class);

        $argument->expects($this->once())
            ->method('getType')
            ->willReturn($dtoClass);

        $request->expects($this->once())
            ->method('getContent')
            ->willReturn($content);

        $this->serializer->expects($this->once())
            ->method('deserialize')
            ->with($content, $dtoClass, 'json')
            ->willReturn($expectedDto);

        $this->assertEquals([$expectedDto], $subject->resolve($request, $argument));
    }

    public function testResolveWithInvalidArguments(): void
    {
        $subject = new RequestArgumentResolver($this->serializer);

        $request = $this->createMock(Request::class);
        $argument = $this->createMock(ArgumentMetadata::class);

        $argument->expects($this->once())
            ->method('getType')
            ->willReturn(\DateTimeImmutable::class);

        $this->assertEquals([], $subject->resolve($request, $argument));
    }

    /**
     * @see testResolveWithValidArguments
     */
    public static function validDtoData(): array
    {
        $presentationDto = new PresentationDto();
        $presentationDto->name = 'presentation';
        $presentationDto->description = 'description';
        $presentationDto->startsAt = '01.05.2023 15:30';
        $presentationDto->endsAt = '01.05.2023 16:30';

        return [
            'Presentation DTO' => [
                'dtoClass' => PresentationDto::class,
                'content' => <<<EOD
                    {
                        "name": "presentation",
                        "description": "description",
                        "startsAt": "01.05.2023 15:30",
                        "endsAt": "01.05.2023 16:30"
                    }
                EOD,
                'expectedDto' => $presentationDto,
            ]
        ];
    }
}
