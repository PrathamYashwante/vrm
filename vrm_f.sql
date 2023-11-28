-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2023 at 07:45 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `blender`
--

CREATE TABLE `blender` (
  `ENTRY_DATE` date NOT NULL,
  `MCC_4_PSC` double DEFAULT NULL,
  `MCC_4_CHD` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blender_pc`
--

CREATE TABLE `blender_pc` (
  `ENTRY_DATE` date NOT NULL,
  `MCC_4_PSC` double DEFAULT NULL,
  `MCC_4_CHD` double DEFAULT NULL,
  `SUBTOTAL` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bulker`
--

CREATE TABLE `bulker` (
  `ENTRY_DATE` date NOT NULL,
  `BULKER_1` double DEFAULT NULL,
  `BULKER_2` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bulker_packers`
--

CREATE TABLE `bulker_packers` (
  `ENTRY_DATE` date NOT NULL,
  `VRM_01_BULKER_GGBS` double DEFAULT NULL,
  `SILO_01_BULKER_PSC_CHD` double DEFAULT NULL,
  `PACKER_1_MCC_5` double DEFAULT NULL,
  `PACKER_2_MCC_6` double DEFAULT NULL,
  `PACKER_3_MCC_7` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bulker_packers_pc`
--

CREATE TABLE `bulker_packers_pc` (
  `ENTRY_DATE` date NOT NULL,
  `VRM_01_BULKER_GGBS` double DEFAULT NULL,
  `SILO_01_BULKER_PSC_CHD` double DEFAULT NULL,
  `PACKER_1_MCC_5` double DEFAULT NULL,
  `PACKER_2_MCC_6` double DEFAULT NULL,
  `PACKER_3_MCC_7` double DEFAULT NULL,
  `SUBTOTAL` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bulker_pc`
--

CREATE TABLE `bulker_pc` (
  `ENTRY_DATE` date NOT NULL,
  `BULKER_1` double DEFAULT NULL,
  `BULKER_2` double DEFAULT NULL,
  `SUBTOTAL` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bulker_vrm2`
--

CREATE TABLE `bulker_vrm2` (
  `ENTRY_DATE` date NOT NULL,
  `BULKER_1` double DEFAULT NULL,
  `BULKER_2` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bulker_vrm2_pc`
--

CREATE TABLE `bulker_vrm2_pc` (
  `ENTRY_DATE` date NOT NULL,
  `BULKER_1` double DEFAULT NULL,
  `BULKER_2` double DEFAULT NULL,
  `SUBTOTAL` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `common_group`
--

CREATE TABLE `common_group` (
  `ENTRY_DATE` date NOT NULL,
  `MCC_5_HAG` double DEFAULT NULL,
  `MCC_2_HOPPER_EXTRACT` double DEFAULT NULL,
  `610BE1_PE` double DEFAULT NULL,
  `SILO_FEED` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `common_group_pc`
--

CREATE TABLE `common_group_pc` (
  `ENTRY_DATE` date NOT NULL,
  `MCC_5_HAG` double DEFAULT NULL,
  `MCC_2_HOPPER_EXTRACT` double DEFAULT NULL,
  `610BE1_PE` double DEFAULT NULL,
  `SILO_FEED` double DEFAULT NULL,
  `SUBTOTAL` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lighting_trf_loss`
--

CREATE TABLE `lighting_trf_loss` (
  `ENTRY_DATE` date NOT NULL,
  `1_6KV_LIGHTING_TRAFO` double DEFAULT NULL,
  `SLDB_1_LIGHTING` double DEFAULT NULL,
  `SLDB_3_LIGHTING` double DEFAULT NULL,
  `16_20_MVA_TRF_LOSSES` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lighting_trf_loss_pc`
--

CREATE TABLE `lighting_trf_loss_pc` (
  `ENTRY_DATE` date NOT NULL,
  `1_6KV_LIGHTING_TRAFO` double DEFAULT NULL,
  `SLDB_1_LIGHTING` double DEFAULT NULL,
  `SLDB_3_LIGHTING` double DEFAULT NULL,
  `16_20_MVA_TRF_LOSSES` double DEFAULT NULL,
  `SUBTOTAL` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lighting_trf_loss_vrm1`
--

CREATE TABLE `lighting_trf_loss_vrm1` (
  `ENTRY_DATE` date NOT NULL,
  `LIGHTING` double DEFAULT NULL,
  `6_3_MVA_TRF_LOSSES` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lighting_trf_loss_vrm1_pc`
--

CREATE TABLE `lighting_trf_loss_vrm1_pc` (
  `ENTRY_DATE` date NOT NULL,
  `LIGHTING` double DEFAULT NULL,
  `6_3_MVA_TRF_LOSSES` double DEFAULT NULL,
  `SUBTOTAL` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lighting_trf_loss_vrm2`
--

CREATE TABLE `lighting_trf_loss_vrm2` (
  `ENTRY_DATE` date NOT NULL,
  `LIGHTING` double DEFAULT NULL,
  `5MVA_TRANSFORMER` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lighting_trf_loss_vrm2_pc`
--

CREATE TABLE `lighting_trf_loss_vrm2_pc` (
  `ENTRY_DATE` date NOT NULL,
  `LIGHTING` double DEFAULT NULL,
  `5MVA_TRANSFORMER` double DEFAULT NULL,
  `SUBTOTAL` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `others`
--

CREATE TABLE `others` (
  `ENTRY_DATE` date NOT NULL,
  `JETTY` double DEFAULT NULL,
  `M_SAND` double DEFAULT NULL,
  `VRM_3_PROJECT` double DEFAULT NULL,
  `GIS_LOSSES` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `others_pc`
--

CREATE TABLE `others_pc` (
  `ENTRY_DATE` date NOT NULL,
  `JETTY` double DEFAULT NULL,
  `M_SAND` double DEFAULT NULL,
  `VRM_3_PROJECT` double DEFAULT NULL,
  `GIS_LOSSES` double DEFAULT NULL,
  `SUBTOTAL` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rmhs`
--

CREATE TABLE `rmhs` (
  `ENTRY_DATE` date NOT NULL,
  `RMHS` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rmhs_pc`
--

CREATE TABLE `rmhs_pc` (
  `ENTRY_DATE` date NOT NULL,
  `RMHS` double DEFAULT NULL,
  `SUBTOTAL` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rp_1_grinding`
--

CREATE TABLE `rp_1_grinding` (
  `ENTRY_DATE` date NOT NULL,
  `RP_1_MAIN_DRIVE_1` double DEFAULT NULL,
  `RP_1_MAIN_DRIVE_2` double DEFAULT NULL,
  `RP_1_B_H_FAN` double DEFAULT NULL,
  `RP_1_SKS_FAN` double DEFAULT NULL,
  `REJECT_ELEVATOR_MOTOR` double DEFAULT NULL,
  `MCC_3` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rp_1_grinding`
--

INSERT INTO `rp_1_grinding` (`ENTRY_DATE`, `RP_1_MAIN_DRIVE_1`, `RP_1_MAIN_DRIVE_2`, `RP_1_B_H_FAN`, `RP_1_SKS_FAN`, `REJECT_ELEVATOR_MOTOR`, `MCC_3`) VALUES
('2023-07-01', 25884290, 25860070, 14125012, 999882, 3132265, 4017253);

-- --------------------------------------------------------

--
-- Table structure for table `rp_1_grinding_pc`
--

CREATE TABLE `rp_1_grinding_pc` (
  `ENTRY_DATE` date NOT NULL,
  `RP_1_MAIN_DRIVE_1` double DEFAULT NULL,
  `RP_1_MAIN_DRIVE_2` double DEFAULT NULL,
  `RP_1_B_H_FAN` double DEFAULT NULL,
  `RP_1_SKS_FAN` double DEFAULT NULL,
  `REJECT_ELEVATOR_MOTOR` double DEFAULT NULL,
  `MCC_3` double DEFAULT NULL,
  `SUBTOTAL` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rp_1_grinding_sm`
--

CREATE TABLE `rp_1_grinding_sm` (
  `ENTRY_DATE` date NOT NULL,
  `RP_1_MAIN_DRIVE_1` double DEFAULT NULL,
  `RP_1_MAIN_DRIVE_2` double DEFAULT NULL,
  `RP_1_B_H_FAN` double DEFAULT NULL,
  `RP_1_SKS_FAN` double DEFAULT NULL,
  `REJECT_ELEVATOR_MOTOR` double DEFAULT NULL,
  `MCC_3` double DEFAULT NULL,
  `SUBTOTAL` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rp_2_grinding`
--

CREATE TABLE `rp_2_grinding` (
  `ENTRY_DATE` date NOT NULL,
  `RP_2_MAIN_DRIVE_1` double DEFAULT NULL,
  `RP_2_MAIN_DRIVE_2` double DEFAULT NULL,
  `RP_2_B_H_FAN` double DEFAULT NULL,
  `RP_2_SKS_FAN` double DEFAULT NULL,
  `REJECT_ELEVATOR_MOTOR` double DEFAULT NULL,
  `MCC_4` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rp_2_grinding_pc`
--

CREATE TABLE `rp_2_grinding_pc` (
  `ENTRY_DATE` date NOT NULL,
  `RP_2_MAIN_DRIVE_1` double DEFAULT NULL,
  `RP_2_MAIN_DRIVE_2` double DEFAULT NULL,
  `RP_2_B_H_FAN` double DEFAULT NULL,
  `RP_2_SKS_FAN` double DEFAULT NULL,
  `REJECT_ELEVATOR_MOTOR` double DEFAULT NULL,
  `MCC_4` double DEFAULT NULL,
  `SUBTOTAL` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rp_2_grinding_sm`
--

CREATE TABLE `rp_2_grinding_sm` (
  `ENTRY_DATE` date NOT NULL,
  `RP_2_MAIN_DRIVE_1` double DEFAULT NULL,
  `RP_2_MAIN_DRIVE_2` double DEFAULT NULL,
  `RP_2_B_H_FAN` double DEFAULT NULL,
  `RP_2_SKS_FAN` double DEFAULT NULL,
  `REJECT_ELEVATOR_MOTOR` double DEFAULT NULL,
  `MCC_4` double DEFAULT NULL,
  `SUBTOTAL` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `table_timestamps`
--

CREATE TABLE `table_timestamps` (
  `NAME_OF_TABLE` varchar(255) NOT NULL,
  `TIMESTAMP_OF_TABLE` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_timestamps`
--

INSERT INTO `table_timestamps` (`NAME_OF_TABLE`, `TIMESTAMP_OF_TABLE`) VALUES
('BLENDER', '2023-07-14 16:47:03'),
('BLENDER_pc', '2023-07-14 16:47:03'),
('BULKER', '2023-07-14 16:45:33'),
('BULKER_PACKERS', '2023-07-14 16:48:38'),
('BULKER_PACKERS_pc', '2023-07-14 16:48:38'),
('BULKER_pc', '2023-07-14 16:45:33'),
('BULKER_VRM2', '2023-07-14 16:50:33'),
('BULKER_VRM2_pc', '2023-07-14 16:50:33'),
('COMMON_GROUP', '2023-07-14 16:44:08'),
('COMMON_GROUP_pc', '2023-07-14 16:44:08'),
('LIGHTING_TRF_LOSS', '2023-07-14 16:45:05'),
('LIGHTING_TRF_LOSS_pc', '2023-07-14 16:45:05'),
('LIGHTING_TRF_LOSS_VRM1', '2023-07-14 16:47:56'),
('LIGHTING_TRF_LOSS_VRM1_pc', '2023-07-14 16:47:56'),
('LIGHTING_TRF_LOSS_VRM2', '2023-07-14 16:50:17'),
('LIGHTING_TRF_LOSS_VRM2_pc', '2023-07-14 16:50:17'),
('OTHERS', '2023-07-14 16:50:56'),
('OTHERS_pc', '2023-07-14 16:50:56'),
('RMHS', '2023-07-14 16:45:19'),
('RMHS_pc', '2023-07-14 16:45:19'),
('RP_1_GRINDING', '2023-07-14 16:42:37'),
('RP_1_GRINDING_pc', '2023-07-14 16:42:37'),
('RP_1_GRINDING_sm', '2023-07-14 16:42:37'),
('RP_2_GRINDING', '2023-07-14 16:43:43'),
('RP_2_GRINDING_pc', '2023-07-14 16:43:43'),
('RP_2_GRINDING_sm', '2023-07-14 16:43:43'),
('UTILITES', '2023-07-14 16:44:37'),
('UTILITES_pc', '2023-07-14 16:44:37'),
('UTILITY', '2023-07-14 16:47:24'),
('UTILITY_pc', '2023-07-14 16:47:24'),
('UTILITY_VRM2', '2023-07-14 16:49:56'),
('UTILITY_VRM2_pc', '2023-07-14 16:49:56'),
('VRM_1_GC_SELF', '2023-07-14 16:46:07'),
('VRM_1_GC_SELF_pc', '2023-07-14 16:46:07'),
('VRM_1_GC_SELF_sm', '2023-07-14 16:46:07'),
('VRM_1_GS', '2023-07-14 16:46:46'),
('VRM_1_GS_pc', '2023-07-14 16:46:46'),
('VRM_1_GS_sm', '2023-07-14 16:46:46'),
('VRM_2_GC_SELF', '2023-07-14 16:49:05'),
('VRM_2_GC_SELF_pc', '2023-07-14 16:49:05'),
('VRM_2_GC_SELF_sm', '2023-07-14 16:49:05'),
('VRM_2_OPC_M', '2023-07-14 16:49:36'),
('VRM_2_OPC_M_pc', '2023-07-14 16:49:36'),
('VRM_2_OPC_M_sm', '2023-07-14 16:49:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `usersID` int(11) NOT NULL,
  `usersFullName` varchar(128) NOT NULL,
  `usersUserName` varchar(128) NOT NULL,
  `usersPassword` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `utilites`
--

CREATE TABLE `utilites` (
  `ENTRY_DATE` date NOT NULL,
  `ADB` double DEFAULT NULL,
  `COMPRESSOR` double DEFAULT NULL,
  `WTP` double DEFAULT NULL,
  `CHILLER_UNIT` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `utilites_pc`
--

CREATE TABLE `utilites_pc` (
  `ENTRY_DATE` date NOT NULL,
  `ADB` double DEFAULT NULL,
  `COMPRESSOR` double DEFAULT NULL,
  `WTP` double DEFAULT NULL,
  `CHILLER_UNIT` double DEFAULT NULL,
  `SUBTOTAL` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `utility`
--

CREATE TABLE `utility` (
  `ENTRY_DATE` date NOT NULL,
  `COMPRESSOR_MCC_8_541CP07` double DEFAULT NULL,
  `WTP` double DEFAULT NULL,
  `SILO_BLOWERS` double DEFAULT NULL,
  `MAIN_ADB_QC_LAB_ADB_1` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `utility_pc`
--

CREATE TABLE `utility_pc` (
  `ENTRY_DATE` date NOT NULL,
  `COMPRESSOR_MCC_8_541CP07` double DEFAULT NULL,
  `WTP` double DEFAULT NULL,
  `SILO_BLOWERS` double DEFAULT NULL,
  `MAIN_ADB_QC_LAB_ADB_1` double DEFAULT NULL,
  `SUBTOTAL` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `utility_vrm2`
--

CREATE TABLE `utility_vrm2` (
  `ENTRY_DATE` date NOT NULL,
  `AC_PACKAGE` double DEFAULT NULL,
  `COMPRESSOR` double DEFAULT NULL,
  `WTP` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `utility_vrm2_pc`
--

CREATE TABLE `utility_vrm2_pc` (
  `ENTRY_DATE` date NOT NULL,
  `AC_PACKAGE` double DEFAULT NULL,
  `COMPRESSOR` double DEFAULT NULL,
  `WTP` double DEFAULT NULL,
  `SUBTOTAL` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vrm_1_gc_self`
--

CREATE TABLE `vrm_1_gc_self` (
  `ENTRY_DATE` date NOT NULL,
  `2500_KW_HT_MOTOR` double DEFAULT NULL,
  `700_KW_HT_MOTOR` double DEFAULT NULL,
  `ROTARY_CLASSIFIER` double DEFAULT NULL,
  `MCC_1` double DEFAULT NULL,
  `MCC_2_VRM_GRINDING_SECTION` double DEFAULT NULL,
  `MCC_3_VRM_GRINDING_SECTION` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vrm_1_gc_self_pc`
--

CREATE TABLE `vrm_1_gc_self_pc` (
  `ENTRY_DATE` date NOT NULL,
  `2500_KW_HT_MOTOR` double DEFAULT NULL,
  `700_KW_HT_MOTOR` double DEFAULT NULL,
  `ROTARY_CLASSIFIER` double DEFAULT NULL,
  `MCC_1` double DEFAULT NULL,
  `MCC_2_VRM_GRINDING_SECTION` double DEFAULT NULL,
  `MCC_3_VRM_GRINDING_SECTION` double DEFAULT NULL,
  `SUBTOTAL` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vrm_1_gc_self_sm`
--

CREATE TABLE `vrm_1_gc_self_sm` (
  `ENTRY_DATE` date NOT NULL,
  `2500_KW_HT_MOTOR` double DEFAULT NULL,
  `700_KW_HT_MOTOR` double DEFAULT NULL,
  `ROTARY_CLASSIFIER` double DEFAULT NULL,
  `MCC_1` double DEFAULT NULL,
  `MCC_2_VRM_GRINDING_SECTION` double DEFAULT NULL,
  `MCC_3_VRM_GRINDING_SECTION` double DEFAULT NULL,
  `SUBTOTAL` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vrm_1_gs`
--

CREATE TABLE `vrm_1_gs` (
  `ENTRY_DATE` date NOT NULL,
  `2500_KW_HT_MOTOR` double DEFAULT NULL,
  `700_KW_HT_MOTOR` double DEFAULT NULL,
  `ROTARY_CLASSIFIER` double DEFAULT NULL,
  `MCC_1` double DEFAULT NULL,
  `MCC_2_VRM_GRINDING_SECTION` double DEFAULT NULL,
  `MCC_3_VRM_GRINDING_SECTION` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vrm_1_gs_pc`
--

CREATE TABLE `vrm_1_gs_pc` (
  `ENTRY_DATE` date NOT NULL,
  `2500_KW_HT_MOTOR` double DEFAULT NULL,
  `700_KW_HT_MOTOR` double DEFAULT NULL,
  `ROTARY_CLASSIFIER` double DEFAULT NULL,
  `MCC_1` double DEFAULT NULL,
  `MCC_2_VRM_GRINDING_SECTION` double DEFAULT NULL,
  `MCC_3_VRM_GRINDING_SECTION` double DEFAULT NULL,
  `SUBTOTAL` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vrm_1_gs_sm`
--

CREATE TABLE `vrm_1_gs_sm` (
  `ENTRY_DATE` date NOT NULL,
  `2500_KW_HT_MOTOR` double DEFAULT NULL,
  `700_KW_HT_MOTOR` double DEFAULT NULL,
  `ROTARY_CLASSIFIER` double DEFAULT NULL,
  `MCC_1` double DEFAULT NULL,
  `MCC_2_VRM_GRINDING_SECTION` double DEFAULT NULL,
  `MCC_3_VRM_GRINDING_SECTION` double DEFAULT NULL,
  `SUBTOTAL` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vrm_2_gc_self`
--

CREATE TABLE `vrm_2_gc_self` (
  `ENTRY_DATE` date NOT NULL,
  `1500_KW_HT_MOTOR` double DEFAULT NULL,
  `575_KW_LT_MOTOR` double DEFAULT NULL,
  `SEPERATOR` double DEFAULT NULL,
  `VRM_IMCC` double DEFAULT NULL,
  `VRM_AUX_PUMP` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vrm_2_gc_self_pc`
--

CREATE TABLE `vrm_2_gc_self_pc` (
  `ENTRY_DATE` date NOT NULL,
  `1500_KW_HT_MOTOR` double DEFAULT NULL,
  `575_KW_LT_MOTOR` double DEFAULT NULL,
  `SEPERATOR` double DEFAULT NULL,
  `VRM_IMCC` double DEFAULT NULL,
  `VRM_AUX_PUMP` double DEFAULT NULL,
  `SUBTOTAL` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vrm_2_gc_self_sm`
--

CREATE TABLE `vrm_2_gc_self_sm` (
  `ENTRY_DATE` date NOT NULL,
  `1500_KW_HT_MOTOR` double DEFAULT NULL,
  `575_KW_LT_MOTOR` double DEFAULT NULL,
  `SEPERATOR` double DEFAULT NULL,
  `VRM_IMCC` double DEFAULT NULL,
  `VRM_AUX_PUMP` double DEFAULT NULL,
  `SUBTOTAL` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vrm_2_opc_m`
--

CREATE TABLE `vrm_2_opc_m` (
  `ENTRY_DATE` date NOT NULL,
  `1500_KW_HT_MOTOR` double DEFAULT NULL,
  `575_KW_LT_MOTOR` double DEFAULT NULL,
  `SEPERATOR` double DEFAULT NULL,
  `VRM_IMCC` double DEFAULT NULL,
  `VRM_AUX_PUMP` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vrm_2_opc_m_pc`
--

CREATE TABLE `vrm_2_opc_m_pc` (
  `ENTRY_DATE` date NOT NULL,
  `1500_KW_HT_MOTOR` double DEFAULT NULL,
  `575_KW_LT_MOTOR` double DEFAULT NULL,
  `SEPERATOR` double DEFAULT NULL,
  `VRM_IMCC` double DEFAULT NULL,
  `VRM_AUX_PUMP` double DEFAULT NULL,
  `SUBTOTAL` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vrm_2_opc_m_sm`
--

CREATE TABLE `vrm_2_opc_m_sm` (
  `ENTRY_DATE` date NOT NULL,
  `1500_KW_HT_MOTOR` double DEFAULT NULL,
  `575_KW_LT_MOTOR` double DEFAULT NULL,
  `SEPERATOR` double DEFAULT NULL,
  `VRM_IMCC` double DEFAULT NULL,
  `VRM_AUX_PUMP` double DEFAULT NULL,
  `SUBTOTAL` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blender`
--
ALTER TABLE `blender`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `blender_pc`
--
ALTER TABLE `blender_pc`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `bulker`
--
ALTER TABLE `bulker`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `bulker_packers`
--
ALTER TABLE `bulker_packers`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `bulker_packers_pc`
--
ALTER TABLE `bulker_packers_pc`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `bulker_pc`
--
ALTER TABLE `bulker_pc`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `bulker_vrm2`
--
ALTER TABLE `bulker_vrm2`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `bulker_vrm2_pc`
--
ALTER TABLE `bulker_vrm2_pc`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `common_group`
--
ALTER TABLE `common_group`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `common_group_pc`
--
ALTER TABLE `common_group_pc`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `lighting_trf_loss`
--
ALTER TABLE `lighting_trf_loss`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `lighting_trf_loss_pc`
--
ALTER TABLE `lighting_trf_loss_pc`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `lighting_trf_loss_vrm1`
--
ALTER TABLE `lighting_trf_loss_vrm1`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `lighting_trf_loss_vrm1_pc`
--
ALTER TABLE `lighting_trf_loss_vrm1_pc`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `lighting_trf_loss_vrm2`
--
ALTER TABLE `lighting_trf_loss_vrm2`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `lighting_trf_loss_vrm2_pc`
--
ALTER TABLE `lighting_trf_loss_vrm2_pc`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `others`
--
ALTER TABLE `others`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `others_pc`
--
ALTER TABLE `others_pc`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `rmhs`
--
ALTER TABLE `rmhs`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `rmhs_pc`
--
ALTER TABLE `rmhs_pc`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `rp_1_grinding`
--
ALTER TABLE `rp_1_grinding`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `rp_1_grinding_pc`
--
ALTER TABLE `rp_1_grinding_pc`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `rp_1_grinding_sm`
--
ALTER TABLE `rp_1_grinding_sm`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `rp_2_grinding`
--
ALTER TABLE `rp_2_grinding`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `rp_2_grinding_pc`
--
ALTER TABLE `rp_2_grinding_pc`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `rp_2_grinding_sm`
--
ALTER TABLE `rp_2_grinding_sm`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `table_timestamps`
--
ALTER TABLE `table_timestamps`
  ADD PRIMARY KEY (`NAME_OF_TABLE`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usersID`);

--
-- Indexes for table `utilites`
--
ALTER TABLE `utilites`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `utilites_pc`
--
ALTER TABLE `utilites_pc`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `utility`
--
ALTER TABLE `utility`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `utility_pc`
--
ALTER TABLE `utility_pc`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `utility_vrm2`
--
ALTER TABLE `utility_vrm2`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `utility_vrm2_pc`
--
ALTER TABLE `utility_vrm2_pc`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `vrm_1_gc_self`
--
ALTER TABLE `vrm_1_gc_self`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `vrm_1_gc_self_pc`
--
ALTER TABLE `vrm_1_gc_self_pc`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `vrm_1_gc_self_sm`
--
ALTER TABLE `vrm_1_gc_self_sm`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `vrm_1_gs`
--
ALTER TABLE `vrm_1_gs`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `vrm_1_gs_pc`
--
ALTER TABLE `vrm_1_gs_pc`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `vrm_1_gs_sm`
--
ALTER TABLE `vrm_1_gs_sm`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `vrm_2_gc_self`
--
ALTER TABLE `vrm_2_gc_self`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `vrm_2_gc_self_pc`
--
ALTER TABLE `vrm_2_gc_self_pc`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `vrm_2_gc_self_sm`
--
ALTER TABLE `vrm_2_gc_self_sm`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `vrm_2_opc_m`
--
ALTER TABLE `vrm_2_opc_m`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `vrm_2_opc_m_pc`
--
ALTER TABLE `vrm_2_opc_m_pc`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- Indexes for table `vrm_2_opc_m_sm`
--
ALTER TABLE `vrm_2_opc_m_sm`
  ADD PRIMARY KEY (`ENTRY_DATE`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `usersID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
