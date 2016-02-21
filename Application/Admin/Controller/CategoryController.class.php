<?php
namespace Admin\Controller;
use Admin\Controller;
class CategoryController extends FontEndController {
   
    public function manger(){
        $categorymodel=D('Category');
        $data=$categorymodel->field('cat_name')->select();
        $this->assign('data',$data);
        //获取服务类型表单提交值
        if(!empty($_POST['server_content'])){
        //if(!empty($_POST['sc_hidden'])&&$_POST['sc_hidden']==="server_content"){
            $server_content=$_POST['server_content'];
            $this->assign($server_content,'selected="selected"');
            $this->assign('server_content',$server_content);
        }else{
            $server_content=$data[0]['cat_name'];
            $this->assign('server_content',$server_content);
        }
        
        $data_cat=$categorymodel->where("cat_name='$server_content'")->getField('shuxing');
        $arr_shuxing=unserialize($data_cat);//得到反序列化属性数组
        $this->assign("arr_shuxing",$arr_shuxing);//给模板里面的$arr_shuxing赋值
        $this->display();
    }
    
    public function check(){
        var_dump($_POST);
    }

    
    
    


}