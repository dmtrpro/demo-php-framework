<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 25.01.18
 * Time: 2:18
 */

namespace App\Presentation\Controller;

use App\Framework\DB\SQLiteDataBase;

class GalleryController extends Controller
{
    /* @var string */
    const LAYOUT = 'gallery';

    protected $images;

    protected $db;

    public function __construct()
    {
        //parent::__construct();

        $this->addToLayoutData('headerText', $this->render('gallery/_form'));

        //$this->images = json_decode(file_get_contents(DATA_DIR . 'gallery.json'), true);

        $this->db = new SQLiteDataBase();

        $this->images = $this->db->selectAll();
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
        if (empty($this->images)){
            $images = [
                'river' => ['slug' => 'forest-river', 'image' => 'forest-river.jpg', 'excerpt' => 'Лес', 'filesize' => 0],
                'lake' => ['slug' => 'lake', 'image' => 'lake.jpg', 'excerpt' => 'Озеро', 'filesize' => 0],
                'mountain' => ['slug' => 'mountain', 'image' => 'mountain.jpg', 'excerpt' => 'Горы', 'filesize' => 0],
                'paradise' => ['slug' => 'paradise', 'image' => 'paradise.jpg', 'excerpt' => 'Водопады', 'filesize' => 0],
                'deer' => ['slug' => 'deer', 'image' => 'deer.jpg', 'excerpt' => 'Олени', 'filesize' => 0],
                'waterfall' => ['slug' => 'waterfall', 'image' => 'waterfall.jpg', 'excerpt' => 'Ручьи', 'filesize' => 0],
            ];
            //file_put_contents(DATA_DIR . 'gallery.json', json_encode($images));

            $this->db->insertImages($images);

            $this->addToLayoutData('modalText', 'Галерея создана!');
        }

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

                $image = [
                    'slug' => $slug,
                    'image' => strip_tags($fileName),
                    'excerpt' => htmlspecialchars($_POST['excerpt']),
                    'filesize' => $_FILES['image']['size']
                ];

                $this->db->insert($image);

                //file_put_contents(DATA_DIR . 'gallery.json', json_encode($image));

                $this->images[$slug] = $image;

            } else {
                $this->addToLayoutData('modalText', 'Файл не загружен');
            }
        }

    }
}