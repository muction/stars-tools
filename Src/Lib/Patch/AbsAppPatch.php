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
     * GIT仓库目录
     * @var string
     */
    private $gitDir = "";

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

    /**
     * 保存补丁的dir
     * @var string
     */
    private $savePatchDir = "";

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
     * 设置git仓库本路径
     * @param $gitDir
     * @return mixed
     */
    protected function setGitDir( $gitDir ){

        return $this->gitDir = $gitDir ;
    }

    /**
     * 获取git仓库本地路径
     * @return string
     */
    protected function getGitDir(){
        return $this->gitDir;
    }

    /**
     * 设置补丁DIr
     * @param $savePatchDir
     * @return mixed
     */
    protected function setSavePatchDir( $savePatchDir ){
        return $this->savePatchDir =$savePatchDir;
    }

    /**
     * 获取补丁DIR
     * @return string
     */
    protected function getSavePatchDir(){
        return $this->savePatchDir;
    }

    /**
     * 生成补丁文件名，不包含扩展名
     * @return mixed
     */
    protected function makePatchFileName(){

        return 'PATCH.'.date('Ymd.Hi');
    }


}
