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
        $template = str_replace(':', DIRECTORY_SEPARATOR, $template);

        $filePath = TEMPLATE_DIR . DIRECTORY_SEPARATOR . $template . '.php';

        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException("Template '$template' not found!", 501);
        }

        ob_start();

        extract($params);

        require($filePath);

        $result = ob_get_clean();

        return $result;
    }
}