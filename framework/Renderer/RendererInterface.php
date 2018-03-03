<?php

namespace Framework\Renderer;


interface RendererInterface
{
    public function render (string $template, array $params = []): string;
}