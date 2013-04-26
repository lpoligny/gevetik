<?php

class Categorie extends AppModel{
	
	public $name = 'Categorie';
	
	public $useTable = 'categorie';
	
	public $primaryKey = 'categorie_id';
	
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
				'Option' => array(
								'className' => 'Option',
								),
				);
				
	/**
	 * Définition du comportement du modèle
	 * http://book.cakephp.org/2.0/en/models/behaviors.html
	 */
	//public $actAs;
	
	
	/**
	 // * Définition des règles de validation du modèle
	 * http://book.cakephp.org/2.0/en/models/data-validation.html
	 */
	public $validate = array(
				'nom_categorie' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier un nom pour cette catégorie.",
											),	
								
								'unique' => array(
											'rule' => array('slugify'),
											'message' => 'Cette catégorie existe déjà.',
											),
								),
				);
	
	/**
	 * Vérifie si une catégorie est unique, pour un évènement, en générant un identifiant à partir de son nom.
	 */
	public function slugify($check){
		//replacement basique
		$replace = array('ê', 'é', 'è', 'à', 'ç');
		$by = array('e', 'e', 'e', 'a', 'c');
		$slug = str_replace($replace, $by, $check['nom_categorie']);
		
		//remplacement par regex
		$pattern =  array('/@/', '#[/\s&\\\\]#', '/[^-_\d\w]/');
		$replace = array('_at_', '_', '');
		$slug = strtolower(preg_replace($pattern, $replace, $slug));
		
		if($this->find('count', array('conditions' => array(
														'Categorie.evenement_id' => $this->data['Categorie']['evenement_id'],
														'slug_categorie' => $slug,
														))
						)>0)
			return false;
		
		$this->data['Categorie']['slug_categorie'] = $slug;
		return true;
	}
	
	
	public function creerCategorie($evenement_id, $nom_categorie){
		
		
		$data = array(
				'evenement_id' => $evenement_id,
				'nom_categorie' => $nom_categorie,
				);
		$this->create();
		if(!$this->save($data))
			return false;
		
		$categorie_id = $this->getInsertID();
		
		//création des options
		$categorie = $this->find('first', array('conditions' => array('Categorie.evenement_id' => 2, 'categorie_id !=' => $categorie_id)));
		
		if(!empty($categorie)){
			foreach($categorie['Option'] as $option):
				$data = array(
						'categorie_id' => $categorie_id,
						'nom_option' => $option['nom_option'],
						'prix_unitaire' => $option['prix_unitaire'],
						'quantite_minimum' => $option['quantite_minimum'],
						'quantite_maximum' => $option['quantite_maximum'],
						);
						
				$this->Option->create();
				if(!$this->Option->save($data)){
					$this->delete($categorie_id);
					return false;
				}
			endforeach;
		}
		else{
		//Création de l'option Entrée
			$data = array(
					'categorie_id' => $categorie_id,
					'nom_option' => 'Entrée',
					);
					
			$this->Option->create();
			if(!$this->Option->save($data)){
				$this->delete($categorie_id);
				return false;
			}
		}
		return true;
	}
	
	/**
	 * Récupère les catégories d'un évènement en remplaçant les clés numériques 
	 * par le slug de la catégorie et de l'option
	 */
	public function getCategories($evenement_id){
		$res = $this->find('all', array('conditions' => array('Categorie.evenement_id' => $evenement_id)));
		
		$categories = array();
		
		foreach($res as $row){
			$slug_categorie = $row['Categorie']['slug_categorie'];
			$categories[$slug_categorie] = array(
										'Categorie' => $row['Categorie'],
										'Evenement' => $row['Evenement'],
										'Option' => array(),
										);
			
			foreach($row['Option'] as $option):
				$categories[$slug_categorie]['Option'][$option['slug_option']] = $option;			
			endforeach;
		}
		
		return $categories;
	}
	
}

?>