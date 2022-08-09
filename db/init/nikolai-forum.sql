/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50641
 Source Host           : localhost:3306
 Source Schema         : nikolai-forum

 Target Server Type    : MySQL
 Target Server Version : 50641
 File Encoding         : 65001

 Date: 22/06/2020 14:01:30
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bans
-- ----------------------------
DROP TABLE IF EXISTS `bans`;
CREATE TABLE `bans`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_from_id` int(11) NOT NULL,
  `user_to_id` int(11) NOT NULL,
  `description` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ban_datetime_int` int(11) NULL DEFAULT NULL,
  `is_permanent` tinyint(1) NOT NULL DEFAULT 0,
  `unban_datetime_int` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `BANS_KEY_1`(`user_from_id`) USING BTREE,
  INDEX `BANS_KEY_2`(`user_to_id`) USING BTREE,
  CONSTRAINT `BANS_KEY_1` FOREIGN KEY (`user_from_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `BANS_KEY_2` FOREIGN KEY (`user_to_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of bans
-- ----------------------------

-- ----------------------------
-- Table structure for commentaries
-- ----------------------------
DROP TABLE IF EXISTS `commentaries`;
CREATE TABLE `commentaries`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) NULL DEFAULT NULL,
  `user_from_id` int(11) NULL DEFAULT NULL,
  `text` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `creation_datetime_int` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `COMMENTARIES_KEY_1`(`topic_id`) USING BTREE,
  INDEX `COMMENTARIES_KEY_2`(`user_from_id`) USING BTREE,
  CONSTRAINT `COMMENTARIES_KEY_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `COMMENTARIES_KEY_2` FOREIGN KEY (`user_from_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of commentaries
-- ----------------------------

-- ----------------------------
-- Table structure for forums
-- ----------------------------
DROP TABLE IF EXISTS `forums`;
CREATE TABLE `forums`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(63) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Без названия',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Нет описания',
  `user_from_id` int(11) NULL DEFAULT NULL,
  `forum_id` int(11) NULL DEFAULT 0,
  `is_category` tinyint(1) NOT NULL DEFAULT 0,
  `is_description_hided` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `FORUMS_KEY_1`(`user_from_id`) USING BTREE,
  INDEX `FORUMS_KEY_2`(`forum_id`) USING BTREE,
  CONSTRAINT `FORUMS_KEY_1` FOREIGN KEY (`user_from_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `FORUMS_KEY_2` FOREIGN KEY (`forum_id`) REFERENCES `forums` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of forums
-- ----------------------------
-- Так как MySQL всё равно присваивает id = 1, даже если указать 0, то создаём с id = 1, а затем обновляем его на 0
INSERT INTO `forums` VALUES (1, 'Главный форум', 'Нет описания', NULL, 0, 0, 1);
UPDATE `forums` SET id = 0 WHERE id = 1;

-- ----------------------------
-- Table structure for groups
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_from_id` int(11) NULL DEFAULT NULL,
  `rank` int(11) NOT NULL DEFAULT 100,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Без названия',
  `description` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `can_warn_users_in_lower_groups` tinyint(1) NOT NULL DEFAULT 2,
  `can_unwarn_warns_from_him` tinyint(1) NOT NULL DEFAULT 2,
  `can_unwarn_warns_from_users_in_lower_groups` tinyint(1) NOT NULL DEFAULT 2,
  `can_unwarn_warns_from_users_in_groups_with_same_rank` tinyint(1) NOT NULL DEFAULT 2,
  `can_ban_users_in_lower_groups` tinyint(1) NOT NULL DEFAULT 2,
  `can_unban_bans_from_him` tinyint(1) NOT NULL DEFAULT 2,
  `can_unban_bans_from_users_in_lower_groups` tinyint(1) NOT NULL DEFAULT 2,
  `can_unban_bans_from_users_in_groups_with_same_rank` tinyint(1) NOT NULL DEFAULT 2,
  `can_create_groups` tinyint(1) NOT NULL DEFAULT 2,
  `can_edit_groups_from_him` tinyint(1) NOT NULL DEFAULT 2,
  `can_edit_groups_from_users_in_lower_groups` tinyint(1) NOT NULL DEFAULT 2,
  `can_edit_groups_from_users_in_groups_with_same_rank` tinyint(1) NOT NULL DEFAULT 2,
  `can_delete_groups_from_him` tinyint(1) NOT NULL DEFAULT 2,
  `can_delete_groups_from_users_in_lower_groups` tinyint(1) NOT NULL DEFAULT 2,
  `can_delete_groups_from_users_in_groups_with_same_rank` tinyint(1) NOT NULL DEFAULT 2,
  `can_edit_users_in_lower_groups` tinyint(1) NOT NULL DEFAULT 2,
  `can_change_users_in_lower_groups_attach_to_lower_groups` tinyint(1) NOT NULL DEFAULT 2,
  `can_change_users_in_groups_with_same_rank_attach_to_lower_groups` tinyint(1) NOT NULL DEFAULT 2,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `GROUPS_KEY`(`user_from_id`) USING BTREE,
  CONSTRAINT `GROUPS_KEY` FOREIGN KEY (`user_from_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of groups
-- ----------------------------
INSERT INTO `groups` VALUES (-1, -1, -1, 'Скрытые Владельцы', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `groups` VALUES (1, NULL, 1, 'Владельцы', 'Высшая группа с полным доступом.', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `groups` VALUES (2, NULL, 999, 'Пользователи', 'В эту группу входят все зарегистрированные пользователи.', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `groups` VALUES (3, NULL, 1000, 'Гости', 'Незарегистрированные посетители.', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- ----------------------------
-- Table structure for groups_permissions_to_forums
-- ----------------------------
DROP TABLE IF EXISTS `groups_permissions_to_forums`;
CREATE TABLE `groups_permissions_to_forums`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `forum_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `can_see_this_forum` tinyint(1) NOT NULL DEFAULT 1,
  `can_edit_this_forum` tinyint(1) NOT NULL DEFAULT 2,
  `can_delete_this_forum` tinyint(1) NOT NULL DEFAULT 2,
  `can_create_forums` tinyint(1) NOT NULL DEFAULT 2,
  `can_create_topics` tinyint(1) NOT NULL DEFAULT 2,
  `can_create_commentaries` tinyint(1) NOT NULL DEFAULT 2,
  `can_edit_forums_from_him` tinyint(1) NOT NULL DEFAULT 2,
  `can_edit_forums_from_users_in_lower_groups` tinyint(1) NOT NULL DEFAULT 2,
  `can_edit_forums_from_users_in_groups_with_same_rank` tinyint(1) NOT NULL DEFAULT 2,
  `can_delete_forums_from_him` tinyint(1) NOT NULL DEFAULT 2,
  `can_delete_forums_from_users_in_lower_groups` tinyint(1) NOT NULL DEFAULT 2,
  `can_delete_forums_from_users_in_groups_with_same_rank` tinyint(1) NOT NULL DEFAULT 2,
  `can_edit_topics_from_him` tinyint(1) NOT NULL DEFAULT 2,
  `can_edit_topics_from_users_in_lower_groups` tinyint(1) NOT NULL DEFAULT 2,
  `can_edit_topics_from_users_in_groups_with_same_rank` tinyint(1) NOT NULL DEFAULT 2,
  `can_delete_topics_from_him` tinyint(1) NOT NULL DEFAULT 2,
  `can_delete_topics_from_users_in_lower_groups` tinyint(1) NOT NULL DEFAULT 2,
  `can_delete_topics_from_users_in_groups_with_same_rank` tinyint(1) NOT NULL DEFAULT 2,
  `can_edit_commentaries_from_him` tinyint(1) NOT NULL DEFAULT 2,
  `can_edit_commentaries_from_users_in_lower_groups` tinyint(1) NOT NULL DEFAULT 2,
  `can_edit_commentaries_from_users_in_groups_with_same_rank` tinyint(1) NOT NULL DEFAULT 2,
  `can_delete_commentaries_from_him` tinyint(1) NOT NULL DEFAULT 2,
  `can_delete_commentaries_from_users_in_lower_groups` tinyint(1) NOT NULL DEFAULT 2,
  `can_delete_commentaries_from_users_in_groups_with_same_rank` tinyint(1) NOT NULL DEFAULT 2,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `GROUPS_PERMISSIONS_TO_FORUMS_UNIQUE`(`forum_id`, `group_id`) USING BTREE,
  INDEX `GROUPS_PERMISSIONS_TO_FORUMS_KEY_2`(`group_id`) USING BTREE,
  CONSTRAINT `GROUPS_PERMISSIONS_TO_FORUMS_KEY_1` FOREIGN KEY (`forum_id`) REFERENCES `forums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `GROUPS_PERMISSIONS_TO_FORUMS_KEY_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of groups_permissions_to_forums
-- ----------------------------
INSERT INTO `groups_permissions_to_forums` VALUES (1, 0, -1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `groups_permissions_to_forums` VALUES (2, 0, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `groups_permissions_to_forums` VALUES (3, 0, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `groups_permissions_to_forums` VALUES (4, 0, 3, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- ----------------------------
-- Table structure for topics
-- ----------------------------
DROP TABLE IF EXISTS `topics`;
CREATE TABLE `topics`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Нет описания',
  `user_from_id` int(11) NULL DEFAULT NULL,
  `forum_id` int(11) NULL DEFAULT NULL,
  `is_closed` tinyint(1) NOT NULL DEFAULT 0,
  `is_description_hided` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `TOPICS_KEY_2`(`forum_id`) USING BTREE,
  INDEX `TOPICS_KEY_1`(`user_from_id`) USING BTREE,
  CONSTRAINT `TOPICS_KEY_1` FOREIGN KEY (`user_from_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `TOPICS_KEY_2` FOREIGN KEY (`forum_id`) REFERENCES `forums` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of topics
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varbinary(32) NOT NULL,
  `password_md5` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `registration_ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `registration_datetime_int` int(11) NULL DEFAULT NULL,
  `last_active_datetime_int` int(11) NULL DEFAULT NULL,
  `avatar_link` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `about` varchar(512) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `role` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Пользователь',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `USERS_INDEX`(`nick`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of users
-- ----------------------------
-- Начальный пароль от админки - 123456789
INSERT INTO `users` VALUES (-1, 0x61646D696E, '25f9e794323b453885f5181f1b624d0b', NULL, NULL, 1592771035, '', '', NULL);

-- ----------------------------
-- Table structure for users_to_groups
-- ----------------------------
DROP TABLE IF EXISTS `users_to_groups`;
CREATE TABLE `users_to_groups`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `USERS_TO_GROUPS_KEY_1`(`user_id`) USING BTREE,
  INDEX `USERS_TO_GROUPS_KEY_2`(`group_id`) USING BTREE,
  CONSTRAINT `USERS_TO_GROUPS_KEY_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `USERS_TO_GROUPS_KEY_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of users_to_groups
-- ----------------------------
INSERT INTO `users_to_groups` VALUES (-1, -1, -1);

-- ----------------------------
-- Table structure for warns
-- ----------------------------
DROP TABLE IF EXISTS `warns`;
CREATE TABLE `warns`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_from_id` int(11) NOT NULL,
  `user_to_id` int(11) NOT NULL,
  `description` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `warn_datetime_int` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `WARNS_KEY_1`(`user_from_id`) USING BTREE,
  INDEX `WARNS_KEY_2`(`user_to_id`) USING BTREE,
  CONSTRAINT `WARNS_KEY_1` FOREIGN KEY (`user_from_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `WARNS_KEY_2` FOREIGN KEY (`user_to_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of warns
-- ----------------------------

-- ----------------------------
-- Triggers structure for table groups
-- ----------------------------
DROP TRIGGER IF EXISTS `GROUPS_AFTER_INSERT`;
delimiter ;;
CREATE TRIGGER `GROUPS_AFTER_INSERT` AFTER INSERT ON `groups` FOR EACH ROW BEGIN
	DECLARE _i INT;
	DECLARE _forum_id INT;
	DECLARE _group_id INT;
	DECLARE _forums_count INT;
	
	SET _group_id = NEW.id;
	
	SELECT COUNT(id) FROM forums INTO _forums_count;
	
	SET _i = 0;
	WHILE _i < _forums_count DO
		SELECT id FROM forums LIMIT 1 OFFSET _i INTO _forum_id;
		IF _forum_id = 0 THEN
			INSERT INTO groups_permissions_to_forums(group_id, forum_id,
				can_see_this_forum,
				can_edit_this_forum,
				can_delete_this_forum,
				can_create_forums,
				can_create_topics,
				can_create_commentaries,
				can_edit_forums_from_him,
				can_edit_forums_from_users_in_lower_groups,
				can_edit_forums_from_users_in_groups_with_same_rank,
				can_delete_forums_from_him,
				can_delete_forums_from_users_in_lower_groups,
				can_delete_forums_from_users_in_groups_with_same_rank,
				can_edit_topics_from_him,
				can_edit_topics_from_users_in_lower_groups,
				can_edit_topics_from_users_in_groups_with_same_rank,
				can_delete_topics_from_him,
				can_delete_topics_from_users_in_lower_groups,
				can_delete_topics_from_users_in_groups_with_same_rank,
				can_edit_commentaries_from_him,
				can_edit_commentaries_from_users_in_lower_groups,
				can_edit_commentaries_from_users_in_groups_with_same_rank,
				can_delete_commentaries_from_him,
				can_delete_commentaries_from_users_in_lower_groups,
				can_delete_commentaries_from_users_in_groups_with_same_rank
			) VALUES(_group_id, _forum_id,
				1,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0
			);
		ELSE
				INSERT INTO groups_permissions_to_forums(group_id, forum_id) VALUES(_group_id, _forum_id);
		END IF;
		SET _i = _i + 1;
	END WHILE;
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table users
-- ----------------------------
DROP TRIGGER IF EXISTS `USERS_AFTER_INSERT`;
delimiter ;;
CREATE TRIGGER `USERS_AFTER_INSERT` AFTER INSERT ON `users` FOR EACH ROW BEGIN
	INSERT INTO users_to_groups(user_id, group_id) VALUES(NEW.id, 2);
END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
