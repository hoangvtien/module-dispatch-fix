<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 19 Jul 2011 09:07:26 GMT
 */

if( !defined( 'NV_MAINFILE' ) )
	die( 'Stop!!!' );

$sql_drop_module = array( );

//bảng công văn mặc định

$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_departments";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cat";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_type";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_signer";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_document";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_de_do";

//bảng công văn thiết kế mới

$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_assignment";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_department";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_department_cat";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_fields";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_follow";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_user";
//$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_type";

$sql_create_module = $sql_drop_module;

//bảng công văn mặc định

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_departments (
 id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
 parentid mediumint(8) unsigned NOT NULL DEFAULT '0',
 alias varchar(250) NOT NULL,
 title varchar(250) NOT NULL,
 introduction mediumtext NOT NULL,
 head varchar(255) NOT NULL,
 addtime int(11) unsigned NOT NULL DEFAULT '0',
 weight smallint(4) unsigned NOT NULL DEFAULT '0',
 PRIMARY KEY (id),
 UNIQUE KEY alias (alias),
 KEY weight (weight)
 ) ENGINE=MyISAM;";

 $sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cat (
 id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
 parentid mediumint(8) unsigned NOT NULL DEFAULT '0',
 alias varchar(250) NOT NULL,
 title varchar(250) NOT NULL,
 introduction mediumtext NOT NULL,
 addtime int(11) unsigned NOT NULL DEFAULT '0',
 weight smallint(4) unsigned NOT NULL DEFAULT '0',
 status tinyint(1) unsigned NOT NULL DEFAULT '0',
 PRIMARY KEY (id),
 UNIQUE KEY alias (alias),
 KEY weight (weight)
 ) ENGINE=MyISAM;";

 $sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_type (
 id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
 parentid mediumint(8) unsigned NOT NULL DEFAULT '0',
 alias varchar(250) NOT NULL,
 title varchar(250) NOT NULL,
 weight smallint(4) unsigned NOT NULL DEFAULT '0',
 status tinyint(1) unsigned NOT NULL DEFAULT '0',
 PRIMARY KEY (id),
 UNIQUE KEY alias (alias),
 KEY weight (weight)
 ) ENGINE=MyISAM;";

 $sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_signer (
 id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
 name varchar(255) NOT NULL,
 positions varchar(255) NOT NULL,
 weight smallint(4) unsigned NOT NULL DEFAULT '0',
 status tinyint(1) unsigned NOT NULL DEFAULT '0',
 PRIMARY KEY (id)
 ) ENGINE=MyISAM;";

 $sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_document (
 id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
 type mediumint(8) unsigned NOT NULL DEFAULT '0',
 catid mediumint(8) unsigned NOT NULL DEFAULT '0',
 alias varchar(250) NOT NULL,
 title varchar(250) NOT NULL,
 code varchar(100) NOT NULL,
 content mediumtext NOT NULL,
 file varchar(255) NOT NULL,
 from_org varchar(255) NOT NULL,
 from_depid mediumint(8) unsigned NOT NULL DEFAULT '0',
 from_signer mediumint(8) unsigned NOT NULL DEFAULT '0',
 from_time int(11) unsigned NOT NULL DEFAULT '0',
 date_iss int(11) unsigned NOT NULL DEFAULT '0',
 date_first int(11) unsigned NOT NULL DEFAULT '0',
 date_die int(11) unsigned NOT NULL DEFAULT '0',
 to_org mediumtext NOT NULL,
 groups_view varchar(255) NOT NULL,
 status tinyint(1) unsigned NOT NULL DEFAULT '0',
 view int(11) unsigned NOT NULL DEFAULT '0',
 PRIMARY KEY (id),
 UNIQUE KEY alias (alias),
 KEY type (type),
 KEY catid (catid)
 ) ENGINE=MyISAM;";

 $sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_de_do (
 id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
 doid mediumint(8) unsigned NOT NULL DEFAULT '0',
 deid mediumint(8) unsigned NOT NULL DEFAULT '0',
 PRIMARY KEY (id)
 ) ENGINE=MyISAM;";

//bảng công văn thiết kế mới

//assignment
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_assignment (
  id mediumint(8) NOT NULL AUTO_INCREMENT,
  id_dispatch int(11) UNSIGNED NOT NULL DEFAULT '0',
  id_department mediumint(8) UNSIGNED NOT NULL,
  assingtime int(11) UNSIGNED NOT NULL DEFAULT '0',
  completiontime int(11) UNSIGNED NOT NULL DEFAULT '0',
  userid_command mediumint(8) NOT NULL DEFAULT '0',
  userid_follow mediumint(8) NOT NULL DEFAULT '0',
  userid_perform mediumint(8) NOT NULL DEFAULT '0',
  work_content text COLLATE utf8mb4_unicode_ci NOT NULL,
  result TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  attach_file varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (id),
 KEY id_dispatch (id_dispatch,id_department)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_department (
   `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `depcatid` mediumint(8) NOT NULL DEFAULT '0',
  `title` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  alias varchar(250) NOT NULL,
  `weight` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  	PRIMARY KEY (`id`),
 	KEY `depcatid` (`depcatid`,`weight`)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_department_cat (
   `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  	alias varchar(250) NOT NULL,
  	`weight` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  	PRIMARY KEY (`id`),
  	KEY `weight` (`weight`)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_fields (
 `id` tinyint(4) UNSIGNED NOT NULL AUTO_INCREMENT,
 `title` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_follow (
   id mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  id_dispatch int(11) NOT NULL,
  id_department mediumint(8) NOT NULL,
  list_userid varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  timeview int(11) NOT NULL,
  list_hitstotal varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (id),
 KEY id_dispatch (id_dispatch,id_department)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows (
  id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  type tinyint(4) NOT NULL COMMENT 'Công văn đi hoặc đến',
  idfield tinyint(4) NOT NULL COMMENT 'Chủ đề',
  idtype tinyint(4) NOT NULL COMMENT 'Loại công văn',
  title varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tiêu đề',
  abstract text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Trích yếu',
  name_signer varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Người ký văn bản',
  name_initial varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Người ký nháy',
  level_important tinyint(4) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Mức độ quan trọng',
  number_dispatch varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Số công văn',
  number_text_come varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Số văn bản đến',
  note text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Ghi chú',
  publtime int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Ngày gửi',
  date_iss int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Ngày ban hành',
  date_first int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Ngày có hiệu lực',
  date_die int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Ngày hết hiệu lực',
  from_org varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Đơn vị soạn',
  to_org MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Đơn vị nhận' ,
  dep_catid VARCHAR(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Loại phòng ban nhận',
  to_depid VARCHAR(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Phòng ban nhận',
  attach_file varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'File đính kèm',
  alias varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Liên kết',
  status tinyint(4) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Trạng thái',
  term_view int(11) NOT NULL DEFAULT '0' COMMENT 'Hạn xem',
  reply tinyint(4) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Phúc đáp',
  groups_view VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nhóm xem',
  view INT(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Lượt xem',
  PRIMARY KEY (id),
  KEY idfield (idfield),
	KEY idtype (idtype),
	KEY status (status)
) ENGINE=MyISAM;";

/*$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_type (
	`id` tinyint(4) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  	PRIMARY KEY (`id`)
) ENGINE=MyISAM;";*/

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_user (
	userid mediumint(8) UNSIGNED NOT NULL,
  iddepart mediumint(8) NOT NULL DEFAULT '0',
  office tinyint(4) NOT NULL DEFAULT '0',
  UNIQUE KEY userid (userid,iddepart)
) ENGINE=MyISAM;";

