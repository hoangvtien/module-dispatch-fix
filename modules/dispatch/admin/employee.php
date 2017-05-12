<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 19 Jul 2011 09:07:26 GMT
 */

if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

/**
 * nv_FixWeightCat()
 *
 * @param integer $parentid
 * @return
 */

$array = array();
$error = "";

// Danh sach nhân viên của phòng
if ($nv_Request->isset_request('deid', 'get')) {
	$array_data = array();
    $deid= $nv_Request->get_int('deid', 'get', 0);

	$sql = 'SELECT username, first_name, last_name, email, '. NV_USERS_GLOBALTABLE . '.userid, office FROM ' . NV_PREFIXLANG . '_' . $module_data . '_user, ' . NV_USERS_GLOBALTABLE . ' WHERE ' . NV_USERS_GLOBALTABLE . '.userid=' . NV_PREFIXLANG . '_' . $module_data . '_user.userid AND iddepart =' . $deid;
   	$result = $db->query($sql);
	$office = array($lang_module['paper_handling'],$lang_module['manage'],$lang_module['other_emplyee']);
	while($row = $result->fetch()){
		$array_data[] = array(
                'username' => $row['username'],
                'fullname' => nv_show_name_user($row['first_name'], $row['last_name'], $row['username']),
                'email' => $row['email'],
                'link' => '',
                'userid' => $row['userid'],
                'office' => $office[$row['office']]
            );
	}

 	$xtpl = new XTemplate("employee.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
    $xtpl->assign('FORM_ACTION', NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "&amp;add=1");
    $xtpl->assign('LANG', $lang_module);

    $filtersql = ' userid NOT IN (SELECT userid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_user WHERE iddepart=' . $deid . ')';
	foreach($array_data as $data){
		$xtpl->assign('DATA', $data);
		$xtpl->parse('userlist.data');
	}

    $xtpl->assign('FILTERSQL', $crypt->encrypt($filtersql, NV_CHECK_SESSION));
    $xtpl->assign('GID', $deid);
	$xtpl->assign('MODULE_URL', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );

    $xtpl->parse('userlist');
    $contents = $xtpl->text('userlist');
}
/*if ($nv_Request->isset_request('listUsers', 'get')) {
	 $deid= $nv_Request->get_int('listUsers', 'get', 0);
	$sql = 'SELECT username, first_name, last_name, email, '. NV_USERS_GLOBALTABLE . '.userid, office FROM ' . NV_PREFIXLANG . '_' . $module_data . '_user, ' . NV_USERS_GLOBALTABLE . ' WHERE ' . NV_USERS_GLOBALTABLE . '.userid=' . NV_PREFIXLANG . '_' . $module_data . '_user.userid AND iddepart =' . $deid;
   	$result = $db->query($sql);

	while($row = $result->fetch()){
		$array_data[] = array(
                'username' => $row['username'],
                'fullname' => nv_show_name_user($row['first_name'], $row['last_name'], $row['username']),
                'email' => $row['email'],
                'link' => '',
                'userid' => $row['userid'],
                'office' => $row['office']
            );
	}
	foreach($array_data as $data){
		$xtpl->assign('DATA', $data);
		$xtpl->parse('user.data');
		$xtpl->parse('user');
    	$xtpl->out('user');
    	exit();
	}
}*/

    $page_title = $lang_module['employee_list'];
    $is_error = false;
	$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
	$xtpl->assign('LANG', $lang_module);
	$xtpl->assign('GLANG', $lang_global);
	$xtpl->assign('TEMPLATE', $global_config['module_theme']);
	$xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
	$xtpl->assign('OP', $op);
	$a= NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE;

  // Them thanh vien vao nhom
if ($nv_Request->isset_request('deid, uid', 'post,get')) {
    $deid = $nv_Request->get_int('deid', 'post', 0);
    $uid = $nv_Request->get_int('uid', 'post', 0);
	$office = $nv_Request->get_int('office', 'post', 0);
     $sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_user VALUES (
            " . $uid . ",
            " . $deid . ",
            " . $office . "
            )";

    $id = $db->insert_id($sql);
    $nv_Cache->delMod($module_name);
    nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['addMemberToDepart'], 'Member Id: ' . $uid . ' Department ID: ' . $deid, $admin_info['userid']);

    die('OK');
}
if ($nv_Request->isset_request('deid,exclude', 'post,get')) {
    $deid = $nv_Request->get_int('deid', 'post', 0);
    $uid = $nv_Request->get_int('exclude', 'post', 0);
	$sql = 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_user WHERE iddepart=' . $deid . ' AND userid=' . $uid;
	$db->query($sql);
	nv_insert_logs(NV_LANG_DATA, $module_data, "delete employee", '', $admin_info['userid'], '');
	die('OK');
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';