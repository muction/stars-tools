<?php


namespace Stars\Tools\Lib\Patch;


use Stars\Tools\Contracts\IAppMakePatchOption;

class ApplyPatch
{
    /**
     * 工作目录
     * @var string
     */
    private $workDir = "";

    /**
     * 相对于workdir的补丁包文件
     * @var string
     */
    private $patchFile = "";

    /**
     * 保存补丁包路径
     * @var string
     */
    private $savePatchDir ="";

    private $readMeFileName = "readme.txt";

    /**
     * 初始化
     * ApplyPatch constructor.
     * @param AppApplyPatchOption $appApplyPatchOption
     */
    public function __construct(AppApplyPatchOption $appApplyPatchOption )
    {
        $this->workDir = $appApplyPatchOption->getWorkDir();
        $this->patchFile = $appApplyPatchOption->getPatchFile() ;
        $this->savePatchDir = $appApplyPatchOption->getSavePatchDir() ;
    }

    /**
     * 处理
     */
    public function handle()
    {
        try{

            if( !file_exists( $this->savePatchDir . $this->patchFile ) ){
                throw new \Exception( "补丁包文件不存在: {$this->patchFile}");
            }

            //先校验补丁包文件是否合法
            $this->patchFileIsValid();

            //创建补丁包临时目录
            $patchTmpDir = $this->savePatchDir .'/tmp/';
            if(!is_dir($patchTmpDir)){
                mkdir( $patchTmpDir ,0755 );
            }

            //覆盖解压补丁包
            exec('unzip -o '. $this->savePatchDir. $this->patchFile .' -d '. $patchTmpDir , $output );

            //解压完成后开始读取readme文件
            if( !file_exists($patchTmpDir . $this->readMeFileName) ){
                throw new \Exception("补丁包损坏，找不到索引文件，请重新下载");
            }

            $readmeIndex = file_get_contents( $patchTmpDir . $this->readMeFileName );
            $readmeIndex = explode("\r\n", $readmeIndex);
            $readmeIndex = array_map(function( $v ){
                return trim($v);
            } , array_filter($readmeIndex));
            foreach ($readmeIndex as $indexFile){
                if($indexFile && !file_exists( $patchTmpDir . $indexFile ) ){
                    throw new \Exception("{$indexFile} 补丁包子文件丢失或失效请重新下载");
                }
            }

            foreach ($readmeIndex as $patch){
                $patchFile = $patchTmpDir . $patch ;
                $targetFilePath = $this->workDir . $patch;
                exec( "cp -f {$patchFile} {$targetFilePath} " , $output );
            }

            return $readmeIndex;

        }catch (\Exception $exception){
            throw $exception;
        }
    }

    /**
     * 校验补丁包是否正确
     */
    private function patchFileIsValid(){

        try{
            $fileName = explode( '.' , $this->patchFile );
            $patchMd5 = isset($fileName[3]) ? $fileName[3] : null;

            if( !$patchMd5 || md5_file( $this->savePatchDir . $this->patchFile)  != $patchMd5 ){
                throw new \Exception( "补丁包损坏请重新下载");
            }

            return true;

        }catch (\Exception $exception){
            throw $exception;
        }
    }
}
