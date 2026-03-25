<?php

declare(strict_types=1);

namespace App\Shared\Domain\MessageBus;

interface MessageHandlerInterface
{
    public function handle(MessageInterface $message): void;
}
