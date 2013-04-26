<h1><?php echo $nom_evenement;?></h1>
<hr/>

<p>
	Bienvenue sur le site de <?php echo $nom_evenement;?>. Les dates importantes sont :
	<br/>
	<?php echo $evenement['date_debut'].' à '.$evenement['date_fin'].' à '.$evenement['adresse'];?>
</p>

<ul>
	<li>Ouverture des soumissions : <?php echo $evenement['date_soumission_debut'];?></li>
	<li>Fermeture des soumission : <?php echo $evenement['date_soumission_fin'];?></li>
	<li>Notification aux auteurs : <?php echo $evenement['date_acceptation'];?></li>
</ul>

<h5>Description</h5>
<p><?php echo $evenement['parsed_description'];?></p>
<br/>

<h5>Les prix des inscriptions :</h5>

<table>
	<tr>
		<th>Description</th>
		<th>Enregistrement tôt</th>
		<th>Prix normal</th>
	</tr>
	<?php 
	foreach($categories as $categorie):
		$enregistrement_tot = $categorie['Option']['entree']['prix_unitaire']-$categorie['Evenement']['remise'];
		?>
		<tr>
			<td><?php echo $categorie['Categorie']['nom_categorie'];?></td>
			<td><?php echo ($enregistrement_tot>0)?$enregistrement_tot :'0';?></td>
			<td><?php echo $categorie['Option']['entree']['prix_unitaire'];?></td>
		</tr>
		<?php 
	endforeach;
	?>
</table>

<h5>Prix des options</h5>
<table>
	<tr>
		<th>Description</th>
		<?php 
		$categories_order = array();
		foreach($categories as $categorie):
			$categories_order[] = $categorie['Categorie']['slug_categorie'];
			?>
			<th><?php echo $categorie['Categorie']['nom_categorie'];?></th>
			<?php 
		endforeach;
		?>
	</tr>
	<?php 
	$categorie = $categories[$categories_order[0]];
	$options = $categorie['Option'];

	foreach($options as $slug_option => $option){
		?>
		<tr>
			<td><?php echo $option['nom_option'];?></td>
			<?php 
			foreach($categories_order as $slug_categorie):
				?>
				<td><?php echo $categories[$slug_categorie]['Option'][$slug_option]['prix_unitaire'];?></td>
				<?php 
			endforeach;
			?>
		</tr>
		<?php 
	}
	?>
</table>