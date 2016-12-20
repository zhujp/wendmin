<?php 
namespace app\admin\validate;


use think\Validate;
use app\admin\model\Managers;

class Managers extends Validate
{

    protected $rule = [
        'username' =>  'require',
        'mobile' =>  'mobile:|checkMobile:',
        'email' => 'email',
        'password' => 'require',
    ];

    protected $message = [
        'username.require' => '用户名不能为空',
        'mobile.mobile' => '请输入合法手机',
        'mobile.checkMobile' => '您的手机已经有账号啦',
        'email.email' => '请输入合法电子邮箱',
        'password.require' => '请输入密码'
    ];

    protected $scene = [
        'edit' => ['username','mobile','email']
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
        $manager = Managers::get(['mobile'=>$value]);
        
        return empty($manager->id) || $data['id'] == $manager->id;
    }
}