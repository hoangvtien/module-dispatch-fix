<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 19 Jul 2011 09:07:26 GMT
 */

if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

$arr_department_cat = $arr_department = $arr_type = $arr_term_view = array();

//Hạn xem
$arr_term_view = array(
    '0' => array(
        'id' => '0',
        'name' => $lang_module['dis_date_term_view']
    ),
    '1' => array(
        'id' => '1',
        'name' => $lang_module['dis_expired']
    ),
    '2' => array(
        'id' => '2',
        'name' => $lang_module['dis_unexpired']
    )
	);

//Loại phòng ban
$result_department_cat =$db->query('SELECT id,title FROM '. NV_PREFIXLANG . '_' . $module_data . '_department_cat');
while($row = $result_department_cat->fetch()) {
	$arr_department_cat[$row['id']]= $row;
}

//Loại công văn
$result_type =$db->query('SELECT id,title FROM '. NV_PREFIXLANG . '_' . $module_data . '_type');
while($row = $result_type->fetch()) {
	$arr_type[$row['id']]= $row;
}

//Phòng ban
$decat = $htmldecat = '';
if ($nv_Request->isset_request('set_todepartment', 'get')) {
	$htmldecat = '<div class="col-md-6">'. $lang_module['departments'] . '&nbsp;&nbsp; <select class="form-control" name="department">
			<option value="0">'.$lang_module['departments'].'</option>';
	$decat = $nv_Request->get_int('depcatid', 'get',0);
	$result_department =$db->query('SELECT id,title FROM '. NV_PREFIXLANG . '_' . $module_data . '_department WHERE depcatid='.$decat);
	while($row = $result_department->fetch()) {
	$htmldecat .= '<option value="'.$row['id'].'">'.$row['title'].'</option>';
}
$htmldecat .= '</select></div>';

	die($htmldecat);

}
$result_department =$db->query('SELECT id,title FROM '. NV_PREFIXLANG . '_' . $module_data . '_department');
while($row = $result_department->fetch()) {
	$arr_department[$row['id']]= $row;
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
	$xtpl->assign('DEPARTMENT', $department);
	$xtpl->parse('main.departmentid');
}

foreach ($arr_type as $type) {
	$xtpl->assign('DIS_TYPE', $type);
	$xtpl->parse('main.typeid');
}

//Hạn xem
foreach($arr_term_view as $view) {
	$xtpl->assign('TERMVIEW', $view);
	$xtpl->parse('main.term_viewid');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';