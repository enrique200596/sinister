<?php
require_once 'vehicle.php';
require_once 'executive.php';

class Sinister
{
    private int $id;
    private DateTime $date;
    private Vehicle $vehicle;
    private Executive $executive;
    private Workshop $workshop;
    private string $state;
    private array $tasks;

    public function setVehicle(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    public function setExecutive(Executive $executive)
    {
        $this->executive = $executive;
    }

    public function addTask($title,$description,$executive,$operator,$scheduledDate)
    {
        $t=new Task()
    }
}
