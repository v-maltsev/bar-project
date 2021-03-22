<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\ErrorHandler;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use DomainException;

class DomainExceptionFormatter implements EventSubscriberInterface
{
    private ErrorHandler $errors;
    private LoggerInterface $logger;

    public function __construct(ErrorHandler $errors, LoggerInterface $logger)
    {
        $this->errors = $errors;
        $this->logger = $logger;
    }

    public static function getSubscribedEvents(): array
    {
        return array(
            KernelEvents::EXCEPTION => 'onKernelException'
        );
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $request = $event->getRequest();

        if (!$exception instanceof DomainException) {
            return;
        }

        if (strpos($request->attributes->get('_route'), 'api.') !== 0) {
            return;
        }

        $this->errors->handle($exception);

        $event->setResponse(new JsonResponse([
            'error' => [
                'code' => 400,
                'message' => $exception->getMessage(),
            ]
        ], 400));
    }
}
