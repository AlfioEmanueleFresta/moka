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
 * The template engine wrapper
 */
class TemplateEngine extends Smarty {

	public function __construct() {
		parent::__construct();
		$this->caching = 0;
		$this->setTemplateDir(".");
		$this->setCompileDir("./core/data/temp");
		$this->setConfigDir("./core/configuration");
	}

	public function setData($data) {
		$this->assign($data);
	}

	public function renderFile($file) {
		$this->display($file);
	}

}