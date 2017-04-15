<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 19 Jul 2011 09:07:26 GMT
 */

if( !defined( 'NV_IS_FILE_ADMIN' ) )
	die( 'Stop!!!' );
$content = '';
$listdecat = $nv_Request->get_string( 'depcatid', 'get', '' );

if( $listdecat )
{
	$content = '<table>
						<tr>
							<td>
								<input id = "check_all[]" type="checkbox" value="yes" onclick="nv_checkAll(this.form, "idcheck[]", "check_all[]",this.checked);" />' . $lang_module['dis_cho'] . '
							</td>
						</tr>';

	$arr_decat = array( );
	$result = $db->query( 'SELECT * FROM ' . $db_config['prefix'] . '_' . NV_LANG_DATA . '_' . $module_data . '_department where depcatid IN (' . $listdecat . ')' );
	$id = $name = '';
	while( $row = $result->fetch( ) )
	{
		$arr_decat[$row['id']] = $row;
		$id = $row['id'];
		$name = $row['title'];
		$content .= '<tr>
	 <td>
	 <input name="deid[' . $id . ']" value="' . $id . '" type="checkbox" id="idcheck[]"/> ' . $name . '
	 </td>
	 </tr>';
	}
	$content .= '</table>';
}

include NV_ROOTDIR . '/includes/header.php';
echo $content;
include NV_ROOTDIR . '/includes/footer.php';
