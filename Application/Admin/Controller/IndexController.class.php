<?php
namespace Admin\Controller;
use Admin\Controller;
class IndexController extends FontEndController {
    public function index(){
        header ( " Expires: Mon, 26 Jul 1970 05:00:00 GMT " );
        header ( " Last-Modified:" . gmdate ( " D, d M Y H:i:s " ). "GMT " );
        $this->assign("title","婚啦啦_后台管理");
        $arr=array(
            '风格'=>array('中式','西式','教堂','户外'),
            '主持形式'=>array('搞笑幽默','优雅大方','大气磅礴','综合多变'),
            '专业'=>array('播音专业','电台主持','其它')
            );
        $arr_se=  serialize($arr);
        $this->assign('arr_se',$arr_se);
        $this->display('index');
 
    }


}