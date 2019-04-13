<?php 
// $testing = shell_exec("cd ../ && ls -la");
$update = shell_exec("cd ../ && php artisan siranap:update 2>&1");
// echo "<pre>$testing</pre>";
echo "<pre>$update</pre>";