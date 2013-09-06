<?php

class Persona extends BindableCollection {

	public function onPreDelete() {
		echo "Sto per cancellare {$this->_objectId}...\n";
	}

	public  function onPostDelete() {
		echo "Ho cancellato!\n";
	}



}