<?php
//从库
$db['default'] = array(
    'db' => 'sdk_data',
    'server' => array('host' => '192.168.10.10', 'user' => 'homestead', 'password' => 'secret'),
);

//主库
$db['main'] = array(
    'db' => 'sdk_data',
    'server' => array('host' => '192.168.10.10', 'user' => 'homestead', 'password' => 'secret'),
);

$db['user_log'] = array(
    'db' => 'sdk_user_log',
    'server' => array('host' => 'mysql.db2.hutao.net', 'user' => 'hutao_sdk', 'password' => '123456'),
);

$db['log'] = array(
    'db' => 'sdk_log',
    'server' => array('host' => 'mysql.db2.hutao.net', 'user' => 'hutao_sdk', 'password' => '123456'),
);

$db['log_warehouse'] = array(
    'db' => 'sdk_warehouse_{index}',
    'server' => array('host' => 'mysql.db2.hutao.net', 'user' => 'hutao_sdk', 'password' => '123456'),
);

return $db;
