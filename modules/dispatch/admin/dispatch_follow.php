<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 19 Jul 2011 09:07:26 GMT
 */

if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

$arr_department_cat = $arr_department = array();

//Loại phòng ban
$result_department_cat =$db->query('SELECT id,title FROM '. NV_PREFIXLANG . '_' . $module_data . '_department_cat');
while($row = $result_department_cat->fetch()) {
	$arr_department_cat[$row['id']]= $row;
}

//Phòng ban
$result_department =$db->query('SELECT id,title FROM '. NV_PREFIXLANG . '_' . $module_data . '_department');
while($row1 = $result_department->fetch()) {
	$arr_department[$row1['id']]= $row1;
}


$xtpl = new XTemplate("dispatch_follow.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);

foreach ($arr_department_cat as $department_cat) {
	//$department_cat['selected'] = $department_cat['id'] == $array['type'] ? " selected=\"selected\"" : "";
	$xtpl->assign('DEPARTMENT_CAT', $department_cat);
	$xtpl->parse('main.departmentid_cat');
}

foreach ($arr_department as $department) {
	//$department_cat['selected'] = $department_cat['id'] == $array['type'] ? " selected=\"selected\"" : "";
	$xtpl->assign('DEPARTMENT', $department);
	$xtpl->parse('main.departmentid');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';