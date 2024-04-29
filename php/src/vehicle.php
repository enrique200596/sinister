<?php
class Vehicle
{
    private string $plate;
    private string $brand;
    private string $model;
    private string $color;

    public function __construct($plate, $brand, $model, $color)
    {
        $this->setPlate($plate);
        $this->setBrand($brand);
        $this->setModel($model);
        $this->setColor($color);
    }

    public function setPlate($plate)
    {
        $this->plate = $plate;
    }
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }
    public function setModel($model)
    {
        $this->model = $model;
    }
    public function setColor($color)
    {
        $this->color = $color;
    }
}
