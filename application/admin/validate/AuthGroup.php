<?php 
namespace app\admin\validate;


use think\Validate;

class AuthGroup extends Validate
{

    protected $rule = [
        'group_name' =>  'require',
    ];

    protected $message = [
        'group_name.require' => '权限组名称不能为空'
    ];
}