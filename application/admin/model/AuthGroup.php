<?php 
namespace app\admin\model;

class AuthGroup extends AbstractModel
{


    public function getDisabledTextAttr($value,$data)
    {
        $text = [0=>'是',1=>'否'];
        return $text[$data['disabled']];
    }

    
    public function saveAuthGroup($data)
    {
        $row = [
            'group_name' => $data['group_name'],
            'intro' => empty($data['intro']) ? '' : $data['intro'],
            'disabled' => isset($data['disabled']) ? 0 : 1,
        ];
        
        if (empty($data['id'])) {
            return self::create($row);
        }

        return $this->save($row,['id'=>$data['id']]);
    }
}