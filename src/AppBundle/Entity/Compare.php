<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Compare
 *
 * @ORM\Table(name="compare")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CompareRepository")
 */
class Compare
{
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
     * @ORM\Column(name="compareTo", type="string", length=255)
     */
    private $compareTo;
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->compareTo;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="compareWith", type="string", length=255)
     */
    private $compareWith;


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
     * Set compareTo
     *
     * @param string $compareTo
     *
     * @return Compare
     */
    public function setCompareTo($compareTo)
    {
        $this->compareTo = $compareTo;

        return $this;
    }

    /**
     * Get compareTo
     *
     * @return string
     */
    public function getCompareTo()
    {
        return $this->compareTo;
    }

    /**
     * Set compareWith
     *
     * @param string $compareWith
     *
     * @return Compare
     */
    public function setCompareWith($compareWith)
    {
        $this->compareWith = $compareWith;

        return $this;
    }

    /**
     * Get compareWith
     *
     * @return string
     */
    public function getCompareWith()
    {
        return $this->compareWith;
    }
}

