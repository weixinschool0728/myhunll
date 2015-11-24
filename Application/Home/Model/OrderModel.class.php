<?php
namespace Home\Model;
use Think\Model;

class  OrderModel extends Model {
    protected $fields=array(
        'order_id','order_no','user_id','cart_id', 'goods_id','shop_id','shop_name','goods_name','server_day', 'status',
        'pay_type', 'pay_status', 'pay_info', 'trade_no', 'created', 'updated', 'deleted','price','appraise','score','_autoinc'=>true
    );
}
