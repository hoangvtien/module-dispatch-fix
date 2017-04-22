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

$array['parentid'] = $catid = $array['type'] = $array['from_signer'] = $array['to_depid'] = $array['to_depcatid'] = 0;
$arr_de['parentid'] = $array['statusid'] = $deid = $id = $array['level_important'] = $array['reply'] = $array['deid'] = 0;
$arr_imgs = $arr_img = $list_de = $lis = $listde = $listdecat = $to_depcatid = $_to_depcatid = $arr_deid = $_arr_deid = array( );
$array['publtime'] = $array['term_view'] = $array['date_iss'] = $array['date_first'] = $array['date_die'] = $check = $to_person = $to_recipient = $error = '';
$array['groups_view'] = 6;
$id = $nv_Request->get_int( 'id', 'get', 0 );

// System groups user
$groups_list = nv_groups_list( );

$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_rows WHERE id=" . $id;
$result = $db->query( $sql );
$num = $result->rowCount( );
if( $num > 0 )
{
	$array = $result->fetch( );
	$array['parentid'] = $array['idfield'];
	$array['statusid'] = $array['status'];
	$array['deid'] = $array['to_depid'];
	$array['to_depcatid'] = $array['dep_catid'];
	$arr_imgs = explode( ',', $array['attach_file'] );

	/*$sql1 = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_de_do WHERE doid=" . $id;

	 $result1 = $db->query($sql1);
	 $nu = $result1->rowCount();
	 if ($nu > 0) {
	 while ($r = $result1->fetch()) {
	 $listde[$r['deid']] = $r['deid'];
	 }
	 }*/
}

if( $nv_Request->isset_request( 'submit', 'post' ) || $nv_Request->isset_request( 'send', 'post' ) )
{
	$id = $nv_Request->get_int( 'id', 'post', 0 );

	$gr = array( );

	$_groups_view = $nv_Request->get_array( 'groups_view', 'post', array( ) );
	$array['groups_view'] = !empty( $_groups_view ) ? implode( ',', nv_groups_post( array_intersect( $_groups_view, array_keys( $groups_list ) ) ) ) : '';

	$array['parentid'] = $nv_Request->get_int( 'parentid', 'post', 0 );
	$array['type'] = $nv_Request->get_int( 'type', 'post', 0 );
	$array['typeid'] = $nv_Request->get_int( 'typeid', 'post', 0 );
	$array['title'] = $nv_Request->get_string( 'title', 'post', '', '' );
	$array['alias'] = change_alias( $array['title'] );
	$array['code'] = $nv_Request->get_string( 'code', 'post', '' );
	$array['number_text_come'] = $nv_Request->get_string( 'number_text_come', 'post', '' );
	$array['to_org'] = $nv_Request->get_string( 'to_org', 'post', '' );
	$to_depcatid = $nv_Request->get_array( 'to_depcatid', 'post', array( ) );
	asort( $to_depcatid );
	$array['to_depcatid'] = !empty( $to_depcatid ) ? implode( ',', $to_depcatid ) : '';
	asort( $arr_deid );
	$arr_deid = $nv_Request->get_array( 'deid', 'post', array( ) );
	$array['deid'] = !empty( $arr_deid ) ? implode( ',', $arr_deid ) : '';
	$array['from_org'] = $nv_Request->get_string( 'from_org', 'post', '' );
	$array['from_signer'] = $nv_Request->get_int( 'from_signer', 'post', 0 );
	$array['content'] = $nv_Request->get_string( 'content', 'post', '' );
	$array['statusid'] = $nv_Request->get_int( 'statusid', 'post', 0 );
	$array['typeid'] = $nv_Request->get_int( 'typeid', 'post', 0 );
	$array['name_signer'] = $nv_Request->get_string( 'name_signer', 'post', '' );
	$array['name_initial'] = $nv_Request->get_string( 'name_initial', 'post', '' );
	$array['note'] = $nv_Request->get_string( 'note', 'post', '' );
	$array['level_important'] = $nv_Request->get_int( 'level_important', 'post', 0 );
	$array['reply'] = $nv_Request->get_int( 'reply', 'post', 0 );
	$arr_img = $nv_Request->get_typed_array( 'fileupload', 'post', 'string' );
	$array['publtime'] = $nv_Request->get_title( 'publtime', 'post', '', '' );

	if( !empty( $array['publtime'] ) )
	{
		unset( $m );
		if( preg_match( "/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $array['publtime'], $m ) )
		{
			$array['publtime'] = mktime( 0, 0, 0, $m[2], $m[1], $m[3] );
		}
		else
		{
			die( $lang_module['in_result_errday'] );
		}
	}
	else
	{
		$array['publtime'] = '';
	}

	$array['date_iss'] = $nv_Request->get_title( 'date_iss', 'post', '', 1 );

	if( !empty( $array['date_iss'] ) )
	{
		unset( $m );
		if( preg_match( "/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $array['date_iss'], $m ) )
		{
			$array['date_iss'] = mktime( 0, 0, 0, $m[2], $m[1], $m[3] );
		}
		else
		{
			die( $lang_module['in_result_errday'] );
		}
	}
	else
	{
		$array['date_iss'] = '';
	}

	$array['date_first'] = $nv_Request->get_title( 'date_first', 'post', '', 1 );

	if( !empty( $array['date_first'] ) )
	{
		unset( $m );
		if( preg_match( "/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $array['date_first'], $m ) )
		{
			$array['date_first'] = mktime( 0, 0, 0, $m[2], $m[1], $m[3] );
		}
		else
		{
			die( $lang_module['in_result_errday'] );
		}
	}
	else
	{
		$array['date_first'] = '';
	}

	$array['date_die'] = $nv_Request->get_title( 'date_die', 'post', '', 1 );

	if( !empty( $array['date_die'] ) )
	{
		unset( $m );
		if( preg_match( "/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $array['date_die'], $m ) )
		{
			$array['date_die'] = mktime( 0, 0, 0, $m[2], $m[1], $m[3] );
		}
		else
		{
			die( $lang_module['in_result_errday'] );
		}
	}
	else
	{
		$array['date_die'] = 0;
	}

	$array['term_view'] = $nv_Request->get_title( 'term_view', 'post', 1 );

	if( !empty( $array['term_view'] ) )
	{
		unset( $m );
		if( preg_match( "/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $array['term_view'], $m ) )
		{
			$array['term_view'] = mktime( 0, 0, 0, $m[2], $m[1], $m[3] );
		}
		else
		{
			die( $lang_module['in_result_errday'] );
		}
	}
	else
	{
		$array['term_view'] = 0;
	}

	$cut = strlen( NV_BASE_SITEURL . "uploads/" . $module_name . "/" );

	foreach( $arr_img as $arr )
	{
		$arr_imgs[] = substr( $arr, $cut, strlen( $arr ) );
	}
	$array['file'] = (!empty( $arr_imgs )) ? implode( ",", $arr_imgs ) : "";

	$listde = $nv_Request->get_typed_array( 'deid', 'post', 'int' );

	if( $error == '' )
	{

		if( $array['title'] == "" )
		{
			$error = $lang_module['error_title'];
		}
		else
		if( $array['code'] == '' )
		{
			$error = $lang_module['error_code'];
		}
		else
		if( $array['publtime'] == '' )
		{
			$error = $lang_module['error_from_time'];
		}
		else
		if( $array['name_signer'] == '' )
		{
			$error = $lang_module['error_si'];
		}
		else
		if( $array['date_iss'] == '' )
		{
			$error = $lang_module['error_iss'];
		}
		else
		if( $array['date_first'] == '' )
		{
			$error = $lang_module['error_first'];
		}
		else
		if( $array['from_org'] == '' )
		{
			$error = $lang_module['error_souce'];
		}
		else
		if( $array['date_iss'] > $array['date_first'] )
		{
			$error = $lang_module['error_iss_first'];
		}
		else
		if( $array['publtime'] > $array['date_iss'] )
		{
			$error = $lang_module['error_iss_time'];

		}
		else
		if( $array['date_die'] != 0 && ($array['date_die'] < $array['date_first']) )
		{
			$error = $lang_module['error_die_first'];
		}
		else
		{
			if( $id != 0 )
			{
				$sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_rows SET
                    type = " . $array['type'] . ",
					idfield = " . $array['parentid'] . ",
					idtype = " . $array['typeid'] . ",
                    title = " . $db->quote( $array['title'] ) . ",
					abstract=" . $db->quote( $array['content'] ) . ",
					name_signer= " . $db->quote( $array['name_signer'] ) . ",
					name_initial =" . $db->quote( $array['name_initial'] ) . ",
					level_important = " . $array['level_important'] . ",
					number_dispatch = " . $db->quote( $array['code'] ) . ",
					number_text_come = " . $db->quote( $array['number_text_come'] ) . ",
					note= " . $db->quote( $array['note'] ) . ",
					publtime = " . $array['publtime'] . ",
					date_iss=" . $array['date_iss'] . ",
					date_first = " . $array['date_first'] . ",
					date_die =" . $array['date_die'] . ",
					from_org = " . $db->quote( $array['from_org'] ) . ",
					to_org = " . $db->quote( $array['to_org'] ) . ",
					dep_catid = " . $db->quote( $array['to_depcatid'] ) . ",
					to_depid = " . $db->quote( $array['deid'] ) . ",
					attach_file = " . $db->quote( $array['file'] ) . ",
                    alias = '',
					status = " . $array['statusid'] . ",
					term_view = " . $array['term_view'] . ",
					reply = " . $array['reply'] . ",
					groups_view = " . $array['groups_view'] . "
					WHERE id = " . $id;

				if( $db->query( $sql ) )
				{
					$query = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_rows SET
                		alias=" . $db->quote( $array['alias'] . "-" . $id ) . ", status = 4 WHERE id=" . $id;
					$db->query( $query );

					if( $nv_Request->isset_request( 'send', 'post' ) )
					{
						//theo dõi công văn
						$i = 0;
						$result = $db->query( 'SELECT id_department FROM ' . NV_PREFIXLANG . '_' . $module_data . '_follow WHERE id_dispatch = ' . $id );
						while( $row = $result->fetch( ) )
						{
							if( !in_array( $row['id_department'], $people ) )
							{
								$db->query( 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_follow WHERE id_dispatch = ' . $id . ' AND id_department = ' . $row['id_department'] );
							}
						}
						foreach( $arr_deid as $row_deid )
						{
							$arr_userid = $arr_timeview = $arr_list_hitstotal = array( );
							$listuserid = $listtimeview = $list_hitstotal = '';
							$number_follow = 0;

							$number_follow = $db->query( 'SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_follow WHERE id_dispatch = ' . $id . ' AND id_department = ' . $row_deid )->rowCount( );

							if( $number_follow > 0 )
								continue;
							$result = $db->query( 'SELECT userid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_user WHERE iddepart = ' . $row_deid );
							while( $row = $result->fetch( ) )
							{
								$arr_userid[$row['userid']] = $row['userid'];
								$arr_timeview[$row['userid']] = 0;
								$arr_list_hitstotal[$row['userid']] = 0;
							}
							$listuserid = implode( ',', $arr_userid );
							$listtimeview = implode( ',', $arr_timeview );
							$list_hitstotal = implode( ',', $arr_list_hitstotal );
							$sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_follow VALUES (
						NULL,
						' . $id . ',
						' . $row_deid . ',
						' . $db->quote( $listuserid ) . ',
						' . $db->quote( $listtimeview ) . ',
						' . $db->quote( $list_hitstotal ) . ')';
							$db->insert_id( $sql );
							$i++;
						}

						//Gửi email xem  công văn
						$alias = $array['alias'] . "-" . $id;
						$link = nv_url_rewrite( NV_MY_DOMAIN . "/index.php?" . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . "=" . $module_name . "&amp;op=detail/" . $alias, true );
						$result = $db->query( 'SELECT t1.userid, t2.email FROM ' . NV_PREFIXLANG . '_' . $module_data . '_user t1,' . $db_config['prefix'] . '_users t2 WHERE t1.userid = t2.userid AND iddepart IN (' . $array['deid'] . ')' );
						while( $row = $result->fetch( ) )
						{
							nv_sendmail( array(
								$lang_module['dis_titile_email'],
								$global_config['smtp_username']
							), $row['email'], $lang_module['dis_titile_email'], sprintf( $lang_module['dis_content_email'], $link ) );
						}
					}

					Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=main" );
					exit( );

				}
				else
				{
					$error = $lang_module['error_update'];
				}
			}
			else
			{
				$sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_rows VALUES (
					NULL,
					" . $array['type'] . ",
					" . $array['parentid'] . ",
					" . $array['typeid'] . ",
					" . $db->quote( $array['title'] ) . ",
					" . $db->quote( $array['content'] ) . ",
					" . $db->quote( $array['name_signer'] ) . ",
					" . $db->quote( $array['name_initial'] ) . ",
					" . $array['level_important'] . ",
					" . $db->quote( $array['code'] ) . ",
					" . $db->quote( $array['number_text_come'] ) . ",
					" . $db->quote( $array['note'] ) . ",
					" . $array['publtime'] . ",
					" . $array['date_iss'] . ",
					" . $array['date_first'] . ",
					" . $array['date_die'] . ",
					" . $db->quote( $array['from_org'] ) . ",
					" . $db->quote( $array['to_org'] ) . ",
					" . $db->quote( $array['to_depcatid'] ) . ",
					" . $db->quote( $array['deid'] ) . ",
					" . $db->quote( $array['attach_file'] ) . ",
					'',
					" . $array['statusid'] . ",
					" . $array['term_view'] . ",
					" . $array['reply'] . ",
					" . $array['groups_view'] . ",
					0 )";

				$array['id'] = $db->insert_id( $sql );

				if( $array['id'] > 0 )
				{
					$query = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_rows SET
                	alias=" . $db->quote( $array['alias'] . "-" . $array['id'] ) . " WHERE id=" . $array['id'];
					$db->query( $query );

					if( $nv_Request->isset_request( 'send', 'post' ) )
					{
						//Gửi email xem  công văn
						$alias = $array['alias'] . "-" . $id;
						$link = nv_url_rewrite( NV_MY_DOMAIN . "/index.php?" . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . "=" . $module_name . "&amp;op=detail/" . $alias, true );
						$contact = NV_MY_DOMAIN . '/contact/';
						$result = $db->query( 'SELECT t1.userid, t2.email FROM ' . NV_PREFIXLANG . '_' . $module_data . '_user t1,' . $db_config['prefix'] . '_users t2 WHERE t1.userid = t2.userid AND iddepart IN (' . $array['deid'] . ')' );
						while( $row = $result->fetch( ) )
						{
							nv_sendmail( array(
								'',
								$global_config['smtp_username']
							), $row['email'], $lang_module['dis_titile_email'], sprintf( $lang_module['dis_content_email'], $link ) );
						}

						//theo dõi công văn
						foreach( $arr_deid as $row_deid )
						{
							$arr_userid = $arr_timeview = $arr_list_hitstotal = array( );
							$listuserid = $listtimeview = $list_hitstotal = '';
							$result = $db->query( 'SELECT userid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_user WHERE iddepart = ' . $row_deid );
							while( $row = $result->fetch( ) )
							{
								$arr_userid[$row['userid']] = $row['userid'];
								$arr_timeview[$row['userid']] = 0;
								$arr_list_hitstotal[$row['userid']] = 0;
							}
							$listuserid = implode( ',', $arr_userid );
							$listtimeview = implode( ',', $arr_timeview );
							$list_hitstotal = implode( ',', $arr_list_hitstotal );
							$sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_follow VALUES (
						NULL,
						' . $array['id'] . ',
						' . $row_deid . ',
						' . $db->quote( $listuserid ) . ',
						' . $db->quote( $listtimeview ) . ',
						' . $db->quote( $list_hitstotal ) . ')';
							$db->insert_id( $sql );
						}
					}
					Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=main" );
					exit( );

				}
				else
				{
					$error = $lang_module['error_insert'];
				}
			}
		}
	}
}

$fileupload_num = count( $arr_img );
$listcats = nv_listcats( $array['parentid'], 0 );
$listtypes = nv_listtypes( $array['type'], 0 );
$listdes = array( array(
		'id' => 0,
		'parentid' => 0,
		'alias' => '',
		'title' => $lang_module['chos_de'],
		'name' => $lang_module['chos_de'],
		'selected' => '',
		'checked' => ''
	) );

$listdes = $listdes + nv_listdes( $array['deid'], 0 );
$_arr_deid = explode( ',', $array['deid'] );
foreach( $listdes as $li )
{
	if( $li['id'] != 0 )
	{
		$lis[] = array(
			'id' => (int)$li['id'],
			'alias' => $li['alias'],
			'name' => $li['title'],
			'checked' => in_array( $li['id'], $_arr_deid ) ? 'checked="checked"' : ''
		);
	}
}

//$listsinger = nv_signerList($array['from_signer']);

//$array['date_die'] = $array['date_die'] ? nv_date('d/m/Y', $array['date_die']) : '';

//Loại phòng ban
$listdecat = $listdecat + nv_listdecat( $array['to_depcatid'], 0 );

foreach( $arr_status as $a )
{
	$as[] = array(
		'id' => $a['id'],
		'name' => $a['name'],
		'selected' => $a['id'] == $array['statusid'] ? " selected=\"selected\"" : ""
	);
}

foreach( $arr_level_important as $level )
{
	$levels[] = array(
		'id' => $level['id'],
		'name' => $level['name'],
		'selected' => $level['id'] == $array['level_important'] ? " selected=\"selected\"" : ""
	);
}

foreach( $arr_reply as $reply )
{
	$replys[] = array(
		'id' => $reply['id'],
		'name' => $reply['name'],
		'selected' => $reply['id'] == $array['reply'] ? " selected=\"selected\"" : ""
	);
}

foreach( $arr_dis_type as $dis_type )
{
	$dis_types[] = array(
		'id' => $dis_type['id'],
		'name' => $dis_type['name'],
		'selected' => $dis_type['id'] == $array['type'] ? " selected=\"selected\"" : ""
	);
}

$xtpl = new XTemplate( "add_document.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
$xtpl->assign( 'NV_LANG_INTERFACE', NV_LANG_INTERFACE );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'NV_ASSETS_DIR', NV_ASSETS_DIR );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
$xtpl->assign( 'id', $id );
$xtpl->assign( 'FILES_DIR', NV_UPLOADS_DIR . '/' . $module_upload );
$xtpl->assign( 'fileupload_num', $fileupload_num );
$xtpl->assign( 'FORM_ACTION', NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op );

if( $array['publtime'] != '' )
{
	$array['publtime'] = date( "d.m.Y", $array['publtime'] );
}

if( $array['date_iss'] != '' )
{
	$array['date_iss'] = date( "d.m.Y", $array['date_iss'] );
}

if( $array['date_first'] != '' )
{
	$array['date_first'] = date( "d.m.Y", $array['date_first'] );
}

if( $array['date_die'] != '' && $array['date_die'] != 0 )
{
	$array['date_die'] = date( "d.m.Y", $array['date_die'] );
}
if( $array['term_view'] != '' )
{
	$array['term_view'] = date( "d.m.Y", $array['term_view'] );
}

$xtpl->assign( 'DATA', $array );

foreach( $listcats as $cat )
{
	$xtpl->assign( 'LISTCATS', $cat );
	$xtpl->parse( 'inter.parentid' );
}

foreach( $listtypes as $type )
{
	$xtpl->assign( 'LISTTYPES', $type );
	$xtpl->parse( 'inter.typeid' );
}

foreach( $listdes as $de )
{
	$xtpl->assign( 'LISTDES', $de );
	$xtpl->parse( 'inter.from_depid' );
}

foreach( $as as $a )
{
	$xtpl->assign( 'LISTSTATUS', $a );
	$xtpl->parse( 'inter.statusid' );
}

foreach( $levels as $level )
{
	$xtpl->assign( 'LISTLEVEL', $level );
	$xtpl->parse( 'inter.level_important' );
}

foreach( $replys as $reply )
{
	$xtpl->assign( 'LISTREPLY', $reply );
	$xtpl->parse( 'inter.reply' );
}

foreach( $dis_types as $dis_type )
{
	$xtpl->assign( 'LISTDISTYPE', $dis_type );
	$xtpl->parse( 'inter.dis_type' );
}

$to_depcatid = explode( ',', $array['to_depcatid'] );
foreach( $listdecat as $cat )
{
	$cat['selected'] = in_array( $cat['id'], $to_depcatid ) ? " selected=\"selected\"" : "";
	$xtpl->assign( 'LISTCATDIS', $cat );
	$xtpl->parse( 'inter.dis_listdecat' );
}

if( empty( $id ) )
{
	$xtpl->assign( 'CLASSLIST', 'class="listdecat"' );
	$xtpl->parse( 'inter.dis_listdecat_none' );
}
else
{
	$xtpl->assign( 'CLASSLISTDIS', 'class="listdecat_dis"' );
	$xtpl->parse( 'inter.dis_listdecat_dis' );
}

$groups_view = explode( ',', $array['groups_view'] );
foreach( $groups_list as $_group_id => $_title )
{
	$xtpl->assign( 'groups_view', array(
		'value' => $_group_id,
		'checked' => in_array( $_group_id, $groups_view ) ? ' checked="checked"' : '',
		'title' => $_title
	) );
	$xtpl->parse( 'inter.groups_view' );
}

foreach( $lis as $de )
{
	$xtpl->assign( 'ROW', $de );
	$xtpl->parse( 'inter.loop' );
}

$a = 0;
if( !empty( $arr_imgs ) )
{
	$str = NV_BASE_SITEURL . "uploads/" . $module_name . "/";
	if( $arr_imgs[0] != '' )
	{
		foreach( $arr_imgs as $file )
		{

			if( file_exists( NV_UPLOADS_REAL_DIR . "/" . $module_upload . "/" . $file ) )
			{
				$xtpl->assign( 'FILEUPLOAD', array(
					'value' => $str . $file,
					'key' => $a
				) );
				$xtpl->parse( 'inter.fileupload' );
				$a++;
			}
		}
	}
	else
	{
		$xtpl->parse( 'inter.fileupload' );
	}
}
else
{
	$xtpl->parse( 'inter.fileupload' );
}

if( $error != '' )
{

	$xtpl->assign( 'ERROR', $error );
	$xtpl->parse( 'inter.error' );
}

if( $nv_Request->isset_request( 'action', 'post' ) )
{
	$signer = $nv_Request->get_int( 'singer', 'post', 0 );
	$sql = "SELECT positions FROM " . NV_PREFIXLANG . "_" . $module_data . "_signer WHERE id=" . $signer;
	$result = $db->query( $sql );
	$position = $result->fetchColumn( );
	die( $lang_module['positions'] . ": " . $position );
}

$xtpl->parse( 'inter' );
$contents = $xtpl->text( 'inter' );

$page_title = $lang_module['add_document'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
