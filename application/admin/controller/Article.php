<?php 
namespace app\admin\controller;

use app\admin\model\Articles;

class Article extends Admin
{

    public function _initialize()
    {
        parent::_initialize();
        $this->models = new Articles;
    }

    public function index()
    {
        $lists = $this->models->fetchLists();
        $title = '文章列表';
        return view('index',compact('title','lists'));
    }


    public function create()
    {
        $title = '新增文章';
        return view('create',compact('title'));
    }


    public function save()
    {
        if (request()->isAjax() && input('post.')) {
            $request = json_decode(input('post.data'),true);
            $validate_result = $this->validate($request,'Articles');
            if ($validate_result === true && $this->models->saveArticle($request)) {
                $this->success('文章保存成功','index');
            }

            $this->error ($validate_result);
        }
    }

    public function edit()
    {
        $id = $this->getPk();
        $article = $this->models->find($id);
        $title = '编辑文章';
        return view('edit',compact('article','title'));
    }



}