<?php


namespace Stars\Tools\Lib\Patch;

use Stars\Tools\Contracts\IAppMakePatchOption;

class MakePatch extends AbsAppPatch
{
    /**
     * 打补丁包
     * @param IAppMakePatchOption $makePatchOption
     * @param bool $hasReadMeFile
     * @return mixed|void
     * @throws \Exception
     */
    public function __construct(IAppMakePatchOption $makePatchOption , bool $hasReadMeFile = true)
    {
        $this->setWorkDir( $makePatchOption->getWorkDir() );
        $this->setHandleFile( $makePatchOption->getFiles() );
        $this->setHasReadMeFile( $hasReadMeFile ) ;
        $this->setSavePatchDir( $makePatchOption->getSavePatchDir() );
        if( $makePatchOption->getHandleType() == self::HANDLE_TYPE_GIT){
            $this->setGitDir( $makePatchOption->getGitDir() );
            $this->setMakeGitFiles();
        }
    }

    /**
     * 开始制作
     * @return bool
     * @throws \Exception
     */
    public function handle(){
        try {
            return $this->zipFiles();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @return bool
     * @throws \Exception
     */
    private function zipFiles( )
    {
        try{

            $patchFileName = $this->makePatchFileName( ) ;
            $patchPathFileName = $this->getSavePatchDir() . $patchFileName ;
            foreach ($this->getHandleFile() as $file){
                if( !file_exists( $this->getWorkDir(). $file ) ){
                    throw new \Exception("文件不存在: {$file}");
                }
            }

            $zipFiles = implode(" ",  $this->getHandleFile() );
            if(!$zipFiles){
                throw new \Exception("没有找到有效文件进行打包");
            }

            if( $this->getHasReadMeFile() ){
                $zipFiles .= $this->makeReadMeFile() ;
            }

            exec("zip {$patchPathFileName} {$zipFiles}");

            if(!file_exists($patchPathFileName) ){
                throw new \Exception("打包失败: {$patchPathFileName}");
            }

            //计算补丁md5
            $fileMd5= md5_file( $patchPathFileName );
            $newPatchFileName = $patchFileName .'-'.$fileMd5.'.zip' ;

            //重新命名文件
            $newPatchPathFileName= $this->getSavePatchDir() . $newPatchFileName ;
            if( rename(  $patchPathFileName , $newPatchPathFileName )) {
                return $newPatchFileName;
            }

            return false;

        }catch (\Exception $exception){
            throw $exception;
        }
    }

    /**
     * @return bool
     */
    private function setMakeGitFiles(){
        try{
            $files = [];
            $commitIds = $this->getHandleFile();
            foreach ($commitIds as $commitId ){
                $command = "git -C ".$this->getGitDir() ." show {$commitId} --name-only";
                exec($command, $outPut );
                if( $outPut ){
                    $outPut = array_reverse($outPut );
                    foreach ($outPut as $line){
                        if( file_exists( $this->getWorkDir() . $line ) && $line && !in_array($line , $files)){
                            $files[] = $line;
                        }
                    }
                }
            }

            $this->setHandleFile( $files );

        }catch (\Exception $exception){
            return false;
        }
    }

    /**
     * 在work目录生存readme 文件到压缩包
     * @param null $lineTitle
     * @return string
     */
    private function makeReadMeFile( $lineTitle= null ){

        if( !file_exists( $this->getReadMePathFile() ) ){
            touch( $this->getReadMePathFile() );
        }

        if($lineTitle !=null){
            file_put_contents( $this->getReadMePathFile() , "{$lineTitle} \r\n");
        }

        foreach ($this->getHandleFile()  as $file){
            file_put_contents( $this->getReadMePathFile() , "{$file} \r\n" , FILE_APPEND );
        }
        return ' '.$this->getReadMeFileName() ;
    }

    /**
     *
     * @return string
     */
    private function getReadMePathFile(){
        return $this->getWorkDir(). $this->getReadMeFileName();
    }

    private function getReadMeFileName(){
        return 'readme.txt';
    }
}
