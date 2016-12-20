<?php 
namespace app\admin\controller;

use app\admin\model\Setting;

class Setting extends Admin
{

    public function _initialize()
    {
        parent::_initialize();
        $this->models = new Setting;
    }


    public function index()
    {
        $title = '系统设置';
        $sets = $this->models->fetchSets();
        return view('index',compact('title','sets'));
    }


    public function save()
    {
        if (request()->isAjax()) {
            $data = json_decode(input('post.data'),true);
            $validate_result = $this->validate($data,'Setting');
            if ($validate_result == true && $this->models->saveSetting(array_filter($data))) {
                $this->success('设置保存成功');
            }

            $this->error('设置保存失败');
        }
    }
}