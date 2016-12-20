<?php 
namespace app\admin\model;


class AuthAccess extends AbstractModel
{

    public function fetchAuthManagerByGroupId($group_id,$is_str=false)
    {
        $managers = $this->where('group_id',$group_id)->column('manager_id');
        if ($is_str) {
            return implode(',',$managers);
        }

        return $managers;
    }

    public function saveUserAccess($data)
    {
        $managers = $data;
        unset($managers['group_id']);
        $list = [];
        //删除之前的数据
        $this->where(['group_id'=>$data['group_id']])->delete();
        foreach ($managers as $manager) {
            $row = ['group_id'=>$data['group_id'],'manager_id'=>$manager];
            $list[] = $row;
        }
        
        return self::saveAll($list);
    }
}