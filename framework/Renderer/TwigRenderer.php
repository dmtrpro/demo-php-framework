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
    private $twig;

    /**
     * TwigRenderer constructor.
     * @throws \Twig_Error_Loader
     */
    public function __construct()
    {
        $debug = CONFIG['global']['debug'];

        $loader = new FilesystemLoader();
        $loader->addPath(TEMPLATE_DIR);

        $this->twig = new Environment($loader, array(
            'debug' => $debug,
            'auto_reload' => $debug,
            'cache' => ($debug) ? false : VAR_DIR.'/cache/twig',
        ));
    }

    public function addExtension(\Twig_ExtensionInterface $extension)
    {
        $this->twig->addExtension($extension);
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
        return $this->twig->render( $template.'.html.twig', $params);
    }
}