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
	
	public $evenementID = 0;
	public $nomEvenement = '';
	public $donneeEvenement = '';

	public $components = array('Session',
		                          'Auth' => array(
		                              'authenticate' => array(
		                                          'Form' => array(
		                                              'fields' => array('username' => 'email_participant', 'password' => 'mot_de_passe'),
		                                              'userModel' => 'Participant',
		                                              )
		                                          ),
										'authorize' => 'Controller',
		                              )
		                   	);

	
	function beforeFilter(){
		parent::beforeFilter();
		
		$params = $this->params->params;
		if(array_key_exists('nom_evenement', $params)){
			$this->nomEvenement = $params['nom_evenement'];
			
			$res = $this->Evenement->getEvenement($this->nomEvenement);
			
			//si l'évènement n'existe pas										
			if (!$res) {
				throw new NotFoundException(__('Evenement inconnu'));
			}	
			$this->evenementID = $res['Evenement']['evenement_id'];
			$this->donneeEvenement = $res;
		}
		else
			throw new NotFoundException(__('Situation impossible !'));
			
		if(!$this->Auth->loggedIn())
			$this->isAuthorized();
	}
	
	/**
	 * Gestion des permissions du controleur evenements
	 */
	public function isAuthorized($user = null) {
		if($user==null)
			$user = array(
					'groupe' => 'unknown',
					'participant_id' => 0,
					'id' => 0,
					);
		if($user['groupe']!='participant')
			throw new ForbiddenException(__("Vous n'êtes pas autorisé à accéder à cette section."));

		$action = $this->request->params['action'];
		$params = $this->request->params['pass'];
		
		switch($action){
			case 'organisateur':
				$this->loadModel('Organisateur');
				$res = $this->Organisateur->find('first', array('conditions' => array(
																			'Organisateur.evenement_id' => $this->evenementID,
																			'Organisateur.participant_id' => $user['participant_id'],
																			)));
				if(!$res)
					throw new ForbiddenException(__("Vous n'êtes pas autorisé à accéder à cette section."));
				else if(!$res['Organisateur']['est_organisateur'])
					throw new ForbiddenException(__("Seul les organisateurs peuvent accéder à cette section."));
				break;
				
			case 'article':
				$article_id = $param[0];
				$sub_action = '';
				if(isset($param[1]))
					$sub_action = $param[1];
				
				//accès à l'article
				$this->loadModel('Page_payee');
				$res = $this->Page_payee->find('first', array('conditions' => array(
																		'Page_payee.article_id' => $article_id,
																		'Page_payee.participant_id' => $user['participant_id'],
																		)));
				//un non-contributeur ne peut éditer ou payer un article.
				if(!$res && in_array($sub_action, array('edit', 'paiement')))
					throw new ForbiddenException(__("Vous devez etre un contributeur de l'article pour accéder à cette page."));					
				break;
		}
		
        return true;
    }
	
	
	public function index() {
		$this->loadModel('Categorie');
		$res = $this->Categorie->getCategories($this->evenementID);
		
		$this->set('nom_evenement', $this->donneeEvenement['Evenement']['nom_evenement']);
		$this->set('evenement_id', $this->donneeEvenement['Evenement']['evenement_id']);	
		$this->set('evenement', $this->donneeEvenement['Evenement']);
		$this->set('categories', $res);
		// $this->login();
	}

	public function login() {
		$this->logout();
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				parent::initializeLogin();
				//$this->redirect($this->Auth->redirect());
				$this->Session->setFlash(__('Connexion OK'));
				$this->redirect(array('controller' => $this->nomEvenement, 'action' => 'index'));
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
						$organisateurs = $this->donneeEvenement['Organisateur'];
						$success = true;
						
						foreach($organisateurs as $organisateur):
							$organisateur_id = $organisateur['organisateur_id'];
							
							//Suppression des organisateurs
							if($this->request->data['Organisateur']['del_organisateur_'.$organisateur_id]==1)
								$this->Organisateur->delete($organisateur_id);
							else{
							//modification des organisateurs
								$this->Organisateur->id = $organisateur_id;
								$data = array(
										'est_organisateur' =>  $this->request->data['Organisateur']['est_organisateur_'.$organisateur_id],
										);
								if(!$this->Organisateur->save($data)){
									$this->Session->setFlash("Echec de la modification de l'organisateur");
									$success = false;
									break;
								}
							}
						endforeach;
						if($success)
							$this->Session->setFlash("Droit d'organisateur modifié(s)");
						break;
				}
				
			}
			else if(array_key_exists('Categorie', $this->request->data)){
			
				$this->loadModel('Categorie');
				switch($this->request->data['Categorie']['action']){
					
					case 'add'://ajout d'une catégorie
						$this->Categorie->create();
						if($this->Categorie->creerCategorie($this->evenementID, $this->request->data['Categorie']['nom_categorie']))
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
						
						$data = array(
								'nom_option' => $this->request->data['Option']['nom_option'],
								'prix_unitaire' => 0,
								'quantite_minimum' => '',
								'quantite_maximum' => '',
								);
						
						//pour chaque catégorie, création d'une option de même nom
						foreach($res['Categorie'] as $categorie):
							$this->Option->create();
							$data['categorie_id'] = $categorie['categorie_id'];
							
							if($this->Option->save($data))
								$this->Session->setFlash('Option ajouté');
						endforeach;
						break;
					case 'update'://modification des options
						//récupération des catégorie de l'évènement
						$categories = array();
						foreach($res['Categorie'] as $categorie):
							$categories[] = $categorie['categorie_id'];
						endforeach;
						
						//tri des options par catégorie.
						$options = $this->Option->find('all', array('conditions' => array('Option.categorie_id' => $categories)));
						$sorted_options = array();
						foreach($options as $option):
							$sorted_options[$option['Option']['nom_option']][] = $option;
						endforeach;
						
						$success = true;
						foreach($sorted_options as  $nom_option => $options){
							foreach($options as  $option){
								$option_id = $option['Option']['option_id'];
								
								//suppression
								if(array_key_exists('delete_option_'.$nom_option, $this->request->data['Option']))
									$this->Option->delete($option_id);
								else{ 
								// modification
									$data = array();
									$data['Option']['nom_option'] = $this->request->data['Option']['nom_option_'.$nom_option];
									$data['Option']['prix_unitaire'] = $this->request->data['Option']['prix_unitaire_'.$option_id];
									$data['Option']['quantite_minimum'] = intval($this->request->data['Option']['quantite_minimum_'.$option_id]);
									$data['Option']['quantite_maximum'] = intval($this->request->data['Option']['quantite_maximum_'.$option_id]);
									
									$this->Option->id = $option_id;
									if(!$this->Option->save($data)){
										$success = false;
										//affichage des erreurs
										$this->Option->set($data);
										$errors_group = $this->Option->invalidFields();
										foreach($errors_group as $errors):
											foreach($errors as $error):
												$this->Session->setFlash($error);
											endforeach;
										endforeach;
										break;
									}
								}
							}
						}
						// endforeach;
						if($success)
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
		$categorie_ids = array();
		//récupération des identifiants des catégories
		foreach($res['Categorie'] as $categorie):
			$categorie_ids[] = $categorie['categorie_id'];
		endforeach;
		
		//récupération des options de l'évènement
		$options = $this->Option->find('all', array('conditions' => array('Categorie.categorie_id' => $categorie_ids)));
		$sorted_options = array();
		
		foreach($options as $option):
			$sorted_options[$option['Option']['nom_option']][] = $option;
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
		// $this->set('options_by_categorie', $options_by_categorie);
		$this->set('sorted_options', $sorted_options);
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
}
