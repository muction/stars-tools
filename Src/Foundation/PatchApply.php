<?php


namespace Stars\Tools\Foundation;


use Stars\Tools\Lib\Patch\AppApplyPatchOption;
use Stars\Tools\Lib\Patch\ApplyPatch;

class PatchApply
{
    /**
     * 应用补丁包
     * @param $workDir
     * @param $savePatchPath
     * @param $patchFile
     * @return bool
     * @throws \Exception
     */
    public static function apply( $workDir, $savePatchPath, $patchFile ){
        $option = new AppApplyPatchOption(  $workDir, $savePatchPath, $patchFile);
        $apply =new ApplyPatch( $option );
        try {
            return $apply->handle();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
