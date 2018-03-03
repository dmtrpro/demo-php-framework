<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 03.03.18
 * Time: 20:05
 */

namespace Framework\Renderer;


class PhpRenderer implements RendererInterface
{
    public function render(string $template, array $params = []): string
    {
        extract($params);

        $filePath = TEMPLATE_DIR . '/' . $template . '.php';

        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException("Template '$template' not found!", 501);
        }

        ob_start();

        require($filePath);

        $result = ob_get_clean();

        return $result;
    }
}