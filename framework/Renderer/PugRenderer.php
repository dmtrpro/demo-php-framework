<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 04.03.18
 * Time: 10:50
 */

namespace Framework\Renderer;


use Phug\ExtensionInterface;
use Pug\Pug;

class PugRenderer implements RendererInterface
{
    /**
     * @var Pug
     */
    private $renderer;

    /**
     * PugRenderer constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $debug = CONFIG['global']['debug'];

        $options['paths'][] = TEMPLATE_DIR;
        $options['debug'] = $options['debug'] ?? $debug;
        $options['pretty'] = $options['pretty'] ?? true;
        $options['cache'] = $options['cache'] ?? VAR_DIR . '/cache/pug';

        $this->renderer = new Pug($options);
    }

    /**
     * @param ExtensionInterface $extension
     */
    public function addExtension(ExtensionInterface $extension)
    {
        $this->renderer->addExtension($extension);
    }

    /**
     * @param string $filterName
     * @param callable $callable
     */
    public function addFilter(string $filterName, callable $callable)
    {
        $this->renderer->filter($filterName, $callable);
    }

    /**
     * @param string $template
     * @param array $params
     * @return string
     * @throws \Exception
     */
    public function render(string $template, array $params = []): string
    {
        $template = str_replace(':', DIRECTORY_SEPARATOR, $template);

        return $this->renderer->renderFile(DIRECTORY_SEPARATOR . $template, $params);
    }
}