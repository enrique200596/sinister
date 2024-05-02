<?php

class Task
{
    private int $id;
    private Sinister $sinister;
    private string $title;
    private string $descriptionTask;
    private datetime $creationDate;
    private mixed $scheduledDate;
    private mixed $executionDate;
    private string $state;

    public function __construct()
    {
        $this->id = 0;
        $this->sinister = new Sinister();
        $this->title = '';
        $this->descriptionTask = '';
        $this->creationDate = new DateTime('now', new DateTimeZone('America/La_Paz'));
        $this->scheduledDate = null;
        $this->executionDate = null;
        $this->state = 'Pendiente';
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getsinister(): Sinister
    {
        return $this->sinister;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescriptionTask(): string
    {
        return $this->descriptionTask;
    }

    public function getCreationDate(): string
    {
        return $this->creationDate->format('Y-m-d H:i:s');
    }

    public function getScheduledDate(): string
    {
        if ($this->scheduledDate === null) {
            return '';
        } else {
            return $this->scheduledDate->format('Y-m-d H:i:s');
        }
    }

    public function getExecutionDate(): string
    {
        if ($this->executionDate === null) {
            return '';
        } else {
            return $this->executionDate->format('Y-m-d H:i:s');
        }
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }
}
