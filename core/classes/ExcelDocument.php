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

class ExcelDocument extends GeneratedFile {

	protected
		$_header = [], $_rows = [];

	public function header($headerArray = []) {
		if ( is_array($headerArray) ) {
			$this->_header = $headerArray;
		} else {
			throw new Exception('Excel header must be an array.');
		}
	}

	public function addRow($rowArray = []) {
		$this->_rows[] = $rowArray;
	}

	public function save() {
		$s .= '';
		$s .= "<table><thead>";
		foreach ( $this->_header as $header ) {
			$s .= "<th><strong>{$header}</strong></th>";
		}
		$s .= "</thead><tbody>";
		foreach ( $this->_rows as $row ) {
			$s .= "<tr>";
			foreach ( $row as $field ) {
				$s .= "<td>{$field}</td>";
			}
			$s .= "</tr>";
		}
		$s .= "</tbody></table>";
		file_put_contents($this->path, $s);
		$this->analyse();
		$this->mime = 'application/vnd.ms-excel; charset=utf-8';
	}

}