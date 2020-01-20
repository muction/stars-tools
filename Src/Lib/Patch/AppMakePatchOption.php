<?php


namespace Stars\Tools\Lib\Patch;


use Stars\Tools\Contracts\IAppMakePatchOption;

class AppMakePatchOption implements IAppMakePatchOption
{
    private $handleType=null;

    private $workDir = null;

    private $files = [];

    public function __construct($handleType, string $workDir, array $files)
    {
        $this->handleType = $handleType;
        $this->workDir = $workDir;
        $this->files = $files;
    }

    public function getHandleType()
    {
        return $this->handleType;
    }

    public function getWorkDir()
    {
        return $this->workDir;
    }

    public function getFiles()
    {
        return $this->files;
    }
}
