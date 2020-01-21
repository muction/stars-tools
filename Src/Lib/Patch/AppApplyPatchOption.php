<?php


namespace Stars\Tools\Lib\Patch;


use Stars\Tools\Contracts\IAppApplyPatchOption;

class AppApplyPatchOption implements IAppApplyPatchOption
{
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
    private $patchFile = "";

    /**
     * 保存补丁的目录
     * @var string
     */
    private $savePatchDir ="";

    /**
     * 初始化参数
     * AppMakePatchOption constructor.
     * @param string $workDir
     * @param string $savePatchDir
     * @param string $patchFile
     */
    public function __construct( string $workDir, string $savePatchDir , string $patchFile )
    {

        $this->workDir = $workDir;
        $this->patchFile = $patchFile;
        $this->savePatchDir =$savePatchDir;
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
    public function getPatchFile()
    {
        return $this->patchFile;
    }

    /**
     * 获取保存补丁目录
     * @return string
     */
    public function getSavePatchDir(){
        return $this->savePatchDir;
    }
}
