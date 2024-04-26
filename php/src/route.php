<?php

class Route
{
    private string $object;
    private string $process;
    private array $accessKey;

    public function __construct($object = '', $process = '', $accessKey = [])
    {
        $this->setObject($object);
        $this->setProcess($process);
        $this->setAccessKey($accessKey);
    }

    public function setObject(string $object)
    {
        $this->object = $object;
    }

    public function setProcess(string $process)
    {
        $this->process = $process;
    }

    public function setAccessKey(array $accessKey)
    {
        $this->accessKey = $accessKey;
    }

    public function getObject()
    {
        return $this->object;;
    }

    public function getProcess()
    {
        return $this->process;
    }

    public function getAccessKey()
    {
        return $this->accessKey;
    }

    public function identifyObject(): void
    {
        if (isset($_GET['object']) === true) {
            $this->setObject($_GET['object']);
        }
    }

    public function identifyProcess(): void
    {
        if (isset($_GET['process']) === true) {
            $this->setProcess($_GET['process']);
        }
    }

    public function getName(): string
    {
        return $this->getObject() . '-' . $this->getProcess();
    }

    public function getUrl(): string
    {
        return 'index.php?object=' . $this->getObject() . '&process=' . $this->getProcess();
    }

    public function addAccessKey(string $accessKey): void
    {
        $this->accessKey[] = $accessKey;
    }

    public function checkAccessKey(string $accessKey): string|int|bool
    {
        return array_search($accessKey, $this->accessKey);
    }
}
