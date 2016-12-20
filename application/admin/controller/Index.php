<?php 
namespace app\admin\controller;

class Index extends Admin
{

    public function index()
    {
        $title = '后台首页';
        return view('dashboard',compact('title'));
    }
}
