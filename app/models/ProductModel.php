<?php
class ProductModel

{
    private $id;
    private $name;
    private $price;
    private $description;

    public function __construct($id, $name, $price, $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
    }
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }   

    public function setId($id)
    {
        $this->id = $id;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getDescription()
    {
        return $this->description;
    }   
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getPrice()
    {
        return $this->price;
    }
    public function setPrice($price)
    {
        $this->price = $price;
    }

}


?>