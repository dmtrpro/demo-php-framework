<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 25.01.18
 * Time: 2:18
 */

namespace App\Presentation\Controller;

use App\Framework\DB\SQLiteDataBase;
use Framework\Router\Exception\InvalidRequestException;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

class GalleryController extends Controller
{
    /* @var string */
    const LAYOUT = 'gallery';

    //protected $images;

    protected $db;

    public function __construct()
    {
        //parent::__construct();

        $this->addToLayoutData('headerText', $this->render('gallery/_form'));

        //$this->images = json_decode(file_get_contents(DATA_DIR . 'gallery.json'), true);

        $this->db = new SQLiteDataBase();
    }

    public function indexAction(ServerRequestInterface $request)
    {
        $page['title'] = 'Галерея';

        $page['imageCards'] = $this->db->selectAll();

        $newImage = $this->formHandle();

        if($newImage) {
            $page['imageCards'][] = $newImage;
        }

        return new HtmlResponse($this->renderPage('gallery/index', $page));
    }

    public function singleAction(ServerRequestInterface $request)
    {
        $args = $request->getAttribute('args');
        $image = $args['image'];

        $page['title'] = 'Галерея';

        $this->formHandle();

        $img = $this->db->selectBySlug($image);

        if (!$img) {
            throw new InvalidRequestException($request, "Image with this id not found!");
        }

        $page['image'] = $img['image'];
        $page['excerpt'] = $img['excerpt'];

        return new HtmlResponse($this->renderPage('gallery/single', $page));
    }

    public function generateAction()
    {
        $images = $this->db->selectAll();

        if (empty($images)) {
            $images = [
                ['slug' => 'forest-river', 'image' => 'forest-river.jpg', 'excerpt' => 'Лес', 'filesize' => 0],
                ['slug' => 'lake', 'image' => 'lake.jpg', 'excerpt' => 'Озеро', 'filesize' => 0],
                ['slug' => 'mountain', 'image' => 'mountain.jpg', 'excerpt' => 'Горы', 'filesize' => 0],
                ['slug' => 'paradise', 'image' => 'paradise.jpg', 'excerpt' => 'Водопады', 'filesize' => 0],
                ['slug' => 'deer', 'image' => 'deer.jpg', 'excerpt' => 'Олени', 'filesize' => 0],
                ['slug' => 'waterfall', 'image' => 'waterfall.jpg', 'excerpt' => 'Ручьи', 'filesize' => 0],
            ];
            //file_put_contents(DATA_DIR . 'gallery.json', json_encode($images));

            $this->db->insertImages($images);

            $this->addToLayoutData('modalText', 'Галерея создана!');
        }

        $page['title'] = 'Галерея';

        $page['imageCards'] = $images;

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

                return $image;
            } else {
                $this->addToLayoutData('modalText', 'Файл не загружен');
            }
        }
        return null;
    }
}