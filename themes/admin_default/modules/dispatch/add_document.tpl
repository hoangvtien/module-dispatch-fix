<!-- BEGIN: inter -->

<!-- BEGIN: error -->
<div class="alert alert-danger">
	{ERROR}
</div>
<!-- END: error -->

<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css">

<form action="{FORM_ACTION}" method="post">
	<table class="table table-striped table-bordered table-hover">
		<tbody>
			<tr>
				<td>{LANG.dis_type}</td>
				<td>
				<select class="form-control w200 dis_type" name="type">
					<!-- BEGIN: dis_type -->
					<option value="{LISTDISTYPE.id}"{LISTDISTYPE.selected}>{LISTDISTYPE.name}</option>
					<!-- END: dis_type -->
				</select></td>
			</tr>
			<tr>
				<td width="200px">{LANG.dis_name} (<span class="red">*</span>)</strong></td>
				<td><input class="form-control w400" value="{DATA.title}" name="title" id="title" maxlength="100" /><input type = "hidden" name = "id" value="{id}"></td>
			</tr>

			<tr>
				<td>{LANG.cat_parent}</td>
				<td>
				<select class="form-control w200" name="parentid">
					<!-- BEGIN: parentid -->
					<option value="{LISTCATS.id}"{LISTCATS.selected}>{LISTCATS.name}</option>
					<!-- END: parentid -->
				</select></td>
			</tr>
			<tr>
				<td>{LANG.type}</td>
				<td>
				<select class="form-control w200" name="typeid">
					<!-- BEGIN: typeid -->
					<option value="{LISTTYPES.id}"{LISTTYPES.selected}>{LISTTYPES.name}</option>
					<!-- END: typeid -->
				</select></td>
			</tr>

			<tr>
				<td>{LANG.dis_date_re}(<span class="red">*</span>)</strong></td>
				<td><input class="form-control w200 pull-left" value="{DATA.publtime}" type="text" id="publtime" name="publtime" readonly="readonly" /></td>
			</tr>

			<tr>
				<td>{LANG.dis_code}(<span class="red">*</span>)</strong></td>
				<td><input class="form-control w400" value="{DATA.number_dispatch}" name="code" id="code" maxlength="100" /></td>
			</tr>

			<tr>
				<td>{LANG.number_text_come}</td>
				<td><input class="form-control w400" value="{DATA.number_text_come}" name="number_text_come" id="number_text_come" maxlength="100" /></td>
			</tr>

			<tr>
				<td>{LANG.dis_souce}(<span class="red">*</span>)</strong></td>
				<td><input class="form-control w400" value="{DATA.from_org}" name="from_org" id="from_org" maxlength="100" /></td>
			</tr>
			<tr>
				<td >{LANG.dis_to_org}</td>
				<td><textarea class="form-control w400" name="to_org">{DATA.to_org}</textarea><span class="help-block">{LANG.org}</span></td>
			</tr>
				<tr <!-- BEGIN: dis_listdecat_none -->{CLASSLIST}<!-- END: dis_listdecat_none --> <!-- BEGIN: dis_listdecat_dis -->{CLASSLISTDIS}<!-- END: dis_listdecat_dis-->>
				<td>{LANG.to_dep_catid}</td>
				<td>
				<select class="form-control w200 selectpicker to_depcatid " name="to_depcatid[]" multiple>
					<!-- BEGIN: dis_listdecat -->
					<option value="{LISTCATDIS.id}"{LISTCATDIS.selected}>{LISTCATDIS.title}</option>
					<!-- END: dis_listdecat -->
				</select></td>
			</tr>
			<tr <!-- BEGIN: dis_listdecat_none -->{CLASSLIST}<!-- END: dis_listdecat_none --> <!-- BEGIN: dis_listdecat_dis -->{CLASSLISTDIS}<!-- END: dis_listdecat_dis-->>
				<td>{LANG.from_depid}</td>
				<td>
				<div style="padding: 4px; height: 150px; width: 400px; background: none repeat scroll 0% 0% rgb(255, 255, 255); overflow: auto; text-align: left; border: 1px solid rgb(204, 204, 204);">
					<div id="listdepid_0">
					<table>
						<tr>
							<td>
								<input  type="checkbox" value="yes" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);" />{LANG.dis_cho}
							</td>
						</tr>
						<!-- BEGIN: loop -->
						<tr>
							<td>
								<input name="deid[{ROW.id}]" value="{ROW.id}" type="checkbox" {ROW.checked} id="idcheck[]"/> {ROW.name}
							</td>
						</tr>
						<!-- END: loop -->

					</table>
				</div>
				<div id="listdepid_1">
					&nbsp;
				</div>

				</div>
				</td>
			</tr>
			<tr>
				<td>{LANG.name_signer}(<span class="red">*</span>)</strong></td>
				<td>
					<input class="form-control w400" value="{DATA.name_signer}" name="name_signer" id="name_signer" maxlength="100" />
				</td>
			</tr>
			<tr>
				<td>{LANG.name_initial}</td>
				<td>
					<input class="form-control w400" value="{DATA.name_initial}" name="name_initial" id="name_initial" maxlength="100" />
				</td>
			</tr>


			<tr>
				<td>{LANG.dis_date_iss}(<span class="red">*</span>)</strong></td>
				<td><input class="form-control w200 pull-left" value="{DATA.date_iss}" type="text" id="date_iss" name="date_iss" readonly="readonly" /></td>
			</tr>
			<tr>
				<td>{LANG.dis_date_first}(<span class="red">*</span>)</strong></td>
				<td><input class="form-control w200 pull-left" value="{DATA.date_first}" type="text" id="date_first" name="date_first" readonly="readonly" /></td>
			</tr>

			<tr>
				<td>{LANG.dis_date_die}</td>
				<td><input class="form-control w200 pull-left" value="{DATA.date_die}" type="text" id="date_die" name="date_die"/></td>
			</tr>
			<tr>
				<td>{LANG.dis_term_view}</td>
				<td><input class="form-control w200 pull-left" value="{DATA.term_view}" type="text" id="term_view" name="term_view" readonly="readonly" /></td>
			</tr>
			<tr>
				<td>{LANG.dis_content}</td>
				<td><textarea class="form-control" rows="8" name="content">{DATA.abstract}</textarea></td>
			</tr>

			<tr>
				<td>{LANG.note}</td>
				<td><textarea class="form-control" rows="8" name="note">{DATA.note}</textarea></td>
			</tr>

			<tr>
				<td>{LANG.dis_file}</td>
				<td>
					<div id="fileupload_items">
						<!-- BEGIN: fileupload -->
						<label>
							<input class="form-control w400 pull-left" style="margin-right: 5px" type="text" value="{FILEUPLOAD.value}" name="fileupload[]" id="fileupload{FILEUPLOAD.key}" style="width: 300px" maxlength="255" />
							<input class="btn btn-primary pull-left" style="margin-right: 5px" type="button" id="button{FILEUPLOAD.key}" value="{LANG.browse}" name="selectfile" onclick="nv_open_browse( '{NV_BASE_ADMINURL}index.php?{NV_NAME_VARIABLE}=upload&popup=1&area=fileupload{FILEUPLOAD.key}&path={FILES_DIR}&type=file', 'NVImg', 850, 500, 'resizable=no,scrollbars=no,toolbar=no,location=no,status=no' );return false;" />
						</label>
						<!-- END: fileupload -->
					</div>
					<script type="text/javascript">
						var file_items = '{fileupload_num}';
						var file_selectfile = '{LANG.browse}';
						var nv_base_adminurl = '{NV_BASE_ADMINURL}';
						var file_dir = '{FILES_DIR}';
					</script>
					<input class="btn btn-success" type="button" value="{LANG.add_button}" onclick="nv_file_additem();" />
				</td>
			</tr>
			<tr>
				<td>{LANG.dis_level0}</td>
				<td>
				<select class="form-control w200" name="level_important">
					<!-- BEGIN: level_important -->
					<option value="{LISTLEVEL.id}"{LISTLEVEL.selected}>{LISTLEVEL.name}</option>
					<!-- END: level_important -->
				</select></td>
			</tr>
			<tr>
				<td>{LANG.dis_reply0}</td>
				<td>
				<select class="form-control w200" name="reply">
					<!-- BEGIN: reply -->
					<option value="{LISTREPLY.id}"{LISTREPLY.selected}>{LISTREPLY.name}</option>
					<!-- END: reply -->
				</select></td>
			</tr>
			<tr>
				<td>{LANG.dis_status}</td>
				<td>
				<select class="form-control w200" name="statusid">
					<!-- BEGIN: statusid -->
					<option value="{LISTSTATUS.id}"{LISTSTATUS.selected}>{LISTSTATUS.name}</option>
					<!-- END: statusid -->
				</select></td>
			</tr>
			<tr>
				<td>{LANG.who_view}</td>
				<td>
					<!-- BEGIN: groups_view -->
						<div class="row">
							<label><input name="groups_view[]" type="checkbox" value="{groups_view.value}" {groups_view.checked} />{groups_view.title}</label>
						</div>
					<!-- END: groups_view -->
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input class="btn btn-primary" type="submit" name="submit" value="{LANG.save}" />
					<input class="btn btn-primary" type="submit" name="send" value="{LANG.dis_send}" />
				</td>
			</tr>
		</tbody>
	</table>
</form>

<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript">
	$("#publtime,#date_iss, #date_first, #date_die,#term_view").datepicker({
		showOn : "both",
		dateFormat : "dd.mm.yy",
		changeMonth : true,
		changeYear : true,
		showOtherMonths : true,
		buttonImage : nv_base_siteurl + "assets/images/calendar.gif",
		buttonImageOnly : true
	});
	$('.listdecat').css('display','none');
	$( '.dis_type' ).change(function() {
  	if($( this ).val()== 1) {
  		$('.listdecat').css('display','');
  		$('.listdecat_dis').css('display','');
  	}
  	else {
  		$('.listdecat_dis').css('display','none');
  	}
  });

  $( ".to_depcatid" ).change(function() {
  	var listdepcatid = $( this ).val();
  	$.get(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=set_todepartment&depcatid=' + listdepcatid, function(data) {
		if (data != '') {
			$('#listdepid_1').show();
			$("#listdepid_1").html(data);
			$('#listdepid_0').hide();
		} else {
			$('#listdepid_1').hide();
		}
	});
  });
</script>
<!-- END: inter -->