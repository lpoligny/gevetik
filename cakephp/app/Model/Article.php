<?php

class Article extends AppModel{
	
	public $name = 'Article';
	
	public $useTable = 'article';
	
	public $primaryKey = 'article_id';
	
	/**
	 * Définition des liens entre les modèles
	 * http://book.cakephp.org/2.0/en/models/associations-linking-models-together.html
	 */
	public $belongsTo = array(
				'Evenement' => array(
								'className' => 'Evenement',
								),
				);

	public $hasMany = array(
				'Page_payee' => array(
								'className' => 'Page_payee',
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
				'titre' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier un titre pour cet article.",
											),
								),
				'nombre_page' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier le nombre de page.",
											),
								'numeric' => array(
											'rule' => array('naturalNumber', false),
											'message' => "Le nombre de page doit être un nombre entier.",
											),
								),
				'extra_page' => array(
								'numeric' => array(
											'rule' => array('naturalNumber', true),
											'message' => "Le nombre de page supplémentaire doit être un nombre entier.",
											'allowEmpty' => true
											),
								),
				);
	
}

?>