<?php 
namespace app\api\services;

use think\Db;

class Auth
{
    protected $config = [
        'is_auth' => true,
        'auth_group' => 'auth_group',
        'auth_rules' => 'auth_rules',
        'auth_access' => 'auth_access',
        'auth_user' => 'managers'
    ];

    public function __construct()
    {
        $app_config = config('auth');
        $this->config['is_auth'] = $app_config['is_auth'];
        $this->config['auth_group'] = $app_config['auth_group'];
        $this->config['auth_access'] = $app_config['auth_access'];
        $this->config['auth_user'] = $app_config['auth_user'];
        $this->config['auth_rules'] = $app_config['auth_rules'];
    }

    /**
     * 创建规则
     * @param $app string 所属应用
     * @param $name string url
     * @param $title string 规则描述
     * @param $type int 类型
     * @param $disabled int 是否禁用
     */
    public function createRule($app,$name,$title,$type=0,$disabled=0)
    {
        $row = [
            'app' => $app,
            'name' => $app.'/'.$name,
            'title' => $title,
            'type' => $type,
            'disabled' => $disabled
        ];

        
        return Db::name($this->config['auth_rules'])->insert($row);
    }


    /**
     * 更新验证规则
     */
    public function updateRule($app,$name,$title,$type=0,$disabled=0,$rule_id)
    {
        $row = [
            'app' => $app,
            'name' => $app.'/'.$name,
            'title' => $title,
            'type' => $type,
            'disabled' => $disabled
        ];

        $row['id'] = $rule_id;
        return Db::name($this->config['auth_rules'])->update($row);
    }


    /**
     * 删除规则
     */
    public function destoryRule($app,$rule)
    {
        $rule_id = $this->fetchRuleId($rule,$app);
        return Db::name($this->config['auth_rules'])->delete($rule_id);
    }

    /**
     * 获取用户所有规则
     * @param $app string 应用
     * @param $user_id int 用户ID
     * return array
     */
    public function fetchUserRules($user_id,$app,$is_id=false)
    {

        $user_groups = $this->fetchUserGroups($user_id,$app);
        if (empty($user_groups)) {
            return [];
        }


        $rule_ids = $this->fetchGroupRuleId($user_groups);

        $field = 'name';

        if ($is_id) {
            $field = 'id';
        }
        $rules = Db::name($this->config['auth_rules'])->where(['id'=>['in',$rule_ids]])->column($field);

        return $rules;
    }

    /**
     * 检测用户某一个节点的权限权限
     * @param $user_id 用户id
     * @param $rule 规则
     * return boolean
     */
    public function checkRuleAccess($user_id,$app,$rule)
    {
        $rule_id = $this->fetchRuleId($rule);

        $user_rules = $this->fetchUserRules($user_id,$app,true);

        if (in_array($rule_id, $user_rules,true)) {
            return true;
        }

        return false;
    }



    public function fetchRuleId($rule)
    {
        $where = [
            'name' => $rule,
        ];

        return Db::name($this->config['auth_rules'])->where($where)->value('id');
    }


    /**
     * 获取用户所在应用，所属组ID
     * @param $user_id  用户ID
     * @param $app 应用
     */
    public function fetchUserGroups($user_id,$app)
    {
        $where = [
            'app' => $app,
            'manager_id' => $user_id
        ];
        //获取用户在当前应用里面所属权限组
        $groups = Db::name($this->config['auth_access'])->where($where)->column('group_id');

        return $groups;
    }


    /**
     * 获取权限组所有的规则ID
     * @param $group_id int|array 权限组ID
     * @return 
     */
    public function fetchGroupRuleId($group_id)
    {
        if (is_array($group_id)) {
            $where = ['id'=>['in',$group_id]];
            $rules_arr = Db::name($this->config['auth_group'])->where($where)->column('rules');
            $rules = [];
            foreach ($rules_arr as $val) {
                $rules = array_merge($rules,explode(',', $val));
            }
        } else {
            $rule = Db::name($this->config['auth_group'])->where(['id'=>$group_id])->value('rules');
            $rules = explode(',', $rule);
        }

        return $rules;
    }


    /**
     * 保存权限组权限
     * @param  [type] $group_id 权限组ID
     * @param  [type] $rules    规则ID数组
     * @return [type]           [description]
     */
    public function saveGroupAccess($group_id,$rules)
    {
        $row['rules'] = implode(',', $rules);
        $row['id'] = $group_id;
        return Db::name($this->config['auth_group'])->update($row);
    }


    /**
     * @return array 获取所有权限节点对应的ID，以name为key
     */
    public  function fetchAllRuleId()
    {
        $rules = Db::name($this->config['auth_rules'])->where('disabled',0)->select();
        $result = [];
        foreach ($rules as $val) {
            $result[$val['name'].$val['type']] = $val['id'];
        }

        return $result;
    }
    
}