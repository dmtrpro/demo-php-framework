<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 27.01.18
 * Time: 3:39
 */

$images = [
    'river' => ['image' => 'forest-river.jpg', 'excerpt' => 'Лес'],
    'lake' => ['image' => 'lake.jpg', 'excerpt' => 'Озеро'],
    'mountain' => ['image' => 'mountain.jpg', 'excerpt' => 'Горы'],
    'paradise' => ['image' => 'paradise.jpg', 'excerpt' => 'Водопады'],
    'deer' => ['image' => 'deer.jpg', 'excerpt' => 'Олени'],
    'waterfall' => ['image' => 'waterfall.jpg', 'excerpt' => 'Ручьи'],
];
file_put_contents(DATA_DIR . 'gallery.json', json_encode($images));
