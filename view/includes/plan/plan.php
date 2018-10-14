<?php if (isset($planes[$dia][$comida])) { ?>
	<?php foreach ($planes[$dia][$comida] as $art) { ?>
		<div id="plan_<?php echo $art->id_plan(); ?>" style="width: 200pt; float: left;">
			<?php include PATH_VIEW . 'includes/plan/art_plan.php'; ?>
		</div>
	<?php } ?>
	<div class="separador"></div>
<?php } ?>