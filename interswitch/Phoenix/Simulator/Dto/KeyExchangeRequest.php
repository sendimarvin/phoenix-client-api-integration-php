<?php

namespace Interswitch\Phoenix\Simulator\Dto;

class KeyExchangeRequest extends ClientTerminalRequest
{
    protected string $password;
    public string $clientSessionPublicKey;

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getClientSessionPublicKey(): string
    {
        return $this->clientSessionPublicKey;
    }

    public function setClientSessionPublicKey(string $clientSessionPublicKey): void
    {
        $this->clientSessionPublicKey = $clientSessionPublicKey;
    }
}
