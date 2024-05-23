<?php
setcookie('is_logged_in', false, time() - 3600, '/');
setcookie('username', '', time() - 3600, '/');
setcookie('user_id', -1, time() - 3600, '/');
setcookie('email', '', time() - 3600, '/');
setcookie('is_admin', 0, time() - 3600, '/');

header('Location: /');