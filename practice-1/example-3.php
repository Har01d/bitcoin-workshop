<?php

// Третья задача -- поиск nulldata-выходов, которые содержат в себе что-то интересное.
// Анализируем 3 последних блока на предмет наличия nulldata-выходов, если есть -- выводим их.
// По сути мы создаём полный аналог сервиса http://coinsecrets.org

require_once('connect.php');

$last = daemonQuery('getblockcount');

$tx_count = 0;

for ($i = $last; $i > $last - 3; $i--) // Это мы уже делали в прошлый раз
{
	$hash = daemonQuery('getblockhash', [$i]);
	$info = daemonQuery('getblock', [$hash]);

	foreach ($info['tx'] as $txid) // Теперь мы итерируем массив транзакций
	{
		// Используем метод getrawtransaction для получения информации о транзакции
		// "1" в параметрах означает, что мы хотим распарсить транзакцию в массив
		$tx = daemonQuery('getrawtransaction', [$txid, 1]);

		// $tx['vout'] содержит массив выходов, так что нам надо проитерировать его
		foreach ($tx['vout'] as $output)
		{
			// Если тип выхода -- nulldata
			if ($output['scriptPubKey']['type'] == 'nulldata')
			{
				// Скрипт хранится в hex, поэтому конвертируем его в двоичный формат, если будут символы
				// из ASCII, они отобразятся.
				echo hex2bin($output['scriptPubKey']['hex']) . PHP_EOL;
			}
		}
	}
}