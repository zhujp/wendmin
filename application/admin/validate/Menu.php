<?php 
namespace app\admin\validate;

use think\Validate;

class Menu extends Validate
{
    protected $rule = [
        'name' => 'require|max:40',
        'url' => 'require|max:60',
    ];

    protected $message = [
        'name.require' => '请填写菜单名称',
        'url.require' => '请填写菜单Url' 
    ];
}