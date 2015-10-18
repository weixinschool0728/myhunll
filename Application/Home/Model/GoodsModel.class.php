<?php
namespace Home\Model;
use Think\Model;

class  GoodsModel extends Model {
    protected $fields=array(
        'goods_id','cat_id','area','user_id', 'goods_name', 'click_count','goods_number','yuan_price', 'price',
        'promote_price', 'promote_start_date', 'promote_end_date', 'warn_number', 'keywords', 'goods_desc', 'goods_img','goods_img_qita', 'comment_number','shuxing',
        'add_time','sort_order','is_delete','is_best','is_new','is_hot','last_update',
        '_pk'=>'goods_id','_autoinc'=>true
    );
}
