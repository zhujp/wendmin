<?php 
namespace app\admin\validate;


use think\Validate;

class Articles extends Validate
{

    protected $rule = [
        'title|文章标题' =>  'require',
        'body|文章内容' =>  'require',
    ];
}