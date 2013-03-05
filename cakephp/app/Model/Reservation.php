<?php

class Reservation extends AppModel{
	
	public $name = 'Reservation';
	
	public $useTable = 'rservation';
	
	/**
	 * Définition des liens entre les modèles
	 * http://book.cakephp.org/2.0/en/models/associations-linking-models-together.html
	 */
	public $hasOne = array(
				'Paiement' => array(
								'className' => 'Paiement',
								),
				'Participant' => array(
								'className' => 'Participant',
								),
				'Evenement' => array(
								'className' => 'Evenement',
								),
				);
	
	/**
	 * Définition du comportement du modèle
	 * http://book.cakephp.org/2.0/en/models/behaviors.html
	 */
	//public $actAs;
	
}

?>