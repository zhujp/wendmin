<?php 
namespace app\api\controller;

class File
{
    public function upload()
    {
        $file = request()->file('img');
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            $img_url = $info->getSaveName();
            $path = request()->domain().DS.'uploads'.DS;
            $result = ['status'=>1,'src'=>$path.$img_url,'msg'=>'图片上传成功'];
        }else{
            
            $result = ['status'=>0,'msg'=>$file->getError()];
        }

        echo  json_encode($result);
    }
}