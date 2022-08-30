<?php
namespace TgRedmine\helpers;

class Redmine extends Singleton
{
    private $client;

    public function __construct()
    {
        $config = Cfg::getInstance();
        $host = $config->get('redmine.url');
        $api_key = $config->get('redmine.api_key');
        $this->client = new \Redmine\Client\NativeCurlClient($host, $api_key);
    }

    public function getClient()
    {
        return $this->client;
    }
}