<?php

class Evenement extends AppModel{
	
	public $name = 'Evenement';
	
	public $useTable = 'evenement';
	
	public $primaryKey = 'evenement_id';
	
	/**
	 * Définition des liens entre les modèles
	 * http://book.cakephp.org/2.0/en/models/associations-linking-models-together.html
	 */
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
				'Organisateur' => array(
								'className' => 'Organisateur',
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
								'logic_date' => array(
											'rule' => array('validPlanning', 'today'),
											'message' => "Votre date limite de remise ne peut se situer avant aujourd'hui.",
											),
								'logic_calendar' => array(
											'rule' => array('validPlanning'),
											'message' => "Votre date limite de remise ne peut se situer après la date de début de l'évenement.",
											),
								),
				'date_debut' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier une date de début d'évènement.",
											),
								'date' => array(
											'rule' => array('date'),
											'message' => "Vous devez spécifier une date valide pour cette évènement.",
											),
								'logic_date' => array(
											'rule' => array('validPlanning', 'today'),
											'message' => "Votre date de début d'évènement ne peut se situer avant aujourd'hui.",
											),
								),
				'date_fin' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier une date de fin d'évènement.",
											),
								'date' => array(
											'rule' => array('date'),
											'message' => "Vous devez spécifier une date valide pour cette évènement.",
											),
								'logic_calendar' => array(
											'rule' => array('validInterval'),
											'message' => "Votre date de fin d'évènement peut se situer avant la date de début de l'évenement.",
											),
								),
				'date_soumission_debut' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier une date.",
											),
								'date' => array(
											'rule' => array('date'),
											'message' => "Vous devez spécifier une date valide.",
											),
								'logic_date' => array(
											'rule' => array('validPlanning', 'today'),
											'message' => "Votre date ne peut se situer avant aujourd'hui.",
											),
								'logic_calendar' => array(
											'rule' => array('validPlanning'),
											'message' => "Votre date ne peut se situer après la date de début de l'évenement.",
											),
								),
				'date_soumission_fin' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier une date.",
											),
								'date' => array(
											'rule' => array('date'),
											'message' => "Vous devez spécifier une date valide.",
											),
								'logic_calendar' => array(
											'rule' => array('validSoumission'),
											'message' => "Votre date ne peut se situer après la date de début de l'évenement.",
											),
								),
				'date_acceptation' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier une date.",
											),
								'date' => array(
											'rule' => array('date'),
											'message' => "Vous devez spécifier une date valide.",
											),
								'logic_calendar' => array(
											'rule' => array('validPlanning'),
											'message' => "Votre date ne peut se situer après la date de début de l'évenement.",
											),
								),
				'date_acceptation_definitive' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier une date.",
											),
								'date' => array(
											'rule' => array('date'),
											'message' => "Vous devez spécifier une date valide.",
											),
								'logic_calendar' => array(
											'rule' => array('validAcceptation'),
											'message' => "Votre date ne peut se situer après la date de début de l'évenement.",
											),
								),
				);
	
	/*
	 *Méthodes de validation
	 */
	public function validPlanning($check_date, $date_start = ''){
		$date_debut_evenement = new DateTime($this->data['Evenement']['date_debut']);
		if(is_array($check_date))
			$check_date = current($check_date);
		$check_date = new DateTime($check_date);
		
		if(!empty($date_start) && !is_array($date_start)):
			$date_start = new DateTime($date_start);
			return ($date_start <= $check_date);
		endif;
		
		return ($check_date <= $date_debut_evenement);
	}
	
	public function validInterval($check_date){
		$date_debut_evenement = new DateTime($this->data['Evenement']['date_debut']);
		if(is_array($check_date))
			$check_date = current($check_date);
		$check_date = new DateTime($check_date);
		
		return ($date_debut_evenement <= $check_date);
	}
	
	public function validSoumission($check_date){
		$date_soumission_debut = new DateTime($this->data['Evenement']['date_soumission_debut']);
		if(is_array($check_date))
			$check_date = current($check_date);
		$check_date = new DateTime($check_date);
		
		return ($date_soumission_debut <= $check_date);
	}

	public function validAcceptation($check_date){
		$date_soumission_debut = new DateTime($this->data['Evenement']['date_acceptation_definitive']);
		if(is_array($check_date))
			$check_date = current($check_date);
		$check_date = new DateTime($check_date);
		
		return ($date_soumission_debut <= $check_date);
	}

	
	/*
	 *Méthode du modèle
	 */
	public function creerEvenement($nom_evenement, $organisateur_id, $date_debut){
		$data = array(
			'nom_evenement' => $nom_evenement,
			'date_debut' => $date_debut,
			'date_fin' => $date_debut,
			'date_soumission_debut' => $date_debut,
			'date_soumission_fin' => $date_debut,
			'date_acceptation' => $date_debut,
			'date_acceptation_definitive' => $date_debut,
			'date_remise' => $date_debut,
			);
		$this->create();
		if(!$this->save($data))
			return false;
		
		$evenement_id = $this->getInsertID();
		
		$data = array(
				'participant_id' => $organisateur_id,
				'evenement_id' => $evenement_id,
				'est_organisateur' => 1,
				);
		//création de l'organisateur	
		$this->Organisateur->create();
		if(!$this->Organisateur->save($data)){
			$this->delete($evenement_id);
			return false;
		}
			
		//création de la catégorie Normal
		$data = array(
				'evenement_id' => $evenement_id,
				'nom_categorie' => 'Normal',
				);
		$this->Categorie->create();
		if(!$this->Categorie->save($data)){
			$this->delete($evenement_id);
			return false;
		}
		
		//création de l'option Entrée
		App::uses('Option', 'Model');
		$this->Option = new Option();
		
		$data = array(
				'categorie_id' => $this->Categorie->getInsertID(),
				'nom_option' => 'Entrée',
				);
		$this->Option->create();
		if(!$this->Option->save($data)){
			$this->delete($evenement_id);
			return false;
		}
		
		return true;
	}
}

?>