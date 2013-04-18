<?php
/** BENJAMIN RABILLER
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
	public $evenementID = 0;
	public $helpers = array('Html', 'Form');
	
	public $uses = array();
	
	public $donneeEvenement = '';
	public $nomEvenement = '';

	public $components = array('Session',
		                          'Auth' => array(
		                              'authenticate' => array(
		                                          'Form' => array(
		                                              'fields' => array('username' => 'email_participant', 'password' => 'mot_de_passe'),
		                                              'userModel' => 'Participant',
		                                              )
		                                          ),
		                              )
		                   	);

	
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
			$this->evenementID = $res['Evenement']['evenement_id'];
		}
	}
	
	
	public function index() {
		$this->set('nom_evenement', $this->donneeEvenement['Evenement']['nom_evenement']);
		$this->set('date_debut_evenement', $this->donneeEvenement['Evenement']['date_debut']);
		$this->set('date_fin_evenement', $this->donneeEvenement['Evenement']['date_fin']);
		$this->login();

	}

	public function login() {
		$this->logout();
		$this->loadModel('Participant');
		$result = $this->Participant->find('all');
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->Session->setFlash(__('Connexion réalisée avec succès'));
				$this->redirect(array('controller' => $this->nomEvenement, 'action' => 'participant'));
			}
			 else {
				$this->Session->setFlash(__('Login ou mot de passe incorrect'));
			}
		}
	}

	public function logout() {
		$this->Auth->logout();
	}
	
	public function organisateur(){
		$this->loadModel('Option');
		$this->loadModel('Participant');
		$this->loadModel('Organisateur');
		
		$res = $this->donneeEvenement;
		
		/*
		 *sauvegarde des modifications
		 */
		if($this->request->is('post')){
			//modification des informations de l'évènement
			if(array_key_exists('Evenement', $this->request->data)){
				$this->Evenement->id = $this->request->data['Evenement']['evenement_id'];
				
				if($this->Evenement->save($this->request->data))
					$this->Session->setFlash('Evènement modifié');
				else
					$this->Session->setFlash('Echec de la modification l\'évènement');
					
			}
			else if(array_key_exists('Organisateur', $this->request->data)){
				switch($this->request->data['Organisateur']['action']){
					
					case 'add'://ajout
						$this->Organisateur->create();
						if($this->Organisateur->save($this->request->data))
							$this->Session->setFlash('Organisateur ajouté');
						else
							$this->Session->setFlash("Echec de l'ajout de l'organisateur");
						break;
						
					case 'update':
						$organisateurs = $this->Organisateur->getOrganisateurs($res['Evenement']['evenement_id']);
						$success = true;
						foreach($organisateurs as $organisateur):
							$organisateur_id = $organisateur['Organisateur']['organisateur_id'];
							$this->Organisateur->id = $organisateur_id;
							$data = array(
									'nom_role' =>  $this->request->data['Organisateur']['nom_role_'.$organisateur_id],
									);
							if(!$this->Organisateur->save($data)){
								$this->Session->setFlash("Echec de l'ajout de l'organisateur");
								$success = false;
								break;
							}
						endforeach;
						if($success)
							$this->Session->setFlash("Role(s) d'organisateur modifié(s)");
						break;
				}
				
			}
			else if(array_key_exists('Categorie', $this->request->data)){
			
				$this->loadModel('Categorie');
				switch($this->request->data['Categorie']['action']){
					
					case 'add'://ajout d'une catégorie
						$this->Categorie->create();
						if($this->Categorie->save($this->request->data))
							$this->Session->setFlash('Catégorie ajoutée');
						else
							$this->Session->setFlash("Echec d'ajout de la catégorie");
						break;
						
					case 'delete'://suppression de catégories
						foreach($this->request->data['Categorie'] as $categorie_id):
							$this->Categorie->delete($categorie_id);
						endforeach;
						
						$this->Session->setFlash('Catégorie(s) supprimée(s)');
						break;
				}
				
			}
			else if(array_key_exists('Option', $this->request->data)){
				
				switch($this->request->data['Option']['action']){
					
					case 'add'://ajout d'une option
						$this->Option->create();
						if($this->Option->save($this->request->data))
							$this->Session->setFlash('Option ajouté');
						else
							$this->Session->setFlash("Echec d'ajout d'option");
						break;
					
					case 'update'://modification des options
						$categories = array();
						foreach($res['Categorie'] as $categorie):
							$categories[] = $categorie['categorie_id'];
						endforeach;
						
						$options = $this->Option->find('all', array('conditions' => array('Option.categorie_id' => $categories)));
						debug($this->request->data);
						foreach($options as $option):
							$option_id = $option['Option']['option_id'];
							if(array_key_exists('delete_option_'.$option_id, $this->request->data['Option']))//suppression
								$this->Option->delete($option_id);
							else{ // modification
							
								$data = array();
								$this->Option->id = $option_id;
								$data['nom_option'] = $this->request->data['Option']['nom_option_'.$option_id];
								$data['prix_unitaire'] = $this->request->data['Option']['prix_unitaire_'.$option_id];
								$data['quantite_minimum'] = $this->request->data['Option']['quantite_minimum_'.$option_id];
								$data['quantite_maximum'] = $this->request->data['Option']['quantite_maximum_'.$option_id];
							
								if(!$this->Option->save($data)){
									$this->Session->setFlash('Echec de la modification des options');
									break;
								}
							}
						endforeach;
					
						$this->Session->setFlash('Option(s) modifiée(s)');
						break;
				}
			}
			
			//mise à niveau
			$this->request->data = array();
			$res = $this->Evenement->find('first', array(
													'conditions' => array('Evenement.nom_evenement' => $this->nomEvenement),
													));
        }
		//récupération des options
		$options_by_categorie = array();
		foreach($res['Categorie'] as $categorie):
			$options_by_categorie[$categorie['categorie_id']] = $this->Option->getOptions($categorie['categorie_id']);
		endforeach;
		
		//récupérations détaillé des organisateurs
		$organisateurs = $this->Organisateur->getOrganisateurs($res['Evenement']['evenement_id']);
		
		$participants = $this->Participant->find('list');
		//exclusion des participants déjà considéré comme des organisateurs pour cet évènement
		foreach($organisateurs as $organisateur){
			if(array_key_exists($organisateur['Organisateur']['participant_id'], $participants))
				unset($participants[$organisateur['Organisateur']['participant_id']]);
		}
		
		/*
		 *variables de vue
		 */
		$this->set('evenement', $res['Evenement']);
		$this->set('organisateurs', $organisateurs);
		$this->set('participants', $participants);
		$this->set('categories', $res['Categorie']);
		$this->set('options_by_categorie', $options_by_categorie);
	}
	

	/************************************************************************************************************************************************/
	/************************************************************************************************************************************************/
	/************************************************************************************************************************************************/
	/************************************************************************************************************************************************/
	/************************************************************************************************************************************************/
	/************************************************************************************************************************************************/
	/************************************************************************************************************************************************/

	public function inscription() {
	$this->set('nom_evenement', $this->donneeEvenement['Evenement']['nom_evenement']);
	$this->set('date_debut_evenement', $this->donneeEvenement['Evenement']['date_debut']);
	$this->set('date_fin_evenement', $this->donneeEvenement['Evenement']['date_fin']);
	$this->loadModel('Participant');
	$result = $this->Participant->find('all');
        if ($this->request->is('post')) {
            $this->Participant->create();
            if ($this->Participant->save($this->request->data)) {
                $this->Session->setFlash(__('Votre inscription a été prise en compte'));
                $this->redirect(array('controller' => $this->nomEvenement, 'action' => 'index'));
            } else {
                $this->Session->setFlash(__('Votre inscritpion à echoué.'));
            }
        }

    }

	public function participant(){
		$this->set('nom_evenement', $this->donneeEvenement['Evenement']['nom_evenement']);
		$this->set('date_debut_evenement', $this->donneeEvenement['Evenement']['date_debut']);
		$this->set('date_fin_evenement', $this->donneeEvenement['Evenement']['date_fin']);
		$this->loadModel('Participant');
	}
}
