<?php

class Evenement extends AppModel{
	
	public $name = 'Evenement';
	
	public $useTable = 'evenement';
	
	public $primaryKey = 'evenement_id';
	
	/**
	 * Définition des liens entre les modèles
	 * http://book.cakephp.org/2.0/en/models/associations-linking-models-together.html
	 */
	public $hasOne = array(
				'Organisateur' => array(
								'className' => 'Participant',
								),
				);
	
	public $hasMany = array(
				'Categorie' => array(
								'className' => 'Categorie',
								),
				'Article' => array(
								'className' => 'Article',
								),
				'Reservation' => array(
								'className' => 'Reservation',
								),
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
				'nom_evenement' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier un nom pour cet évènement.",
											),
								),
				'remise' => array(
								'value' => array(
											'rule' => array('numeric'),
											'message' => 'La remise doit être un nombre.',
											'allowEmpty' => true,
											),
								),
				'date_remise' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier une date limite pour la remise.",
											),
								'date' => array(
											'rule' => array('date'),
											'message' => "Vous devez spécifier une date limite valide pour avoir droit à la remise.",
											),
								),
				'date_debut_evenement' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier une date de début d'évènement.",
											),
								'date' => array(
											'rule' => array('date'),
											'message' => "Vous devez spécifier une date valide pour cette évènement.",
											),
								),
				'date_fin_evenement' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier une date de fin d'évènement.",
											),
								'date' => array(
											'rule' => array('date'),
											'message' => "Vous devez spécifier une date valide pour cette évènement.",
											),
								),
				);
	
	
	public function beforeSave(){
		$date_remise = new Date($this->data['Evenement']['date_remise']);
		$date_debut_evenement = new Date($this->data['Evenement']['date_debut_evenement']);
		$date_fin_evenement = new Date($this->data['Evenement']['date_fin_evenement']);
		
		
		if($date_fin_evenement<=$date_debut_evenement || $date_fin_evenement<=$date_remise)
			return false;
		
		return true;
	}
}

?>