<?php 
namespace app\admin\controller;

use app\admin\model\AuthGroup;
use app\admin\model\AuthAccess;
use app\admin\model\AuthRules;
use app\admin\model\Managers;
use app\admin\model\Menu;
use app\api\services\Auth as AuthCls;

class Auth extends Admin
{   
    //管理员模型
    protected $managerModel;
    //用户组模型
    protected $authAccessModel;
    //权限节点规则表
    protected $authRulesModel;

    //用户菜单表模型
    protected $menuModel;

    protected $authObj;

    public function _initialize()
    {
        parent::_initialize();
        $this->models = new AuthGroup;
        $this->managerModel = new Managers;
        $this->authAccessModel = new AuthAccess;
        $this->authRulesModel = new AuthRules;
        $this->menuModel = new Menu;
        $this->authObj = new AuthCls;
    }

    public function index()
    {
        $lists = $this->models->fetchLists();
        $title = '权限管理';
        return view('index',compact('title','lists'));
    }


    public function create()
    {
        $title = '新增权限组';
        return view('create',compact('title'));
    }


    public function save()
    {
        if (request()->isAjax() && input('post.')) {
            $request = json_decode(input('post.data'),true);
            $validate_result = $this->validate($request,'AuthGroup');
            if ($validate_result === true && $this->models->saveAuthGroup($request)) {
                $this->success('权限组保存成功','index');
            }

            $this->error ($validate_result);
        }
    }


    public function edit()
    {
        $id = $this->getPk();
        $group = $this->models->find($id);
        $title = '权限组编辑';

        return view('edit',compact('group','title'));
    }


    /**
     * 权限组授权
     */
    public function access()
    {
        $group_id = $this->getPk();
        
        $group = $this->models->find($group_id);
        $rules = $this->authObj->fetchAllRuleId();
        $group_access = explode(',',$group->rules);
        $access = $this->menuModel->fetchNodeMenu($group_access,$rules);
        $title = '权限组授权';
        return view('access',compact('title','group_id','access','group_access'));
    }


    public function saveAccess()
    {
        if (request()->isAjax() && input('post.')) {
            $data = json_decode(input('post.data'),true);
            $group_id = array_shift($data);

            if ($this->authObj->saveGroupAccess($group_id,$data)) {
                return $this->success('保存成功',url('index'));
            }
            $this->error('权限保存失败');
        }
    }
    


    /**
     * 成员授权
     */
    public function user()
    {
        $group_id = $this->getPk();
        $managers = $this->managerModel->fetchManagers();
        $title = '成员授权';
        $authManagers = $this->authAccessModel->fetchAuthManagerByGroupId($group_id,true);
        return view('user',compact('managers','title','group_id','authManagers'));
    }


    /**
     * 保存授权用户
     */
    public function authUser()
    {
        if (request()->isAjax() && input('post.')) {
            $data = json_decode(input('post.data'),true);
            if ($this->authAccessModel->saveUserAccess($data)) {
                return $this->success('保存成功',url('user',['id'=>$data['group_id']]));
            }
            $this->error($this->authAccessModel->getError());
        }
    }
}