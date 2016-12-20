<?php 
namespace app\admin\controller;

use app\admin\model\Menu as MenuModel;
use app\admin\model\AuthRules;
use app\api\services\Auth;
/**
 * 菜单控制器
 */
class Menu extends Admin
{
    protected $authModel;

    public function _initialize()
    {
        parent::_initialize();
        $this->models = new MenuModel;
        $this->authModel = new AuthRules;
    }
    public function index()
    {
        $lists = $this->models->fetchLists(['parent_id'=>0]);
        $title = '菜单列表';
        return view('index',compact('title','lists'));
    }


    public function show()
    {
        $id = $this->getPk();
        $lists = $this->models->fetchLists(['parent_id'=>$id]);
        
        $title = '菜单列表';
        return view('index',compact('title','lists'));
    }


    public function create()
    {
        $menus = $this->models->fetchSelectMenu();
        $title = '创建菜单';
        return view('create',compact('title','menus'));
    }


    public function edit()
    {
        $id = $this->getPk();
        $item = $this->models->find($id);
        $menus = $this->models->fetchSelectMenu();
        
        $title = '编辑菜单';
        return view('edit',compact('title','menus','item'));
    }


    public function save()
    {
        if (request()->isPost() && input('post.')) {
            $data = json_decode(input('post.data'),true);
            $validate_result = $this->validate($data,'Menu');
            $rule_id = 0;
            $auth = new Auth;
            if (!empty($data['id'])) {
                $menu = $this->models->find($data['id']);
                $rule_id = $auth->fetchRuleId(request()->module().'/'.$menu->url);
            }
            
            
            if ($validate_result === true && $this->models->saveMenu($data)) {
                
                $rule_type = empty($data['parent_id']) ? 0 : 1;
                $disabled = isset($data['disabled']) ? 0 : 1;
                if (empty($rule_id)) {
                    $auth->createRule(request()->module(),$data['url'],$data['name'],$rule_type,$disabled);
                } else {
                    $auth->updateRule(request()->module(),$data['url'],$data['name'],$rule_type,$disabled,$rule_id);
                }
                
                // $this->authModel->saveRule($data);
                $this->success('菜单保存成功','index');
            }

            $this->error($validate_result);
        }
    }


    public function destory()
    {
        if (request()->isAjax()) {
            $id = $this->getPk();
            $obj = $this->models->find($id);
            $auth = new Auth;
            $auth->destoryRule(request()->module(),$obj->url);
            if ($obj->delete()) {
                return $this->success('删除成功','index');
            }
        }
        return $this->error('删除失败','index');
    }

}