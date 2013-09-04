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