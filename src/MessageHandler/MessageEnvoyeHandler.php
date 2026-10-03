<?php

namespace App\MessageHandler;

use App\Message\MessageEnvoye;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class MessageEnvoyeHandler
{
    public function __invoke(MessageEnvoye $message): void
    {
        file_put_contents(
            'var/messages.log',
            $message->getContenu() . PHP_EOL,
            FILE_APPEND
        );
    }
}