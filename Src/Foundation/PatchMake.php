<?php


namespace Stars\Tools\Foundation;


use Stars\Tools\Lib\Patch\AppMakePatchOption;
use Stars\Tools\Lib\Patch\MakePatch;

class PatchMake
{
    /**
     * 制作GIt补丁
     * @param string $workDir
     * @param string $savePatchDir
     * @param string $gitDir
     * @param array $commitIds
     * @return bool
     * @throws \Exception
     */
    public static function makeGitPatch( string $workDir ,string $savePatchDir , string $gitDir ,array $commitIds ){
        try {
            $option = new AppMakePatchOption( MakePatch::HANDLE_TYPE_GIT , $workDir , $savePatchDir , $commitIds , $gitDir );
            $makePatch= new MakePatch($option);
            return $makePatch->handle();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * 制作文件补丁
     * @param string $workDir
     * @param string $savePatchDir
     * @param array $files
     * @return bool
     * @throws \Exception
     */
    public static function makeFilePatch( string $workDir ,string $savePatchDir , array $files ){
        try {
            $option = new AppMakePatchOption( MakePatch::HANDLE_TYPE_FILE , $workDir , $savePatchDir , $files  );
            $makePatch= new MakePatch($option);
            return $makePatch->handle();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
