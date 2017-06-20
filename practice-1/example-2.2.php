<?php

require_once('connect.php');

$last = daemonQuery('getblockcount');

// Номер (т.н. "высоту") последнего блока мы получили.
// Но как нам получить информацию о нём? У нас есть метод
// getblock "hash"
// но он в качестве параметра принимает хеш блока, а не его высоту.
// Но на помощь приходит метод
// getblockhash index
// который по высоте даёт хеш.

$last_hash = daemonQuery('getblockhash', [$last]);

echo $last_hash;