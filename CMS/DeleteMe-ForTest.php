<?php
$password = 123;
echo $hashed_pass = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));

echo '<br>';

echo password_verify($password,$hashed_pass);