<?php

namespace Stars\Tools\Contracts;


interface IAppMakePatchOption
{
    public function __construct( $handleType , string $workDir , array $files );

    public function getHandleType();

    public function getWorkDir();

    public function getFiles();
}
