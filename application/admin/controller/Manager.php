<?php 
namespace app\admin\controller;

use think\Db;
use app\admin\model\Managers;

class Manager extends Admin
{

    public function _initialize()
    {
        parent::_initialize();
        $this->models = new Managers;
    }

    public function index()
    {
        $lists = $this->models->fetchLists();
        $title = '管理员列表';
        return view('index',compact('title','lists'));
    }


    public function create()
    {
        $title = '新增管理员';
        return view('create',compact('title'));
    }


    public function save()
    {
        if (request()->isAjax() && input('post.')) {

            $request = json_decode(input('post.data'),true);
            if (empty($request['id'])) {
                $validate_result = $this->validate($request,'Managers');
            } else {
                $validate_result = $this->validate($request,'Managers.edit');
            }
            
            if (true === $validate_result && $this->models->saveManager($request)) {

                $this->success('保存成功','index');
            }
            $this->error($validate_result);
        }
    }


    public function edit()
    {
        $id = $this->getPk();
        $manager = $this->models->find($id);
        $title = '编辑管理员';

        return view('edit',compact('manager','title'));
    }


    public function setting()
    {
        $title = '个人设置';
        $manager = $this->models->find(session('manager_id'));
        return view('setting',compact('manager','title'));
    }

}