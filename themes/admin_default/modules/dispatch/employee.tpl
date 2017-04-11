<!-- BEGIN: main -->danh sách nhân viên


<div id="ablist" class="form-inline">
	ID tài khoản: <input title="{LANG.search_id}" class="form-control txt" type="text" name="uid" id="uid" value="" maxlength="11" style="width:50px" />
	<input class="btn btn-primary" name="addUser" type="button" value="Thêm nhân viên" />
	<input class="btn btn-success" name="searchUser" type="button" value="Tìm" />
</div>

<div id="pageContent">&nbsp;</div>
<script type="text/javascript">
	//<![CDATA[
	$(function() {
		$("div#pageContent").load("{MODULE_URL}={OP}&listUsers={GID}&random=" + nv_randomPassword(10));
	});
	$("input[name=searchUser]").click(function() {
		nv_open_browse("http://congvan.my/admin/index.php?language=vi&nv=users&op=getuserid&area=uid&filtersql=vUhbjls6WmTsLw0O0U6SS159KPebUPco9n33OpAl-CgQz11v-IeXqNGZUXz3ZRyxUceWyba1wqGyFg6ye97zrhmhyiBL4iP5YX6RzRZJwP4,", "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
		return false;
	});
	$("input[name=addUser]").click(function() {
		var a = $("#ablist input[name=uid]").val(), a = intval(a);
		a == 0 && ( a = "");
		$("#ablist input[name=uid]").val(a);
		if (a == "") {
			return alert("{LANG.choiceUserID}"), $("#ablist input[name=uid]").select(), false;
		}
		$("#pageContent input, #pageContent select").attr("disabled", "disabled");
		$.ajax({
			type : "POST",
			url : "{MODULE_URL}={OP}",
			data : "gid={GID}&uid=" + a + "&rand=" + nv_randomPassword(10),
			success : function(a) {
				a == "OK" ? ($("#ablist input[name=uid]").val(""), $("div#pageContent").load("{MODULE_URL}={OP}&listUsers={GID}&random=" + nv_randomPassword(10))) : alert(a);
			}
		});
		return !1;
	});
	//]]>
</script>

<!-- END: main -->