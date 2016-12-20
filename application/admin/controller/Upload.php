<?php 
namespace app\admin\controller;

use think\Controller;
use app\api\services\File;

class Upload extends Controller
{

    public function fileUpload()
    {
        $file = new File;
        $result = $file->upload('img');
        echo json_encode($result);
    }
}