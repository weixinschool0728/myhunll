<?php
namespace Home\Controller;
use Home\Controller;
class KindeditorController extends FontEndController {
        public function editor_check(){
        $file_info=$this->upload('image/temp/');
        //当有文件没有上传时，提示并返回
        if(count($file_info)<1){
            $this->error('请选择文件');
            exit();
        }
        
        $file_url=UPLOAD.$file_info['imgFile']['savepath'].$file_info['imgFile']['savename'];
        $data_1=array(
            'error' => 0,
            'url' => '/'.$file_url
        );
        echo json_encode($data_1);
        exit();
    }


}