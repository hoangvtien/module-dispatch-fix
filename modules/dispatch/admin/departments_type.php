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

/**
 * nv_del_cat()
 *
 * @param mixed $catid
 * @return
 */
function nv_del_cat($catid)
{
    global $db, $module_data, $admin_info;
//Chỗ này cần xem xét chuyển dữ liệu phòng ban sang loại phòng ban khác hoặc xóa hết dữ liệu liên quan
    $sql = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_department WHERE depcatid=" . $catid;
    $db->query($sql);
    $sql = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_department_cat WHERE id=" . $catid;
    $db->query($sql);

    nv_insert_logs(NV_LANG_DATA, $module_data, "delete dispatch", '', $admin_info['userid'], '');
}

$array = array();
$error = "";

//thêm loại phòng ban
if ($nv_Request->isset_request('add', 'get')) {
    $page_title = $lang_module['detype_add'];
    $is_error = false;
    if ($nv_Request->isset_request('submit', 'post')) {

        $array['title'] = $nv_Request->get_title('title', 'post', '', 1);
        $array['alias'] = $nv_Request->get_title('alias', 'post', '');
        $array['alias'] = ($array['alias'] == "") ? change_alias($array['title']) : change_alias($array['alias']);

        if (empty($array['title'])) {
            $error = $lang_module['detype_err_notitle'];
            $is_error = true;
        } else {
            if (!$is_error) {
                $sql = "SELECT COUNT(*) AS count FROM " . NV_PREFIXLANG . "_" . $module_data . "_department_cat WHERE alias=" . $db->quote($array['alias']);
                $result = $db->query($sql);
                $count = $result->fetchColumn();

                if ($count) {
                    $error = $lang_module['detype_err_exist'];
                    $is_error = true;
                }
            }
        }

        if (!$is_error) {
            $sql = "SELECT MAX(weight) AS new_weight FROM " . NV_PREFIXLANG . "_" . $module_data . "_department_cat";
            $result = $db->query($sql);
            $new_weight = $result->fetchColumn();
            $new_weight = (int) $new_weight;
            $new_weight++;

            $sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_department_cat VALUES (
            NULL,
            " . $db->quote($array['title']) . ",
            " . $db->quote($array['alias']) . ",
            " . $new_weight . "
            )";

            $decat_id = $db->insert_id($sql);

            if (!$decat_id) {
                $error = $lang_module['de_err_save'];
                $is_error = true;
            } else {
                nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['detype_add'], $array['title'], $admin_info['userid']);
                $nv_Cache->delMod($module_name);
                Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=departments_type");
                exit();
            }
        }
    } else {
        $array['title'] = "";
        $array['alias'] = "";
    }

    $xtpl = new XTemplate("detype_add.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
    $xtpl->assign('FORM_ACTION', NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "&amp;add=1");
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('DATA', $array);

    if (!empty($error)) {
        $xtpl->assign('ERROR', $error);
        $xtpl->parse('main.error');
    }

    $xtpl->parse('main');
    $contents = $xtpl->text('main');

    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';

    exit();
}

//Sua loại phòng ban
if ($nv_Request->isset_request('edit', 'get')) {
    $page_title = $lang_module['detype_edit'];
    $deid = $nv_Request->get_int('deid', 'get', 0);

    if (empty($deid)) {
        Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=departments_type");
        exit();
    }

    $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_department_cat WHERE id=" . $deid;
    $result = $db->query($sql);
    $numcat = $result->rowCount();

    if ($numcat != 1) {
        Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=departments_type");
        exit();
    }

    $row = $result->fetch();

    $is_error = false;

    if ($nv_Request->isset_request('submit', 'post')) {
        $array['title'] = $nv_Request->get_title('title', 'post', '', 1);
        $array['alias'] = $nv_Request->get_title('alias', 'post', '');
        $array['alias'] = ($array['alias'] == "") ? change_alias($array['title']) : change_alias($array['alias']);

        if (empty($array['title'])) {
            $error = $lang_module['detype_err_notitle'];
            $is_error = true;
        } else {
            if (!$is_error) {
                $sql = "SELECT COUNT(*) AS count FROM " . NV_PREFIXLANG . "_" . $module_data . "_department_cat WHERE id!=" . $deid . " AND alias=" . $db->quote($array['alias']);
                $result = $db->query($sql);
                $count = $result->fetchColumn();
                if ($count) {
                    $error = $lang_module['detype_err_exist'];
                    $is_error = true;
                }
            }
        }

        if (!$is_error) {
            $new_weight = $row['weight'];

            $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_department_cat SET
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
                nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['detype_edit'], $array['title'], $admin_info['userid']);
                Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=departments_type");
                exit();
            }
        }
    } else {
        $array['title'] = $row['title'];
        $array['alias'] = $row['alias'];
    }
    $xtpl = new XTemplate("detype_add.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
    $xtpl->assign('FORM_ACTION', NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "&amp;edit=1&amp;deid=" . $deid);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('DATA', $array);

    if (!empty($error)) {
        $xtpl->assign('ERROR', $error);
        $xtpl->parse('main.error');
    }

    $xtpl->parse('main');
    $contents = $xtpl->text('main');

    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';

    exit();
}

//Xóa loại phòng ban
if ($nv_Request->isset_request('del', 'post')) {
    if (!defined('NV_IS_AJAX')) die('Wrong URL');

    $deid = $nv_Request->get_int('deid', 'post', 0);

    if (empty($deid)) {
        die('NO');
    }

    $sql = "SELECT COUNT(*) AS count FROM " . NV_PREFIXLANG . "_" . $module_data . "_department_cat WHERE id=" . $deid;
    $result = $db->query($sql);
    list ($count) = $result->fetch(3);

    if ($count != 1) {
        die('NO');
    }

    nv_del_cat($deid);
    $nv_Cache->delMod($module_name);

    die('OK');
}
//Chinh thu tu loại phòng ban
if ($nv_Request->isset_request('changeweight', 'post')) {
    if (!defined('NV_IS_AJAX')) die('Wrong URL');

    $deid = $nv_Request->get_int('deid', 'post', 0);
    $new = $nv_Request->get_int('new', 'post', 0);

    if (empty($deid)) die('NO');

    $query = "SELECT id FROM " . NV_PREFIXLANG . "_" . $module_data . "_department_cat WHERE id!=" . $deid . " ORDER BY weight ASC";
    $result = $db->query($query);
    $weight = 0;
    while ($row = $result->fetch()) {
        $weight++;
        if ($weight == $new) $weight++;
        $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_department_cat SET weight=" . $weight . " WHERE id=" . $row['id'];
        $db->query($sql);
    }
    $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_department_cat SET weight=" . $new . " WHERE id=" . $deid;
    $db->query($sql);

    $nv_Cache->delMod($module_name);

    die('OK');
}

//Danh sach loại phong ban
$page_title = $lang_module['detype_list'];

$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_department_cat ORDER BY weight ASC";
$result = $db->query($sql);
$num = $result->rowCount();

if (!$num) {
    Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=departments_type&add=1");
    exit();
}

$list = array();
$a = 0;

while ($row = $result->fetch()) {
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
        'weight' => $weight,
        'class' => $class
    );

    $a++;
}
$caption = $lang_module['detype_list'];
$xtpl = new XTemplate("detype_list.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
$xtpl->assign('ADD_NEW_DE', NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=departments_type&amp;add=1");
$xtpl->assign('TABLE_CAPTION', $caption);
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

    $xtpl->assign('EDIT_URL', NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=departments_type&amp;edit=1&amp;deid=" . $row['id']);
    $xtpl->parse('main.row');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';