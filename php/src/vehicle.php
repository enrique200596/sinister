<?php
class Vehicle
{
    private string $plate;
    private string $brand;
    private string $model;
    private int $year;
    private string $color;

    public function __construct($plate, $brand, $model, $year, $color)
    {
        $this->setPlate($plate);
        $this->setBrand($brand);
        $this->setModel($model);
        $this->setYear($year);
        $this->setColor($color);
    }

    public function setPlate($plate)
    {
        $this->plate = $plate;
    }

    public function getPlate()
    {
        return $this->plate;
    }

    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    public function getBrand()
    {
        return $this->brand;
    }

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setYear(int $year)
    {
        $this->year = $year;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function setColor($color)
    {
        $this->color = $color;
    }

    public function getColor()
    {
        return $this->color;
    }
}
