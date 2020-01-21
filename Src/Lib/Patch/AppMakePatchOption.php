<?php


namespace Stars\Tools\Lib\Patch;


use Stars\Tools\Contracts\IAppMakePatchOption;

class AppMakePatchOption implements IAppMakePatchOption
{
    /**
     * 处理方式类型
     * @var null
     */
    private $handleType=null;

    /**
     * 工作目录
     *  是指当前的程序运行的所在目录
     * @var string|null
     */
    private $workDir = null;

    /**
     * 要处理的文件列表，必须是全路径列表
     * @var array
     */
    private $files = [];

    /**
     * 处理方式为 GIT时的仓库所在路径
     * @var string
     */
    private $girDir = "";

    /**
     * 保存补丁的目录
     * @var string
     */
    private $savePatchDir ="";

    /**
     * 初始化参数
     * AppMakePatchOption constructor.
     * @param $handleType
     * @param string $workDir
     * @param string $savePatchDir
     * @param array $files
     * @param string $gitDir
     */
    public function __construct($handleType, string $workDir, string $savePatchDir , array $files ,$gitDir ="")
    {
        $this->handleType = $handleType;
        $this->workDir = $workDir;
        $this->files = $files;
        $this->girDir = $gitDir;
        $this->savePatchDir =$savePatchDir;
    }

    /**
     * 获取处理类型
     * @return null
     */
    public function getHandleType()
    {
        return $this->handleType;
    }

    /**
     * 获取工作目录
     * @return string|null
     */
    public function getWorkDir()
    {
        return $this->workDir;
    }

    /**
     * 获取处理的文件
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * 获取GIT仓库目录
     * @return string
     */
    public function getGitDir()
    {
        return $this->girDir;
    }

    /**
     * 获取保存补丁目录
     * @return string
     */
    public function getSavePatchDir(){
        return $this->savePatchDir;
    }
}
