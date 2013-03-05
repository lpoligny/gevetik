<?php

class Auteur extends AppModel{
	
	public $name = 'Auteur';
	
	public $useTable = 'auteur';
	
	/**
	 * Définition des liens entre les modèles
	 * http://book.cakephp.org/2.0/en/models/associations-linking-models-together.html
	 */
	public $hasOne = array(
				'Paiement' => array(
								'className' => 'Paiement',
								),
				);
	
	public $hasAndBelongsToMany = array(
				'Article' => array(
								'className' => 'Article',
								'joinTable' => 'Page_payee',
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
				'prenom_auteur' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier le prénom de l'auteur.",
											),
								'char' => array(
											'rule' => array('char'),
											'message' => "Le prénom de l'auteur ne peut contenir que des caractères.",
											),
								),
				'nom_auteur' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier le nom de l'auteur.",
											),
								'char' => array(
											'rule' => array('char'),
											'message' => "Le nom de l'auteur ne peut contenir que des caractères.",
											),
								),
				'email_auteur' => array(
								'email' => array(
											'rule' => array('email'),
											'message' => "L'email de l'auteur est invalide.",
											),
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier le email pour cet auteur.",
											),
								'unique' => array(
											'rule' => array('isUnique'),
											'message' => "Il existe déjà un auteur avec cet email.",
											),
								),
				);
	
	
	public function beforeSave(){
		$date_creation = new Date($this->data['Evenement']['date_creation']);
		$date_evenement = new Date($this->data['Evenement']['date_evenement']);
		
		
		if($date_evenement<=$date_creation)
			return false;
		
		return true;
	}
	
	/**
	 * méthode de vérification : Elle vérifie si check est composé de caractères (caractères accentués compris).
	 * /!\ Cettte méthode est une copie du modèle Organisateur.
	 */
	public function char($check){
		//return preg_match('#^[^\d[:space:][:punct:]_-]*$#', $check); tester si alpha prends les caractères accentués.
		return preg_match('#^[[:alpha:]]*$#', $check);
	}
}

?>