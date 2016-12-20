<?php 

return [
    'extra_file_list'        => [ APP_PATH . 'helper'.EXT, THINK_PATH . 'helper'.EXT],
    'auth' => [
        'is_auth' => true,
        'auth_group' => 'auth_group',
        'auth_access' => 'auth_access',
        'auth_user' => 'managers',
        'auth_rules' => 'auth_rules',
        'supper_admin'=> 24,
    ]
];