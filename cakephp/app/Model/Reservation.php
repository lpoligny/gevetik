<?php

class Reservation extends AppModel{
	
	public $name = 'Reservation';
	
	public $useTable = 'reservation';
	
	public $primaryKey = 'reservation_id';
	
	/**
	 * Définition des liens entre les modèles
	 * http://book.cakephp.org/2.0/en/models/associations-linking-models-together.html
	 */

	
	public $belongsTo = array('Evenement','Participant','Paiement');
	
	/**
	 * Définition du comportement du modèle
	 * http://book.cakephp.org/2.0/en/models/behaviors.html
	 */
	//public $actAs;
	
}

?>
