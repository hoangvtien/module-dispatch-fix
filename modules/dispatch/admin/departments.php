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
function nv_FixWeightCat($parentid = 0)
{
    global $db, $module_data;

    $sql = "SELECT id FROM " . NV_PREFIXLANG . "_" . $module_data . "_department ORDER BY weight ASC";
    $result = $db->query($sql);
    $weight = 0;
    while ($row = $result->fetch()) {
        $weight++;
        $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_department SET weight=" . $weight . " WHERE id=" . $row['id']);
    }
}

/**
 * nv_del_cat()
 *
 * @param mixed $catid
 * @return
 */
function nv_del_cat($deid)
{
	//cần chỉnh lại khi xóa một phòng ban sẽ xóa hết dữ liệu hay chuyển sang một phòng ban thay thế khác
    global $db, $module_data, $admin_info;

   /* $sql = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_document WHERE from_depid=" . $deid;
    $db->query($sql);

    $sql = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_de_do WHERE deid=" . $deid;
    $db->query($sql);

    $sql = "SELECT id FROM " . NV_PREFIXLANG . "_" . $module_data . "_departments WHERE parentid=" . $deid;
    $result = $db->query($sql);
    while (list ($id) = $result->fetch(3)) {
        nv_del_cat($id);
    }*/

    $sql = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_department WHERE id=" . $deid;
    $db->query($sql);
    nv_insert_logs(NV_LANG_DATA, $module_data, "delete dispatch", '', $admin_info['userid'], '');
}

$array = array();
$error = "";

//them chu de
if ($nv_Request->isset_request('add', 'get')) {
    $page_title = $lang_module['de_add'];
    $is_error = false;
    if ($nv_Request->isset_request('submit', 'post')) {
        $array['parentid'] = $nv_Request->get_int('parentid', 'post', 0);
        $array['title'] = $nv_Request->get_title('title', 'post', '', 1);
        $array['alias'] = $nv_Request->get_title('alias', 'post', '');
        $array['alias'] = ($array['alias'] == "") ? change_alias($array['title']) : change_alias($array['alias']);

        if (empty($array['title'])) {
            $error = $lang_module['de_err_notitle'];
            $is_error = true;
        } else {
            if (!empty($array['parentid'])) {
                $sql = "SELECT COUNT(*) AS count FROM " . NV_PREFIXLANG . "_" . $module_data . "_department_cat WHERE id=" . $array['parentid'];
                $result = $db->query($sql);
                $count = $result->fetchColumn();

                if (!$count) {
                    $error = $lang_module['de_err_noexist'];
                    $is_error = true;
                }
            }

            if (!$is_error) {
                $sql = "SELECT COUNT(*) AS count FROM " . NV_PREFIXLANG . "_" . $module_data . "_department WHERE alias=" . $db->quote($array['alias']);
                $result = $db->query($sql);
                $count = $result->fetchColumn();

                if ($count) {
                    $error = $lang_module['de_err_exist'];
                    $is_error = true;
                }
            }
        }
		if (!$is_error) {
            $sql = "SELECT MAX(weight) AS new_weight FROM " . NV_PREFIXLANG . "_" . $module_data . "_department";
            $result = $db->query($sql);
            $new_weight = $result->fetchColumn();
            $new_weight = (int) $new_weight;
            $new_weight++;

            $sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_department VALUES (
            NULL,
            " . $array['parentid'] . ",
            " . $db->quote($array['title']) . ",
            " . $db->quote($array['alias']) . ",
            " . $new_weight . "
            )";

            $deid = $db->insert_id($sql);

            if (!$deid) {
                $error = $lang_module['de_err_save'];
                $is_error = true;
            } else {
                nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['de_add'], $array['title'], $admin_info['userid']);
                $nv_Cache->delMod($module_name);
                Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=departments");
                exit();
            }
        }
    } else {
        $array['parentid'] = 0;
        $array['title'] = "";
        $array['alias'] = "";
    }
	$sql = "SELECT id, title FROM " . NV_PREFIXLANG . "_" . $module_data . "_department_cat";
    $result = $db->query($sql);
	while($row = $result->fetch()){
		 $listdes[] = array(
	            'id' => $row['id'],
	            'name' => $row['title'],
	            'selected' => ""
	    );
	}

    $xtpl = new XTemplate("de_add.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
    $xtpl->assign('FORM_ACTION', NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "&amp;add=1");
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('DATA', $array);

    if (!empty($error)) {
        $xtpl->assign('ERROR', $error);
        $xtpl->parse('main.error');
    }

    foreach ($listdes as $cat) {
        $xtpl->assign('LISTCATS', $cat);
        $xtpl->parse('main.parentid');
    }

    $xtpl->parse('main');
    $contents = $xtpl->text('main');

    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';

    exit();
}

//Sua chu de
if ($nv_Request->isset_request('edit', 'get')) {
    $page_title = $lang_module['de_edit'];

    $deid = $nv_Request->get_int('deid', 'get', 0);

    if (empty($deid)) {
        Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=departments");
        exit();
    }

    $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_department WHERE id=" . $deid;
    $result = $db->query($sql);
    $numcat = $result->rowCount();

    if ($numcat != 1) {
        Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=departments");
        exit();
    }

    $row = $result->fetch();

    $is_error = false;

    if ($nv_Request->isset_request('submit', 'post')) {
        $array['parentid'] = $nv_Request->get_int('parentid', 'post', 0);
        $array['title'] = $nv_Request->get_title('title', 'post', '', 1);
        $array['alias'] = $nv_Request->get_title('alias', 'post', '');
        $array['alias'] = ($array['alias'] == "") ? change_alias($array['title']) : change_alias($array['alias']);

        if (empty($array['title'])) {
            $error = $lang_module['cat_err_notitle'];
            $is_error = true;
        } else {
            if (!empty($array['parentid'])) {
                $sql = "SELECT COUNT(*) AS count FROM " . NV_PREFIXLANG . "_" . $module_data . "_department_cat WHERE id=" . $array['parentid'];
                $result = $db->query($sql);
                $count = $result->fetchColumn();

                if (!$count) {
                    $error = $lang_module['de_err_noexist'];
                    $is_error = true;
                }
            }

            if (!$is_error) {
                $sql = "SELECT COUNT(*) AS count FROM " . NV_PREFIXLANG . "_" . $module_data . "_department WHERE id!=" . $deid . " AND alias=" . $db->quote($array['alias']);
                $result = $db->query($sql);
                $count = $result->fetchColumn();
                if ($count) {
                    $error = $lang_module['de_err_exist'];
                    $is_error = true;
                }
            }
        }

        if (!$is_error) {
            if ($array['parentid'] != $row['parentid']) {
                $sql = "SELECT MAX(weight) AS new_weight FROM " . NV_PREFIXLANG . "_" . $module_data . "_department WHERE depcatid=" . $array['parentid'];
                $result = $db->query($sql);
                $new_weight = $result->fetchColumn();
                $new_weight = (int) $new_weight;
                $new_weight++;
            } else {
                $new_weight = $row['weight'];
            }

            $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_department SET
            depcatid=" . $array['parentid'] . ",
            title=" . $db->quote($array['title']) . ",
            alias=" . $db->quote($array['alias']) . ",
            weight=" . $new_weight . "
            WHERE id=" . $deid;
            $result = $db->query($sql);

            if (!$result) {
                $error = $lang_module['de_err_update'];
                $is_error = true;
            } else {
                $nv_Cache->delMod($module_name);
                nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['cat_edit'], $array['title'], $admin_info['userid']);
                Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=departments");
                exit();
            }
        }
    } else {
        $array['title'] = $row['title'];
        $array['alias'] = $row['alias'];
    }

   $sql = "SELECT id, title FROM " . NV_PREFIXLANG . "_" . $module_data . "_department_cat";
    $result = $db->query($sql);
	while($row1 = $result->fetch()){
		 $listdes[] = array(
	            'id' => $row1['id'],
	            'name' => $row1['title'],
	            'selected' => $row['depcatid'] == $row1['id'] ? " selected=\"selected\"" : "",
            	'checked' => $row['depcatid'] == $row1['id'] ? " checked=\"checked\"" : ""
	    );
	}

    $xtpl = new XTemplate("de_add.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
    $xtpl->assign('FORM_ACTION', NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "&amp;edit=1&amp;deid=" . $deid);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('DATA', $array);

    if (!empty($error)) {
        $xtpl->assign('ERROR', $error);
        $xtpl->parse('main.error');
    }

    foreach ($listdes as $cat) {
        $xtpl->assign('LISTCATS', $cat);
        $xtpl->parse('main.parentid');
    }

    $xtpl->parse('main');
    $contents = $xtpl->text('main');

    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';

    exit();
}

//Xoa pong ban
if ($nv_Request->isset_request('del', 'post')) {
    if (!defined('NV_IS_AJAX')) die('Wrong URL');

    $deid = $nv_Request->get_int('deid', 'post', 0);

    if (empty($deid)) {
        die('NO');
    }
    nv_del_cat($deid);
    nv_FixWeightCat($parentid);
    $nv_Cache->delMod($module_name);

    die('OK');
}
//Chinh thu tu chu de
if ($nv_Request->isset_request('changeweight', 'post')) {
    if (!defined('NV_IS_AJAX')) die('Wrong URL');

    $deid = $nv_Request->get_int('deid', 'post', 0);
    $new = $nv_Request->get_int('new', 'post', 0);

    if (empty($deid)) die('NO');
    $query = "SELECT id FROM " . NV_PREFIXLANG . "_" . $module_data . "_department WHERE id!=" . $deid . " ORDER BY weight ASC";
    $result = $db->query($query);
    $weight = 0;
    while ($row = $result->fetch()) {
        $weight++;
        if ($weight == $new) $weight++;
        $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_department SET weight=" . $weight . " WHERE id=" . $row['id'];
        $db->query($sql);
    }
    $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_department SET weight=" . $new . " WHERE id=" . $deid;
    $db->query($sql);

    $nv_Cache->delMod($module_name);

    die('OK');
}

//Danh sach phong ban
$page_title = $lang_module['de_list'];

$pid = $nv_Request->get_int('pid', 'get', 0);

$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_department ORDER BY weight ASC";
$result = $db->query($sql);
$num = $result->rowCount();

if (!$num) {
    Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=departments&add=1");
    exit();
}
$list = array();
$a = 0;

while ($row = $result->fetch()) {
	$sql2 = "SELECT title FROM " . NV_PREFIXLANG . "_" . $module_data . "_department_cat WHERE id=" . $row['depcatid'];
	$result2 = $db->query($sql2);
	$parentid = $result2->fetch();
	$parentid = $parentid['title'];
    $weight = array();
    for ($i = 1; $i <= $num; $i++) {
        $weight[$i]['title'] = $i;
        $weight[$i]['pos'] = $i;
        $weight[$i]['selected'] = ($i == $row['weight']) ? " selected=\"selected\"" : "";
    }

    $class = ($a % 2) ? " class=\"second\"" : "";

    $list[$row['id']] = array(
        'id' => (int) $row['id'],
        'title' => $row['title'],
        'titlelink' => NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;deid=" . $row['id'],
        'parentid' => $parentid,
        'weight' => $weight,
        'class' => $class
    );

    $a++;
}

$xtpl = new XTemplate("de_list.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
$xtpl->assign('ADD_NEW_DE', NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=departments&amp;add=1");

$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);

foreach ($list as $row) {
    $xtpl->assign('ROW', $row);

    foreach ($row['weight'] as $weight) {
        $xtpl->assign('WEIGHT', $weight);
        $xtpl->parse('main.row.weight');
    }

    $xtpl->assign('EDIT_URL', NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=departments&amp;edit=1&amp;deid=" . $row['id']);
    $xtpl->parse('main.row');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';