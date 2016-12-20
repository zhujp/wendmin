<?php 
namespace app\admin\model;

use \think\Model;

/**
 * 系统设置模型
 */
class Setting extends Model
{

    public function fetchSets()
    {
        return  $this->order('sort asc')->select();
    }


    public function saveSetting($data)
    {
        foreach ($data as $k=>$v) {
            $where['name'] = $k;
            $set = self::get($where);
            $set->value = $v;
            $set->save();
        }

        return true;
    }
}