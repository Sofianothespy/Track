<H1>It looks like the database that OWA uses needs to be updated.</H1>

<P>Here is a list of modules that have updates that needs to be applied:</P>

<UL>

<?php foreach ($modules as $k => $module): ?>
	
	<LI><?php echo $module; ?></LI>
	
<?php endforeach;?>

</UL>

<a href="<?php echo $this->makeLink(array('do' => 'base.updatesApply'));?>">Apply updates</a>