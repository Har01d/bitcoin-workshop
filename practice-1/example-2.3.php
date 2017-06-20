<?php

require_once('connect.php');

$last = daemonQuery('getblockcount');
$last_hash = daemonQuery('getblockhash', [$last]);

// Теперь получим информацию о блоке с помощью метода getblock

$last_info = daemonQuery('getblock', [$last_hash]);

// Информация о блоке -- массив

print_r($last_info);