-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2021 at 10:07 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `openpip`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_settings`
--

CREATE TABLE `admin_settings` (
  `id` int(11) NOT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `short_title` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `home_page` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `about` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `faq` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `download` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `show_downloads` tinyint(1) NOT NULL,
  `show_download_all` tinyint(1) NOT NULL,
  `footer` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `main_color_scheme` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `header_color_scheme` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo_color_scheme` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `button_color_scheme` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `example_1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `example_2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `example_3` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `query_node_color` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `interactor_node_color` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `published_edge_color` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `validated_edge_color` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `verified_edge_color` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `literature_edge_color` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `version` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `annotation`
--

CREATE TABLE `annotation` (
  `id` int(11) NOT NULL,
  `annotation` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `identifier` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `annotation_type` int(11) DEFAULT NULL,
  `type_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `annotation_interaction`
--

CREATE TABLE `annotation_interaction` (
  `interaction_id` int(11) NOT NULL,
  `annotation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `annotation_protein`
--

CREATE TABLE `annotation_protein` (
  `protein_id` int(11) NOT NULL,
  `annotation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `annotation_type`
--

CREATE TABLE `annotation_type` (
  `id` int(11) NOT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `show_in_table` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `show_in_filter` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fields` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `boolean` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `filter` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `filter_name` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `text` varchar(4000) COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `show` tinyint(1) NOT NULL,
  `show_on_home_page` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complex`
--

CREATE TABLE `complex` (
  `id` int(11) NOT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complex_protein`
--

CREATE TABLE `complex_protein` (
  `complex_id` int(11) NOT NULL,
  `protein_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dataset`
--

CREATE TABLE `dataset` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pubmed_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `author` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `year` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `interaction_status` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number_of_interactions` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_path` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dataset_request`
--

CREATE TABLE `dataset_request` (
  `id` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `md5` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `request` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dataset_request_dataset`
--

CREATE TABLE `dataset_request_dataset` (
  `dataset_id` int(11) NOT NULL,
  `dataset_request_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_file`
--

CREATE TABLE `data_file` (
  `id` int(11) NOT NULL,
  `dataset_id` int(11) DEFAULT NULL,
  `name` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `method` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_type` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `domain`
--

CREATE TABLE `domain` (
  `id` int(11) NOT NULL,
  `protein_id` int(11) DEFAULT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_position` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `end_position` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sequence` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `domain_organism`
--

CREATE TABLE `domain_organism` (
  `organism_id` int(11) NOT NULL,
  `domain_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `external_link`
--

CREATE TABLE `external_link` (
  `id` int(11) NOT NULL,
  `protein_id` int(11) DEFAULT NULL,
  `database_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fos_group`
--

CREATE TABLE `fos_group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fos_user_user_group`
--

CREATE TABLE `fos_user_user_group` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `identifier`
--

CREATE TABLE `identifier` (
  `id` int(11) NOT NULL,
  `identifier` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `naming_convention` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `interaction`
--

CREATE TABLE `interaction` (
  `id` int(11) NOT NULL,
  `domain` int(11) DEFAULT NULL,
  `score` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `removed` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `binding_start` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `binding_end` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `interactor_A` int(11) DEFAULT NULL,
  `interactor_B` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `interaction_category`
--

CREATE TABLE `interaction_category` (
  `id` int(11) NOT NULL,
  `admin_settings_id` int(11) DEFAULT NULL,
  `category_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color_scheme` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `selected_by_default` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `include_in_home_page_count` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `interaction_dataset`
--

CREATE TABLE `interaction_dataset` (
  `dataset_id` int(11) NOT NULL,
  `interaction_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `interaction_domain`
--

CREATE TABLE `interaction_domain` (
  `domain_id` int(11) NOT NULL,
  `interaction_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `interaction_interaction_category`
--

CREATE TABLE `interaction_interaction_category` (
  `interaction_category_id` int(11) NOT NULL,
  `interaction_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `interaction_interaction_networks`
--

CREATE TABLE `interaction_interaction_networks` (
  `interaction_network_id` int(11) NOT NULL,
  `interaction_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `interaction_network`
--

CREATE TABLE `interaction_network` (
  `id` int(11) NOT NULL,
  `interactor_query_string` varchar(3000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `score_parameter` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_array` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tissue_expression_array` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `query` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `interaction_support_information`
--

CREATE TABLE `interaction_support_information` (
  `id` int(11) NOT NULL,
  `interaction_id` int(11) DEFAULT NULL,
  `support_information_id` int(11) DEFAULT NULL,
  `value` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organism`
--

CREATE TABLE `organism` (
  `id` int(11) NOT NULL,
  `taxid_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `common_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `class` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `scientific_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `protein`
--

CREATE TABLE `protein` (
  `id` int(11) NOT NULL,
  `gene_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `protein_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `uniprot_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ensembl_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entrez_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sequence` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(10000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number_of_interactions_in_database` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `protein_identifier`
--

CREATE TABLE `protein_identifier` (
  `identifier_id` int(11) NOT NULL,
  `protein_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `protein_isoform`
--

CREATE TABLE `protein_isoform` (
  `protein_id` int(11) NOT NULL,
  `isoform_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `protein_organism`
--

CREATE TABLE `protein_organism` (
  `organism_id` int(11) NOT NULL,
  `protein_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `save_network`
--

CREATE TABLE `save_network` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `current_protein_array` text DEFAULT NULL,
  `all_protein_array` text DEFAULT NULL,
  `current_interaction_array` text DEFAULT NULL,
  `all_interaction_array` text DEFAULT NULL,
  `annotation_parameter_array` text DEFAULT NULL,
  `query_parameters` text DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `query_protein_array` varchar(1000) DEFAULT NULL,
  `hash` varchar(100) NOT NULL,
  `date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `support_information`
--

CREATE TABLE `support_information` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test_table`
--

CREATE TABLE `test_table` (
  `test_column` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_datasets`
--

CREATE TABLE `user_datasets` (
  `dataset_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_interaction_networks`
--

CREATE TABLE `user_interaction_networks` (
  `interaction_network_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_protein`
--

CREATE TABLE `user_protein` (
  `protein_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_settings`
--
ALTER TABLE `admin_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `annotation`
--
ALTER TABLE `annotation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2E443EF28F6F87AD` (`annotation_type`);

--
-- Indexes for table `annotation_interaction`
--
ALTER TABLE `annotation_interaction`
  ADD PRIMARY KEY (`interaction_id`,`annotation_id`);

--
-- Indexes for table `annotation_protein`
--
ALTER TABLE `annotation_protein`
  ADD PRIMARY KEY (`annotation_id`,`protein_id`),
  ADD KEY `IDX_439A14E854985755` (`protein_id`),
  ADD KEY `IDX_439A14E8E075FC54` (`annotation_id`);

--
-- Indexes for table `annotation_type`
--
ALTER TABLE `annotation_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complex`
--
ALTER TABLE `complex`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complex_protein`
--
ALTER TABLE `complex_protein`
  ADD PRIMARY KEY (`complex_id`,`protein_id`),
  ADD KEY `IDX_9CA559D6E4695F7C` (`complex_id`),
  ADD KEY `IDX_9CA559D654985755` (`protein_id`);

--
-- Indexes for table `dataset`
--
ALTER TABLE `dataset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dataset_request`
--
ALTER TABLE `dataset_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dataset_request_dataset`
--
ALTER TABLE `dataset_request_dataset`
  ADD PRIMARY KEY (`dataset_id`,`dataset_request_id`),
  ADD KEY `IDX_938C0834D47C2D1B` (`dataset_id`),
  ADD KEY `IDX_938C0834678591AA` (`dataset_request_id`);

--
-- Indexes for table `data_file`
--
ALTER TABLE `data_file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_37D0FDF2D47C2D1B` (`dataset_id`);

--
-- Indexes for table `domain`
--
ALTER TABLE `domain`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A7A91E0B54985755` (`protein_id`);

--
-- Indexes for table `domain_organism`
--
ALTER TABLE `domain_organism`
  ADD PRIMARY KEY (`organism_id`,`domain_id`),
  ADD KEY `IDX_1EDDC56364180A36` (`organism_id`),
  ADD KEY `IDX_1EDDC563115F0EE5` (`domain_id`);

--
-- Indexes for table `external_link`
--
ALTER TABLE `external_link`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A3B3F9DD54985755` (`protein_id`);

--
-- Indexes for table `fos_group`
--
ALTER TABLE `fos_group`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_4B019DDB5E237E06` (`name`);

--
-- Indexes for table `fos_user_user_group`
--
ALTER TABLE `fos_user_user_group`
  ADD PRIMARY KEY (`user_id`,`group_id`),
  ADD KEY `IDX_B3C77447A76ED395` (`user_id`),
  ADD KEY `IDX_B3C77447FE54D947` (`group_id`);

--
-- Indexes for table `identifier`
--
ALTER TABLE `identifier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `interaction`
--
ALTER TABLE `interaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_378DFDA7A7A91E0B` (`domain`),
  ADD KEY `IDX_378DFDA76C944D70` (`interactor_A`),
  ADD KEY `IDX_378DFDA7F59D1CCA` (`interactor_B`);

--
-- Indexes for table `interaction_category`
--
ALTER TABLE `interaction_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3C990E38C48ED181` (`admin_settings_id`);

--
-- Indexes for table `interaction_dataset`
--
ALTER TABLE `interaction_dataset`
  ADD PRIMARY KEY (`dataset_id`,`interaction_id`),
  ADD KEY `IDX_D7E676B1D47C2D1B` (`dataset_id`),
  ADD KEY `IDX_D7E676B1886DEE8F` (`interaction_id`);

--
-- Indexes for table `interaction_domain`
--
ALTER TABLE `interaction_domain`
  ADD PRIMARY KEY (`domain_id`,`interaction_id`),
  ADD KEY `IDX_5110AA94115F0EE5` (`domain_id`),
  ADD KEY `IDX_5110AA94886DEE8F` (`interaction_id`);

--
-- Indexes for table `interaction_interaction_category`
--
ALTER TABLE `interaction_interaction_category`
  ADD PRIMARY KEY (`interaction_category_id`,`interaction_id`),
  ADD KEY `IDX_605705B45B69774A` (`interaction_category_id`),
  ADD KEY `IDX_605705B4886DEE8F` (`interaction_id`);

--
-- Indexes for table `interaction_interaction_networks`
--
ALTER TABLE `interaction_interaction_networks`
  ADD PRIMARY KEY (`interaction_network_id`,`interaction_id`),
  ADD KEY `IDX_BFA2A85E72BF6E77` (`interaction_network_id`),
  ADD KEY `IDX_BFA2A85E886DEE8F` (`interaction_id`);

--
-- Indexes for table `interaction_network`
--
ALTER TABLE `interaction_network`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `interaction_support_information`
--
ALTER TABLE `interaction_support_information`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_815A6518886DEE8F` (`interaction_id`),
  ADD KEY `IDX_815A6518E7A44270` (`support_information_id`);

--
-- Indexes for table `organism`
--
ALTER TABLE `organism`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `protein`
--
ALTER TABLE `protein`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `protein_identifier`
--
ALTER TABLE `protein_identifier`
  ADD PRIMARY KEY (`identifier_id`,`protein_id`),
  ADD KEY `IDX_1AE91CD9EF794DF6` (`identifier_id`),
  ADD KEY `IDX_1AE91CD954985755` (`protein_id`);

--
-- Indexes for table `protein_isoform`
--
ALTER TABLE `protein_isoform`
  ADD PRIMARY KEY (`protein_id`,`isoform_id`),
  ADD KEY `IDX_3BA1014954985755` (`protein_id`),
  ADD KEY `IDX_3BA10149CC074EC8` (`isoform_id`);

--
-- Indexes for table `protein_organism`
--
ALTER TABLE `protein_organism`
  ADD PRIMARY KEY (`organism_id`,`protein_id`),
  ADD KEY `IDX_ACDFE23864180A36` (`organism_id`),
  ADD KEY `IDX_ACDFE23854985755` (`protein_id`);

--
-- Indexes for table `save_network`
--
ALTER TABLE `save_network`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_information`
--
ALTER TABLE `support_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D64992FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_8D93D649A0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_8D93D649C05FB297` (`confirmation_token`);

--
-- Indexes for table `user_datasets`
--
ALTER TABLE `user_datasets`
  ADD PRIMARY KEY (`dataset_id`,`user_id`),
  ADD KEY `IDX_7DE7599ED47C2D1B` (`dataset_id`),
  ADD KEY `IDX_7DE7599EA76ED395` (`user_id`);

--
-- Indexes for table `user_interaction_networks`
--
ALTER TABLE `user_interaction_networks`
  ADD PRIMARY KEY (`interaction_network_id`,`user_id`),
  ADD KEY `IDX_5D4D70AD72BF6E77` (`interaction_network_id`),
  ADD KEY `IDX_5D4D70ADA76ED395` (`user_id`);

--
-- Indexes for table `user_protein`
--
ALTER TABLE `user_protein`
  ADD PRIMARY KEY (`protein_id`,`user_id`),
  ADD KEY `IDX_C0F5FFB854985755` (`protein_id`),
  ADD KEY `IDX_C0F5FFB8A76ED395` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_settings`
--
ALTER TABLE `admin_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `annotation`
--
ALTER TABLE `annotation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=213325;

--
-- AUTO_INCREMENT for table `annotation_type`
--
ALTER TABLE `annotation_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `complex`
--
ALTER TABLE `complex`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dataset`
--
ALTER TABLE `dataset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `dataset_request`
--
ALTER TABLE `dataset_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_file`
--
ALTER TABLE `data_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `domain`
--
ALTER TABLE `domain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `external_link`
--
ALTER TABLE `external_link`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fos_group`
--
ALTER TABLE `fos_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `identifier`
--
ALTER TABLE `identifier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23201;

--
-- AUTO_INCREMENT for table `interaction`
--
ALTER TABLE `interaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76564;

--
-- AUTO_INCREMENT for table `interaction_category`
--
ALTER TABLE `interaction_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `interaction_network`
--
ALTER TABLE `interaction_network`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `interaction_support_information`
--
ALTER TABLE `interaction_support_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organism`
--
ALTER TABLE `organism`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `protein`
--
ALTER TABLE `protein`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11601;

--
-- AUTO_INCREMENT for table `save_network`
--
ALTER TABLE `save_network`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `support_information`
--
ALTER TABLE `support_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=596;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `annotation`
--
ALTER TABLE `annotation`
  ADD CONSTRAINT `FK_2E443EF28F6F87AD` FOREIGN KEY (`annotation_type`) REFERENCES `annotation_type` (`id`);

--
-- Constraints for table `annotation_protein`
--
ALTER TABLE `annotation_protein`
  ADD CONSTRAINT `FK_439A14E854985755` FOREIGN KEY (`protein_id`) REFERENCES `protein` (`id`),
  ADD CONSTRAINT `FK_439A14E8E075FC54` FOREIGN KEY (`annotation_id`) REFERENCES `annotation` (`id`);

--
-- Constraints for table `complex_protein`
--
ALTER TABLE `complex_protein`
  ADD CONSTRAINT `FK_9CA559D654985755` FOREIGN KEY (`protein_id`) REFERENCES `protein` (`id`),
  ADD CONSTRAINT `FK_9CA559D6E4695F7C` FOREIGN KEY (`complex_id`) REFERENCES `complex` (`id`);

--
-- Constraints for table `dataset_request_dataset`
--
ALTER TABLE `dataset_request_dataset`
  ADD CONSTRAINT `FK_938C0834678591AA` FOREIGN KEY (`dataset_request_id`) REFERENCES `dataset_request` (`id`),
  ADD CONSTRAINT `FK_938C0834D47C2D1B` FOREIGN KEY (`dataset_id`) REFERENCES `dataset` (`id`);

--
-- Constraints for table `data_file`
--
ALTER TABLE `data_file`
  ADD CONSTRAINT `FK_37D0FDF2D47C2D1B` FOREIGN KEY (`dataset_id`) REFERENCES `dataset` (`id`);

--
-- Constraints for table `domain`
--
ALTER TABLE `domain`
  ADD CONSTRAINT `FK_A7A91E0B54985755` FOREIGN KEY (`protein_id`) REFERENCES `protein` (`id`);

--
-- Constraints for table `domain_organism`
--
ALTER TABLE `domain_organism`
  ADD CONSTRAINT `FK_1EDDC563115F0EE5` FOREIGN KEY (`domain_id`) REFERENCES `domain` (`id`),
  ADD CONSTRAINT `FK_1EDDC56364180A36` FOREIGN KEY (`organism_id`) REFERENCES `organism` (`id`);

--
-- Constraints for table `external_link`
--
ALTER TABLE `external_link`
  ADD CONSTRAINT `FK_A3B3F9DD54985755` FOREIGN KEY (`protein_id`) REFERENCES `protein` (`id`);

--
-- Constraints for table `fos_user_user_group`
--
ALTER TABLE `fos_user_user_group`
  ADD CONSTRAINT `FK_B3C77447A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_B3C77447FE54D947` FOREIGN KEY (`group_id`) REFERENCES `fos_group` (`id`);

--
-- Constraints for table `interaction`
--
ALTER TABLE `interaction`
  ADD CONSTRAINT `FK_378DFDA76C944D70` FOREIGN KEY (`interactor_A`) REFERENCES `protein` (`id`),
  ADD CONSTRAINT `FK_378DFDA7A7A91E0B` FOREIGN KEY (`domain`) REFERENCES `domain` (`id`),
  ADD CONSTRAINT `FK_378DFDA7F59D1CCA` FOREIGN KEY (`interactor_B`) REFERENCES `protein` (`id`);

--
-- Constraints for table `interaction_category`
--
ALTER TABLE `interaction_category`
  ADD CONSTRAINT `FK_3C990E38C48ED181` FOREIGN KEY (`admin_settings_id`) REFERENCES `admin_settings` (`id`);

--
-- Constraints for table `interaction_dataset`
--
ALTER TABLE `interaction_dataset`
  ADD CONSTRAINT `FK_D7E676B1D47C2D1B` FOREIGN KEY (`dataset_id`) REFERENCES `dataset` (`id`);

--
-- Constraints for table `interaction_domain`
--
ALTER TABLE `interaction_domain`
  ADD CONSTRAINT `FK_5110AA94115F0EE5` FOREIGN KEY (`domain_id`) REFERENCES `domain` (`id`),
  ADD CONSTRAINT `FK_5110AA94886DEE8F` FOREIGN KEY (`interaction_id`) REFERENCES `interaction` (`id`);

--
-- Constraints for table `interaction_interaction_category`
--
ALTER TABLE `interaction_interaction_category`
  ADD CONSTRAINT `FK_605705B45B69774A` FOREIGN KEY (`interaction_category_id`) REFERENCES `interaction_category` (`id`);

--
-- Constraints for table `interaction_interaction_networks`
--
ALTER TABLE `interaction_interaction_networks`
  ADD CONSTRAINT `FK_BFA2A85E72BF6E77` FOREIGN KEY (`interaction_network_id`) REFERENCES `interaction_network` (`id`),
  ADD CONSTRAINT `FK_BFA2A85E886DEE8F` FOREIGN KEY (`interaction_id`) REFERENCES `interaction` (`id`);

--
-- Constraints for table `interaction_support_information`
--
ALTER TABLE `interaction_support_information`
  ADD CONSTRAINT `FK_815A6518886DEE8F` FOREIGN KEY (`interaction_id`) REFERENCES `interaction` (`id`),
  ADD CONSTRAINT `FK_815A6518E7A44270` FOREIGN KEY (`support_information_id`) REFERENCES `support_information` (`id`);

--
-- Constraints for table `protein_identifier`
--
ALTER TABLE `protein_identifier`
  ADD CONSTRAINT `FK_1AE91CD954985755` FOREIGN KEY (`protein_id`) REFERENCES `protein` (`id`),
  ADD CONSTRAINT `FK_1AE91CD9EF794DF6` FOREIGN KEY (`identifier_id`) REFERENCES `identifier` (`id`);

--
-- Constraints for table `protein_isoform`
--
ALTER TABLE `protein_isoform`
  ADD CONSTRAINT `FK_3BA1014954985755` FOREIGN KEY (`protein_id`) REFERENCES `protein` (`id`),
  ADD CONSTRAINT `FK_3BA10149CC074EC8` FOREIGN KEY (`isoform_id`) REFERENCES `protein` (`id`);

--
-- Constraints for table `protein_organism`
--
ALTER TABLE `protein_organism`
  ADD CONSTRAINT `FK_ACDFE23854985755` FOREIGN KEY (`protein_id`) REFERENCES `protein` (`id`),
  ADD CONSTRAINT `FK_ACDFE23864180A36` FOREIGN KEY (`organism_id`) REFERENCES `organism` (`id`);

--
-- Constraints for table `user_datasets`
--
ALTER TABLE `user_datasets`
  ADD CONSTRAINT `FK_7DE7599EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_7DE7599ED47C2D1B` FOREIGN KEY (`dataset_id`) REFERENCES `dataset` (`id`);

--
-- Constraints for table `user_interaction_networks`
--
ALTER TABLE `user_interaction_networks`
  ADD CONSTRAINT `FK_5D4D70AD72BF6E77` FOREIGN KEY (`interaction_network_id`) REFERENCES `interaction_network` (`id`),
  ADD CONSTRAINT `FK_5D4D70ADA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `user_protein`
--
ALTER TABLE `user_protein`
  ADD CONSTRAINT `FK_C0F5FFB854985755` FOREIGN KEY (`protein_id`) REFERENCES `protein` (`id`),
  ADD CONSTRAINT `FK_C0F5FFB8A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
