<form action="<?=$this->make_report_link('dashboard_report.php');?>" method="GET">
	<SELECT name="period" onchange='OnChange(this.form.period);'>
		<OPTION VALUE="today" <?php if ($period == 'today'): echo 'selected'; endif; ?>>Today</OPTION>
		<OPTION VALUE="yesterday" <?php if ($period == 'yesterday'): echo 'selected'; endif; ?>>Yesterday</OPTION>
		<OPTION VALUE="this_week" <?php if ($period == 'this_week'): echo 'selected'; endif; ?>>This Week</OPTION>
		<OPTION VALUE="last_seven_days" <?php if ($period == 'last_seven_days'): echo 'selected'; endif; ?>>Last Seven Days</OPTION>
		<OPTION VALUE="this_month" <?php if ($period == 'this_month'): echo 'selected'; endif;?>>This Month</OPTION>
		<OPTION VALUE="this_year" <?php if ($period == 'this_year'): echo 'selected'; endif;?>>This Year</OPTION>
	</SELECT>
	
</FORM>

<SCRIPT LANGUAGE=javascript>
<!--
function OnChange(dropdown)
{
	var myindex  = dropdown.selectedIndex
	var SelValue = dropdown.options[myindex].value
	var baseURL  =  '<?=$this->make_report_link('dashboard_report.php');?>'
	top.location.href = baseURL+'period='+SelValue;
    
	return true;
}
//-->
</SCRIPT>
	
