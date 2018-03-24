<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 04.03.18
 * Time: 10:50
 */

namespace Framework\Renderer;


use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigRenderer implements RendererInterface
{
    /**
     * @var Environment
     */
    private $renderer;

    /**
     * TwigRenderer constructor.
     * @param array $options
     * @throws \Twig_Error_Loader
     */
    public function __construct(array $options = [])
    {
        $debug = CONFIG['global']['debug'];

        $loader = new FilesystemLoader();
        $loader->addPath(TEMPLATE_DIR);

        $options['debug'] = $options['debug'] ?? $debug;
        $options['auto_reload'] = $options['auto_reload'] ?? $debug;
        $options['cache'] = $options['cache'] ?? VAR_DIR . '/cache/twig';

        $this->renderer = new Environment($loader, $options);
    }

    /**
     * @param \Twig_ExtensionInterface $extension
     */
    public function addExtension(\Twig_ExtensionInterface $extension)
    {
        $this->renderer->addExtension($extension);
    }

    /**
     * @param string $template
     * @param array $params
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function render(string $template, array $params = []): string
    {
        $template = str_replace(':', DIRECTORY_SEPARATOR, $template);

        return $this->renderer->render($template . '.html.twig', $params);
    }
}