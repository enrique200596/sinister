<?php
require_once 'coordinates.php';

class Workshop
{
    private int $id;
    private string $name;
    private Coordinates $location;

    public function __construct(int $id = 0, string $name = '', Coordinates $location = new Coordinates('', '', ''))
    {
        $this->setId($id);
        $this->setName($name);
        $this->setLocation($location);
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setLocation(Coordinates $location): void
    {
        $this->location = $location;
    }

    public function getLocation(): Coordinates
    {
        return $this->location;
    }
}
