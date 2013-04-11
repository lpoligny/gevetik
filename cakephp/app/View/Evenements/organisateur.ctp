
<!--  Evenements/organisateur.ctp -->

<h4>Editer un évènement</h4>
<?php 
////////////////echo strftime("%d %B %Y à %H:%M", time());
echo $this->Form->create('Evenement', array('type' => 'post'));
	echo $this->Form->input('nom_evenement', array(
				'label' => "Nom de l'évènement",
				'default' => $evenement['nom_evenement'],
				// 'disabled' => true,
				));
	echo $this->Form->input('slug_evenement', array(
				'label' => "Identifiant de l'évènement",
				'default' => $evenement['slug_evenement'],
				));
	echo $this->Form->checkbox('evenement_active', array(
					'value' => 1,
					'checked' => ($evenement['evenement_active']==1),
					));
	echo $this->Form->label('evenement_active', 'Rendre visible');
	
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
	
	?>
	<strong>Utilisez ces balises pour :</strong><br/>
	<ul>
		<?php 
		foreach($evenement['parsable_fields'] as $field => $desc):
			echo '<li>['.$field.'] - '.$desc.'</li>'."\n";
		endforeach;
		?>
	</ul>
	
	<h5>Previsualisation :</h5>
	<?php 
	echo '<p>'.$evenement['parsed_description'].'</p>';
	
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
					'comite'		=> 'Membre du comité',
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
					'label' => 'Role',
					));
		echo $this->Form->checkbox('est_organisateur', array(
					'value' => 1,
					));
		echo $this->Form->label('est_organisateur', 'Est organisateur');
		
	echo $this->Form->end("Ajouter");
endif;

// modification des droits des organisateurs
echo $this->Form->create('Organisateur', array('type' => 'post'));
	echo $this->Form->input('action', array(
					'type' => 'hidden',
					'default' => 'update',
					));
	
		$cells = array();
		foreach($organisateurs as $organisateur):
			$cb_organisateur = $this->Form->checkbox('est_organisateur_'.$organisateur['Organisateur']['organisateur_id'], array(
					'value' => 1,
					'checked' => ($organisateur['Organisateur']['est_organisateur'])?true :false,
					));
			$cb_organisateur.= $this->Form->input('organisateur_'.$organisateur['Organisateur']['organisateur_id'], array(
												'type' => 'hidden',
												'value' => $organisateur['Organisateur']['organisateur_id'],
												));
			
			if(count($organisateurs)>1)
				$cb_supprimer = $this->Form->checkbox('del_organisateur_'.$organisateur['Organisateur']['organisateur_id'], array(
						'value' => 1,
						));
			else
				$cb_supprimer = $this->Form->input('del_organisateur_'.$organisateur['Organisateur']['organisateur_id'], array(
						'type' => 'hidden',
						'value' => 0,
						));
			
			$cells[] = array(
						ucfirst($organisateur['Participant']['prenom_participant']).' '.ucwords($organisateur['Participant']['nom_participant']),
						$organisateur['Organisateur']['nom_role'],
						$cb_organisateur,
						$cb_supprimer,
						);
		endforeach;
		
		//affichage du tableau
		echo "<table>\n"
				.$this->Html->tableHeaders(array('Nom', 'Role', 'Organisateur ?', 'Supprimer ?'))
				.$this->Html->tableCells($cells)
			."</table>";
		
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
					if($categorie['nom_categorie']=='Normal')
						echo 'Normal - Non supprimable';
					else{
						echo $this->Form->checkbox('categorie_'.$categorie['categorie_id'], array(
								'value' => $categorie['categorie_id'],
								'hiddenField' => false,
								));
						echo $this->Form->label('categorie_'.$categorie['categorie_id'], $categorie['nom_categorie']);
					}
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
		
		echo $this->Form->input('nom_option', array(
				'type' => 'text',
				'label' => "nom de l'option",
				));
	echo $this->Form->end("Ajouter l'option");
	
	
	
	if(!empty($sorted_options)){
		//formulaire de gestion des options
		echo $this->Form->create('Option', array('type' => 'post'));
			echo $this->Form->input('action', array(
											'type' => 'hidden',
											'default' => 'update',
											));
			?>
			<table>
				<tr>
					<th>Catégorie</th>
					<th>Prix</th>
					<th>Quantité min.</th>
					<th>Quantité max.</th>	
				</tr>
				<?php
				foreach($sorted_options as $nom_option => $options){
				
					?>
					<tr>
						<?php 
						if($nom_option=='Entrée'):
							?>
							<td colspan="3">Option Entrée</td>
							<td>Non supprimable</td>
							<?php 
						else:
							?>
							<td colspan="3">
								<?php 
								echo $this->Form->input('nom_option_'.$nom_option, array(
												'type' => 'text',
												'default' => $nom_option,
												'label' => "Option",
												));
								?>
							</td>
							<td>
								<?php 
								echo $this->Form->checkbox('delete_option_'.$nom_option, array(
												'value' => 1,
												'hiddenField' => false,
												));
								?>
							</td>
							<?php 
						endif;
						?>
					</tr>
					<?php 
					foreach($options as $option){	
						$option_id = $option['Option']['option_id'];
					
						?>
						<tr>
							<td>
								<?php echo $option['Categorie']['nom_categorie'];?>
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
					}
				}
				?>	
			</table>
			<?php 
		echo $this->Form->end("Modifier les options");
	}
}
?>
