<?php
namespace Yaseek;

class Instagram {

    private $clientId;
    private $clientSecret;

    public function __construct($clientId, $clientSecret) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }
}