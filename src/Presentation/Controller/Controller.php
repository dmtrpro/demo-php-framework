<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 27.01.18
 * Time: 22:43
 */

namespace App\Presentation\Controller;

abstract class Controller
{
    /* @var string */
    const LAYOUT = 'base';

    /* @var mixed[] */
    protected $layoutData = [];

    /**
     * @return array
     */
    public function getLayoutData(): array
    {
        return $this->layoutData;
    }

    /**
     * @param array $layoutData
     */
    public function setLayoutData(array $layoutData)
    {
        $this->layoutData = $layoutData;
    }

    /**
     * @param string $key
     * @param $value
     */
    public function addToLayoutData(string $key, $value)
    {
        $this->layoutData[$key] = $value;
    }

    /**
     * @param array $pageTitle
     * @return string
     */
    protected function getTitle(array $pageTitle = [])
    {
        if ($pageTitle['title']) {
            return trim($pageTitle['title']) . ' | ' . CONFIG['site']['name'];
        }

        return CONFIG['site']['name'];
    }

    /**
     * @param string $template
     * @param array $params
     * @return string
     */
    public function render(string $template, array $params = [])
    {
        extract($params);

        $filePath = TEMPLATE_DIR . $template . '.php';

        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException("Template '$template' not found!", 501);
        }

        ob_start();

        include($filePath);

        $result = ob_get_contents();
        ob_end_clean();

        return $result;
    }

    /**
     * @param string $template
     * @param array $params
     * @return string
     */
    public function renderPage(string $template, array $params)
    {
        $layout = static::LAYOUT;

        $layoutData = [
            'title' => $this->getTitle($params),
            'content' => $this->render($template, ['page' => $params]),
        ];

        $layoutData = array_merge($layoutData, $this->getLayoutData());

        return $this->render('layouts/' . $layout, $layoutData);
    }
}