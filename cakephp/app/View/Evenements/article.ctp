
<h4>Article '<?php echo $article['Article']['titre'];?>'</h4>

<strong>Page(s) :</strong> <?php echo $article['Article']['nombre_page']
	.(($article['Article']['extra_page']>0)?'( dont '.$article['Article']['extra_page'].' page(s) supplémentaire(s) )' :'');?>
<br/>
<strong>Mots-clés :</strong> <?php echo $article['Article']['keywords'];?>
<br/>
<br/>
<strong>Résumé :</strong>
<br/>
<p>
<?php 
if(empty($article['Article']['resume']))
	echo "Aucun résumé n'est disponible.";
else
	echo $article['Article']['resume'];
?>
</p>

<?php 
if(!empty($auteurs)){
	?>
	<strong>Auteur(s) :</strong>
	<ul>
		<?php 
		foreach($auteurs as $auteur):
			?>
			<li><?php echo $auteur['Participant']['nom_complet'];?></li>
			<?php 
		endforeach;
		?>
	</ul>
	<?php 
}
?>