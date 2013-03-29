
<!--  Evenements/organisateur.ctp -->

<h4>Editer un évènement</h4>
<?php 
echo $this->Form->create('Evenement', array('type' => 'post'));
	echo $this->Form->input('nom_evenement', array(
				'label' => "Nom de l'évènement",
				'default' => $evenement['nom_evenement'],
				// 'disabled' => true,
				));
	echo $this->Form->input('evenement_id', array(
				'type' => 'hidden',
				'label' => 'evenement_id',
				'default' => $evenement['evenement_id'],
				));
							
	echo $this->Form->input('description', array(
				'type' => 'textarea',
				'label' => 'Description',
				'default' => $evenement['description'],
				));
	echo $this->Form->input('date_debut', array(
				'type' => 'date',
				'label' => "Date de début de l'évènement",
				'default' => $evenement['date_debut'],
				'dateFormat' => 'Y-M-D',
				'minYear' => date('Y'),
				));
	echo $this->Form->input('date_fin', array(
				'type' => 'date',
				'label' => "Date de fin de l'évènement",
				'default' => $evenement['date_fin'],
				'dateFormat' => 'Y-M-D',
				'minYear' => date('Y'),
				));
	echo $this->Form->input('remise', array(
				'type' => 'text',
				'label' => "Remise de l'évènement",
				'default' => $evenement['remise'],
				));
	echo $this->Form->input('date_remise', array(
				'type' => 'date',
				'label' => "Date limite de remise de l'évènement",
				'default' => $evenement['date_remise'],
				'dateFormat' => 'Y-M-D',
				'minYear' => date('Y'),
				));
	echo $this->Form->input('date_soumission_debut', array(
				'type' => 'date',
				'label' => "Date de droit de soumission",
				'default' => $evenement['date_soumission_debut'],
				'dateFormat' => 'Y-M-D',
				'minYear' => date('Y'),
				));
	echo $this->Form->input('date_soumission_fin', array(
				'type' => 'date',
				'label' => "Date limite de droit de soumission",
				'default' => $evenement['date_soumission_fin'],
				'dateFormat' => 'Y-M-D',
				'minYear' => date('Y'),
				));
			
	echo $this->Form->input('date_acceptation', array(
				'type' => 'date',
				'label' => "Date d'acceptation",
				'default' => $evenement['date_acceptation'],
				'dateFormat' => 'Y-M-D',
				'minYear' => date('Y'),
				));
	echo $this->Form->input('date_acceptation_definitive', array(
				'type' => 'date',
				'label' => "Date d'acceptation limite",
				'default' => $evenement['date_acceptation_definitive'],
				'dateFormat' => 'Y-M-D',
				'minYear' => date('Y'),
				));
echo $this->Form->end("Enregistrer");

//affichage des organisateurs
?>

<h5>Liste des organisateurs</h5>

<?php 

$type_organisateur = array(
					'organisateur' 	=> 'Organisateur',
					'guest'			=> 'Invité',
					'assistant'		=> 'Assistant',
					);
if(!empty($participants)):				
	echo $this->Form->create('Organisateur', array('type' => 'post'));
		echo $this->Form->input('action', array(
					'type' => "hidden",
					'default' => 'add',
					));
		echo $this->Form->input('evenement_id', array(
					'type' => "hidden",
					'default' => $evenement['evenement_id'],
					));
		echo $this->Form->input('participant_id', array(
					'options' => $participants,
					'label' => 'Organisateur',
					));
		echo $this->Form->input('nom_role', array(
					'options' => $type_organisateur,
					'default' => 'guest',
					'label' => 'Role',
					));
		
	echo $this->Form->end("Ajouter");
endif;

echo $this->Form->create('Organisateur', array('type' => 'post'));
	echo $this->Form->input('action', array(
					'type' => 'hidden',
					'default' => 'update',
					));
	?>
	<ul>
		<?php 
		foreach($organisateurs as $organisateur):
			?>
			<li>
				<?php 
				echo ucfirst($organisateur['Participant']['prenom_participant']).' '.ucwords($organisateur['Participant']['nom_participant'])
					.'('.$this->Form->input('nom_role_'.$organisateur['Organisateur']['organisateur_id'], array(
									'options' => $type_organisateur,
									'default' => $organisateur['Organisateur']['nom_role'],
									))
					.') - '.$organisateur['Participant']['profession'];
				?>
			</li>
			<?php
		endforeach;
		?>
	</ul>
	<?php 
echo $this->Form->end("Modifier");
?>
<br/>
<br/>

<h5>Gestion des catégories</h5>
<?php
echo $this->Form->create('Categorie', array('type' => 'post'));
	echo $this->Form->input('action', array(
					'type' => 'hidden',
					'default' => 'add',
					));
	echo $this->Form->input('nom_categorie', array(
				'type' => 'text',
				'label' => "nom de la catégorie",
				));
	echo $this->Form->input('evenement_id', array(
				'type' => 'hidden',
				'label' => 'evenement_id',
				'default' => $evenement['evenement_id'],
				));
echo $this->Form->end("Ajouter la catégorie");
//affichage des categories	
if(empty($categories)):
	?>
	<div>Pas de catégorie</div>
	<?php
else:

	echo $this->Form->create('Categorie', array('type' => 'post'));
		echo $this->Form->input('action', array(
					'type' => 'hidden',
					'default' => 'delete',
					));
		?>
		<ul>
			<?php
			foreach($categories as $categorie):
				?>
				<li>
					<?php 
					echo $this->Form->checkbox('categorie_'.$categorie['categorie_id'], array(
							'value' => $categorie['categorie_id'],
							'hiddenField' => false,
							));
					echo $this->Form->label('categorie_'.$categorie['categorie_id'], $categorie['nom_categorie']);
					?>
				</li>
				<?php
			endforeach;
			?>
		</ul>
		<?php
	echo $this->Form->end("Supprimer les catégories");
endif;


//gestion des options
if(!empty($categories)){
	?>
	<h5>Gestion des options</h5>
	<?php

	echo $this->Form->create('Option', array('type' => 'post'));
		echo $this->Form->input('action', array(
					'type' => 'hidden',
					'default' => 'add',
					));
					
		$options = array();
		foreach($categories as $categorie):
			$options[$categorie['categorie_id']] = $categorie['nom_categorie'];
		endforeach;
		
		echo $this->Form->input('categorie_id', array(
						'options' => $options,
						'label' => 'Catégorie',
						));
		echo $this->Form->input('nom_option', array(
				'type' => 'text',
				'label' => "nom de l'option",
				));
		echo $this->Form->input('prix_unitaire', array(
				'type' => 'text',
				'label' => "prix unitaire",
				));
		echo $this->Form->input('quantite_minimum', array(
				'type' => 'text',
				'label' => "Quantité minimum",
				));
		echo $this->Form->input('quantite_maximum', array(
				'type' => 'text',
				'label' => "Quantité maximum",
				));
	echo $this->Form->end("Ajouter l'option");
	
	
	if(!empty($options_by_categorie)){
		//formulaire de gestion des options
		echo $this->Form->create('Option', array('type' => 'post'));
			echo $this->Form->input('action', array(
												'type' => 'hidden',
												'default' => 'update',
												));
			?>
			<ul>
				<?php
				foreach($options_by_categorie as $options){
					?>
					<li>
						<strong><?php echo $options[0]['Categorie']['nom_categorie'];?></strong>
						<table>
							<tr>
								<th>Action</th>
								<th>Nom</th>
								<th>Prix</th>
								<th>Quantité min.</th>
								<th>Quantité max.</th>
							</tr>
							
							<?php
							foreach($options as $option):
								$option_id = $option['Option']['option_id'];
								?>
								<tr>
									<td>
										<?php
										echo $this->Form->checkbox('delete_option_'.$option_id, array(
											'value' => $option_id,
											'hiddenField' => false,
											));
										?>
									</td>
									
									<td>
										<?php 
										echo $this->Form->input('option_id_'.$option_id, array(
																'type' => 'hidden',
																'default' => $option_id,
																));
										echo $this->Form->input('nom_option_'.$option_id, array(
																'type' => 'text',
																'default' => $option['Option']['nom_option'],
																'label' => false,
																));
										?>
									</td>
									<td>
										<?php 
										echo $this->Form->input('prix_unitaire_'.$option_id, array(
																'type' => 'text',
																'default' => $option['Option']['prix_unitaire'],
																'label' => false,
																));
										?>
									</td>
									<td>
										<?php 
										echo $this->Form->input('quantite_minimum_'.$option_id, array(
																'type' => 'text',
																'default' => $option['Option']['quantite_minimum'],
																'label' => false,
																));
										?>
									</td>
									<td>
										<?php 
										echo $this->Form->input('quantite_maximum_'.$option_id, array(
																'type' => 'text',
																'default' => $option['Option']['quantite_maximum'],
																'label' => false,
																));
										?>
									</td>
								</tr>
								<?php
							endforeach;
							?>
						</table>
					</li>
					<?php
				}
				?>
			</ul>
			<?php
		echo $this->Form->end("Modifier les options");
	}
}
?>
