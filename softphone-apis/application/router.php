<?php

$router = Dispatcher::$router;
$router->setSuffix('');

//Default router. Ex: blog/list/page/1
$router->addRoute('([^/]+)?/?([^/]+)?/?(.*)',
		array(),
		array(1 => '{controller}', 2 => '{action}', 3 => '{params}')
);
