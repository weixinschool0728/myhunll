<?php
namespace Home\Model;
use Think\Model;

class  UsersModel extends Model {
    protected $fields=array(
        'user_id','email','open_id','user_name','password','zhifu_password','zhifubao', 'question', 'answer','sex','head_url', 'birthday',
        'rank_points', 'reg_time', 'last_login', 'last_ip', 'visit_count', 'user_rank', 'shopman_id', 'address','salt',
        'qq','mobile_phone','is_validated','credit_line','daijinjuan','passwd_question','passwd_answer','server_form','shenfenzheng_url','yingyezhizhao_url',
        'true_name','location','weixin','weixin_erweima','server_content','shop_introduce','shopman_reg_time',
        '_pk'=>'user_id','_autoinc'=>true
    );
}
