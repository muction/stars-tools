<?php
namespace Stars\Tools\Foundation;
use Illuminate\Support\Facades\DB;
use Stars\Peace\Entity\MenuBindEntity;
use Stars\Tools\Contracts\ISearch;
use Stars\Tools\Contracts\ISearchMenuBind;

/**
 * Class SearchSearch
 * @package Stars\Search\Foundation
 */
class SearchPeace implements ISearch,ISearchMenuBind
{

    private $keyWord = "" ;

    private $searchColumns = [];

    private $bindInfos = [];

    private $orderBy = [];

    /**
     * 设置关键字
     * @param $keyWord
     * @return mixed|void
     */
    public function setKeyWord( $keyWord )
    {
        $this->keyWord = $keyWord;
        return $this;
    }

    /**
     * 设置列表字段
     * @param array $columns
     * @return mixed|void
     */
    public function setListColumns(array $columns)
    {
        $this->listColumns = $columns ;
        return $this;
    }

    /**
     * @param int $bindId
     * @param array $searchColumns
     * @param array $listColumns
     * @return $this|mixed
     */
    public function addSearchMenuBindConfig(int $bindId, array $searchColumns, $listColumns)
    {
        $this->searchColumns[ $bindId ] = [ 'searchColumns'=>$searchColumns , 'listColumns'=>$listColumns  ];
        return $this;
    }

    /**
     * 分页获取数据
     * @param int $pageSize
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|mixed|null
     */
    public function paginate($pageSize = 10)
    {
        $bindInfos = $this->filterBindInfo ();
        $union = null;

        foreach ( $bindInfos as $bindId =>$column )
        {
            $bindInfo = MenuBindEntity::bindDetail( $bindId );
            if( $bindInfo ){
                $tmp = DB::table( $bindInfo['table_name'] );

                if( is_string($column['list_columns'])){
                    $tmp = $tmp ->selectRaw( $column['list_columns'] ) ;
                }elseif( is_array( $column['list_columns'] )){
                    $tmp = $tmp ->select( $column['list_columns'] ) ;
                }

                 $tmp = $tmp->where(function($query ) use ($column){
                    foreach ($column['search_columns'] as $column){
                        $query->orWhere( $column  ,'LIKE' , "%{$this->keyWord}%" );
                    }
                });

                if( $union ){
                    $union = $union->union( $tmp );
                }else{
                    $union = $tmp;
                }

            }
        }

        return $union ? $union->orderBy('id','DESC')->paginate( $pageSize ) : $union;

    }

    /**
     * 过滤
     * @return array
     */
    private function filterBindInfo(){

        $result = [];
        foreach ($this->searchColumns as $bindId =>$column )
        {
            $bindInfo = MenuBindEntity::bindDetail( $bindId );
            if( !in_array( $bindInfo['table_name'], $result ) ){
                array_push( $result , $bindInfo['table_name'] ) ;

                $this->bindInfos[ $bindId ] = [
                    'bind_id' => $bindId ,
                    'table_name'=> $bindInfo['table_name'] ,
                    'search_columns'=> $column['searchColumns'] ,
                    'list_columns'=> $column['listColumns'] ,
                ];
            }
        }

        return $this->bindInfos;
    }
}
