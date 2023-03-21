<?php

declare(strict_types=1);

namespace App\Services;


abstract class StorageService
{
    private string $path;
    public array $data = [];


    public function __construct(string $configName)
    {
        $this->path = $_SERVER['DOCUMENT_ROOT'] . '/../storage/' . $configName;
        if (!file_exists($this->path)) {
            die("Cant find config file");
        }

        $this->decode();
    }


    /**
     * @param string $key
     * @return string|null
     */
    public function get(string $key): ?string
    {
        return $this->data[$key] ?? null;
    }

    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    public function set(string $key, string $value): void
    {
        $this->data[$key] = $value;

        $this->save();
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($this->data[$key]);
    }

    private function decode(): void
    {
        $data = file_get_contents($this->path);
        $this->data = $data ? json_decode($data, true) : [];
    }

    private function save(): void
    {
        $config = file_get_contents($this->path);
        $tempArray = json_decode($config, true);
        $tempArray = array_merge($tempArray, $this->data);
        $jsonData = json_encode($tempArray);
        file_put_contents($this->path, $jsonData);
    }
}
