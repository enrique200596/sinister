<?php
class Route
{
    private $object;
    private $process;
    private $function;
    private $accessKey;

    public function __construct($object = '', $process = '', $function = null, $accessKey = null)
    {
        $this->setObject($object);
        $this->setProcess($process);
        $this->setFunction($function);
        $this->setAccessKey($accessKey);
    }

    public function setObject(string $object)
    {
        $this->object = $object;
    }

    public function getObject()
    {
        return $this->object;;
    }

    public function setProcess(string $process)
    {
        $this->process = $process;
    }

    public function getProcess()
    {
        return $this->process;;
    }

    public function setFunction(Closure|null $function)
    {
        $this->function = $function;
    }

    public function getFunction()
    {
        return $this->function;;
    }

    public function setAccessKey(string|null $accessKey)
    {
        $this->accessKey = $accessKey;
    }

    public function getAccessKey()
    {
        return $this->accessKey;
    }

    public function identifyObject()
    {
        if (isset($_GET['object']) === true) {
            $this->setObject($_GET['object']);
        }
    }

    public function identifyProcess()
    {
        if (isset($_GET['process']) === true) {
            $this->setProcess($_GET['process']);
        }
    }

    public function getName()
    {
        return $this->getObject() . '-' . $this->getProcess();
    }

    public function getUrl()
    {
        return 'index.php?object=' . $this->getObject() . '&process=' . $this->getProcess();
    }

    public function compareAccessKey($userAccessKey)
    {
        return password_verify($userAccessKey, $this->getAccessKey());
    }
}
