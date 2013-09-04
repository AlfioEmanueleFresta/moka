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



/**
 * Makes the string uppercase and eventually trims it
 */
function upperCase( $input, $trimmed = true ) {
	if ( $trimmed ) {
		$input = trim($input);
	}
	return strtoupper($input);
}

/**
 * Makes the string lowercase and eventually trims it
 */
function lowerCase( $input, $trimmed = true ) {
	if ( $trimmed ) {
		$input = trim($input);
	}
	return strtolower($input);
}

/**
 * Makes the string a name
 */
function makeName( $input, $trimmed = true ) {
	$input = lowerCase($input, $trimmed);
	return ucwords($input);
}

/**
 * Makes the string a title
 */
function makeTitle( $input, $trimmed = true ) {
	$input = lowerCase($input, $trimmed);
	return ucfirst($input);
}

