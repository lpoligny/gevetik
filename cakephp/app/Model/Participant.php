<?php

class Participant extends AppModel{
	
	public $name = 'Participant';
	
	public $useTable = 'participant';
	
	public $primaryKey = 'participant_id';
	
	/**
	 * Définition des liens entre les modèles
	 * http://book.cakephp.org/2.0/en/models/associations-linking-models-together.html
	 */
	public $hasMany = array(
				'Reservation' => array(
								'className' => 'Reservation',
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
	
	
	/**
	 * Définition des règles de validation du modèle
	 * http://book.cakephp.org/2.0/en/models/data-validation.html
	 */
	public $validate = array(
				'prenom_participant' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier le prénom pour ce participant.",
											),
								'char' => array(
											'rule' => array('char'),
											'message' => "Le prénom du participant ne peut contenir que des caractères.",
											),
								),
				'nom_participant' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier le nom du participant.",
											),
								'char' => array(
											'rule' => array('char'),
											'message' => "Le nom du participant ne peut contenir que des caractères.",
											),
								),
				'email_participant' => array(
								'email' => array(
											'rule' => array('email'),
											'message' => "L'email de l'organisateur est invalide.",
											),
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier le email pour cet organisateur.",
											),
								'unique' => array(
											'rule' => array('isUnique'),
											'message' => "Il existe déjà un participant avec cet email.",
											),
								),
				);
	
	/**
	 * méthode de vérification : Elle vérifie si check est composé de caractères (caractères accentués compris).
	 * /!\ Cette méthode est une copie du modèle Organisateur.
	 */
	public function char($check){
		//return preg_match('#^[^\d[:space:][:punct:]_-]*$#', $check); tester si alpha prends les caractères accentués.
		return preg_match('#^[[:alpha:]]*$#', $check);
	}
}

?>