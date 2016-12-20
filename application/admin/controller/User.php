<?php 
namespace app\admin\controller;

use app\admin\model\Users;

class User extends Admin
{

    public function _initialize()
    {
        parent::_initialize();
        $this->models = new Users;
    }

    public function index()
    {

        $lists = $this->models->fetchLists();
        $title = '用户列表';
        return view('index',compact('title','lists'));
    }


    public function create()
    {

        $title = '创建用户';
        return view('create',compact('title'));
    }


    public function save()
    {

        if (request()->isAjax() && input('post.')) {
            $request = json_decode(input('post.data'),true);
            $validate_result = $this->validate($request,'Users');
            if (true === $validate_result && $this->models->createUser($request)) {

                $this->success('创建成功','index');
            }
            $this->error($validate_result);
        }
    }


    public function edit()
    {
        $id = $this->getPk();
        $user = $this->models->find($id);

        $title = '编辑用户';
        return view('edit',compact('user','title'));
    }


    public function update()
    {
        if (request()->isAjax() && input('post.')) {
            $request = json_decode(input('post.data'),true);
            $validate_result = $this->validate($request,'Users.edit');
            if (true === $validate_result && $this->models->updateUser($request)) {

                $this->success('修改成功','index');
            }
            $this->error($validate_result);
        }
    }

}