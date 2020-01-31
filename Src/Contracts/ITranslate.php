<?php


namespace Stars\Tools\Contracts;

/**
 * 翻译
 * Interface ITranslate
 * @package Stars\Tools\Contracts
 */
interface ITranslate
{
    /**
     * 需要翻译的内容
     * @param $contents
     * @return mixed
     */
    public function content( $contents );

    /**
     * 获取翻译结果
     * @return mixed
     */
    public function result();
}
