<?php

declare(strict_types=1);

namespace App\ArgumentResolver;

use App\DataTransfer\DataTransferObjectInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;

#[Autoconfigure(tags: ['controller.argument_value_resolver'])]
final class RequestArgumentResolver implements ValueResolverInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $argumentType = $argument->getType();

        if (false === \is_subclass_of($argumentType, DataTransferObjectInterface::class)) {
            return [];
        }

        return [$this->serializer->deserialize($request->getContent(), $argumentType,'json')];
    }
}
