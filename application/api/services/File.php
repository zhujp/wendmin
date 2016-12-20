<?php 
namespace app\api\services;

class File
{
    public function upload($filename)
    {
        $file = request()->file($filename);
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            // 成功上传后 获取上传信息
            // 输出 jpg
            // echo $info->getExtension();
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            $img_url = $info->getSaveName();
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
            // echo $info->getFilename(); 
            $path = request()->domain().DS.'uploads'.DS;
            $result = ['status'=>1,'src'=>$path.$img_url,'msg'=>'图片上传成功'];
        }else{
            // 上传失败获取错误信息
            // echo $file->getError();
            $result = ['status'=>0,'msg'=>$file->getError()];
        }

        return $result;
    }
}