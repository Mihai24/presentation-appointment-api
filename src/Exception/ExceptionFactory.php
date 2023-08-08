<?php

declare(strict_types=1);

namespace App\Exception;

use App\Exception\General\GeneralException;
use App\Exception\Http\AccessDeniedException;
use App\Exception\Http\BadRequestException;
use App\Exception\Http\MethodNotAllowedException;
use App\Exception\Http\NotFoundException;
use Symfony\Component\HttpFoundation\File\Exception\UnexpectedTypeException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException as AccessDeniedExceptionCore;

class ExceptionFactory implements ExceptionFactoryInterface
{
    public function create(\Throwable $throwable): AbstractException
    {
        if ($throwable instanceof AbstractException) {
            return $throwable;
        }

        return match ($throwable::class) {
            MethodNotAllowedHttpException::class => new MethodNotAllowedException(),
            AccessDeniedHttpException::class, AccessDeniedExceptionCore::class  => new AccessDeniedException(),
            NotFoundHttpException::class => new NotFoundException(),
            BadRequestHttpException::class, UnexpectedTypeException::class => new BadRequestException(),
            default => new GeneralException(),
        };
    }
}
