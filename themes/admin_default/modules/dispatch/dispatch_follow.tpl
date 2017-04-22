<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger">
	{ERROR}
</div>
<!-- END: error -->
<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css">
<h1>Theo dõi công văn</h1>
<div class="well">
	<form class="form-inline" action="{FORM_ACTION}" method="get">
		<input type="hidden" name ='nv' value={MODULE_NAME}>
		<input type="hidden" name ='op' value={OP}>
		{LANG.departments_type} &nbsp;&nbsp;
		<select class="form-control" name="department">
			<!-- BEGIN: departmentid_cat -->
			<option value="{DEPARTMENT_CAT.id}">{DEPARTMENT_CAT.title}</option>
			<!-- END: departmentid_cat -->
		</select>
		{LANG.departments} &nbsp;&nbsp;
		<select class="form-control" name="department">
			<!-- BEGIN: departmentid -->
			<option value="{DEPARTMENT.id}">{DEPARTMENT.title}</option>
			<!-- END: departmentid -->
		</select>
		{LANG.dis} &nbsp;&nbsp;
		<select class="form-control" name="type">
			<!-- BEGIN: typeid -->
			<option value="{LISTTYPES.id}"{LISTTYPES.selected}>{LISTTYPES.name}</option>
			<!-- END: typeid -->
		</select>
		{LANG.from}
		<input class="form-control" value="{FROM}" type="text" id="from" name="from" readonly="readonly"/>
		{LANG.to}
		<input class="form-control" value="{TO}" type="text" id="to" name="to" readonly="readonly" />
		{LANG.dis_date_term_view} &nbsp;&nbsp;
		<select class="form-control" name="department">
			<!-- BEGIN: typeid -->
			<option value="{LISTTYPES.id}"{LISTTYPES.selected}>{LISTTYPES.name}</option>
			<!-- END: typeid -->
		</select>
		<input class="btn btn-primary" type="submit" value="Search" name="timkiem">
	</form>
</div>

<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript">
	$("#from,#to").datepicker({
		showOn : "both",
		dateFormat : "dd.mm.yy",
		changeMonth : true,
		changeYear : true,
		showOtherMonths : true,
		buttonImage : nv_base_siteurl + "assets/images/calendar.gif",
		buttonImageOnly : true
	});
</script>

<!-- END: main -->