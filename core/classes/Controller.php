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
 * The standard controller 
 */
abstract class Controller  {

	public
		$view 		= null,
		$session  	= null,
		$interface  = null;

	/** OVERRIDABLE **/
	public
		$_required 		= [], // Array of parameters to check not to be empty
		$_end;

	public function __construct() {

	}

	public function assignSession($sid = null) {
		if ( $this->sid ) {
			$session = new Session($sid);
		} else {
			$session = new Session();
		}
		setcookie('sid', (string) $session);
		$this->session = $session;
	}

	/**
	 * The core of the page code
	 */
	public abstract function run() {}

	public function getParam($name) {
		if ( isset($_POST[$name]) ) {
			return $_POST[$name];
		} elseif ( isset($_GET[$name]) ) {
			return $_GET[$name];
		} else {
			return false;
		}
	}

	protected function checkNotEmpty() {
		foreach ( $this->_required as $param ) {
			if ( $this->getParam($param) === false ) {
				$this->goBack('missing_param', ['param' => $param]);
				return false;
			}
		}
	}

	/**
	 * Executes the controller
	 */
	public function respond() {
		$this->checkNotEmpty();
		$this->run();
		$this->view->render();
	}

	/**
	 ** HTTP STUFF
	 **/

	protected function setHeader($name, $value, $exit = false) {
		header("{$name}: {$value}");
		if ( $exit )
			exit(0);
	}

	protected function redirect($where) {
		$where = stripSlash($where);
		$where = "{$this->interface}/{$where}";
		$this->setHeader("Location", $where);
	}

}