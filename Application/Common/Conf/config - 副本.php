<?php
return array(
	//'配置项'=>'配置值'
    'DEFAULT_CONTROLLER'    =>  'Index', // 默认控制器名称
    'DEFAULT_ACTION'        =>  'index', // 默认操作名称
    'APP_GROUP_LIST'        => 'Home,Admin',      // 项目分组设定,多个组之间用逗号分隔,例如'Home,Admin'
    'DEFAULT_GROUP'         => 'Home',  // 默认分组
     'URL_MODEL'            =>  2,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
    // 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式
    'TMPL_L_DELIM'=>'<{',//模板左分隔符
    'TMPL_R_DELIM'=>'}>',//模板右分隔符
    'URL_CASE_INSENSITIVE'  => true,  // 默认false 表示URL区分大小写 true则表示不区分大小写
    'DEFAULT_THEME'         =>  'Default',	// 默认模板主题名称
     'URL_HTML_SUFFIX'       =>  'html',  // URL伪静态后缀设置
    'TMPL_PARSE_STRING'     =>array(
        '__PUBLIC_HOME__'   =>'/Public/Home',
        '__PUBLIC_ADMIN__'   =>'/Public/Admin',
        '__PUBLIC_COMMON__'   =>'/Public/Common'
    ),
    'LAYOUT_ON'             =>  true, // 是否启用布局
    'LAYOUT_NAME'           =>  'layout', // 当前布局名称 默认为layout
     /* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'location', // 服务器地址
    'DB_NAME'               =>  'model_init',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'asd123321',          // 密码
    'DB_PORT'               =>  '',        // 端口
    'DB_PREFIX'             =>  'm_',    // 数据库表前缀
    'DB_PARAMS'          	=>  array(), // 数据库连接参数    
    'DB_DEBUG'  			=>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
    'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
    'DB_CHARSET'            =>  'utf8'      // 数据库编码默认采用utf8
);