<?php
class Notification
{
    private string $type;
    private string $name;
    private string $message;

    public function __construct(string $type = '', string $name = '', string $message = '')
    {
        $this->setType($type);
        $this->setName($name);
        $this->setMessage($message);
    }

    public function setType(string $type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setMessage(string $message)
    {
        $this->message = $message;
    }
    
    public function getMessage()
    {
        return $this->message;
    }
}
