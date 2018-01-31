<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 25.01.18
 * Time: 2:18
 */

namespace App\Presentation\Controller;

class GalleryController extends Controller
{
    /* @var string */
    const LAYOUT = 'gallery';

    protected $images;

    public function __construct()
    {
        //parent::__construct();

        $this->addToLayoutData('headerText', $this->render('gallery/_form'));

        $this->images = json_decode(file_get_contents(DATA_DIR . 'gallery.json'), true);
    }

    public function indexAction()
    {
        $this->formHandle();

        $page['title'] = 'Галерея';

        $page['imageCards'] = $this->images;

        return $this->renderPage('gallery/index', $page);

    }

    public function singleAction($image = null)
    {
        $this->formHandle();

        $page['title'] = 'Галерея';

        if (!$image) {
            $image = $_GET['image'];
        }

        if (!$this->images[$image]) {
            throw new \InvalidArgumentException("Page not found!", 404);
        }

        $page['image'] = $this->images[$image]['image'];
        $page['excerpt'] = $this->images[$image]['excerpt'];

        return $this->renderPage('gallery/single', $page);
    }

    public function generateAction($image = null)
    {
        $images = [
            'river' => ['image' => 'forest-river.jpg', 'excerpt' => 'Лес'],
            'lake' => ['image' => 'lake.jpg', 'excerpt' => 'Озеро'],
            'mountain' => ['image' => 'mountain.jpg', 'excerpt' => 'Горы'],
            'paradise' => ['image' => 'paradise.jpg', 'excerpt' => 'Водопады'],
            'deer' => ['image' => 'deer.jpg', 'excerpt' => 'Олени'],
            'waterfall' => ['image' => 'waterfall.jpg', 'excerpt' => 'Ручьи'],
        ];
        file_put_contents(DATA_DIR . 'gallery.json', json_encode($images));

        $this->addToLayoutData('modalText', 'Галерея сгенерирована!');

        $page['title'] = 'Галерея';

        $page['imageCards'] = $this->images;

        return $this->renderPage('gallery/index', $page);
    }

    protected function formHandle()
    {
        if ($_FILES['image']) {
            $slug = uniqid('img');
            $fileName = $slug . '-' . $_FILES['image']['name'];

            if (move_uploaded_file($_FILES['image']['tmp_name'], UPLOADS_DIR . $fileName)) {
                $this->addToLayoutData('modalText', 'Файл загружен успешно');

                $this->images[$slug] = [
                    'image' => strip_tags($fileName),
                    'excerpt' => htmlspecialchars($_POST['excerpt'])
                ];

                file_put_contents(DATA_DIR . 'gallery.json', json_encode($this->images));

            } else {
                $this->addToLayoutData('modalText', 'Файл не загружен');
            }
        }

    }
}