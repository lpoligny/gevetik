<?php

class Paiement extends AppModel{
	
	public $name = 'Paiement';
	
	public $useTable = 'paiement';
	
	public $primaryKey = 'paiement_id';
	
	/**
	 * Définition des liens entre les modèles
	 * http://book.cakephp.org/2.0/en/models/associations-linking-models-together.html
	 */
	public $belongsTo = array(
				'Page_payee' => array(
								'className' => 'Page_payee',
								'foreignKey' => 'page_payee_id',
								),
				'Reservation' => array(
								'className' => 'Reservation',
								'foreignKey' => 'reservation_id',
								),
				);
	
	public $hasMany = array(
				'Option_paiement' => array(
								'className' => 'Option_paiement',
								)
				);
		
	/**
	 * Définition du comportement du modèle
	 * http://book.cakephp.org/2.0/en/models/behaviors.html
	 */
	//public $actAs;
	
	
	/**
	 * Définition des règles de validation du modèle
	 * http://book.cakephp.org/2.0/en/models/data-validation.html
	 */
	public $validate = array(
				'total' => array(
								'value' => array(
											'rule' => array('numeric'),
											'message' => 'Le total doit être un nombre.',
											'allowEmpty' => true,
											),
								)
				);
				
	public function getTypesPaiement(){
		return array(
				'cb' => 'CB',
				'cheque' => 'Chèque',
				);
	}
}

?>
