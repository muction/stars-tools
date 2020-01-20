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

        if( $makePatchOption->getHandleType() == self::HANDLE_TYPE_GIT){
            $this->setMakeGitFiles();
        }
        return $this->zipFiles();
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
            $patchPathFileName = $this->getWorkDir() . $patchFileName ;

            foreach ($this->getHandleFile() as $file){
                if( !file_exists( $file ) ){
                    throw new \Exception("文件不存在: {$file}");
                }
            }

            $zipFiles = implode(" ",  $this->getHandleFile() );

            exec("zip {$patchPathFileName} {$zipFiles}");

            if(!file_exists($patchPathFileName) ){
                throw new \Exception("打包失败");
            }
            //计算补丁md5
            $fileMd5= md5_file( $patchPathFileName );
            $newPatchFileName = $patchFileName .'-'.$fileMd5.'.zip' ;

            //重新命名文件
            $newPatchPathFileName= $patchPathFileName . $newPatchFileName ;
            if( rename(  $patchPathFileName , $newPatchPathFileName )) {
                return $newPatchFileName;
            }

            return false;

        }catch (\Exception $exception){
            throw $exception;
        }
    }

    /**
     *
     */
    private function setMakeGitFiles(){
        try{
            $commitIds = "";
            while ( !$commitIds ){
                $input = $this->ask("请输入git提交ID，多个用空格：");
                if($input){
                    $commitIds = $input;
                }
            }

            $files = [];
            $commitIds = explode(" ",  $this->getHandleFile());
            foreach ($commitIds as $commitId ){
                exec("git -C ".$this->gitRepoDir ." show {$commitId} --name-only", $outPut );
                if( $outPut ){
                    $outPut = array_reverse($outPut );
                    foreach ($outPut as $line){
                        if( file_exists( base_path($line) ) ){
                            $files[] = $line;
                        }
                    }
                }
            }
            $this->setHandleFile( $files );
            $this->zipFiles( $files );

        }catch (\Exception $exception){

            $this->error("获取GIT提交时异常：".$exception->getMessage() );
        }
    }

    /**
     * 在work目录生存readme 文件到压缩包
     */
    private function makeReadMeFile(){

        if( !file_exists( $this->getReadMePathFile() ) ){
            touch( $this->getReadMePathFile() );
        }

        if( file_put_contents( $this->getReadMePathFile() , "本次补丁包文件列表 \r\n") ){
            return $this->getReadMePathFile() ;
        }

        return false;
    }

    /**
     *
     * @return string
     */
    private function getReadMePathFile(){
        return $this->getWorkDir().'readme.txt';
    }

}
