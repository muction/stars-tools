<?php
namespace Stars\Tools\Contracts;

interface ISearch
{
    /**
     * 设置搜索关键字
     * @param $columns
     * @return mixed
     */
    public function setKeyWord ( $keyWord );

    /**
     * 设置返回数据字段名称
     * @param array $columns
     * @return mixed
     */
    public function setListColumns( array $columns );

    /**
     * 分页获取
     * @param int $pageSize
     * @return mixed
     */
    public function paginate( $pageSize = 10 );
}
