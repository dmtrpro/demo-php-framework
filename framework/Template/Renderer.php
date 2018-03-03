<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 03.03.18
 * Time: 14:31
 */

namespace Framework\Template;

interface Renderer
{
    public function render($templateName, array $params = []): string;
}