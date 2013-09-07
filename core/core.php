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

/*
 * Hello, we are Moka's global objects!
 */
$db 		= null;
$cache 		= false;
$conf 		= [];
$session	= null;
$me 		= null;


/*
 * Set the application timezone
 */
date_default_timezone_set('Europe/London');

/*
 * Load every file in the directories in $_load, please!
 */
$_load = ['configuration', 'libraries'];
foreach ( $_load as $_directory ) {
	$_dir 	= "core/{$_directory}/";
	$_files = scandir($_dir);
	$_files = array_diff($_files, ['.', '..']);
	foreach ( $_files as $_file ) {
		$_file = $_dir . $_file;
		if ( is_dir($_file) ) { continue; }
		require $_file;
	}
}

/*
 * Set the class autoloader for the files...
 */
spl_autoload_register(function ($class) {
	if ( is_readable( 'core/classes/' . $class . '.php') ) {
		require 'core/classes/' . $class . '.php';
	} else {
		return false;
	}
});

/*
 * We assume any other class you name is a collection
 */
spl_autoload_register(function ($class) {
	eval("class {$class} extends Collection {}");
});

/*
 * Needed configuration, are you here?
 */
$whatsNeeded = ['database', 'emails'];
foreach ( $whatsNeeded as $needed ) {
	if ( !isset($conf[$needed]) ) {
		die("The {$needed} configuration is missing, sorry.\n");
	}
}

/*
 * You, Moka, go connect to the database! 
 */
try {
	$db = new MongoClient(
		$conf['database']['connection'],
		$conf['database']['options']
	);
	$db = $db->selectDB($conf['database']['database']);
} catch ( Exception $e ) {
	die("An error has occured while trying to connect to the Mongo database.\nError: {$e->message}\n");
}

/*
 * Connects to the cache server, if needed
 */
if ( isset($conf['memcached']) ) {
	try {
		$cache = new Memcached();
		// Add the configured servers...
		foreach ( $conf['memcached']['servers'] as $_cacheServer ) {
			$cache->addServer(
				$_cacheServer['host'],
				$_cacheServer['port']
			);
		}
	} catch ( Exception $e ) {
		die("Error connecting to the cache server: {$e->message}\n");
	}
}
