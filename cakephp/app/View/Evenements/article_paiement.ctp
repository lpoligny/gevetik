
<h4>Article '<?php echo $article['Article']['titre'];?>' - Paiement</h4>


<?php 
if($article['Article']['extra_page']==0){
	?>
	<h4>Vous n'avez pas de pages supplémentaires à payer</h4>
	<?php 
}
else{
	$cout_unitaire_extra = 100;
?>
	<table>
		<tr>
			<th>Auteur</th>
			<th>Type de paiement</th>
			<th>Etat</th>
			<th>nombre d'extra payé</th>
			<th>Valeur (€)</th>
		</tr>
		<?php 
		$extra_page_paye = 0;
		foreach($payeurs as $payeur):
			?>
			<tr>
				<td><?php echo $payeur['Participant']['nom_complet'];?></td>
				<td><?php echo $payeur['Paiement']['type'];?></td>
				<td><?php echo ($payeur['Paiement']['validation'])?'Oui' :'Non';?></td>
				<td><?php echo $payeur['Page_payee']['extra_page_payee'];?></td>
				<td><?php echo $payeur['Page_payee']['extra_page_payee']*$cout_unitaire_extra;?></td>
			</tr>
			<?php 
			$extra_page_paye+= $payeur['Page_payee']['extra_page_payee'];
		endforeach;
		$extra_restant = $article['Article']['extra_page']-$extra_page_paye;
		?>
		<tr>
			<td colspan="3"><strong>Reste à payer</strong></td>
			<td><?php echo $extra_restant;?></td>
			<td><?php echo $extra_restant*$cout_unitaire_extra;?></td>
		</tr>
		<tr>
			<td colspan="3"><strong>Total</strong></td>
			<td><?php echo $article['Article']['extra_page'];?></td>
			<td><?php echo $article['Article']['extra_page']*$cout_unitaire_extra;?></td>
		</tr>
	</table>
	
	<?php
	if($extra_restant>0){
		echo $this->Form->create('Page_payee', array('type' => 'post'));
			echo $this->Form->input('page_payee_id', array(
									'type' => 'hidden',
									'value' => 2,
									));
			$options = array();
			for($i = 0; $i<= $extra_restant; $i++)
				$options[$i] = $i;
			echo "<strong>1 page payée = ".$cout_unitaire_extra." €</strong><br/>\n";	
			echo $this->Form->input('extra_page', array(
									'options' => $options,
									'label' => 'Page à payer',
									'default' => '0',
									));
			
			echo $this->Form->input('type_paiement', array(
									'options' => $types_paiement,
									'label' => 'Paiement par ',
									));
		
		echo $this->Form->end('Payer');
	}
}
?>