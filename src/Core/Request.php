<?php

namespace Maru\Inventory\Core;

class Request
{
    protected array $get;
    protected array $post;
    protected array $files;
    protected array $server;
    protected array $cookies;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->files = $_FILES;
        $this->server = $_SERVER;
        $this->cookies = $_COOKIE;
    }

    public function method(): string
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
    }

    public function all(): array
    {
        return array_merge($this->get, $this->post);
    }

    public function input(string $key, $default = null)
    {
        return $this->post[$key] ?? $this->get[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return isset($this->post[$key]) || isset($this->get[$key]);
    }

    public function file(string $key)
    {
        return $this->files[$key] ?? null;
    }

    public function header(string $key, $default = null)
    {
        $key = 'HTTP_' . strtoupper(str_replace('-', '_', $key));
        return $this->server[$key] ?? $default;
    }

    public function path(): string
    {
        $uri = parse_url($this->server['REQUEST_URI'], PHP_URL_PATH);
        return trim($uri, '/');
    }

    public function isMethod(string $method): bool
    {
        return $this->method() === strtoupper($method);
    }

    public function ip(): ?string
    {
        return $this->server['REMOTE_ADDR'] ?? null;
    }

    public function redirect($url)
    {
        header('Location: '.$url);
    }
}
