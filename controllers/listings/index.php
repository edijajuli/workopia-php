<?php

$config = require basePath('config/db.php');
$db = new Database($config);

$listngs = $db->query('SELECT * FROM listings LIMIT 6')->fetchAll();

loadView('listings/index', [
    'listings' => $listngs
]);
