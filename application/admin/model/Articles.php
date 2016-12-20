<?php 
namespace app\admin\model;

class Articles extends AbstractModel
{
    // public $insert = ['created_at'];

    public $update = ['updated_at'];


    // protected function setCreatedAtAttr()
    // {
    //     return time();
    // }


    protected function setUpdatedAtAttr()
    {
        return time();
    }

    public function getCreatedAtAttr($value)
    {
        return date('Y-m-d',$value);
    }

    public function getDisabledTextAttr($value,$data)
    {
        $text = [0=>'是',1=>'否'];
        return $text[$data['disabled']];
    }

    public function saveArticle($data)
    {
        $row = [
            'title' => $data['title'],
            'body' => $data['body'],
            'disabled' => isset($data['disabled']) ? 0 : 1,
            'intro' => empty($data['intro']) ? '' : $data['intro'],
            'author' => empty($data['author']) ? '' : $data['author'],
            'manager_id' => session('?manager_id') ? session('manager_id') : 0,
            'created_at' => empty($data['created_at']) ? time() : strtotime($data['created_at'])
        ];
        
        if (empty($data['id'])) {
            return self::create($row);
        } else {
            return $this->save($row,['id'=>$data['id']]);
        }
        
    }

}