<?php 
namespace app\admin\model;

class AuthRules extends AbstractModel
{

    public function saveRule($data)
    {
        $type = empty($data['parent_id']) ? 0 : 1;

        $rule = self::get(['name'=>$data['url'],'type'=>$type]);
        $row = [
            'app' => 'admin',
            'type' => empty($data['parent_id']) ? 0 : 1,
            'name' => $data['url'],
            'title' => $data['name']
        ];
        if (empty($rule)) {
            
            return self::create($row);
        }

        return $this->save($row,['id'=>$rule->id]);

    }


    public function fetchRules()
    {
        
    }

}