<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2018/12/18
 * Time: 17:56
 */

namespace app\models;



interface  Article
{

    /**查询列表
     * @param array $data
     * @return mixed
     */
    public  function list( $data=[] );

    /**分析数据
     * @param array $data
     * @return mixed
     */
    public function analysis( $data=[] );

    /**拉取数据
     * @return mixed
     */
    public function pull();
}