<?php

namespace App\Entity; 


class AdSearch{


    /**
     * Undocumented variable
     *
     * @var int|null
     */
    private $minPrice;

        /**
     * Undocumented variable
     *
     * @var int|null
     */
    private $maxPrice;
    

    /**
     *@var string|null 
     */
    private $city;
    /**
     * Get undocumented variable
     *
     * @return  int|null
     */ 
    public function getMinPrice()
    {
        return $this->minPrice;
    }


    /**
     * Set undocumented variable
     *
     * @param  int|null  $minPrice  Undocumented variable
     *
     * @return  self
     */ 
    public function setMinPrice($minPrice)
    {
        $this->minPrice = $minPrice;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  int|null
     */ 
    public function getMaxPrice()
    {
        return $this->maxPrice;
    }

    /**
     * Set undocumented variable
     *
     * @param  int|null  $maxPrice  Undocumented variable
     *
     * @return  self
     */ 
    public function setMaxPrice($maxPrice)
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }
    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }
}