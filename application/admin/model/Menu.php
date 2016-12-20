<?php 
namespace app\admin\model;

class Menu extends AbstractModel
{

    public function getDisabledTextAttr($value,$data)
    {
        $text = [0=>'是',1=>'否'];
        return $text[$data['disabled']];
    }

    /**
     * @param $parent_id 所属菜单id
     * @return 返回分级的路径
     */
    public function fetchPathStr($parent_id)
    {
        $parent = self::get($parent_id);

        if (empty($parent->parent_id)) {
            return $parent_id.',';
        }

        return $parent->path_str.','.$parent_id;
    }


    public function fetchSelectMenu()
    {
        $menuObj = self::where(['disabled'=>0])->order('sort asc')->select();
        if (empty($menuObj)) {
            return [];
        }
        foreach ($menuObj as $obj) {
            $menus[] = $obj->toArray();
        }
        $result = [];

        foreach ($menus as $key=>$val) {
            $refer[$val['id']] = &$menus[$key]; 
        }

        foreach ($menus as $k=>$v) {
            if (empty($v['parent_id'])) {
                $result[] = &$menus[$k];
            } else {
                $refer[$v['parent_id']]['child'][] = &$menus[$k];
            }
        }
        
        return $result;
    }


    public function fetchNodeMenu($access,$rules)
    {
        $menuObj = self::where(['disabled'=>0])->order('sort asc')->select();
        if (empty($menuObj)) {
            return [];
        }
        foreach ($menuObj as $obj) {
            $menu = $obj->toArray();
            $menu['checked'] = 0;
            $type = empty($obj['parent_id']) ? 0 : 1;
            $rule_id = $rules[request()->module().'/'.$menu['url'].$type];
            if (in_array($rule_id, $access)) {
                $menu['checked'] = 1;
            }
            $menu['rule_id'] = $rule_id;
            $menus[] = $menu;
        }
        $result = [];

        foreach ($menus as $key=>$val) {
            $refer[$val['id']] = &$menus[$key]; 
        }

        foreach ($menus as $k=>$v) {
            if (empty($v['parent_id'])) {
                $result[] = &$menus[$k];
            } else {
                $refer[$v['parent_id']]['child'][] = &$menus[$k];
            }
        }
        
        return $result;
    }


    public function saveMenu($data)
    {
        $parent_id = empty($data['parent_id']) ? 0 : $data['parent_id'];
        $path_str = '';
        if (!empty($parent_id)) {
            $path_str = $this->fetchPathStr($parent_id);
        }

        $row = [
            'name' => $data['name'],
            'url' => $data['url'],
            'path_str' => $path_str,
            'parent_id' => $parent_id,
            'sort' => $data['sort'],
            'disabled' => isset($data['disabled']) ? 0 : 1
        ];


        if (empty($data['id'])) {

            return self::create($row);
        } 

        return $this->save($row,['id'=>$data['id']]);
    }


    public function fetchAuthMenus($app,$user_rules,$is_auth)
    {
        
        $menuObj = self::where(['disabled'=>0])->order('sort asc')->select();
        if (empty($menuObj)) {
            return [];
        }
        foreach ($menuObj as $obj) {
            $user_menu = $obj->toArray();
            if (!$is_auth || in_array($app.'/'.$user_menu['url'], $user_rules)) {
                $menus[] = $user_menu;
            }
        }
        $result = [];

        foreach ($menus as $key=>$val) {
            $refer[$val['id']] = &$menus[$key]; 
        }

        foreach ($menus as $k=>$v) {
            if (empty($v['parent_id'])) {
                $result[] = &$menus[$k];
            } else {
                $refer[$v['parent_id']]['child'][] = &$menus[$k];
            }
        }
        
        return $result;
    }


}