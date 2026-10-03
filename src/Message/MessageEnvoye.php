<?php

namespace App\Message;

class MessageEnvoye
{
    public function __construct(
        private string $contenu
    ) {
    }

    public function getContenu(): string
    {
        return $this->contenu;
    }
}