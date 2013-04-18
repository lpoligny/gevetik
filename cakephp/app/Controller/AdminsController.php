<?php

	// Jonathan

	class AdminsController extends AppController{
		function login(){
			if($this->request->is('post')){
				$sent = $this -> request -> data['Admins'];

				$data = $this -> Admin -> find('first',array(
										'conditions' => array(
											'login' => $sent['login'],
											'password' => Security::hash($sent['password'])
										)
									)
				);

				// A ameliorer !
				$this -> logout();

				if($this->Auth->login($data)){
					$this -> redirect(array('action' => 'index'));
				}
				else{
					$this -> Session -> setFlash(__('Login ou mot de passe incorrect.'));
				}
			}
		}

		function logout(){
			$this -> Auth -> logout();
		}

		function modifier_orga_evenement(){
			if($this -> request -> is('post')){
				$evenement_id = $this -> request -> data['select_evt'];
				//$conditions = array('Evenement.evenement_id' => $evenement_id);

				$this -> loadModel('Organisateur');
				$data = $this -> Organisateur -> find('all');

				$this -> set('evt_id',$evenement_id);
				$this -> set('infos',$data);
			}
			else{
				$this -> set('infos','Aucune donnée envoyée');
			}
		}

		function nouvel_evenement(){
			$this -> loadModel('Organisateur');

			$fields = array('DISTINCT Organisateur.participant_id','Participant.prenom_participant', 'Participant.nom_participant', 'Participant.participant_id');
			$data = $this -> Organisateur -> find('all',array('fields' => $fields));

			$this -> set('infos',$data);
		}

		function confirmer_ajout_conf(){
			if($this -> request -> is('post')){
				$sent = $this -> request -> data['ajout_conf'];

				$this -> loadModel('Evenement');

				$this -> Evenement -> save($sent);

				$this -> set('infos','L\'évènement à bien été ajouté');
			}
			else{
				$this -> set('infos','Aucune donnée envoyée');
			}
		}

		//TODO
		function gerer_organisateurs(){
			if($this -> request -> is('post')){
				$sent = $this -> request -> data['gerer_orga'];

				

				$this -> set('infos',$sent);
			}
			else{

			}
		}

		function modifier_visibilite(){
			if($this -> request -> is('post')){
				$sent = $this -> request -> data['visible'];

				$this -> loadModel('Evenement');
				$this -> Evenement -> save($sent);

				$this -> set('infos','Modification enregistrée');
			}
			else{
				$this -> set('infos','Aucune donnée reçue, modification non effectuée');
			}
		}

		function index(){
			$this -> loadModel('Evenement');
			$data = $this -> Evenement -> find('all');

			$this -> set('infos',$data);
		}
	}
?>
