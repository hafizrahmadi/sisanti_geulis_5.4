/*
 Navicat Premium Data Transfer

 Source Server         : localhost_phpmyadmin
 Source Server Type    : MySQL
 Source Server Version : 100411
 Source Host           : localhost:3306
 Source Schema         : db_sisanti_geulis

 Target Server Type    : MySQL
 Target Server Version : 100411
 File Encoding         : 65001

 Date: 25/04/2020 16:51:23
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
BEGIN;
INSERT INTO `migrations` VALUES (1, '2020_04_18_075127_create_model_users_table', 1);
INSERT INTO `migrations` VALUES (3, '2014_10_12_100000_create_password_resets_table', 2);
INSERT INTO `migrations` VALUES (5, '2014_10_12_000000_create_users_table', 3);
INSERT INTO `migrations` VALUES (6, '2020_04_23_215557_create_surat_masuk_table', 3);
COMMIT;

-- ----------------------------
-- Table structure for tb_jabatan
-- ----------------------------
DROP TABLE IF EXISTS `tb_jabatan`;
CREATE TABLE `tb_jabatan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jabatan` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tb_jabatan
-- ----------------------------
BEGIN;
INSERT INTO `tb_jabatan` VALUES (1, 'CAMAT');
INSERT INTO `tb_jabatan` VALUES (2, 'SEKCAM');
INSERT INTO `tb_jabatan` VALUES (3, 'KASI EKBANG');
INSERT INTO `tb_jabatan` VALUES (4, 'KASI PEMERINTAHAN');
INSERT INTO `tb_jabatan` VALUES (5, 'KASI PKM');
INSERT INTO `tb_jabatan` VALUES (6, 'KASI TRAMTIB');
INSERT INTO `tb_jabatan` VALUES (7, 'KASI PELAYANAN');
INSERT INTO `tb_jabatan` VALUES (8, 'KASUBAG UMPEG');
INSERT INTO `tb_jabatan` VALUES (9, 'KASUBAG PROKEU');
INSERT INTO `tb_jabatan` VALUES (10, 'PELAKSANA');
COMMIT;

-- ----------------------------
-- Table structure for tb_surat_masuk
-- ----------------------------
DROP TABLE IF EXISTS `tb_surat_masuk`;
CREATE TABLE `tb_surat_masuk` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomor_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_surat` date NOT NULL,
  `perihal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asal_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lampiran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_user` bigint(20) unsigned NOT NULL,
  `file_dokumen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_user_camat` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tb_surat_masuk_id_user_foreign` (`id_user`),
  KEY `tb_surat_masuk_id_user_camat_foreign` (`id_user_camat`),
  CONSTRAINT `tb_surat_masuk_id_user_camat_foreign` FOREIGN KEY (`id_user_camat`) REFERENCES `tb_user` (`id`),
  CONSTRAINT `tb_surat_masuk_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tb_surat_masuk
-- ----------------------------
BEGIN;
INSERT INTO `tb_surat_masuk` VALUES (1, '123123', '2020-04-25', 'coba123', 'asdasd', 'qweqwe', 1, 'file_suratmasuk/ENodin-421.pdf', 'qwekqlwe', 3, '2020-04-25 09:45:11', '2020-04-25 09:45:11');
COMMIT;

-- ----------------------------
-- Table structure for tb_user
-- ----------------------------
DROP TABLE IF EXISTS `tb_user`;
CREATE TABLE `tb_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `npk` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pangkat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `golongan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` int(10) DEFAULT NULL,
  `role` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firebase` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tb_user_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tb_user
-- ----------------------------
BEGIN;
INSERT INTO `tb_user` VALUES (1, 'admin', 'admin', '1234', 'mimin tampan', 'tralal', '1', 10, 'admin', '-', '', '2020-04-18 13:28:07', '2020-04-22 16:23:04');
INSERT INTO `tb_user` VALUES (3, 'camat', 'camat', '123123', 'hafiz rahmadi', 'eqweqwe', '1', 1, 'camat', 'QHP2ShynvXsgHGH81e65xjwWq8qoqjRwttlDahUYsar9D4RuRyN5vJAns1hb3OJw8NaCZzshuUc59dnyjIupEQ5FCcXeThnbcaN2sGjV7Ez2O3xkcrEZmUYPrzYYxFPHIduBeHiySipgGUupcHw1wd6TqFfK2HGh', '123', '2020-04-18 13:31:49', '2020-04-25 09:44:31');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
