<?php
namespace Stars\Tools\Lib\Translate;
use GuzzleHttp\Client;
use Stars\Tools\Contracts\ITranslate;

/**
 * @inheritDoc http://api.fanyi.baidu.com/product/113
 * Class BaiDuTranslate
 * @package Stars\Tools\Lib\Translate
 */
class BaiDuTranslate implements ITranslate
{
    /**
     * 开发者ID
     * @var string
     */
    private $appId = '';

    /**
     * 原文语言，默认auto
     * @var string
     */
    private $from = '';

    /**
     * 译文语言，auto
     * @var string
     */
    private $to = '';

    /**
     * 秘钥
     * @var string
     */
    private $secret = '';

    /**
     * 翻译接口地址
     * @var string
     */
    private $apiUrl ='http://api.fanyi.baidu.com/api/trans/vip/translate';

    /**
     * 原文
     * @var string
     */
    private $transContent = "";

    /**
     * 接口响应内容
     * @var string
     */
    private $responseContent = "";

    /**
     * 构造
     * BaiDuTranslate constructor.
     * @param $appId
     * @param $from
     * @param $to
     * @param $sc
     */
    public function __construct( $appId, $secret , $from ='auto' , $to='auto' )
    {
        $this->appId = $appId ;
        $this->from = $from;
        $this->to = $to ;
        $this->secret = $secret;
    }

    /**
     * @inheritDoc
     */
    public function content($contents)
    {
        $this->transContent = $contents ;
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function result()
    {
        //开始翻译
        if($this->handleTranslate()){
            $response = json_decode( $this->responseContent , true );
            return isset($response['trans_result']) ? $response['trans_result'] : null;
        } ;

        return null;
    }

    /**
     * 请求翻译接口
     * @return mixed
     * @throws \Exception
     */
    private function handleTranslate(){

        $httpClient = new Client();
        $salt = time();
        $params =  [
            'form_params'=>[
                'q'=> $this->transContent ,
                'from'=> $this->from ,
                'to'=> $this->to ,
                'appid'=> $this->appId ,
                'salt'=>$salt,
                'sign'=> $this->makeRequestSign(  $salt )
            ]
        ] ;
        $response = $httpClient->post( $this->apiUrl , $params);
        if($response->getStatusCode() == 200 ){
            $this->responseContent = $response->getBody()->getContents() ;
            return true;
        }

        return false;
    }

    /**
     * 生成sign
     * @param $salt
     * @return string
     */
    private function makeRequestSign( $salt ){

        return md5( $this->appId . $this->transContent . $salt. $this->secret );
    }
}
