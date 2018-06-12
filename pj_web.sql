/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50717
Source Host           : localhost:3306
Source Database       : pj_web

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2018-01-22 15:02:26
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `acl_auth`
-- ----------------------------
DROP TABLE IF EXISTS `acl_auth`;
CREATE TABLE `acl_auth` (
  `auth_id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `auth_group_id` smallint(4) unsigned NOT NULL DEFAULT '0',
  `auth_name` varchar(64) NOT NULL,
  `aliasname` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`auth_id`)
) ENGINE=MyISAM AUTO_INCREMENT=889 DEFAULT CHARSET=utf8 COMMENT='权限表';

-- ----------------------------
-- Records of acl_auth
-- ----------------------------
INSERT INTO `acl_auth` VALUES ('653', '108', 'controller_admin_list', '管理员列表');
INSERT INTO `acl_auth` VALUES ('654', '108', 'controller_admin_add', '');
INSERT INTO `acl_auth` VALUES ('655', '108', 'controller_admin_edit', '');
INSERT INTO `acl_auth` VALUES ('656', '108', 'controller_admin_save', '');
INSERT INTO `acl_auth` VALUES ('657', '108', 'controller_admin_update', '');
INSERT INTO `acl_auth` VALUES ('658', '108', 'controller_admin_remove', '');
INSERT INTO `acl_auth` VALUES ('666', '110', 'controller_attach_upload', '');
INSERT INTO `acl_auth` VALUES ('667', '110', 'controller_attach_chunk', '');
INSERT INTO `acl_auth` VALUES ('668', '111', 'controller_cache_set', '');
INSERT INTO `acl_auth` VALUES ('669', '111', 'controller_cache_reset', '');
INSERT INTO `acl_auth` VALUES ('670', '111', 'controller_cache_clear', '');
INSERT INTO `acl_auth` VALUES ('671', '111', 'controller_cache_runtime', '');
INSERT INTO `acl_auth` VALUES ('682', '114', 'controller_console_index', '');
INSERT INTO `acl_auth` VALUES ('683', '114', 'controller_console_env', '');
INSERT INTO `acl_auth` VALUES ('692', '117', 'controller_group_list', '');
INSERT INTO `acl_auth` VALUES ('693', '117', 'controller_group_bind', '');
INSERT INTO `acl_auth` VALUES ('694', '117', 'controller_group_savebind', '');
INSERT INTO `acl_auth` VALUES ('695', '117', 'controller_group_add', '');
INSERT INTO `acl_auth` VALUES ('696', '117', 'controller_group_edit', '');
INSERT INTO `acl_auth` VALUES ('697', '117', 'controller_group_save', '');
INSERT INTO `acl_auth` VALUES ('698', '117', 'controller_group_update', '');
INSERT INTO `acl_auth` VALUES ('699', '117', 'controller_group_remove', '');
INSERT INTO `acl_auth` VALUES ('700', '118', 'controller_limit_list', '');
INSERT INTO `acl_auth` VALUES ('701', '118', 'controller_limit_allctl', '');
INSERT INTO `acl_auth` VALUES ('702', '118', 'controller_limit_ctlaliasupdate', '');
INSERT INTO `acl_auth` VALUES ('703', '118', 'controller_limit_actaliasupdate', '');
INSERT INTO `acl_auth` VALUES ('704', '118', 'controller_limit_addctl', '');
INSERT INTO `acl_auth` VALUES ('705', '118', 'controller_limit_createlg', '');
INSERT INTO `acl_auth` VALUES ('706', '118', 'controller_limit_addact', '');
INSERT INTO `acl_auth` VALUES ('707', '118', 'controller_limit_createl', '');
INSERT INTO `acl_auth` VALUES ('710', '120', 'controller_login_index', '');
INSERT INTO `acl_auth` VALUES ('711', '120', 'controller_login_logining', '');
INSERT INTO `acl_auth` VALUES ('712', '120', 'controller_login_logout', '');
INSERT INTO `acl_auth` VALUES ('713', '120', 'controller_login_signup', '');
INSERT INTO `acl_auth` VALUES ('714', '120', 'controller_login_forgot', '');
INSERT INTO `acl_auth` VALUES ('715', '121', 'controller_media_index', '');
INSERT INTO `acl_auth` VALUES ('716', '121', 'controller_media_list', '');
INSERT INTO `acl_auth` VALUES ('717', '121', 'controller_media_add', '');
INSERT INTO `acl_auth` VALUES ('718', '121', 'controller_media_edit', '');
INSERT INTO `acl_auth` VALUES ('719', '121', 'controller_media_del', '');
INSERT INTO `acl_auth` VALUES ('725', '123', 'controller_node_list', '');
INSERT INTO `acl_auth` VALUES ('726', '123', 'controller_node_add', '');
INSERT INTO `acl_auth` VALUES ('727', '123', 'controller_node_edit', '');
INSERT INTO `acl_auth` VALUES ('728', '123', 'controller_node_save', '');
INSERT INTO `acl_auth` VALUES ('729', '123', 'controller_node_update', '');
INSERT INTO `acl_auth` VALUES ('730', '123', 'controller_node_tovoid', '');
INSERT INTO `acl_auth` VALUES ('731', '123', 'controller_node_backshow', '');
INSERT INTO `acl_auth` VALUES ('732', '123', 'controller_node_del', '');
INSERT INTO `acl_auth` VALUES ('838', '136', 'controller_category_list', '');
INSERT INTO `acl_auth` VALUES ('837', '120', 'controller_login_captcha', '');
INSERT INTO `acl_auth` VALUES ('751', '127', 'controller_rank_list', '');
INSERT INTO `acl_auth` VALUES ('752', '127', 'controller_rank_add', '');
INSERT INTO `acl_auth` VALUES ('753', '127', 'controller_rank_edit', '');
INSERT INTO `acl_auth` VALUES ('754', '127', 'controller_rank_save', '');
INSERT INTO `acl_auth` VALUES ('755', '127', 'controller_rank_update', '');
INSERT INTO `acl_auth` VALUES ('756', '127', 'controller_rank_remove', '');
INSERT INTO `acl_auth` VALUES ('757', '128', 'controller_role_list', '');
INSERT INTO `acl_auth` VALUES ('758', '128', 'controller_role_bind', '');
INSERT INTO `acl_auth` VALUES ('759', '128', 'controller_role_savebind', '');
INSERT INTO `acl_auth` VALUES ('760', '128', 'controller_role_add', '');
INSERT INTO `acl_auth` VALUES ('761', '128', 'controller_role_edit', '');
INSERT INTO `acl_auth` VALUES ('762', '128', 'controller_role_save', '');
INSERT INTO `acl_auth` VALUES ('763', '128', 'controller_role_update', '');
INSERT INTO `acl_auth` VALUES ('764', '128', 'controller_role_remove', '');
INSERT INTO `acl_auth` VALUES ('882', '130', 'controller_tool_makeacl', '');
INSERT INTO `acl_auth` VALUES ('779', '131', 'controller_userm_list', '');
INSERT INTO `acl_auth` VALUES ('780', '131', 'controller_userm_add', '');
INSERT INTO `acl_auth` VALUES ('781', '131', 'controller_userm_edit', '');
INSERT INTO `acl_auth` VALUES ('782', '131', 'controller_userm_save', '');
INSERT INTO `acl_auth` VALUES ('783', '131', 'controller_userm_update', '');
INSERT INTO `acl_auth` VALUES ('784', '131', 'controller_userm_remove', '');
INSERT INTO `acl_auth` VALUES ('785', '131', 'controller_userm_checkmob', '');
INSERT INTO `acl_auth` VALUES ('842', '136', 'controller_category_del', '');
INSERT INTO `acl_auth` VALUES ('841', '136', 'controller_category_save', '');
INSERT INTO `acl_auth` VALUES ('840', '136', 'controller_category_edit', '');
INSERT INTO `acl_auth` VALUES ('839', '136', 'controller_category_add', '');
INSERT INTO `acl_auth` VALUES ('828', '110', 'controller_attach_plup', '');
INSERT INTO `acl_auth` VALUES ('883', '140', 'controller_page_list', '');
INSERT INTO `acl_auth` VALUES ('884', '140', 'controller_page_add', '');
INSERT INTO `acl_auth` VALUES ('885', '140', 'controller_page_save', '');
INSERT INTO `acl_auth` VALUES ('886', '140', 'controller_page_edit', '');
INSERT INTO `acl_auth` VALUES ('887', '140', 'controller_page_update', '');
INSERT INTO `acl_auth` VALUES ('888', '140', 'controller_page_remove', '');

-- ----------------------------
-- Table structure for `acl_auth_group`
-- ----------------------------
DROP TABLE IF EXISTS `acl_auth_group`;
CREATE TABLE `acl_auth_group` (
  `auth_group_id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `auth_group_name` varchar(64) NOT NULL,
  `aliasname` varchar(64) DEFAULT NULL,
  `need_login` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`auth_group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=141 DEFAULT CHARSET=utf8 COMMENT='权限组';

-- ----------------------------
-- Records of acl_auth_group
-- ----------------------------
INSERT INTO `acl_auth_group` VALUES ('108', 'controller_admin', '管理员', '1');
INSERT INTO `acl_auth_group` VALUES ('110', 'controller_attach', '', '1');
INSERT INTO `acl_auth_group` VALUES ('111', 'controller_cache', '', '1');
INSERT INTO `acl_auth_group` VALUES ('114', 'controller_console', '', '1');
INSERT INTO `acl_auth_group` VALUES ('117', 'controller_group', '', '1');
INSERT INTO `acl_auth_group` VALUES ('118', 'controller_limit', '', '1');
INSERT INTO `acl_auth_group` VALUES ('120', 'controller_login', '', '0');
INSERT INTO `acl_auth_group` VALUES ('121', 'controller_media', '', '1');
INSERT INTO `acl_auth_group` VALUES ('123', 'controller_node', '', '1');
INSERT INTO `acl_auth_group` VALUES ('136', 'controller_category', '', '1');
INSERT INTO `acl_auth_group` VALUES ('127', 'controller_rank', '', '1');
INSERT INTO `acl_auth_group` VALUES ('128', 'controller_role', '', '1');
INSERT INTO `acl_auth_group` VALUES ('130', 'controller_tool', '', '1');
INSERT INTO `acl_auth_group` VALUES ('131', 'controller_userm', '', '1');
INSERT INTO `acl_auth_group` VALUES ('140', 'controller_page', '', '1');

-- ----------------------------
-- Table structure for `acl_group`
-- ----------------------------
DROP TABLE IF EXISTS `acl_group`;
CREATE TABLE `acl_group` (
  `group_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(60) NOT NULL,
  `group_text` varchar(60) DEFAULT NULL,
  `depict` varchar(255) DEFAULT NULL,
  `available` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否可用',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='用户组';

-- ----------------------------
-- Records of acl_group
-- ----------------------------
INSERT INTO `acl_group` VALUES ('2', 'editor', '编辑员', '编辑人员', '1');

-- ----------------------------
-- Table structure for `acl_group_role`
-- ----------------------------
DROP TABLE IF EXISTS `acl_group_role`;
CREATE TABLE `acl_group_role` (
  `group_id` smallint(6) unsigned NOT NULL,
  `role_id` smallint(6) unsigned NOT NULL,
  `is_allow` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`group_id`,`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组-权限映射';

-- ----------------------------
-- Records of acl_group_role
-- ----------------------------
INSERT INTO `acl_group_role` VALUES ('2', '2', '1');

-- ----------------------------
-- Table structure for `acl_role`
-- ----------------------------
DROP TABLE IF EXISTS `acl_role`;
CREATE TABLE `acl_role` (
  `role_id` int(10) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(64) NOT NULL DEFAULT '',
  `role_text` varchar(64) DEFAULT NULL,
  `depict` varchar(255) DEFAULT NULL,
  `available` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='角色';

-- ----------------------------
-- Records of acl_role
-- ----------------------------
INSERT INTO `acl_role` VALUES ('2', 'baserole', '全局角色', '全局设置角色', '1');

-- ----------------------------
-- Table structure for `acl_role_auth`
-- ----------------------------
DROP TABLE IF EXISTS `acl_role_auth`;
CREATE TABLE `acl_role_auth` (
  `role_id` int(10) unsigned NOT NULL DEFAULT '0',
  `auth_id` int(10) unsigned NOT NULL DEFAULT '0',
  `is_allow` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`role_id`,`auth_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色权限映射';

-- ----------------------------
-- Records of acl_role_auth
-- ----------------------------
INSERT INTO `acl_role_auth` VALUES ('2', '682', '1');
INSERT INTO `acl_role_auth` VALUES ('2', '683', '1');

-- ----------------------------
-- Table structure for `acl_user`
-- ----------------------------
DROP TABLE IF EXISTS `acl_user`;
CREATE TABLE `acl_user` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(15) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `email` varchar(40) NOT NULL COMMENT '电邮',
  `salt` char(10) NOT NULL COMMENT '密码KEY',
  `secques` char(32) DEFAULT NULL COMMENT '密码问题',
  `groupid` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '管理组ID',
  `memo` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '用户状态',
  `created` int(10) unsigned NOT NULL,
  `updated` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='用户';

-- ----------------------------
-- Records of acl_user
-- ----------------------------
INSERT INTO `acl_user` VALUES ('1', 'admin', '421e06f258b7e5d0f0697d4c820d1298', 'web@web.com', 'K4621E', null, '0', '12', '1', '1400157649', '1492782292');
INSERT INTO `acl_user` VALUES ('7', 'test', '302ad1d481d43e0df6da056687337dc8', 'test@test.com', '8f210f', null, '0', '1', '0', '1456894040', '1493358071');

-- ----------------------------
-- Table structure for `acl_user_ssl`
-- ----------------------------
DROP TABLE IF EXISTS `acl_user_ssl`;
CREATE TABLE `acl_user_ssl` (
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of acl_user_ssl
-- ----------------------------
INSERT INTO `acl_user_ssl` VALUES ('1');

-- ----------------------------
-- Table structure for `acl_user_stats`
-- ----------------------------
DROP TABLE IF EXISTS `acl_user_stats`;
CREATE TABLE `acl_user_stats` (
  `uid` int(10) unsigned NOT NULL,
  `regip` char(15) DEFAULT '',
  `lastip` char(15) DEFAULT '',
  `failedlogin` tinyint(2) DEFAULT '0',
  `lastactivity` int(10) unsigned DEFAULT '0',
  `loginnum` mediumint(6) DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of acl_user_stats
-- ----------------------------
INSERT INTO `acl_user_stats` VALUES ('1', '127.0.0.1', '::1', '0', '1516604105', '592');
INSERT INTO `acl_user_stats` VALUES ('7', '::1', '', '0', '0', '0');

-- ----------------------------
-- Table structure for `common_page`
-- ----------------------------
DROP TABLE IF EXISTS `common_page`;
CREATE TABLE `common_page` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `content` mediumtext NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `updated` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='普通页面';

-- ----------------------------
-- Records of common_page
-- ----------------------------
INSERT INTO `common_page` VALUES ('1', '版权copy', '<p>\n	版权描述版权copy\n</p>', '1273216195', '1506043899');

-- ----------------------------
-- Table structure for `common_process`
-- ----------------------------
DROP TABLE IF EXISTS `common_process`;
CREATE TABLE `common_process` (
  `processid` char(32) NOT NULL,
  `expiry` int(10) DEFAULT NULL,
  `extra` int(10) DEFAULT NULL,
  PRIMARY KEY (`processid`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COMMENT='进度锁';

-- ----------------------------
-- Records of common_process
-- ----------------------------

-- ----------------------------
-- Table structure for `common_syscache`
-- ----------------------------
DROP TABLE IF EXISTS `common_syscache`;
CREATE TABLE `common_syscache` (
  `cname` varchar(32) NOT NULL,
  `ctype` tinyint(3) unsigned NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `data` mediumtext NOT NULL,
  PRIMARY KEY (`cname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统缓存';

-- ----------------------------
-- Records of common_syscache
-- ----------------------------
INSERT INTO `common_syscache` VALUES ('sys_acladmin', '1', '1516159275', '{\"ADMIN\":{\"allow\":\"ACL_HAS_ROLE\",\"deny\":\"ACL_NULL\",\"actions\":{\"LIST\":{\"allow\":[\"ROOT\",\"ADMIN_LIST\"],\"deny\":[\"deny_ADMIN_LIST\"]},\"ADD\":{\"allow\":[\"ROOT\",\"ADMIN_ADD\"],\"deny\":[\"deny_ADMIN_ADD\"]},\"EDIT\":{\"allow\":[\"ROOT\",\"ADMIN_EDIT\"],\"deny\":[\"deny_ADMIN_EDIT\"]},\"SAVE\":{\"allow\":[\"ROOT\",\"ADMIN_SAVE\"],\"deny\":[\"deny_ADMIN_SAVE\"]},\"UPDATE\":{\"allow\":[\"ROOT\",\"ADMIN_UPDATE\"],\"deny\":[\"deny_ADMIN_UPDATE\"]},\"REMOVE\":{\"allow\":[\"ROOT\",\"ADMIN_REMOVE\"],\"deny\":[\"deny_ADMIN_REMOVE\"]}}},\"ATTACH\":{\"allow\":\"ACL_HAS_ROLE\",\"deny\":\"ACL_NULL\",\"actions\":{\"UPLOAD\":{\"allow\":[\"ROOT\",\"ATTACH_UPLOAD\"],\"deny\":[\"deny_ATTACH_UPLOAD\"]},\"CHUNK\":{\"allow\":[\"ROOT\",\"ATTACH_CHUNK\"],\"deny\":[\"deny_ATTACH_CHUNK\"]},\"PLUP\":{\"allow\":[\"ROOT\",\"ATTACH_PLUP\"],\"deny\":[\"deny_ATTACH_PLUP\"]}}},\"CACHE\":{\"allow\":\"ACL_HAS_ROLE\",\"deny\":\"ACL_NULL\",\"actions\":{\"SET\":{\"allow\":[\"ROOT\",\"CACHE_SET\"],\"deny\":[\"deny_CACHE_SET\"]},\"RESET\":{\"allow\":[\"ROOT\",\"CACHE_RESET\"],\"deny\":[\"deny_CACHE_RESET\"]},\"CLEAR\":{\"allow\":[\"ROOT\",\"CACHE_CLEAR\"],\"deny\":[\"deny_CACHE_CLEAR\"]},\"RUNTIME\":{\"allow\":[\"ROOT\",\"CACHE_RUNTIME\"],\"deny\":[\"deny_CACHE_RUNTIME\"]}}},\"CONSOLE\":{\"allow\":\"ACL_HAS_ROLE\",\"deny\":\"ACL_NULL\",\"actions\":{\"INDEX\":{\"allow\":[\"ROOT\",\"CONSOLE_INDEX\",\"BASEROLE\"],\"deny\":[\"deny_CONSOLE_INDEX\",\"deny_BASEROLE\"]},\"ENV\":{\"allow\":[\"ROOT\",\"CONSOLE_ENV\",\"BASEROLE\"],\"deny\":[\"deny_CONSOLE_ENV\",\"deny_BASEROLE\"]}}},\"GROUP\":{\"allow\":\"ACL_HAS_ROLE\",\"deny\":\"ACL_NULL\",\"actions\":{\"LIST\":{\"allow\":[\"ROOT\",\"GROUP_LIST\"],\"deny\":[\"deny_GROUP_LIST\"]},\"BIND\":{\"allow\":[\"ROOT\",\"GROUP_BIND\"],\"deny\":[\"deny_GROUP_BIND\"]},\"SAVEBIND\":{\"allow\":[\"ROOT\",\"GROUP_SAVEBIND\"],\"deny\":[\"deny_GROUP_SAVEBIND\"]},\"ADD\":{\"allow\":[\"ROOT\",\"GROUP_ADD\"],\"deny\":[\"deny_GROUP_ADD\"]},\"EDIT\":{\"allow\":[\"ROOT\",\"GROUP_EDIT\"],\"deny\":[\"deny_GROUP_EDIT\"]},\"SAVE\":{\"allow\":[\"ROOT\",\"GROUP_SAVE\"],\"deny\":[\"deny_GROUP_SAVE\"]},\"UPDATE\":{\"allow\":[\"ROOT\",\"GROUP_UPDATE\"],\"deny\":[\"deny_GROUP_UPDATE\"]},\"REMOVE\":{\"allow\":[\"ROOT\",\"GROUP_REMOVE\"],\"deny\":[\"deny_GROUP_REMOVE\"]}}},\"LIMIT\":{\"allow\":\"ACL_HAS_ROLE\",\"deny\":\"ACL_NULL\",\"actions\":{\"LIST\":{\"allow\":[\"ROOT\",\"LIMIT_LIST\"],\"deny\":[\"deny_LIMIT_LIST\"]},\"ALLCTL\":{\"allow\":[\"ROOT\",\"LIMIT_ALLCTL\"],\"deny\":[\"deny_LIMIT_ALLCTL\"]},\"CTLALIASUPDATE\":{\"allow\":[\"ROOT\",\"LIMIT_CTLALIASUPDATE\"],\"deny\":[\"deny_LIMIT_CTLALIASUPDATE\"]},\"ACTALIASUPDATE\":{\"allow\":[\"ROOT\",\"LIMIT_ACTALIASUPDATE\"],\"deny\":[\"deny_LIMIT_ACTALIASUPDATE\"]},\"ADDCTL\":{\"allow\":[\"ROOT\",\"LIMIT_ADDCTL\"],\"deny\":[\"deny_LIMIT_ADDCTL\"]},\"CREATELG\":{\"allow\":[\"ROOT\",\"LIMIT_CREATELG\"],\"deny\":[\"deny_LIMIT_CREATELG\"]},\"ADDACT\":{\"allow\":[\"ROOT\",\"LIMIT_ADDACT\"],\"deny\":[\"deny_LIMIT_ADDACT\"]},\"CREATEL\":{\"allow\":[\"ROOT\",\"LIMIT_CREATEL\"],\"deny\":[\"deny_LIMIT_CREATEL\"]}}},\"LOGIN\":{\"allow\":\"ACL_EVERYONE\",\"deny\":\"ACL_NULL\"},\"MEDIA\":{\"allow\":\"ACL_HAS_ROLE\",\"deny\":\"ACL_NULL\",\"actions\":{\"INDEX\":{\"allow\":[\"ROOT\",\"MEDIA_INDEX\"],\"deny\":[\"deny_MEDIA_INDEX\"]},\"LIST\":{\"allow\":[\"ROOT\",\"MEDIA_LIST\"],\"deny\":[\"deny_MEDIA_LIST\"]},\"ADD\":{\"allow\":[\"ROOT\",\"MEDIA_ADD\"],\"deny\":[\"deny_MEDIA_ADD\"]},\"EDIT\":{\"allow\":[\"ROOT\",\"MEDIA_EDIT\"],\"deny\":[\"deny_MEDIA_EDIT\"]},\"DEL\":{\"allow\":[\"ROOT\",\"MEDIA_DEL\"],\"deny\":[\"deny_MEDIA_DEL\"]}}},\"NODE\":{\"allow\":\"ACL_HAS_ROLE\",\"deny\":\"ACL_NULL\",\"actions\":{\"LIST\":{\"allow\":[\"ROOT\",\"NODE_LIST\"],\"deny\":[\"deny_NODE_LIST\"]},\"ADD\":{\"allow\":[\"ROOT\",\"NODE_ADD\"],\"deny\":[\"deny_NODE_ADD\"]},\"EDIT\":{\"allow\":[\"ROOT\",\"NODE_EDIT\"],\"deny\":[\"deny_NODE_EDIT\"]},\"SAVE\":{\"allow\":[\"ROOT\",\"NODE_SAVE\"],\"deny\":[\"deny_NODE_SAVE\"]},\"UPDATE\":{\"allow\":[\"ROOT\",\"NODE_UPDATE\"],\"deny\":[\"deny_NODE_UPDATE\"]},\"TOVOID\":{\"allow\":[\"ROOT\",\"NODE_TOVOID\"],\"deny\":[\"deny_NODE_TOVOID\"]},\"BACKSHOW\":{\"allow\":[\"ROOT\",\"NODE_BACKSHOW\"],\"deny\":[\"deny_NODE_BACKSHOW\"]},\"DEL\":{\"allow\":[\"ROOT\",\"NODE_DEL\"],\"deny\":[\"deny_NODE_DEL\"]}}},\"CATEGORY\":{\"allow\":\"ACL_HAS_ROLE\",\"deny\":\"ACL_NULL\",\"actions\":{\"LIST\":{\"allow\":[\"ROOT\",\"CATEGORY_LIST\"],\"deny\":[\"deny_CATEGORY_LIST\"]},\"DEL\":{\"allow\":[\"ROOT\",\"CATEGORY_DEL\"],\"deny\":[\"deny_CATEGORY_DEL\"]},\"SAVE\":{\"allow\":[\"ROOT\",\"CATEGORY_SAVE\"],\"deny\":[\"deny_CATEGORY_SAVE\"]},\"EDIT\":{\"allow\":[\"ROOT\",\"CATEGORY_EDIT\"],\"deny\":[\"deny_CATEGORY_EDIT\"]},\"ADD\":{\"allow\":[\"ROOT\",\"CATEGORY_ADD\"],\"deny\":[\"deny_CATEGORY_ADD\"]}}},\"RANK\":{\"allow\":\"ACL_HAS_ROLE\",\"deny\":\"ACL_NULL\",\"actions\":{\"LIST\":{\"allow\":[\"ROOT\",\"RANK_LIST\"],\"deny\":[\"deny_RANK_LIST\"]},\"ADD\":{\"allow\":[\"ROOT\",\"RANK_ADD\"],\"deny\":[\"deny_RANK_ADD\"]},\"EDIT\":{\"allow\":[\"ROOT\",\"RANK_EDIT\"],\"deny\":[\"deny_RANK_EDIT\"]},\"SAVE\":{\"allow\":[\"ROOT\",\"RANK_SAVE\"],\"deny\":[\"deny_RANK_SAVE\"]},\"UPDATE\":{\"allow\":[\"ROOT\",\"RANK_UPDATE\"],\"deny\":[\"deny_RANK_UPDATE\"]},\"REMOVE\":{\"allow\":[\"ROOT\",\"RANK_REMOVE\"],\"deny\":[\"deny_RANK_REMOVE\"]}}},\"ROLE\":{\"allow\":\"ACL_HAS_ROLE\",\"deny\":\"ACL_NULL\",\"actions\":{\"LIST\":{\"allow\":[\"ROOT\",\"ROLE_LIST\"],\"deny\":[\"deny_ROLE_LIST\"]},\"BIND\":{\"allow\":[\"ROOT\",\"ROLE_BIND\"],\"deny\":[\"deny_ROLE_BIND\"]},\"SAVEBIND\":{\"allow\":[\"ROOT\",\"ROLE_SAVEBIND\"],\"deny\":[\"deny_ROLE_SAVEBIND\"]},\"ADD\":{\"allow\":[\"ROOT\",\"ROLE_ADD\"],\"deny\":[\"deny_ROLE_ADD\"]},\"EDIT\":{\"allow\":[\"ROOT\",\"ROLE_EDIT\"],\"deny\":[\"deny_ROLE_EDIT\"]},\"SAVE\":{\"allow\":[\"ROOT\",\"ROLE_SAVE\"],\"deny\":[\"deny_ROLE_SAVE\"]},\"UPDATE\":{\"allow\":[\"ROOT\",\"ROLE_UPDATE\"],\"deny\":[\"deny_ROLE_UPDATE\"]},\"REMOVE\":{\"allow\":[\"ROOT\",\"ROLE_REMOVE\"],\"deny\":[\"deny_ROLE_REMOVE\"]}}},\"TOOL\":{\"allow\":\"ACL_HAS_ROLE\",\"deny\":\"ACL_NULL\",\"actions\":{\"MAKEACL\":{\"allow\":[\"ROOT\",\"TOOL_MAKEACL\"],\"deny\":[\"deny_TOOL_MAKEACL\"]}}},\"USERM\":{\"allow\":\"ACL_HAS_ROLE\",\"deny\":\"ACL_NULL\",\"actions\":{\"LIST\":{\"allow\":[\"ROOT\",\"USERM_LIST\"],\"deny\":[\"deny_USERM_LIST\"]},\"ADD\":{\"allow\":[\"ROOT\",\"USERM_ADD\"],\"deny\":[\"deny_USERM_ADD\"]},\"EDIT\":{\"allow\":[\"ROOT\",\"USERM_EDIT\"],\"deny\":[\"deny_USERM_EDIT\"]},\"SAVE\":{\"allow\":[\"ROOT\",\"USERM_SAVE\"],\"deny\":[\"deny_USERM_SAVE\"]},\"UPDATE\":{\"allow\":[\"ROOT\",\"USERM_UPDATE\"],\"deny\":[\"deny_USERM_UPDATE\"]},\"REMOVE\":{\"allow\":[\"ROOT\",\"USERM_REMOVE\"],\"deny\":[\"deny_USERM_REMOVE\"]},\"CHECKMOB\":{\"allow\":[\"ROOT\",\"USERM_CHECKMOB\"],\"deny\":[\"deny_USERM_CHECKMOB\"]}}},\"PAGE\":{\"allow\":\"ACL_HAS_ROLE\",\"deny\":\"ACL_NULL\",\"actions\":{\"LIST\":{\"allow\":[\"ROOT\",\"PAGE_LIST\"],\"deny\":[\"deny_PAGE_LIST\"]},\"ADD\":{\"allow\":[\"ROOT\",\"PAGE_ADD\"],\"deny\":[\"deny_PAGE_ADD\"]},\"SAVE\":{\"allow\":[\"ROOT\",\"PAGE_SAVE\"],\"deny\":[\"deny_PAGE_SAVE\"]},\"EDIT\":{\"allow\":[\"ROOT\",\"PAGE_EDIT\"],\"deny\":[\"deny_PAGE_EDIT\"]},\"UPDATE\":{\"allow\":[\"ROOT\",\"PAGE_UPDATE\"],\"deny\":[\"deny_PAGE_UPDATE\"]},\"REMOVE\":{\"allow\":[\"ROOT\",\"PAGE_REMOVE\"],\"deny\":[\"deny_PAGE_REMOVE\"]}}}}');
INSERT INTO `common_syscache` VALUES ('sys_category', '1', '1501133968', '{\\\"1\\\":{\\\"catid\\\":1,\\\"upid\\\":0,\\\"name\\\":\\\"咨询分类\\\",\\\"sortby\\\":0,\\\"channel\\\":1},\\\"27\\\":{\\\"catid\\\":27,\\\"upid\\\":1,\\\"name\\\":\\\"文章\\\",\\\"sortby\\\":0,\\\"channel\\\":0},\\\"tree\\\":{\\\"1\\\":{\\\"catid\\\":1,\\\"upid\\\":0,\\\"name\\\":\\\"咨询分类\\\",\\\"sortby\\\":0,\\\"channel\\\":1,\\\"children\\\":{\\\"27\\\":{\\\"catid\\\":27,\\\"upid\\\":1,\\\"name\\\":\\\"文章\\\",\\\"sortby\\\":0,\\\"channel\\\":0}}}}}');
INSERT INTO `common_syscache` VALUES ('sys_nodecategory', '1', '1501979500', '{\\\"1\\\":{\\\"catid\\\":1,\\\"upid\\\":0,\\\"name\\\":\\\"咨询分类\\\",\\\"sortby\\\":0,\\\"channel\\\":1},\\\"27\\\":{\\\"catid\\\":27,\\\"upid\\\":1,\\\"name\\\":\\\"文章\\\",\\\"sortby\\\":0,\\\"channel\\\":0},\\\"tree\\\":{\\\"1\\\":{\\\"catid\\\":1,\\\"upid\\\":0,\\\"name\\\":\\\"咨询分类\\\",\\\"sortby\\\":0,\\\"channel\\\":1,\\\"children\\\":{\\\"27\\\":{\\\"catid\\\":27,\\\"upid\\\":1,\\\"name\\\":\\\"文章\\\",\\\"sortby\\\":0,\\\"channel\\\":0}}}}}');
INSERT INTO `common_syscache` VALUES ('sys_node_category', '1', '1501979017', '{\\\"1\\\":{\\\"catid\\\":1,\\\"upid\\\":0,\\\"name\\\":\\\"咨询分类\\\",\\\"sortby\\\":0,\\\"channel\\\":1},\\\"27\\\":{\\\"catid\\\":27,\\\"upid\\\":1,\\\"name\\\":\\\"文章\\\",\\\"sortby\\\":0,\\\"channel\\\":0},\\\"tree\\\":{\\\"1\\\":{\\\"catid\\\":1,\\\"upid\\\":0,\\\"name\\\":\\\"咨询分类\\\",\\\"sortby\\\":0,\\\"channel\\\":1,\\\"children\\\":{\\\"27\\\":{\\\"catid\\\":27,\\\"upid\\\":1,\\\"name\\\":\\\"文章\\\",\\\"sortby\\\":0,\\\"channel\\\":0}}}}}');

-- ----------------------------
-- Table structure for `node`
-- ----------------------------
DROP TABLE IF EXISTS `node`;
CREATE TABLE `node` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'AUTO ID',
  `fid` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',
  `subject` varchar(100) NOT NULL COMMENT '标题',
  `digest` varchar(255) DEFAULT '',
  `content` text NOT NULL COMMENT '内容',
  `tags` varchar(100) DEFAULT '' COMMENT '关键词',
  `thumb` varchar(100) DEFAULT '0' COMMENT '缩略图地址',
  `hash` char(32) DEFAULT '' COMMENT '多图上传',
  `userid` int(10) unsigned NOT NULL COMMENT '发布者ID',
  `author` varchar(15) DEFAULT '' COMMENT '发布者',
  `praisenum` int(10) DEFAULT '0' COMMENT '赞成',
  `eggsnum` int(10) DEFAULT '0' COMMENT '鸡蛋',
  `favtimes` int(10) DEFAULT '0' COMMENT '收藏次数',
  `review` int(10) DEFAULT '0' COMMENT '评论',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `created` int(10) unsigned NOT NULL COMMENT '创建日期',
  `updated` int(10) unsigned DEFAULT '0' COMMENT '修改日期',
  PRIMARY KEY (`tid`),
  KEY `userid` (`userid`,`status`,`created`),
  KEY `tid` (`tid`,`status`),
  KEY `status` (`status`,`created`,`fid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COMMENT='文章';

-- ----------------------------
-- Records of node
-- ----------------------------
INSERT INTO `node` VALUES ('53', '27', '22222222222222', '', '22222333', '', '0', '', '1', 'admin', '0', '0', '0', '0', '1', '1492085585', '1516159203');

-- ----------------------------
-- Table structure for `node_category`
-- ----------------------------
DROP TABLE IF EXISTS `node_category`;
CREATE TABLE `node_category` (
  `catid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `upid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '上级ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '分类名称',
  `sortby` smallint(4) unsigned NOT NULL DEFAULT '0',
  `channel` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否频道',
  PRIMARY KEY (`catid`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='文章分类';

-- ----------------------------
-- Records of node_category
-- ----------------------------
INSERT INTO `node_category` VALUES ('1', '0', '咨询分类', '0', '1');
INSERT INTO `node_category` VALUES ('27', '1', '文章', '0', '0');

-- ----------------------------
-- Table structure for `node_media`
-- ----------------------------
DROP TABLE IF EXISTS `node_media`;
CREATE TABLE `node_media` (
  `aid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `idtype` varchar(10) DEFAULT NULL,
  `itemid` int(10) unsigned DEFAULT '0' COMMENT 'threadID',
  `digest` varchar(255) DEFAULT NULL COMMENT '描述',
  `filesite` char(3) NOT NULL DEFAULT 'loc' COMMENT '文件服务器',
  `filepath` varchar(100) NOT NULL COMMENT '文件磁盘路径path',
  `isimage` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否图片',
  `status` tinyint(1) unsigned DEFAULT '1',
  `created` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上传日期',
  `hash` char(32) DEFAULT NULL COMMENT '多图上传会用到',
  `userid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上传用户ID',
  PRIMARY KEY (`aid`),
  KEY `status` (`status`,`created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='附件';

-- ----------------------------
-- Records of node_media
-- ----------------------------

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wxid` int(10) unsigned DEFAULT '0',
  `openid` varchar(64) DEFAULT NULL,
  `unionid` varchar(64) DEFAULT NULL,
  `username` varchar(32) DEFAULT NULL COMMENT '用户名',
  `password` char(32) DEFAULT NULL COMMENT '密码',
  `salt` char(10) DEFAULT NULL COMMENT '密码KEY',
  `email` varchar(50) DEFAULT NULL COMMENT '电邮',
  `nickname` varchar(15) DEFAULT NULL,
  `headimg` varchar(100) DEFAULT '',
  `gender` tinyint(1) unsigned DEFAULT '1',
  `user_money` decimal(10,2) DEFAULT '0.00' COMMENT '余额',
  `frozen_money` decimal(10,2) DEFAULT '0.00' COMMENT '冻结余额',
  `rank_points` int(10) DEFAULT '0' COMMENT '等级积分',
  `pay_points` int(10) DEFAULT '0' COMMENT '消费积分',
  `secques` varchar(32) DEFAULT '' COMMENT '密码问题',
  `groupid` smallint(4) unsigned DEFAULT '1' COMMENT '等级ID',
  `memo` varchar(255) DEFAULT '',
  `name` varchar(20) DEFAULT NULL,
  `mob` varchar(20) DEFAULT NULL,
  `mobloc` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address_id` int(10) unsigned DEFAULT '0',
  `access_token` varchar(100) DEFAULT NULL,
  `subscribe` tinyint(1) unsigned DEFAULT '0',
  `kf_state` tinyint(1) unsigned DEFAULT '0',
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '用户状态',
  `is_delete` tinyint(1) unsigned DEFAULT '0',
  `created` int(10) unsigned DEFAULT NULL,
  `updated` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `openid` (`openid`),
  KEY `email` (`email`) USING BTREE,
  KEY `username` (`username`) USING BTREE,
  KEY `status` (`status`,`created`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户';

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', '0', 'openid', null, 'test', '4adf90cc45885fa948c412a55998d791', '5f0d19', 'vodo@web.com', null, null, '1', '0.00', '0.00', '0', '0', null, '1', 'q', 'tk', '13635462313', '重庆', '(023)68894420', '2', null, '1', '0', '1', '0', '1400164707', '1501979508');

-- ----------------------------
-- Table structure for `user_address`
-- ----------------------------
DROP TABLE IF EXISTS `user_address`;
CREATE TABLE `user_address` (
  `address_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `consignee` varchar(60) NOT NULL DEFAULT '',
  `email` varchar(60) NOT NULL DEFAULT '',
  `country` smallint(5) NOT NULL DEFAULT '0',
  `province` smallint(5) NOT NULL DEFAULT '0',
  `city` smallint(5) NOT NULL DEFAULT '0',
  `district` smallint(5) NOT NULL DEFAULT '0',
  `address` varchar(120) NOT NULL DEFAULT '',
  `zipcode` varchar(60) NOT NULL DEFAULT '',
  `tel` varchar(60) NOT NULL DEFAULT '',
  `mobile` varchar(60) NOT NULL DEFAULT '',
  `sign_building` varchar(120) NOT NULL DEFAULT '',
  `best_time` varchar(120) NOT NULL DEFAULT '',
  PRIMARY KEY (`address_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_address
-- ----------------------------
INSERT INTO `user_address` VALUES ('1', '1', '刘先生', 'ecshop@ecshop.com', '1', '2', '52', '502', '海兴大厦', '', '010-25851234', '13986765412', '', '');
INSERT INTO `user_address` VALUES ('2', '3', '叶先生', 'text@ecshop.com', '1', '2', '52', '510', '通州区旗舰凯旋小区', '', '13588104710', '', '', '');

-- ----------------------------
-- Table structure for `user_group`
-- ----------------------------
DROP TABLE IF EXISTS `user_group`;
CREATE TABLE `user_group` (
  `groupid` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL,
  `balance` int(8) unsigned NOT NULL DEFAULT '500',
  `scores` int(8) unsigned NOT NULL DEFAULT '0',
  `sortby` tinyint(2) unsigned DEFAULT '0',
  `status` tinyint(1) unsigned DEFAULT '1',
  PRIMARY KEY (`groupid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='会员组';

-- ----------------------------
-- Records of user_group
-- ----------------------------
INSERT INTO `user_group` VALUES ('1', '普通会员', '10', '10', null, '1');
INSERT INTO `user_group` VALUES ('3', '钻石会员', '100', '100', null, '1');

-- ----------------------------
-- Table structure for `user_profile`
-- ----------------------------
DROP TABLE IF EXISTS `user_profile`;
CREATE TABLE `user_profile` (
  `uid` int(10) unsigned NOT NULL,
  `birthyear` char(4) DEFAULT NULL,
  `birthmon` char(2) DEFAULT NULL,
  `birthday` char(2) DEFAULT NULL,
  `country` varchar(32) DEFAULT '-',
  `province` varchar(32) DEFAULT '-',
  `city` varchar(32) DEFAULT '-',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员附表';

-- ----------------------------
-- Records of user_profile
-- ----------------------------
INSERT INTO `user_profile` VALUES ('1', '', '', '', '-', '-', '-');

-- ----------------------------
-- Table structure for `user_stats`
-- ----------------------------
DROP TABLE IF EXISTS `user_stats`;
CREATE TABLE `user_stats` (
  `uid` mediumint(8) unsigned NOT NULL,
  `regip` char(15) NOT NULL DEFAULT '',
  `lastip` char(15) NOT NULL DEFAULT '',
  `failedlogin` tinyint(2) DEFAULT '0',
  `lastactivity` int(10) unsigned NOT NULL DEFAULT '0',
  `loginnum` mediumint(6) DEFAULT '0',
  `invisible` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_stats
-- ----------------------------
INSERT INTO `user_stats` VALUES ('1', '', '::1', '0', '1448533106', '1024', '0');
