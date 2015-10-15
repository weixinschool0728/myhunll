<?php
namespace Home\Controller;
use Home\Controller;
class IndexController extends FontEndController {
    public function index(){
        header ( " Expires: Mon, 26 Jul 1970 05:00:00 GMT " );
        header ( " Last-Modified:" . gmdate ( " D, d M Y H:i:s " ). "GMT " );
        $this->assign("title","婚啦啦");
        $this->display('index');
 
    }


}