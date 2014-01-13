<?php

/*
 *
 * This is MOKA, a simple and modern PHP framework
 * Copyright 2013, the authors:
 * - Alfio Emanuele Fresta 	<alfio.emanuele.f@gmail.com>
 * - Angelo Lupo			<angelolupo94@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

require 'core/core.php';

/*
 * Set caching on...
 */
ob_start('ob_gzhandler');
ob_start('_template_replace');

/* 
 * Routing logic
 */
$pages 				= requestMaps();
$controllerFile		= findControllerFile();
$controllerName		= findControllerName();
$viewForce 			= null;
$interface      = guessCurrentInterfaceName();
if ( !$controller ) {
	// 404
	$controllerFile = "./core/classes/Controller404.php";
	$controllerName = "Controller404";
	$viewForce 		= "./core/templates/{$interface}/_404.php";
}

echo "{$controllerFile}, {$controllerName}.";

require $controllerFile;
$controller = new $controllerName;
$controller->assignSession(@$_COOKIE['sid']);
$controller->interface = $interface;
$controller->view = new View;
$controller->respond();

emptyPayload();

/*
 * Finally, go flush everything out
 */
ob_end_flush(); 
header("Content-length: {ob_get_length()}"); 
ob_end_flush();
