<?php

namespace Stars\Tools\Contracts;


interface IAppApplyPatchOption
{
    /**
     *
     * IAppMakePatchOption constructor.
     * @param string $workDir 项目目录
     * @param string $savePatchDir 保存补丁的DIR
     * @param string $patchFile
     */
    public function __construct( string $workDir , string $savePatchDir , string $patchFile);

    /**
     * 获取项目目录
     * @return mixed
     */
    public function getWorkDir();

    /**
     * 获取处理的文件列表
     * @return mixed
     */
    public function getPatchFile();
    /**
     * 获取保存补丁目录
     * @return mixed
     */
    public function getSavePatchDir();
}
