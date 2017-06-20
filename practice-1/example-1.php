<?php

// Для начала попробуем получить список всех возможных методов. Это делается с помощью метода help

require_once('connect.php');

echo daemonQuery('help');