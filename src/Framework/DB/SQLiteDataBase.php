<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 31.01.18
 * Time: 16:39
 */

namespace App\Framework\DB;

use PDO;

class SQLiteDataBase
{
    protected $db;

    public function __construct()
    {
        $this->db = new PDO('sqlite:'.DATA_DIR.'/images.sqlite3');
        //$this->db = new PDO('sqlite:images.sqlite3');

        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->install();
    }

    protected function install()
    {
        $this->db->exec("CREATE TABLE IF NOT EXISTS images (
                    id INTEGER PRIMARY KEY, 
                    slug TEXT,
                    image TEXT,
                    excerpt TEXT,                    
                    filesize INTEGER,
                    views INTEGER,
                    rating INTEGER,
                    created_at INTEGER
        )");
    }

    public function insertImages(array $images)
    {
        foreach ($images as $img) {
            $this->insert($img);
        }
    }

    public function insert(array $img)
    {
        $insert = 'INSERT INTO images (slug, image, filesize, excerpt, created_at) 
                VALUES (:slug, :image, :filesize, :excerpt, datetime())';

        $stmt = $this->db->prepare($insert);

        // Bind parameters to statement variables
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':excerpt', $excerpt);
        $stmt->bindParam(':filesize', $filesize);

        $slug = $img['slug'];
        $image = $img['image'];
        $filesize = $img['filesize'];
        $excerpt = $img['excerpt'];

        // Execute statement
        return $stmt->execute();
    }

    public function selectAll()
    {
        $result = $this->db->query('SELECT * FROM images', PDO::FETCH_ASSOC);

        foreach($result as $row) {
            $res[$row['slug']] = $row;
        }

        return $res;
    }

    public function selectByID($id)
    {
        $select = 'SELECT * FROM images WHERE id=:id';

        $stmt = $this->db->prepare($select);

        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function selectBySlug($slug)
    {
        $select = 'SELECT * FROM images WHERE $slug=:$slug';

        $stmt = $this->db->prepare($select);

        $stmt->bindParam(':id', $slug);

        return $stmt->execute();
    }
}