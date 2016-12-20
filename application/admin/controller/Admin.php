<?php 
namespace app\admin\controller;

use think\Controller;
use app\admin\model\Menu;
use app\api\services\Auth;

/**
 * 后台基类控制器
 */
class Admin extends Controller
{
    protected $models;

    public function _initialize()
    {
        parent::_initialize();
        if (!session('?manager_id')) {
            $this->redirect(url('login/index'));
        }
        //检测权限
        
        if (!$this->checkSupperAdmin() && !$this->checkAccess()) {
            $this->error('对不起您没有该权限');
        }
        //获取有权限的菜单
        $sideMenu = $this->fetchMenus();
        $this->assign('sideMenu',$sideMenu);
    }



    /**
     * 检测当前操作的权限
     * @return [type] [description]
     */
    public function checkAccess()
    {
        $auth = new Auth;

        return $auth->checkRuleAccess(session('manager_id'),request()->module(),request()->path());
    }


    public function checkSupperAdmin()
    {
        if (session('manager_id') == config('auth.supper_admin')) {
            return true;
        }

        return false;
    }



    /**
     * 获取用户的菜单
     * @return [type] [description]
     */
    public function fetchMenus()
    {
        $menu = new Menu;
        $auth = new Auth;
        $user_rules = $auth->fetchUserRules(session('manager_id'),request()->module());

        $is_auth = config('auth.is_auth');
        if ($this->checkSupperAdmin()) {
            $is_auth = false;
        }
        $menus = $menu->fetchAuthMenus(request()->module(),$user_rules,$is_auth);
        // $auth = new 
        return $menus;
    }


    public function getPk($pk = 'id')
    {
        $id = input("param.{$pk}");
        if (empty($id)) {
            return $this->error('没有该纪录的数据');
        }

        return intval($id);
    }


    /**
     * 无刷新分页数据
     */
    public function ajaxPage($lists,$keys = [],$pk='id',$extra=[])
    {
        
        $html = '';
        $length = count(reset($lists));
        foreach ($lists as $list) {
            $html .= '<tr>';
            foreach ($keys as $val) {
                $html .= '<td>'.$list->$val.'</td>';
            }

            if (!empty($extra)) {
                $html .= '<td><a href="'.url($extra['url'],[$pk=>$list->$pk]).'" class="layui-btn layui-btn-normal layui-btn-small" title="'.$extra['title'].'"><i class="layui-icon">'.$extra['icon'].'</i></a>';
            }
            $html .= '<td><a href="'.url('edit',[$pk=>$list->$pk]).'" class="layui-btn layui-btn-normal layui-btn-small" title="编辑"><i class="layui-icon">&#xe642;</i></a>
                <a href="javascript:;" class="layui-btn layui-btn-normal layui-btn-small ajax-del" data-id="'.$list->$pk.'" data-url="'.url('destory').'" title="删除"><i class="layui-icon">&#xe640;</i></a>';

            $html .= '</td></tr>';

        }

        return $html;
    }

    public function destory()
    {
        if (request()->isAjax()) {
            $id = $this->getPk();
            $obj = $this->models->find($id);
            if ($obj->delete()) {
                return $this->success('删除成功','index');
            }
        }
        return $this->error('删除失败','index');
    }
}