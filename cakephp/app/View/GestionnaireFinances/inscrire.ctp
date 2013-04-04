<?php

	// Jonathan


	echo $this -> Form -> create('GestionnaireFinances');

	echo $this -> Form -> input('login', array('label' => "Login :"));

	echo $this -> Form -> input('password', array('label' => "Mot de passe :"));

	echo $this -> Form -> end('Valider');
?>
