<?php


namespace Stars\Tools\Lib\Patch;


use Stars\Tools\Contracts\AppPatch;

abstract class AbsAppPatch implements AppPatch
{
    /**
     * 工作目录
     * @var string
     */
    private $workDir = "";

    /**
     * 抽象
     * @return mixed
     */
    abstract function handle();

    /**
     * 设置工作目录
     * @param $workDir
     * @return mixed
     */
    abstract function setWorkDir( $workDir );

    /**
     * 获取工作目录
     * @return mixed
     */
    abstract function getWorkDir();

}
