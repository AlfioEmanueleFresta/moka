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
 * Represents a general view
 */
class View {

	private
		$_template = null,
		$_renderer = null;

	public 
		$data = null;

	public function __construct( $request_uri = null ) {
		$this->_template = findTemplateFile($request_uri);
		$this->data      = new stdClass;
		$this->renderer  = new TemplateEngine;
	}

	/**
	 * Detects the current interface name
	 */
	private function getInterface() {
		$uri = explode('/', $this->template);
		if ( !isset($uri[3]) )
			throw new Exception("Unknown interface error");
		if ( !is_dir("./core/controllers/{$uri[3]}") )
			throw new Exception("No {$uri[3]} interface found (no controllers directory)");
		return $uri[3];
	}

	/**
	 * Returns the current interface path, es. frontend/
	 */
	private function getInterfacePath() {
		$interface = $this->getInterface();
		if ( $interface == 'frontend' )
			return '/';
		return "{$interface}/";
	}

	/**
	 * Renders the view using the template
	 */
	public function render() {
		if ( !$this->_template )
			throw new Exception("There is no template for the page");
		$this->_renderer->data = (array) $this->data;
		$this->renderHeader();
		$this->renderTemplate();
		$this->renderFooter();
	}

	/**
	 * Render the single page
	 */
	private function renderTemplate() {
		$file 		= $this->_template;
		$this->renderFile($file);
	}

	/**
	 * Render the page header
	 */
	private function renderHeader() {
		$interface 	= $this->getInterfacePath();
		$file 		= "./core/templates/{$interface}/_header.tpl";
		if ( is_readable($file) )
			$this->renderFile($file);
	}

	/**
	 * Render the page footer
	 */
	private function renderFooter() {
		$interface 	= $this->getInterfacePath();
		$file 		= "./core/templates/{$interface}/_footer.tpl";
		if ( is_readable($file) )
			$this->renderFile($file);
	}

	/**
	 * Render the file
	 */
	private function renderFile($fileName) {
		$this->_renderer->renderFile($fileName);
	}

}