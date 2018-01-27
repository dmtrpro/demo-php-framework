<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 25.01.18
 * Time: 1:03
 */

/**
 * @param string $template
 * @param array $params
 * @return string
 */
function render(string $template, array $params = [])
{
    extract($params);

    $filepath = TEMPLATE_DIR.$template.'.php';

    if(!file_exists($filepath)){
        throw new InvalidArgumentException("Template '$template' not found!", 501);
    }

    ob_start();

    include($filepath);

    $result = ob_get_contents();
    ob_end_clean();

    return $result;
}

/**
 * @param string $template
 * @param array $params
 * @return string
 */
function renderPage(string $template, array $params)
{
    $layout = LayoutManager::getLayout();

    if(!file_exists(TEMPLATE_DIR.'layouts/'.$layout.'.php')){
        $layout = 'base';
    }

    $layoutData = [
        'title' => getTitle($params),
        'content' => render($template, ['page' => $params]),
    ];

    $layoutData = array_merge($layoutData,  LayoutManager::getLayoutData());

    return render('layouts/'.$layout, $layoutData);
}

/**
 * @param array $pageTitle
 * @return string
 */
function getTitle(array $pageTitle = [])
{
    if ($pageTitle['title']) {
        return trim($pageTitle['title']) .' | '. CONFIG['site']['name'];
    }

    return CONFIG['site']['name'];
}

class LayoutManager
{
    private static $layout;

    private static $layoutData = [];

    public static function getLayout(): string
    {
        return self::$layout;
    }

    public static function setLayout(string $layout)
    {
        self::$layout = $layout;
    }

    public static function getLayoutData(): array
    {
        return self::$layoutData;
    }

    public static function setLayoutData(array $layoutData)
    {
        self::$layoutData = $layoutData;
    }

    public static function addToLayoutData(string $key, $value)
    {
        self::$layoutData[$key] = $value;
    }
}