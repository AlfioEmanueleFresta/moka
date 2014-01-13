<?php

/*
 *
 * This is MOKA, a simple and modern PHP framework
 * Copyright 2014, the authors:
 * - Alfio Emanuele Fresta 	<alfio.emanuele.f@gmail.com>
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

/**
 * Given a REQUEST_URI, returns an array of possible file names (with no prefix/suffix)
 * 
 * Es.  1: /this/page/test
 * Ris. 1: ['this/page/test', 'this/page/test/_main']
 * Es.  2: /this/page/test/ok
 * Ris. 2: ['this/page/test/ok', 'this/page/test/ok/_main', 'this/page/test_ok']
 *
 * @param 	string 	$request_uri 	Optional. The request URI to analyse. Default is from server.
 * @return  array 	$pages 			An array of possible pages in order of chance. No suffix nor prefix.
 */
function requestMaps( $request_uri = null ) {
	if ( !$request_uri )
		$request_uri = $_SERVER['REQUEST_URI'];
	$page = lowerCase($request_uri);
	$page = explode('/', $page);
	$page = array_diff($page, ['']);
	$page = implode('/', $page);
	if ( !$page ) { $page = 'public/default'; }
	$result = [
		$page,
		"{$page}/_main"
	];
	if ( substr($page, -3) == '/ok' ) )
		$result[] = substr($page, 0, -3);
	return $result;
}

/**
 * Finds controller file for a request or return false
 *
 * @param 	string  			$request_uri 	Optional. The request URI. Default to server.
 * @return 	string|bool(false)					The file path or false on failure.
 */
function findControllerFile( $request_uri = null ) {
	$possible = requestMaps($request_uri);
	foreach ( $possible as $try ) {
		$file = "./core/controllers/{$try}.php";
		if ( is_readable($file) )
			return $file;
		$file = "./core/controllers/frontend/{$try}.php";
		if ( is_readable($file) )
			return $file;
	}
	return false;
} 

/**
 * Finds controller name for a request or return false
 *
 * @param 	string  			$request_uri 	Optional. The request URI. Default to server.
 * @return 	string|bool(false)					The file path or false on failure.
 */
function findControllerFile( $request_uri = null ) {
	$possible = requestMaps($request_uri);
	foreach ( $possible as $try ) {
		$file = "./core/controllers/{$try}.php";
		if ( is_readable($file) )
			return $file;
		$file = "./core/controllers/frontend/{$try}.php";
		if ( is_readable($file) )
			return $file;
	}
	return false;
} 

/**
 * Finds template file for a request or return false
 *
 * @param 	string  			$request_uri 	Optional. The request URI. Default to server.
 * @return 	string|bool(false)					The file path or false on failure.
 */
function findTemplateFile( $request_uri = null ) {
	$possible = requestMaps($request_uri);
	foreach ( $possible as $try ) {
		$file = "./core/templates/{$try}.php";
		if ( is_readable($file) )
			return $file;
		$file = "./core/templates/frontend/{$try}.php";
		if ( is_readable($file) )
			return $file;
	}
	return false;
} 

