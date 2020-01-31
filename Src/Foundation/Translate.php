<?php
namespace Stars\Tools\Foundation;
use Stars\Tools\Contracts\ITranslate;

class Translate
{
    /**
     * 翻译器
     * @var ITranslate|null
     */
    private $translate = null;

    /**
     * 构造一个翻译器
     * AbsTranslate constructor.
     * @param ITranslate $iTranslate
     */
    public function __construct( ITranslate $iTranslate )
    {
        $this->translate = $iTranslate ;
    }

    /**
     * 设置翻译内容
     * @param $contents
     */
    public function setContent( $contents ){
        $this->translate->content( $contents );
    }

    /**
     * 获取翻译结果
     * @return mixed
     */
    public function result(){
        return $this->translate->result();
    }
}
