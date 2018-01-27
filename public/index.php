<?php

try {
    include_once '../app.php';

    LayoutManager::setLayout('gallery');

    LayoutManager::addToLayoutData('headerText', render('gallery/_form'));

    $images = json_decode(file_get_contents(DATA_DIR . 'gallery.json'), true);

    if($_FILES['image']){
        $slug = uniqid('img');
        $fileName = $slug.'-'.$_FILES['image']['name'];

        if ( move_uploaded_file($_FILES['image']['tmp_name'], UPLOADS_DIR.$fileName)) {
            LayoutManager::addToLayoutData('modalText', 'Файл загружен успешно');

            $images[$slug] = [
                'image' => $fileName,
                'excerpt' => strip_tags($_POST['excerpt'])
            ];

            file_put_contents(DATA_DIR.'gallery.json', json_encode($images));

        } else {
            LayoutManager::addToLayoutData('modalText', 'Файл не загружен');
        }
    }

    $page['title'] = 'Галерея';

    $image = $_GET['image'];
    if ($images[$image]) {

        $page['image'] = $images[$image]['image'];
        $page['excerpt'] = $images[$image]['excerpt'];

        echo renderPage('gallery/single', $page);

    } else {
        $page['imageCards'] = $images;

        echo renderPage('gallery/index', $page);
    }


} catch (\Exception $e) {
    echo 'Oups! Error #' . $e->getCode() . ': ' . $e->getMessage();
}