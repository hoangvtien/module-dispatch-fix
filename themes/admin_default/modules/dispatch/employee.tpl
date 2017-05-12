<!-- BEGIN: userlist -->
<div id="ablist" class="form-inline">
	{LANG.userid}: <input title="{LANG.search_id}" class="form-control txt" type="text" name="uid" id="uid" value="" maxlength="11" style="width:50px" />

	<input class="btn btn-success" name="searchUser" type="button" value="Tìm" />

</div>
<div class="well">{LANG.ofice}:
 <select class="form-control w200" name="office">
       <option value="0">Văn thư</option>
        <option value="1">Trưởng bộ phận</option>
       <option value="2" {LISTCATS.selected}>Nhân viên</option>
    </select>
    <br />
    <div>
    	 <input class="btn btn-primary" name="addUser" type="submit" value="{LANG.addemployee}" />
    </div>
</div>
<div id="id_members">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover">
	<col class="w50"/>
	<col span="3" />
	<col class="w250"/>
	<thead>
		<tr>
			<th class="text-center"> {LANG.userid} </th>
			<th> Tài khoản </th>
			<th> Họ tên </th>
			<th> Email </th>
			<th> Chức vụ </th>
			<th class="text-center"> Thao tác </th>
		</tr>
	</thead>
	<tbody>
		<!-- BEGIN: data -->
		<tr>
			<td class="text-center"> {DATA.userid} </td>
			<td><a title="{LANG.detail}" href="{MODULE_URL}=edit&userid={LOOP.userid}">{DATA.username}</a></td>
			<td>{DATA.fullname}</td>
			<td><a href="mailto:{LOOP.email}">{DATA.email}</a></td>
			<td>{DATA.office}</td>
			<td class="text-center">
            <i class="fa fa-edit"></i> <a class="promote" href="javascript:void(0);" data-id="{DATA.userid}">{LANG.edit}</a> -
			<i class="fa fa-trash-o fa-lg"></i> <a class="deletemember" href="javascript:void(0);" title="{DATA.userid}">{LANG.delete}</a>
			</td>
		</tr>
		<!-- END: data -->
	</tbody>
</table>
</div>
<div id="pageContent">&nbsp;</div>
<script type="text/javascript">
	//<![CDATA[
	$(function() {
		//$("div#pageContent").load("{MODULE_URL}={OP}&listUsers={GID}&random=" + nv_randomPassword(10));
	});
	$("input[name=searchUser]").click(function() {
		nv_open_browse("/admin/index.php?language=vi&nv=users&op=getuserid&area=uid&filtersql={FILTERSQL},", "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
		return false;
	});
	$("input[name=addUser]").click(function() {
		var a = $("#ablist input[name=uid]").val(), a = intval(a);
		var b = $("#ablist input[name=office]").val(), b = intval(b);
		a == 0 && ( a = "");
		$("#ablist input[name=uid]").val(a);
		if (a == "") {
			return alert("{LANG.choiceUserID}"), $("#ablist input[name=uid]").select(), false;
		}
		$("#pageContent input, #pageContent select").attr("disabled", "disabled");
		$.ajax({
			type : "POST",
			url : "{MODULE_URL}",
			data : "deid={GID}&uid=" + a + "&office=" + b + "&rand=" + nv_randomPassword(10),
			success : function(a) {
				//a == "OK" ? ($("#ablist input[name=uid]").val(""), $("div#pageContent").load("{MODULE_URL}&deid={GID}&random=" + nv_randomPassword(10))) : alert(a);
			}
		});
		location.reload();
		return !1;
	});
	$("a.deletemember").click(function() {
	confirm("{LANG.delConfirm} ?") && $.ajax({
		type : "POST",
		url : "{MODULE_URL}",
		data : "deid={GID}&exclude=" + $(this).attr("title"),
		success : function(a) {
			//a == "OK" ? $("div#pageContent").load("{MODULE_URL}={OP}&listUsers={GID}&random=" + nv_randomPassword(10)) : alert(a);
		}
	});
	location.reload();
	return !1;
});
	//]]>
</script>
<!-- END: userlist -->
