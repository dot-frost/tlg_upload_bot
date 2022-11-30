<?php

namespace App\Services\Telegram;

use GuzzleHttp\Client;

class Bot
{
    private string $endpoint;

    public function __construct(
        private string $token,
        private string $webhook,
        private Client $clinet = new Client()
    ) {
    }

    private function getBaseUri()
    {
        return "https://api.telegram.org/bot{$this->token}/";
    }

    private function getBaseUriFile()
    {
        return "https://api.telegram.org/file/bot{$this->token}/";
    }

    public function request($method, $params = [])
    {
        return $this->clinet->request('GET', $method, [
            "base_uri" => $this->getBaseUri(),
            "query" => $params
        ]);
    }

    public function upload()
    {
    }

    public function setWebhook($params = [])
    {
        return $this->request("setWebhook", [
            ...$params,
            "url" => $this->webhook,
        ]);
    }

    public function deleteWebhook($params = [])
    {
        return $this->request("deleteWebhook", $params);
    }

    public function downloadFile($filePath)
    {
        return $this->clinet->request('GET', $filePath, [
            "base_uri" => $this->getBaseUriFile()
        ]);
    }
}
