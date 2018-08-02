<?php

namespace AppBundle\Entity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 * @Vich\Uploadable
 */
class Product
{
    
    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Spec")
     * @ORM\JoinColumn(name="spec_id", referencedColumnName="id")
     */
    private $spec;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Brand")
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="id")
     */
    private $brand;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Color")
     * @ORM\JoinColumn(name="color_id", referencedColumnName="id")
     */
    private $color;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Memory")
     * @ORM\JoinColumn(name="memory_id", referencedColumnName="id")
     */
    private $memory;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="ModelName")
     * @ORM\JoinColumn(name="modelName_id", referencedColumnName="id")
     */
    private $modelName;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Url(message = "The url '{{ value }}' is not a valid url")
     * @ORM\Column(name="link", type="string")
     */
    private $link;

    /**
     * @var boolean
     * 
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;



    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="1",max="5")
     * @Assert\NotEqualTo(value = 0)
     * @Assert\Regex(
     *     pattern     = "/^[0-9]+$/i",
     *     htmlPattern = "^[a-zA-Z]+$",
     *     message="Modle Name must be valid"
     * )
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image")
     * @Assert\Image()
     * @var File
     */
    private $imageFile;

    /**
    * @var \DateTime $updated
    *
    * @Gedmo\Timestampable(on="update")
    * @ORM\Column(type="datetime")
    */
    private $updatedAt;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set brand
     *
     * @param \AppBundle\Entity\Brand $brand
     *
     * @return Product
     */
    public function setBrand(\AppBundle\Entity\Brand $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \AppBundle\Entity\Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Product
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set color
     *
     * @param \AppBundle\Entity\Color $color
     *
     * @return Product
     */
    public function setColor(\AppBundle\Entity\Color $color = null)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return \AppBundle\Entity\Color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set memory
     *
     * @param \AppBundle\Entity\Memory $memory
     *
     * @return Product
     */
    public function setMemory(\AppBundle\Entity\Memory $memory = null)
    {
        $this->memory = $memory;

        return $this;
    }

    /**
     * Get memory
     *
     * @return \AppBundle\Entity\Memory
     */
    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * Set modelName
     *
     * @param \AppBundle\Entity\ModelName $modelName
     *
     * @return Product
     */
    public function setModelName(\AppBundle\Entity\ModelName $modelName = null)
    {
        $this->modelName = $modelName;

        return $this;
    }

    /**
     * Get modelName
     *
     * @return \AppBundle\Entity\ModelName
     */
    public function getModelName()
    {
        return $this->modelName;
    }
     /**
         * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
         */
     public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
        
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }
    
    /**
     * return string
     */
    public function __toString()
    {
        return $this->description;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Product
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
  

    /**
     * Set spec
     *
     * @param \AppBundle\Entity\Spec $spec
     *
     * @return Product
     */
    public function setSpec(\AppBundle\Entity\Spec $spec = null)
    {
        $this->spec = $spec;

        return $this;
    }

    /**
     * Get spec
     *
     * @return \AppBundle\Entity\Spec
     */
    public function getSpec()
    {
        return $this->spec;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Product
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

   

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Product
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

     /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;


    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Product
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
    * @ORM\Column(type="string", length=255)
    * @var string
    */
    private $images;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="images")
     * @var File
     */
    private $imageFiles;

    /**
         * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $images
         */
     public function setImageFiles(File $images = null)
    {
        $this->imageFiles = $images;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($images) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
        
    }

    public function getImageFiles()
    {
        return $this->imageFiles;
    }

    /**
     * Set images
     *
     * @param string $images
     *
     * @return Product
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return string
     */
    public function getImages()
    {
        return $this->images;
    }


    /**
    * @ORM\Column(type="string", length=255)
    * @var string
    */
    private $images2;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="images2")
     * @var File
     */
    private $imageFiles2;

    /**
         * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $images2
         */
     public function setImageFiles2(File $images2 = null)
    {
        $this->imageFiles2 = $images2;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($images2) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
        
    }

    public function getImageFiles2()
    {
        return $this->imageFiles2;
    }

    /**
     * Set images2
     *
     * @param string $images2
     *
     * @return Product
     */
    public function setImages2($images2)
    {
        $this->images2 = $images2;

        return $this;
    }

    /**
     * Get images2
     *
     * @return string
     */
    public function getImages2()
    {
        return $this->images2;
    }

}
