<?php

namespace Stars\Tools\Contracts;


interface IAppMakePatchOption
{
    /**
     *
     * IAppMakePatchOption constructor.
     * @param int $handleType 处理方式
     * @param string $workDir 项目目录
     * @param string $savePatchDir 保存补丁的DIR
     * @param array $files 必须是相对于workdir 的文件相对路径
     * @param string $girDir GIT项目仓库dir
     */
    public function __construct( int $handleType , string $workDir , string $savePatchDir , array $files ,string $girDir ="" );

    /**
     * 获取处理方式
     * @return mixed
     */
    public function getHandleType();

    /**
     * 获取项目目录
     * @return mixed
     */
    public function getWorkDir();

    /**
     * 获取处理的文件列表
     * @return mixed
     */
    public function getFiles();

    /**
     * 获取GIT仓库目录
     * @return mixed
     */
    public function getGitDir();

    /**
     * 获取保存补丁目录
     * @return mixed
     */
    public function getSavePatchDir();
}
