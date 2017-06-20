<?php

require_once('connect.php');

$last = daemonQuery('getblockcount');
$last_hash = daemonQuery('getblockhash', [$last]);
$last_info = daemonQuery('getblock', [$last_hash]);

// Как мы можем заметить, в ответе мы получили массив из идентификаторов транзакций, включённых в блок.
// Очевидно, что чтобы посчитать количество транзакций в блоке, достаточно посчитать количество элементов в этом массиве

echo count($last_info['tx']);