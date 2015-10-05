<?php
namespace Home\Model;
use Think\Model;

class  UserModel extends Model {
    protected $fields=array(
        'user_id','email','open_id','user_name','password', 'question', 'answer','sex','head_url', 'birthday',
        'rank_points', 'reg_time', 'last_login', 'last_ip', 'visit_count', 'user_rank', 'shopman_id', 'address','ec_salt','salt',
        'parent_id','flag','alias','qq','mobile_phone','is_validated','credit_line','passwd_question','passwd_answer',
        '_pk'=>'id','_autoinc'=>true
    );
}
