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
		<div class="col-md-6">
			{LANG.departments_type} &nbsp;&nbsp;
			<select class="form-control department_cat" name="department_cat">
				<option value="0">{LANG.departments_type}</option>
				<!-- BEGIN: departmentid_cat -->
				<option value="{DEPARTMENT_CAT.id}">{DEPARTMENT_CAT.title}</option>
				<!-- END: departmentid_cat -->
			</select>
		</div>
		<div id="listdepid_1"></div>
		<div class="col-md-6">
			{LANG.dis} &nbsp;&nbsp;
			<select class="form-control" name="type">
				<option value="0">{LANG.dis}</option>
				<!-- BEGIN: typeid -->
				<option value="{DIS_TYPE.id}">{DIS_TYPE.title}</option>
				<!-- END: typeid -->
			</select>
		</div>
		<div class="col-md-6">
			{LANG.from}
			<input class="form-control" value="{FROM}" type="text" id="from" name="from" readonly="readonly"/>
		</div>
		<div class="col-md-6">
			{LANG.to}
			<input class="form-control" value="{TO}" type="text" id="to" name="to" readonly="readonly" />
		</div>
		<div class="col-md-6">
			{LANG.dis_date_term_view} &nbsp;&nbsp;
			<select class="form-control" name="department">
				<!-- BEGIN: term_viewid -->
				<option value="{TERMVIEW.id}">{TERMVIEW.name}</option>
				<!-- END: term_viewid -->
			</select>
		</div>

		<input class="btn btn-primary" type="submit" value="Search" name="timkiem">
	</form>
</div>
<script>
	$(".department_cat").change(function() {
		var listdepcatid = $(this).val();
		$.get(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=dispatch_follow&set_todepartment=1&depcatid=' + listdepcatid, function(data) {
			if (data != '') {
				alert(data);
				$('#listdepid_1').show();
				$("#listdepid_1").html(data);
				$('#listdepid_0').hide();
			}
		});
	});
</script>

<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<caption>
			{TABLE_CAPTION}
		</caption>
		<colgroup>
			<col class="w250" />
			<col span="4" />
			<col class="w100" />
			<col class="w100" />
			<col class="w150" />
		</colgroup>
		<thead>
			<tr>
				<th> {LANG.dis_name} </th>
				<th> {LANG.departments} </th>
				<th> {LANG.viewers} </th>
				<th> {LANG.positions} </th>
				<th> {LANG.viewers_time} </th>
				<th class="text-center"> {LANG.viewers_status} </th>
				<th class="text-center"> {LANG.dis_date_term_view} </th>
				<th class="text-center"> {LANG.feature} </th>

			</tr>
		</thead>
		<tbody>
			<!-- BEGIN: row -->
			<tr>
				<td><a href="{ROW.link_detail}" target="_blank"> {ROW.title0} </a></td>
				<td> {ROW.code} </td>
				<td><a href="{ROW.link_type}">{ROW.type}</a></td>
				<td><a href="{ROW.link_cat}">{ROW.cat}</a></td>
				<td><a href="{ROW.link_singer}">{ROW.from_signer}</a></td>
				<td class="text-center"> {ROW.from_time} </td>
				<td class="text-center">{ROW.status}</td>
				<td class="text-center"><em class="fa fa-edit fa-lg">&nbsp;</em><a href="{EDIT_URL}" {DISABLED_DIS}>{GLANG.edit}</a> &nbsp;&nbsp; - <em class="fa fa-trash-o fa-lg">&nbsp;</em><a href="javascript:void(0);" onclick="nv_pro_del({ROW.id});" {DISABLED_DIS}>{GLANG.delete}</a></td>

			</tr>
			<!-- END: row -->
		<tbody>
			<!-- BEGIN: generate_page -->
			<tfoot>
				<tr>
					<td colspan="9"> {GENERATE_PAGE} </td>
				</tr>
			</tfoot>
			<!-- END: generate_page -->
	</table>
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