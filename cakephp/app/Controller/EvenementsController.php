<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('AppController', 'Controller');

class EvenementsController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Evenements';

	public $helpers = array('Html', 'Form');
	
	public $uses = array();
	
	public $donneeEvenement = '';
	public $nomEvenement = '';

	public function index($v = '') {
		echo $v;
		//debug(func_get_args());
		//$path = func_get_args();
		debug($this->params['nom_evenement']);
		//print_r($path);
		/*
		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));
		$this->render(implode('/', $path));
		*/
	}
	
	public function organisateur(){
		$this->loadModel('Option');
		$this->loadModel('Categorie');
		
		$res = $this->donneeEvenement;
		
		//récupération des options
		$categories = array();
		foreach($res['Categorie'] as $categorie):
			$categories[] = $categorie['categorie_id'];
		endforeach;
		$result_options = $this->Option->find('all', array(
												'conditions' => array('Categorie.categorie_id' => $categories)
												));
		$options_by_categorie = array();
		
		foreach($result_options as $option):
			$options_by_categorie[$option['Categorie']['categorie_id']][] = $option;
		endforeach;
		
		/*
		 *sauvegarde des modifications
		 */
		if($this->request->is('post') || $this->request->is('put')){
			//modification des informations de l'évènement
			if(array_key_exists('Evenement', $this->request->data)){
				$this->Evenement->id = $this->request->data['Evenement']['evenement_id'];
				
				if($this->Evenement->save($this->request->data)){
					$this->Session->setFlash('Evènement modifié');
					$this->redirect($this->here);
				}
				else{
					$this->Session->setFlash('Echec de la modification l\'évènement');
				}
			}
			else if(array_key_exists('Categorie', $this->request->data)){
			
				//ajout d'une catégorie
				if(array_key_exists('nom_categorie', $this->request->data['Categorie'])):
					$this->Categorie->create();
					if($this->Categorie->save($this->request->data)){
						$this->Session->setFlash('Catégorie ajoutée');
						$this->redirect($this->here);
					}
					else{
						$this->Session->setFlash('Echec de la modification l\'évènement');
					}
				//suppression de catégories
				elseif(!empty($this->request->data['Categorie'])): 
					foreach($this->request->data['Categorie'] as $categorie_id):
						$this->Categorie->delete($categorie_id);
					endforeach;
					
					$this->Session->setFlash('Catégorie(s) supprimée(s)');
					$this->redirect($this->here);
				endif;
				
			}
			else if(array_key_exists('Option', $this->request->data)){
				//ajout d'une option
				if(!array_key_exists('action', $this->request->data['Option'])):
					$this->Option->create();
					if($this->Option->save($this->request->data)){
						$this->Session->setFlash('Option ajouté');
						$this->redirect($this->here);
					}
					else{
						$this->Session->setFlash('Echec de la modification l\'évènement');
					}
				//modification des options
				elseif($this->request->data['Option']['action']=='update'):
					foreach($result_options as $option):
						$option_id = $option['Option']['option_id'];
						$data = array();
						
						$this->Option->id = $option_id;
						$data['nom_option'] = $this->request->data['Option']['nom_option_'.$option_id];
						$data['prix_unitaire'] = $this->request->data['Option']['prix_unitaire_'.$option_id];
						$data['quantite_minimum'] = $this->request->data['Option']['quantite_minimum_'.$option_id];
						$data['quantite_maximum'] = $this->request->data['Option']['quantite_maximum_'.$option_id];
						
						// if(!$this->Option->updateAll($data, array('option_id' => $option_id))){
						if(!$this->Option->save($data)){
							$this->Session->setFlash('Echec de la modification l\'évènement');
						}
					endforeach;
					
					$this->Session->setFlash('Option(s) modifiée(s)');
					$this->redirect($this->here);
					
				endif;
			}
        }
		
		/*
		 *variables de vue
		 */
		$this->set('evenement', $res['Evenement']);
		$this->set('categories', $res['Categorie']);
		$this->set('options_by_categorie', $options_by_categorie);
	}
	
	
	function beforeFilter(){
		parent::beforeFilter();
		
		$params = $this->params->params;
		if(array_key_exists('nom_evenement', $params)){
			$this->nomEvenement = $this->params['nom_evenement'];
			
			$res = $this->Evenement->find('first', array(
													'conditions' => array('Evenement.nom_evenement' => $this->nomEvenement),
													));
			//si l'évènement n'existe pas										
			if (!$res) {
				throw new NotFoundException(__('Evenement inconnu'));
			}	
			$this->donneeEvenement = $res;
		}
	}

	/************************************************************************************************************************************************/
	/************************************************************************************************************************************************/
	/************************************************************************************************************************************************/
	/************************************************************************************************************************************************/
	/************************************************************************************************************************************************/
	/************************************************************************************************************************************************/
	/************************************************************************************************************************************************/

	public function add() {
	$this->loadModel('Participant');
	$result = $this->Participant->find('all');
        if ($this->request->is('post')) {
            $this->Participant->create();
            if ($this->Participant->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        }

    }
}
