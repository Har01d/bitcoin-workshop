<?php

// Этот файл содежит две функции для того, чтобы мы могли подключиться к нашей ноде.
// Используется во всех примерах.

// Настройки, указанные в bitcoin.conf
const DAEMON_PROTOCOL       = 'http';
const DAEMON_LOGIN          = 'user';
const DAEMON_PASSWORD       = 'password';
const DAEMON_HOST           = '127.0.0.1'; // Если нода на удалённом хосте, надо указать его IP
const DAEMON_PORT           = '8332';

// Инициализация Curl
function daemonCurlInit()
{
	static $curl = null;

	if (is_null($curl))
	{
		$curl = curl_init();
	}

	return $curl;
}

// Запрос к ноде. В качестве параметров функция принимает метод (функцию) и массив параметров, которые будут переданы ноде
function daemonQuery($method, $params = [])
{
	$curl         = daemonCurlInit();
	$curl_address = DAEMON_PROTOCOL . '://' . DAEMON_LOGIN . ':' . DAEMON_PASSWORD . '@' . DAEMON_HOST . ':' . DAEMON_PORT . '/';

	// Это всё стандартная работа с Curl
	static $id = 0;
	$request = json_encode(array('method' => $method, 'params' => $params, 'id' => $id));
	$options = array(CURLOPT_URL        => $curl_address, CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => true, CURLOPT_MAXREDIRS => 10,
					 CURLOPT_HTTPHEADER => array('Content-type: application/json'), CURLOPT_POST => true, CURLOPT_POSTFIELDS => $request);

	curl_setopt_array($curl, $options);

	// В $response будет ответ сервера
	$response = json_decode(curl_exec($curl), true);

	$id++;

	if (!$response)
	{
		die('Whoops!');
	}

	// В $response['result'] непосредственная нужная нам информация
	return $response['result'];
}