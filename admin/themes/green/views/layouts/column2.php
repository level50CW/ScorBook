<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
	<!--<div id="span-23" class="span-23 redbar">
		<div id="crowbar">
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Navegación',
			));
			$this->widget('zii.widgets.CMenu', array(
				'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'operations'),
			));
			$this->endWidget();
		?>
		</div><!-- sidebar -->
	<!--</div>-->
	<div class="span-24">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>	

</div>
<?php $this->endContent(); ?>
