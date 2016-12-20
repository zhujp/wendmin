<?php 
namespace app\admin\validate;

use think\Validate;
use app\admin\model\Users as UserModel;

class Users extends Validate
{

    protected $rule = [
        'username' => 'require|max:40',
        'mobile' => 'mobile:|checkMobile:',
        'email' => 'email',
        'password' => 'require',
    ];


    protected $message = [
        'username.require' => '请填写用户名',
        'mobile.mobile' => '请填写手机号码',
        'mobile.checkMobile' => '该手机已经注册过账号',
        'email.email' =>  '请填写合法的邮箱',
        'password.require' => '请填写密码'
    ];

    protected $scene = [
        'edit'  =>  ['username','mobile','email'],
        // 'add' => ['username','mobile','email','password']
    ];

    // 自定义验证规则
    protected function mobile($value)
    {
        if (preg_match('/1\d{10}/', $value)) {
            return true;
        }
        return false;
    }

    protected function checkMobile($value,$rule,$data)
    {
        $user = UserModel::get(['mobile'=>$value]);
        if (!empty($data['id']) && $data['id'] == $user->id) {
            // return '该手机已经注册过账号';
            return false;
        }

        return true;
    }

    
}