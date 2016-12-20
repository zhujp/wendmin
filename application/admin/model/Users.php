<?php 
namespace app\admin\model;

class Users extends AbstractModel
{

    public $insert = ['created_at'];

    public $update = ['updated_at'];


    protected function setCreatedAtAttr()
    {
        return time();
    }


    protected function setUpdatedAtAttr()
    {
        return time();
    }

    public function getSexTextAttr($value,$data)
    {
        $sex = [1=>'男',2=>'女',3=>'保密'];
        return $sex[$data['sex']];
    }

    public function getCreatedAtAttr($value)
    {
        return date('Y-m-d',$value);
    }

    public function getBirthdayAttr($value)
    {
        return date('Y-m-d',$value);
    }

    public function getUpdatedAtAttr($value)
    {
        return empty($value) ? '' : date('Y-m-d',$value);
    }

    public function getIpAttr($value)
    {
        return long2ip($value);
    }


    public function createUser($data)
    {
        $data['password'] = create_password($data['password']);
        $data['ip'] = request()->ip(1);
        $data['birthday'] = empty($data['birthday']) ? 0 : strtotime($data['birthday']);
        
        return self::create($data);
    }

    public function updateUser($data)
    {
        if (!empty($data['password'])) {
            $data['password'] = create_password($data['password']);
        }
        $data['ip'] = request()->ip(1);
        $data['birthday'] = empty($data['birthday']) ? 0 : strtotime($data['birthday']);
        
        return self::update($data);
    }
}