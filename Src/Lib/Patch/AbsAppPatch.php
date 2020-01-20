<?php


namespace Stars\Tools\Lib\Patch;

use Stars\Tools\Contracts\IAppPatch;
use Stars\Tools\Contracts\IAppMakePatchOption;

abstract class AbsAppPatch implements IAppPatch
{
    /**
     * 普通模式
     */
    const HANDLE_TYPE_FILE = 1;

    /**
     * git模式
     */
    const HANDLE_TYPE_GIT = 2;

    /**
     * 工作目录
     * @var string
     */
    private $workDir = "";

    /**
     * 要处理的文件
     * @var null
     */
    private $handleFile = null;

    /**
     * 是否自动生存readme文件
     * @var null
     */
    private $hasReadMeFile = null;


    abstract function __construct( IAppMakePatchOption $makePatchOption , bool $hasReadMeFile = true  ) ;

    /**
     * 设置工作目录
     * @param $workDir
     * @return mixed
     */
    protected function setWorkDir( $workDir ){
        return $this->workDir = $workDir;
    }

    /**
     * 获取工作目录
     * @return mixed
     */
    protected function getWorkDir(){
        return $this->workDir ;
    }

    /**
     * 设置处理的文件
     * @param $handleFile
     * @return mixed
     */
    protected function setHandleFile( $handleFile ){
        return $this->handleFile = $handleFile ;
    }

    /**
     * 获取处理的文件
     * @return null |null
     */
    protected function getHandleFile(){
        return $this->handleFile ;
    }

    /**
     * 设置has readme
     * @param bool $has
     * @return bool
     */
    protected function setHasReadMeFile( bool $has ){
        return $this->hasReadMeFile = $has;
    }

    /**
     * 获取hasReadMeFile
     * @return |null
     */
    protected function getHasReadMeFile(){
        return $this->hasReadMeFile ;
    }

    /**
     * 生成补丁文件名，不包含扩展名
     * @return mixed
     */
    protected function makePatchFileName(){

        return 'PATCH.'.date('Ymd.Hi');
    }


}
