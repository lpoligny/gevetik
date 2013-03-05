<?php

class Organisateur extends AppModel{
	
	public $name = 'Organisateur';
	
	public $useTable = 'organisateur';
	
	/**
	 * Définition des liens entre les modèles
	 * http://book.cakephp.org/2.0/en/models/associations-linking-models-together.html
	 */
	public $hasMany = array(
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
				'prenom_organisateur' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier le prénom pour cet organisateur.",
											),
								'char' => array(
											'rule' => array('char'),
											'message' => "Le prénom de l'organisateur ne peut contenir que des caractères.",
											),
								),
				'nom_organisateur' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier le nom pour cet organisateur.",
											),
								'char' => array(
											'rule' => array('char'),
											'message' => "Le nom de l'organisateur ne peut contenir que des caractères.",
											),
								),
				'email_organisateur' => array(
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
											'message' => "Il existe déjà un organisateur avec cet email.",
											),
								),
				);
	
	/**
	 * méthode de vérification : Elle vérifie si check est composé de caractères (caractères accentués compris).
	 * /!\ Cette méthode a été copié dans le modèle Auteur, Participant.
	 */
	public function char($check){
		//return preg_match('#^[^\d[:space:][:punct:]_-]*$#', $check); tester si alpha prends les caractères accentués.
		return preg_match('#^[[:alpha:]]*$#', $check);
	}
}
?>