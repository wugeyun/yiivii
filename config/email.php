<?php
//系统Email配置文件
return [
    'Username' => Env::get('email.username', 'abc@qq.com'),
    'Password' => Env::get('email.password', '123456'),
];