<?php 

function create_password($password)
{
    return password_hash($password, PASSWORD_BCRYPT);
}

/**
 * 验证用户密码是否正确
 * @password 用户密码
 * @password_has 用户加密之后的密码
 */
function validate_pasword($password,$password_hash)
{
    return password_verify($password,$password_hash);
}