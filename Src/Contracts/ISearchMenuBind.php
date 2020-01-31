<?php
namespace Stars\Tools\Contracts;

interface ISearchMenuBind
{
    /**
     * 菜单绑定设置
     * @param int $bindId
     * @param array $searchColumns
     * @param array $listColumns
     * @return mixed
     */
    public function addSearchMenuBindConfig(int $bindId, array $searchColumns , $listColumns );
}
