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
				$fields = array(
					'DISTINCT Organisateur.participant_id',
					'Participant.prenom_participant', 'Participant.nom_participant', 'Participant.participant_id','Participant.email_participant',
				);
				//$conditions = array('Evenement.evenement_id' => $evenement_id);

				$this -> loadModel('Organisateur');
				$this -> loadModel('Evenement');

				$orgas = $this -> Organisateur -> find('all',array('fields' => $fields));
				$evenement = $this -> Evenement -> find('first',array('conditions' => array('Evenement.evenement_id' => $evenement_id)));
				$deja = $this -> Organisateur -> find('all',array('conditions' => array('Evenement.evenement_id' => $evenement_id)));

				$this -> set('evenement',$evenement);
				$this -> set('infos',$orgas);
				$this -> set('deja',$deja);
			}
			else{
				$this -> set('infos','Aucune donnée envoyée');
			}
		}

		function nouvel_evenement(){
			$this -> loadModel('Organisateur');

			$fields = array(
				'DISTINCT Organisateur.participant_id',
				'Participant.prenom_participant', 'Participant.nom_participant', 'Participant.participant_id'
			);
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
				$this -> set('infos','Aucune donnée envoyée, la mise à jour n\'a pas été effectuée');
			}
		}

		// MAJ des organisateurs affectés à un évènement
		function gerer_organisateurs(){
			if($this -> request -> is('post')){
				$sent = $this -> request -> data['gerer_orga'];
				$evenement_id = $sent['evenement_id'];

				// Pour vérifier qu'il y a au moins 1 organisateur pour l'évènement
				$bool = false;

				$orgas_add = array();
				$orgas_del = array();

				$save = array();
				$save['evenement_id'] = $sent['evenement_id'];
				$save['participant_id'] = "";

				$del = array();
				//$del['evenement_id'] = $sent['evenement_id'];
				$del['participant_id'] = "";


				// On remplit les tableaux servant à la mise à jour de la table
				foreach($sent as $cle => $valeur){

					// Structure du tableau : participant_id => booléen (case cochée ou pas)
					// Si la clé est un entier, elle représente un participant_id. La valeur associée sera le booléen indiquant si la case à été cochée
					if(is_int($cle)){

						// Si case cochée
						if($valeur){
							$bool = true;
							$orgas_add[] = $cle;
						}
						else{
							$orgas_del[] = $cle;
						}
					}
				}

				// Au moins 1 organisateur pour tout evenement
				if($bool){
					$this -> loadModel('Organisateur');

					// On supprime les associations éventuelles (evenement_id,participant_id) si la case correspondant a un organisateur est décochée
					foreach($orgas_del as $id){
						$del['participant_id'] = $id;
						$this -> Organisateur -> deleteAll(array('Organisateur.evenement_id' => $evenement_id, "Organisateur.participant_id" => $id));
					}

					// On l'ajoute si la case est cochée
					foreach($orgas_add as $id){
						$save['participant_id'] = $id;
						$conditions = array('Organisateur.evenement_id' => $evenement_id,'Organisateur.participant_id' => $id);

						// On vérifie si l'association (evenement_id,participant_id) n'existe pas (= organisateur coché, et l'était déja avant)
						// Car sinon, on essaye d'ajouter cette association dans la table alors qu'elle existe déja, donc on ne respecte pas la contrainte d'unicité
						if($this -> Organisateur -> find('count',array('conditions' => $conditions)) < 1){
							$this -> Organisateur -> save($save);
						}
					}

					$this -> set('infos','Modifications enregistrées');
				}
				else{
					$this -> set('infos','Un évènement doit avoir au moins un organisateur. Veuillez ajouter au moins organisateur pour cet évènement');
				}
			}
			else{
				$this -> set('infos',"Aucune donnée envoyée, aucune mise à jour effectuée");
			}
		}

		// Changer la valeur du champ "visible" d'un évènement
		function modifier_visibilite(){
			if($this -> request -> is('post')){
				$sent = $this -> request -> data['visible'];

				// Pour coller avec le nom utilisé par Matthias
				$sent['evenement_active'] = $sent['visible'];

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
