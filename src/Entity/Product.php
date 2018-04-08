<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 08.04.18
 * Time: 21:59
 */

namespace App\Entity;


class Product
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $productId;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $slug;

    /**
     * todo: replace to Money ValueObject
     * @var int
     */
    protected $price;

    /**
     * @var string
     */
    protected $excerpt;

    /**
     * @var string
     */
    protected $content;

    /**
     * todo: replace to Image Entity
     * @var string
     */
    protected $thumb;

    /**
     * todo: replace to Image Entity
     * @var string
     */
    protected $image;

    /**
     * todo: replace to ProductChars Entity
     * @var array[]
     */
    protected $chars;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Product
     */
    public function setId(int $id): Product
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getProductId(): string
    {
        return $this->productId;
    }

    /**
     * @param string $productId
     * @return Product
     */
    public function setProductId(string $productId): Product
    {
        $this->productId = $productId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Product
     */
    public function setTitle(string $title): Product
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return Product
     */
    public function setSlug(string $slug): Product
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     * @return Product
     */
    public function setPrice(int $price): Product
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getExcerpt(): string
    {
        return $this->excerpt;
    }

    /**
     * @param string $excerpt
     * @return Product
     */
    public function setExcerpt(string $excerpt): Product
    {
        $this->excerpt = $excerpt;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Product
     */
    public function setContent(string $content): Product
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getThumb(): string
    {
        return $this->thumb;
    }

    /**
     * @param string $thumb
     * @return Product
     */
    public function setThumb(string $thumb): Product
    {
        $this->thumb = $thumb;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return Product
     */
    public function setImage(string $image): Product
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return array[]
     */
    public function getChars(): array
    {
        return $this->chars;
    }

    /**
     * @param array[] $chars
     * @return Product
     */
    public function setChars(array $chars): Product
    {
        $this->chars = $chars;
        return $this;
    }

    public function addChar($key, $value): Product
    {
        $this->chars[$key] = $value;
        return $this;
    }
}