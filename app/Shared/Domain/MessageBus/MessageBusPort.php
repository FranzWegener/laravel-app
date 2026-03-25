<?php

declare(strict_types=1);

namespace App\Shared\Domain\MessageBus;

interface MessageBusPort
{
    public function registerHandler(string $messageClass, MessageHandlerInterface $handler): void;

    public function dispatch(MessageInterface $message): void;
}
