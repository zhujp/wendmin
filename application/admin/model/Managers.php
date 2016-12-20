<?php 
namespace app\admin\model;

use think\Model;

class Managers extends AbstractModel
{

    protected $insert = ['created_at'];

    protected $update = ['updated_at'];

    protected function setCreatedAtAttr()
    {
        return time();
    }


    protected function setUpdatedAtAttr()
    {
        return time();
    }

    public function getDisabledTextAttr($value,$data)
    {
        $text = [0=>'是',1=>'否'];
        return $text[$data['disabled']];
    }


    /**
     * 管理员登录
     */
    public static function login($username,$password)
    {
        $manager = self::get(['username'=>$username,'disabled'=>0]);
        if (!empty($manager) && validate_pasword($password,$manager->password)) {
            session('manager_id',$manager->id);
            session('username',$username);
            return $manager;
        }

        return false;
    }


    public function saveManager($data)
    {
        $row = [
            'username' => $data['username'],
            'mobile' => $data['mobile'],
            'email' => $data['email'],
        ];
        if (!empty($data['password'])) {
            $row['password'] = create_password($data['password']);
        }
        if (empty($data['id'])) {
            return self::create($row);
        }

        return $this->save($row,['id'=>$data['id']]);
    }


    public function fetchManagers()
    {
        $where = [
            'disabled' => 0,
        ];

        return $this->field('id,username')->select();
    }
}