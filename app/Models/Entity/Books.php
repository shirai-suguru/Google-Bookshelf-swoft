<?php
namespace App\Models\Entity;

use Swoft\Db\Model;
use Swoft\Db\Bean\Annotation\Column;
use Swoft\Db\Bean\Annotation\Entity;
use Swoft\Db\Bean\Annotation\Id;
use Swoft\Db\Bean\Annotation\Required;
use Swoft\Db\Bean\Annotation\Table;
use Swoft\Db\Types;

/**
 * @Entity()
 * @Table(name="books")
 * @uses      Books
 */
class Books extends Model
{
    /**
     * @var int $id 
     * @Id()
     * @Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var string $title 
     * @Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string $author 
     * @Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var string $publishedDate 
     * @Column(name="published_date", type="string", length=255)
     */
    private $publishedDate;

    /**
     * @var string $imageUrl 
     * @Column(name="image_url", type="string", length=255)
     */
    private $imageUrl;

    /**
     * @var string $description 
     * @Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string $createdBy 
     * @Column(name="created_by", type="string", length=255)
     */
    private $createdBy;

    /**
     * @var string $createdById 
     * @Column(name="created_by_id", type="string", length=255)
     */
    private $createdById;

    /**
     * @param int $value
     * @return $this
     */
    public function setId(int $value)
    {
        $this->id = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setTitle(string $value): self
    {
        $this->title = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setAuthor(string $value): self
    {
        $this->author = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setPublishedDate(string $value): self
    {
        $this->publishedDate = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setImageUrl(string $value): self
    {
        $this->imageUrl = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setDescription(string $value): self
    {
        $this->description = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setCreatedBy(string $value): self
    {
        $this->createdBy = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setCreatedById(string $value): self
    {
        $this->createdById = $value;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getPublishedDate()
    {
        return $this->publishedDate;
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @return string
     */
    public function getCreatedById()
    {
        return $this->createdById;
    }

}
