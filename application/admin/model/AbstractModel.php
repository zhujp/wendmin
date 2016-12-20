<?php 
namespace app\admin\model;

use think\Model;

class AbstractModel extends Model
{
    const PAGE_SIZE = 10;

    public function fetchLists($where=[],$order='id desc',$field=true)
    {
        $lists = self::where($where)->order($order)->paginate(self::PAGE_SIZE);
        // $count = self::where($where)->count();
        // $size = ceil($count/self::PAGE_SIZE);

        return $lists;
    }
}