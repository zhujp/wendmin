<?php 
namespace app\admin\controller;

use think\Controller;
use app\admin\model\Managers;

class Login extends Controller
{
    public function index()
    {
        $title = 'Wendiy';       
        return view('index',compact('title'));
    }


    public function login()
    {
        if (request()->isAjax() && input('post.')) {

            $data = json_decode(input('post.data'),true);
            if (empty($data['name']) && empty($data['password'])) {
                $this->error('请输入用户名或者密码');
            }
            $manager = Managers::login($data['name'],$data['password']);

            if (!empty($manager)) {
                $this->success('登录成功',url('index/index'));
            }
            $this->error('用户名或密码错误');

        }

        $this->error('请输入用户名和密码');
    }


    public function logout()
    {
        session('manager_id',null);

        $this->redirect('index');
    }
}