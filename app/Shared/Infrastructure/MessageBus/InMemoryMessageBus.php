<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\MessageBus;

use App\Shared\Domain\Exceptions\InvalidArgumentException;
use App\Shared\Domain\Exceptions\RuntimeException;
use App\Shared\Domain\MessageBus\MessageBusPort;
use App\Shared\Domain\MessageBus\MessageHandlerInterface;
use App\Shared\Domain\MessageBus\MessageInterface;

/**
 * In-memory message bus. In a real application this would delegate to SQS, RabbitMQ, Kafka, etc.
 */
class InMemoryMessageBus implements MessageBusPort
{
    /** @var array<string, MessageHandlerInterface[]> */
    private array $handlers = [];

    public function registerHandler(string $messageClass, MessageHandlerInterface $handler): void
    {
        if (!is_subclass_of($messageClass, MessageInterface::class)) {
            throw new InvalidArgumentException("{$messageClass} must implement MessageInterface");
        }
        $this->handlers[$messageClass][] = $handler;
    }

    public function dispatch(MessageInterface $message): void
    {
        $messageClass = get_class($message);

        if (!isset($this->handlers[$messageClass])) {
            throw new RuntimeException('No handler registered for message: ' . $messageClass);
        }

        foreach ($this->handlers[$messageClass] as $handler) {
            try {
                $handler->handle($message);
            } catch (\Throwable $e) {
                error_log('Handler error: ' . $e->getMessage());
            }
        }
    }
}
