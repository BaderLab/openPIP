-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2021 at 01:20 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE DATABASE IF NOT EXISTS huri;
USE huri;

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
  `version` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mission_title` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `mission_text` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `method_title` tinytext COLLATE utf8_unicode_ci DEFAULT NULL,
  `method_text` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin_settings`
--

INSERT INTO `admin_settings` (`id`, `title`, `short_title`, `url`, `home_page`, `about`, `faq`, `download`, `contact`, `show_downloads`, `show_download_all`, `footer`, `main_color_scheme`, `header_color_scheme`, `logo_color_scheme`, `button_color_scheme`, `example_1`, `example_2`, `example_3`, `query_node_color`, `interactor_node_color`, `published_edge_color`, `validated_edge_color`, `verified_edge_color`, `literature_edge_color`, `version`, `mission_title`, `mission_text`, `method_title`, `method_text`) VALUES
(1, 'openPIP: The Open-source Protein Interaction Platform', 'openPIP', 'http://localhost:8000/', '<p style=\"text-align: center;\"><span style=\"font-family: arial, helvetica, sans-serif; font-size: 18pt; color: #2b83ba;\"><strong><span style=\"background-color: #ffffff; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Human Reference Protein Interactome Project</span></strong></span></p>\r\n<p data-pm-slice=\"1 1 []\"><span style=\"font-size: 12pt;\">One of the long-term goals at the Center for Cancer Systems Biology is to generate a first reference map of the human protein-protein interactome network. To reach this target, we are identifying <strong>binary</strong> protein-protein interactions (PPIs) by <strong>systematically</strong> interrogating all pairwise combinations of predicted human protein-coding genes using proteome-scale technologies. Our approach to map high-quality PPIs is based on using yeast two-hybrid as the primary screening method followed by validation of subsets of PPIs in multiple orthogonal assays for binary PPI detection. As of today, we have identified a total of </span><span style=\"font-size: 12pt;\"><strong>85613 PPIs</strong> involving </span><span style=\"font-size: 12pt;\"><strong>13744 proteins</strong> in systematic screens using this framework.</span></p>\r\n<p><span style=\"font-size: 12pt;\">As part of our interactome mapping effort we are also computationally and experimentally surveying collections of PPIs curated from the literature to extract PPIs with binary experimental evidences that are of comparable high quality to the PPIs identified in our systematic screening efforts. This subset of literature-curated PPIs is equally available for search and download at this web portal and currently comprises </span><span style=\"font-size: 12pt;\"><strong>14595 PPIs</strong> involving <strong>xxx proteins</strong>.</span></p>\r\n<p><span style=\"font-size: 12pt;\">All PPI datasets are described in further details&nbsp;<a href=\"../../about/\">here</a> and are freely available to the research community through the&nbsp;<a href=\"../../search\">search engine</a> or via <a href=\"../download\">download</a>. Preliminary data from ongoing projects are also described and available for search and <a href=\"../download\">download</a> (registration required).</span></p>\r\n<p dir=\"ltr\" style=\"text-align: justify;\">&nbsp;</p>', '<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">At CCSB, the Human Reference Interactome Mapping Project has grown in several distinct stages primarily defined by the number of human protein-coding genes amenable to screening for which at least one&nbsp;<a href=\"http://horfdb.dfci.harvard.edu/\">Gateway-cloned Open Reading Frame</a> (ORF) was available at the time of the project. As of today, three proteome-scale human PPI datasets are available via this web portal, in addition to other PPI datasets from CCSB, which were generated to optimize our pipeline, build a framework for quality control, benchmark new Y2H assay versions, or assess network rewiring as a result of alternative splicing (see below for more details). </span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">We also make available a subset of the curated binary protein interactions from the scientific literature that is of comparable quality to interactions identified in systematic screens at CCSB. </span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">All provided PPI datasets on this web portal have been processed using a new pipeline that maps our ORF sequences and resulting PPIs to Ensembl gene, transcript and protein identifiers that are annotated by the GENCODE consortium as protein-coding. As a result of this updated mapping, previously published datasets that are provided for download on this portal vary slightly in their number of PPIs compared to the protein interaction count provided in the original paper. The original datasets can be accessed in the supplementary material of each respective publication. We highly encourage users to use the updated datasets provided on this web portal for their research. </span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">All datasets are available for download as simple tab-separated file with the interacting protein pairs being indicated as pairs of Ensembl gene IDs. All CCSB interaction data is also available for download in PSI-MI format containing detailed experimental information and isoform-specific ORF, transcript and protein identifiers for each interaction.</span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\"><span id=\"proteome\" style=\"font-size: 18pt; font-family: arial, helvetica, sans-serif; color: #2b83ba; background-color: #ffffff; font-weight: bold; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">CCSB Proteome-scale efforts</span></span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\"><span style=\"color: #3282b8;\">HI-I-05</span>: Our first iteration at mapping the human protein interactome (<a href=\"https://www.ncbi.nlm.nih.gov/pubmed/16189514\">Rual et al Nature 2005</a>) screened a space (Space I) of ~8,000 ORFs corresponding to ~7,000 genes, and identified ~2,700 high-quality binary PPIs. This search space represents ~12% of the complete search space, assuming a total of ~20,000 protein-coding genes.</span><br /><br /><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\"><span style=\"color: #3282b8;\">HI-II-14</span>: The second phase of the human interactome mapping project (<a href=\"https://www.ncbi.nlm.nih.gov/pubmed/25416956\">Rolland et al Cell 2014</a>) generated a dataset of ~14,000 binary PPIs following two screens of a matrix of ~13,000 x 13,000 proteins (Space II). This search space covers ~42% of the complete search space, a more than 3 fold increase with respect to our first attempt.</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\"><span style=\"color: #3282b8;\">HuRI</span>: In the third phase of the project (Luck et al under review, <a href=\"https://www.biorxiv.org/content/10.1101/605451v1\">BioRxiv</a>) the human ORF collection being screened has been expanded to ~17,500 unique genes (Space III) and covers ~77% of the complete search space. ~53,000 PPIs identified from screening space III nine times with three variations of the Y2H assay are provided for search and download. This dataset is also referred to as HI-III-19.</span><br /><br /><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"><span style=\"color: #3282b8;\">HI-union</span>:&nbsp;<a href=\"https://www.biorxiv.org/content/10.1101/605451v1\">HI-union</a> is an aggregate of all PPIs identified in HI-I-05, HI-II-14, HuRI, Venkatesan-09, Yu-11, Yang-16, and Test space screens-19 (see below)<span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\"> transcript and protein identifiers for each interaction.</span></span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\">&nbsp;</p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\"><span id=\"proteome\" style=\"font-size: 18pt; font-family: arial, helvetica, sans-serif; color: #2b83ba; background-color: #ffffff; font-weight: bold; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Other CCSB protein interaction mapping efforts</span></span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"><span style=\"color: #3282b8;\">Venkatesan-09</span>: </span><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">To estimate the coverage and size of the human interactome (<a href=\"https://www.ncbi.nlm.nih.gov/pubmed/19060904\">Venkatesan et al Nature Methods 2009</a>), four Y2H screens were performed on a set of ~1,800 DB-X fusion proteins (or baits, representing ~1,700 unique genes) against ~1,800 AD-Y proteins (or preys, representing ~1,800 unique genes), corresponding to ~10% of the available genes and ~1% of the full search space. This dataset contains ~200 high-quality binary PPIs.</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 14pt;\">&nbsp;</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"><span style=\"color: #3282b8;\">Yu-11</span>: </span><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">To develop a novel Stitch-seq interactome mapping protocol, a Y2H screen was carried out inside Space II (<a href=\"https://www.ncbi.nlm.nih.gov/pubmed/21516116\">Yu et al Nature Methods 2011</a>). Stitch-seq combines PCR stitching with next-generation sequencing, and increases the efficiency and cost effectiveness of Y2H screening. The resulting dataset contains ~1,200 PPIs among proteins encoded by ~1,100 human genes.</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 14pt;\">&nbsp;</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"><span style=\"color: #3282b8;\">Yang-16</span>: </span><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif;\">To assess the extent to which different protein isoforms generated by alternative splicing from the same gene perform different functions within the cell, we have successfully cloned multiple isoforms for 161 genes and screened those for PPIs against all human ORFs from space II (<a href=\"https://www.ncbi.nlm.nih.gov/pubmed/26871637\">Yang et al Cell 2016</a>). ~700 PPIs have been identified.</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 14pt;\">&nbsp;</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 12pt; font-family: arial, helvetica, sans-serif; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"><span style=\"font-size: 14pt;\"><span style=\"color: #3282b8;\">Test space screens-19</span>: </span></span><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif;\">To develop, optimize, and benchmark improvements to the mapping pipeline and variations of the Y2H assay, independent, reciprocal screens on a search space of ~1,800 x ~1,800 genes were completed, constituting ~1% of the full search space. In total, 1,159 PPIs have been identified in these screens and those have been published as part of the paper describing <a href=\"https://www.biorxiv.org/content/10.1101/605451v1\">HuRI</a>. </span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\">&nbsp;</p>\r\n<p style=\"text-align: left;\"><span style=\"font-family: arial, helvetica, sans-serif; font-size: 18pt;\"><span id=\"other-data\" style=\"font-family: arial, helvetica, sans-serif; color: #2b83ba; background-color: #ffffff; font-weight: bold; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Literature</span></span></p>\r\n<p style=\"text-align: left;\"><span style=\"font-family: arial, helvetica, sans-serif; font-size: 12pt;\"><span style=\"font-size: 14pt;\"><span style=\"color: #3282b8;\">Lit-BM</span>: Previously published work (Rolland et al Cell 2014) identified that a subset of the curated interactions from the scientific literature that have at least two pieces of experimental evidence (two different methods or two different papers) of which at least one stems from a binary protein interaction detection assay (Literature binary multiple = Lit-BM) retested at comparable rates in protein interaction detection assays compared to interactions identified in the CCSB screening efforts. Binary PPIs with only one piece of experimental evidence retested at significantly lower rate. Here, we provide an updated set of all PPIs in Lit-BM that we obtained from filtering and classifying PPIs from the&nbsp;<a href=\"https://www.ncbi.nlm.nih.gov/pubmed/23900247\">Mentha</a> resource. Details of the filtering and classification are described in the&nbsp;<a href=\"https://www.biorxiv.org/content/10.1101/605451v1\">HuRI</a> paper.</span><br /></span></p>\r\n<p style=\"text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif; font-size: 18pt;\"><span id=\"yeast\" style=\"font-family: arial, helvetica, sans-serif; color: #2b83ba; background-color: transparent; font-weight: bold; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"><span id=\"yeast\" style=\"font-family: arial, helvetica, sans-serif; color: #2b83ba; background-color: transparent; font-weight: bold; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Description of the Y2H screening pipeline</span></span></span></p>\r\n<p style=\"text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">Details on our screening, pairwise test, and validation protocols are available as part of the HuRI paper and previously published protocols (Choi et al Methods Mol Biol 2018, Dreze et al Methods Enzymol 2010). Briefly, ORFs from the hORFeome collection were transferred into DNA-binding (DB) and activation domain (AD) Y2H destination vectors (see below). The vectors were consequently used to transform yeast strains (see below). Strong DB autoactivators were removed prior to screening. Yeast strains with 1,000 different AD-ORFs were pooled and mated with a single DB-ORF yeast strain. Growing yeast colonies were picked and sequenced to identify likely interacting pairs (First Pass Pairs = FiPPs). FiPPs were consequently individually tested in quadruplicate in a Y2H pairwise test and sequence confirmed resulting in a dataset of verified PPIs. A random subset of these verified PPIs are selected and tested in orthogonal protein interaction detection assays along with sets of known PPIs (positive control) and random pairs of proteins (negative control) to test for the quality of the identified PPIs.&nbsp; If found to be of high biophysical quality, the dataset is considered as validated and as such meets our criteria for publication. Of note, validation controls for the biophysical quality of the identified interactions. Dissecting the functional relevance of a given PPI requires extensive experimental follow-up.</span></p>\r\n<p><span style=\"font-size: 18pt; font-family: arial, helvetica, sans-serif; color: #2b83ba; background-color: transparent; font-weight: bold; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Vector details</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\">&nbsp;</p>\r\n<div dir=\"ltr\" style=\"margin-left: 0pt;\">\r\n<table style=\"border: none; border-collapse: collapse;\"><colgroup><col width=\"102\" /><col width=\"102\" /><col width=\"97\" /><col width=\"207\" /><col width=\"100\" /></colgroup>\r\n<tbody>\r\n<tr style=\"height: 0px;\">\r\n<td style=\"vertical-align: top; background-color: #bfbfbf; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: #bfbfbf; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Name</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; background-color: #bfbfbf; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: #bfbfbf; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">pDEST-DB</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; background-color: #bfbfbf; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: #bfbfbf; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">pDEST-AD-</span><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: #bfbfbf; font-weight: bold; font-style: italic; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">CHY2</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; background-color: #bfbfbf; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: #bfbfbf; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">pDEST-QZ213</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; background-color: #bfbfbf; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: #bfbfbf; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">pDEST-AD-AR68</span></p>\r\n</td>\r\n</tr>\r\n<tr style=\"height: 0px;\">\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Fusion</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Gal4-DB</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">(aa 1-147)</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Gal4-AD</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">(aa 768-881)</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Gal4-AD</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">(aa 768-881)</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Gal4-AD</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">(aa 768-881)</span></p>\r\n</td>\r\n</tr>\r\n<tr style=\"height: 0px;\">\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Fusion location</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">N-term</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">N-term</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">N-term</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">C-term</span></p>\r\n</td>\r\n</tr>\r\n<tr style=\"height: 0px;\">\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Promoter</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Truncated </span><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: italic; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">ADH1</span><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> promoter (-701 to +1)</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Truncated </span><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: italic; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">ADH1</span><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> promoter (-701 to +1)</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Truncated </span><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: italic; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">ADH1</span><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> promoter (-410 to +1)</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Truncated </span><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: italic; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">ADH1 </span><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">promoter (-410 to +1)</span></p>\r\n</td>\r\n</tr>\r\n<tr style=\"height: 0px;\">\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Yeast replication ori</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">CEN</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">CEN</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">2micron</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">2micron</span></p>\r\n</td>\r\n</tr>\r\n<tr style=\"height: 0px;\">\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Linker</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">SRSNQ</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">GGSNQ</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">ICMAYPYDVPDYASLGGHMAMEAPS</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">VDGTA</span></p>\r\n</td>\r\n</tr>\r\n<tr style=\"height: 0px;\">\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Terminator</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: italic; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">ADH1</span><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> Term</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: italic; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">ADH1 </span><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Term</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: italic; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">ADH1</span><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> Term</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: italic; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">ADH1</span><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> Term</span></p>\r\n</td>\r\n</tr>\r\n<tr style=\"height: 0px;\">\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Selection marker</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">AmpR</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">AmpR</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">AmpR</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">AmpR</span></p>\r\n</td>\r\n</tr>\r\n<tr style=\"height: 0px;\">\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">&nbsp;</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">&nbsp;</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">&nbsp;</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">&nbsp;</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</div>\r\n<p>&nbsp;</p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 18pt;\"><span style=\"font-family: arial, helvetica, sans-serif; color: #2b83ba; background-color: transparent; font-weight: bold; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Y2H assay versions</span></span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">Combinations of different yeast strains and vectors result in different Y2H assay versions as described in the table below. </span><br /><br /><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">Assay version 0 was used to generate the datasets HI-I-05 and Venkatesan-09. Assay version 1 was used to generate HI-II-14, Yu-11, Yang-16, some of the test space screens, and the screens 1-3 of HuRI. Assay version 2 was used to generate screens 4-6 and some test space screens and assay version 3 for screens 7-9 of HuRI and some test space screens.</span></p>\r\n<div dir=\"ltr\" style=\"margin-left: 0pt;\">\r\n<table class=\"MsoNormalTable\" style=\"width: 518px; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; border-collapse: collapse; height: 190px;\" border=\"0\" width=\"623\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr style=\"mso-yfti-irow: 0; mso-yfti-firstrow: yes; height: 12.1pt;\">\r\n<td style=\"border: solid black 1.0pt; mso-border-alt: solid black .75pt; background: #BFBFBF; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><strong><span style=\"font-size: 10pt; font-family: Arial, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Assay version</span></strong></p>\r\n</td>\r\n<td style=\"border: solid black 1.0pt; border-left: none; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; background: #BFBFBF; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><strong><span style=\"font-size: 10pt; font-family: Arial, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">DB vector</span></strong></p>\r\n</td>\r\n<td style=\"border: solid black 1.0pt; border-left: none; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; background: #BFBFBF; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><strong><span style=\"font-size: 10pt; font-family: Arial, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">AD vector</span></strong></p>\r\n</td>\r\n<td style=\"border: solid black 1.0pt; border-left: none; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; background: #BFBFBF; padding: .75pt .75pt .75pt .75pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><strong><span style=\"font-size: 10pt; font-family: Arial, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">DB yeast strain &nbsp;</span></strong></p>\r\n</td>\r\n<td style=\"border: solid black 1.0pt; border-left: none; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; background: #BFBFBF; padding: .75pt .75pt .75pt .75pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><strong><span style=\"font-size: 10pt; font-family: Arial, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">AD yeast strain</span></strong></p>\r\n</td>\r\n</tr>\r\n<tr style=\"mso-yfti-irow: 1; height: 12.9pt;\">\r\n<td style=\"border: solid black 1.0pt; border-top: none; mso-border-top-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.9pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: center; line-height: normal;\" align=\"center\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">0</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.9pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">pDEST-DB</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.9pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">pDEST-AD-<em>CHY2</em></span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: .75pt .75pt .75pt .75pt; height: 12.9pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">MaV203</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: .75pt .75pt .75pt .75pt; height: 12.9pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">MaV103</span></p>\r\n</td>\r\n</tr>\r\n<tr style=\"mso-yfti-irow: 2; height: 12.1pt;\">\r\n<td style=\"border: solid black 1.0pt; border-top: none; mso-border-top-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: center; line-height: normal;\" align=\"center\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">1</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">pDEST-DB</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">pDEST-AD-<em>CHY2</em></span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: .75pt .75pt .75pt .75pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">Y8930</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: .75pt .75pt .75pt .75pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">Y8800</span></p>\r\n</td>\r\n</tr>\r\n<tr style=\"mso-yfti-irow: 3; height: 12.1pt;\">\r\n<td style=\"border: solid black 1.0pt; border-top: none; mso-border-top-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: center; line-height: normal;\" align=\"center\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">2</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">pDEST-DB</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">pDEST-QZ213</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: .75pt .75pt .75pt .75pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">Y8930</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: .75pt .75pt .75pt .75pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">Y8800</span></p>\r\n</td>\r\n</tr>\r\n<tr style=\"mso-yfti-irow: 4; mso-yfti-lastrow: yes; height: 12.9pt;\">\r\n<td style=\"border: solid black 1.0pt; border-top: none; mso-border-top-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.9pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: center; line-height: normal;\" align=\"center\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">3</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.9pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">pDEST-DB</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.9pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">pDEST-AD-AR68</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: .75pt .75pt .75pt .75pt; height: 12.9pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">Y8930</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: .75pt .75pt .75pt .75pt; height: 12.9pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">Y8800</span></p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</div>\r\n<p>&nbsp;</p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 18pt;\"><span style=\"font-family: arial, helvetica, sans-serif; color: #2b83ba; background-color: transparent; font-weight: bold; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Search options</span></span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">By default the search function of the web portal will return all query proteins with their interaction partners and all interactions between these proteins that have been identified in any of the PPI datasets described above. The results can be limited to interactions between query proteins and between query proteins and their interaction partners only. For larger queries and for cases when there is no need to display the results as network, the results can be directly retreived as a data file.</span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 18pt;\"><span style=\"font-family: arial, helvetica, sans-serif; color: #2b83ba; background-color: transparent; font-weight: bold; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Filter options</span></span></p>\r\n<p><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif;\"><span style=\"color: #3282b8;\">Confidence Score</span>:</span><br /><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif;\">This score is intended to rank human binary protein-protein interactions (PPIs) identified in systematic screens at CCSB based on their biophysical quality. A random subset of PPIs (~5%) from all Y2H screens are tested in orthogonal binary PPI detection assays, such as MAPPIT and GPCA, to demonstrate the high overall quality of each screen prior to release. The confidence score can be used to further prioritize interactions for experimental follow-up wherever needed. The score is based on information from the Y2H experiments and retest rates of specific subsets of PPIs in MAPPIT and GPCA. The score is the output of a statistical model of the MAPPIT and GPCA tests, which corrects for lower retest rates as a result of differences in the experimental detectability of PPIs rather than differences in their biophysical quality (see HuRI paper on detectability of PPIs).</span><br /><br /><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif;\">Specifically, the probability of a PPI testing positive in GPCA/MAPPIT data is modeled as being composed of two components, formulated as the regularized product of two logistic functions, both with the same input features. The first component represents the probability of a pair to be a false positive, the second represents the probability to test positive for a real interaction. This second component is constrained by data from testing PPIs found in Y2H which have additional independent literature evidence. The confidence score is calculated as the first component, scaled to an estimate of the overall precision of the dataset, obtained using the procedure described in Venkatesan et al Nature Methods 2009. The six features of a PPI used are: the number of screens in which it was detected; the number of different versions of the Y2H assay in which it was detected; the strength of growth of the yeast; whether the interaction between proteins X and Y was detected with both combinations of DNA-binding domain (DB) and activation domain (AD) fusions, i.e. DB-X with AD-Y and DB-Y with AD-X; the number of interaction partners of the two proteins; and the length of the ORF.</span><br /><br /><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif;\"><span style=\"color: #3282b8;\">Interaction status</span>:</span><br /><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif;\">The results can also be restricted to either only show PPIs from CCSB or from the literature. The user can choose to display tissue expression levels and levels of tissue specific expression of nodes in the network in combination with the selection of a tissue (see below).</span><br /><br /><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif;\"><span style=\"color: #3282b8;\">Tissue expression</span>:</span><br /><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif;\">One or multiple tissues can be selected to filter the protein interaction data for proteins that are expressed in at least one of the selected tissues. Only interactions between the expressed proteins will be displayed. By default, expression abundance levels will be represented on the network by increasing the node size. Specificity of expression is indicated by varying the intensity of the color of the nodes (only applicable to cases where a single tissue has been selected). The tissue gene expression data has been extracted from the GTEx portal and has been processed and normalized as described in Paulson et al BMC Bioinformatics 2017. The preferential expression of a given gene in a given tissue was calculated as described in Sonawane et al Cell Reports 2017. More details are also provided in the HuRI paper.</span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 18pt;\"><span style=\"font-family: arial, helvetica, sans-serif; color: #2b83ba; background-color: transparent; font-weight: bold; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Export options</span></span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 12pt;\"><span style=\"font-size: 14pt;\">The network can be exported to Cytoscape by clicking the little orange network icon in the bottom left corner of the network browser, if Cytoscape is installed and running. The proteins displayed in the network can directly be exported as list into a variety of external resources to calculate functional enrichments and perform other network-related searches.</span> </span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 18pt;\"><span style=\"font-family: arial, helvetica, sans-serif; color: #2b83ba; background-color: transparent; font-weight: bold; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Save options</span></span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">The search results can be saved as image (if a network was displayed) or in various text file formats as lists of proteins and interactions. Furthermore, the web portal offers to users the possibility to create an account. If the user is logged in, an extra Save button will appear on the results page allowing the user to save the search result and the exact network representation or session that the user generated. Later, the user can select a saved network/session and reload it into the network browser for further manipulation. Of note, users need to login first prior to performing a search or the search results will be lost.</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 18pt; font-family: arial, helvetica, sans-serif; color: #2b83ba; background-color: #ffffff; font-weight: bold; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Requirements to run the HuRI portal</span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 12pt;\"><span style=\"font-size: 14pt;\">The web browser must be configured to accept cookies and JavaScript must be enabled.</span>&nbsp; </span><span style=\"color: #2b83ba;\"><br /></span></p>\r\n<p id=\"acknowledgments\" dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 18pt; font-family: Arial; color: #2b83ba; background-color: #ffffff; font-weight: bold; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Acknowledgments</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">CCSB interactome mapping and ORFeome cloning efforts are supported by federal grants from the National Human Genome Research Institute of NIH, the Ellison Foundation, the Dana-Farber Cancer Institute Strategic Initiative, the Canada Excellence Research Chairs program, and the Canadian Institutes of Health Research.</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;\">&nbsp;</p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;\">&nbsp;</p>', '<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">Where does the interaction data available for search and download on this web portal come from?</span></strong></span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">The interaction data comes from two sources. The majority comes from a series of systematic screens of human open reading frame (ORF) clone collections performed in the Vidal, Tavernier and Roth labs at Dana-Farber Cancer Institute/Harvard Medical School, Vlaams Instituut voor Biotechnologie/Ghent University and University of Toronto, respectively. These interactions were found using a systematic binary mapping pipeline based upon a high-throughput yeast two-hybrid assay as the primary screen, followed by pairwise retesting in quadruplicate of all primary pairs, and subsequent validation of a random subset using two or more orthogonal assays.<br />The remainder of the data are from databases of curated interactions reported in the literature. The publicly available interaction data was filtered to identify the high-quality binary interactions as described in the</span><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\"> <a href=\"https://www.biorxiv.org/content/10.1101/605451v1\">HuRI paper</a>.<br /></span></p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">Does the interaction data originate from experiments and/or predictions?</span></strong></span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">All of the systematic data come from our systematic experimental screening pipeline and have at least one piece of supporting experimental evidence. This systematic dataset has been shown to have quality (fraction correct) that is on par with high-quality literature curated binary interactions, defined by having at least two pieces of experimental evidence from original publications, curated from the literature.</span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\"><span style=\"font-size: 14pt;\"><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\"><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">Why is the number of interactions for a given dataset different from the number reported in the original publication?</span></strong></span></span></strong></span></span></span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">We map our ORF sequences to GENCODE (v27) gene annotation models to identify the gene, transcript, and protein to which our ORF belongs to. Because the genome is highly redundant, and genome annotation is difficult, there are changes between different GENCODE versions which can result in changes in the genes and proteins to which our ORFs map best. Furthermore, we only provide interactions for ORFs that, based on the gene annotation model, map to protein coding genes. The identification of which genes encode proteins is also subject to change between different gene annotation models.</span></p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"font-size: 14pt;\"><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">I have my query genes in a different identifier format (neither gene symbols nor Uniprot IDs). What can I do to still use them as query on this web portal?</span></strong></span><em><span style=\"font-family: Helvetica, sans-serif;\"> <br /></span></em></span></p>\r\n<p><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif;\">Currently our portal can only be searched using either gene symbols or UniProt accession numbers. You can convert your list of query genes into gene symbols or UniProt IDs at these websites (<a href=\"http://www.uniprot.org/uploadlists/\">http://www.uniprot.org/uploadlists/</a>, <a href=\"https://david.ncifcrf.gov/conversion.jsp)\">https://david.ncifcrf.gov/conversion.jsp)</a>.</span></p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">Why does my search not return any PPIs?</span></strong></span></p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">We have tested the ORFs corresponding to over 17,000 human protein-coding genes using our binary interaction mapping pipeline (a full list of the genes we have tested is available at http://horfdb.dfci.harvard.edu/). However, we may not have screened your gene of interest yet because we do not currently have an ORF clone available for this gene.<br />The other possibility is that even though we have screened for PPIs with an ORF from your gene of interest, the expressed protein may not have resulted in any PPIs. While our binary interaction mapping pipeline is designed to be systematic and unbiased, there are some proteins which may prove to be refractory to the assays used. For example, (i) proteins that are secreted, are intrinsic membrane proteins or require significant post-translational modification may not form stable interactions under our assay conditions, (ii) some human proteins may be unstable or not fold correctly when expressed in yeast, (iii) some proteins may only interact as parts of large complexes and not as binary pairs, or (iv) some proteins may be incapable of interaction due, e.g., to errors or natural sequence variation in the clones, or due to the influence of the fused tags.<br /></span></p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">What would be a good confidence score cutoff to filter the interactions?</span></strong></span></p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"font-size: 14pt;\"><span style=\"font-family: arial, helvetica, sans-serif;\">All CCSB datasets have been validated of their high biophysical quality by testing random subsets of PPIs in independent assays. The confidence score is intended to further rank the identified interactions, for example in cases where too many PPIs result and only a subset of all identified interactions can be used for experimental follow-up. In that sense, a cutoff can be defined based on the number of interactions that a user wants to consider. This score quantifies only a small part of the variance in biophysical quality within the dataset and therefore should not be used to discard PPIs for quality concerns.</span></span></p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"font-size: 14pt;\"><span style=\"font-family: arial, helvetica, sans-serif;\"><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">In which format do I need to save the search results for upload into Cytoscape?</span></strong></span></span></span></p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"font-size: 14pt;\"><span style=\"font-family: arial, helvetica, sans-serif;\">To upload the search results into Cytoscape, export them as a .csv file.</span></span></p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">Why is there not a confidence score for every PPI?&nbsp;</span></strong></span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">The confidence score of a pair is calculated based on several features of how the interaction was detected during screening. This data is only available for pairs detected in the most recent screens (HuRI), and hence we are only able to calculate confidence scores for these pairs.</span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\"><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">How should I cite the interaction data and web portal?<br /></span></strong></span></span></p>\r\n<p>&nbsp;</p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">How can I get information on the clone used to identify an interaction returned from my search?</span></strong></span></p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">The clones used in our screens come from the Human ORFeome clone collection assembled at</span><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\"><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\"> <a href=\"http://horfdb.dfci.harvard.edu\">CCSB</a> and via the&nbsp;<a href=\"http://www.orfeomecollaboration.org\">ORFeome Collaboration</a></span>. Clicking the ORF identifiers will redirect the user to our ORFeome web portal where details on the cloning strategy, source material and nucleotide sequence are provided.</span></p>\r\n<p><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\"><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">How can I get detailed experimental information on an interaction of interest?</span></strong></span></span></strong></span></p>\r\n<p><span style=\"color: #000000; font-size: 14pt; font-family: arial, helvetica, sans-serif;\"><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">By clicking on the edge that represents the interaction of interest in the network visualization on the results page, the user can obtain information on the individual experiments in which that interaction was identified along with information on the corresponding ORF identities. <br /></span></span></p>\r\n<p><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">Isn\'t yeast two-hybrid data full of false positives?</span></strong></span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">Like any other experimental approach, the quality of the data generated is dependent on the careful design of the experiment and rigorous attention to detail in performing the experiments. We first remove all proteins which can autoactivate the yeast reporter genes (i.e., a single protein (as bait or prey in Y2) is able to induce reporter gene expression in the absence of any other partner protein). In addition, our modern binary interaction mapping pipeline contains numerous quality control measures implemented after primary screening, including pairwise verification (regenerating and retesting mated diploids from fresh glycerol stocks) and sequencing to confirm ORF identity. A random sample of verified primary yeast two-hybrid datasets are validated by testing a subset of interactions in at least two orthogonal assays that have been calibrated using positive and random reference sets. We only consider a dataset validated if the biophysical quality of the dataset is equal to, or greater than, a representative sample of interactions selected from the literature.<br />We note that this process can establish that our interactions are of high biophysical quality, meaning that the reported pair of proteins is highly likely to interact when both proteins are expressed together. The assays employed however, cannot inform on whether the identified interactions are physiologically or biologically relevant. Demonstrating such relevance for an individual PPI requires an additional battery of molecular and cellular assays, which we are unable to perform on the more than 60,000 PPIs reported. However, we show that our datasets are highly enriched in linking proteins of similar functional annotation compared to random networks and in follow-up studies we provide evidence for the functional relevance of a number&nbsp; of PPIs (see our published work). Integration of Y2H interactome data with current data on contextual gene and protein expression and protein localization data can prioritize PPIs that are more likely to be physiologically relevant in the selected cellular context. However, one should not necessarily rule out any PPI in our dataset because of lack of contextual data due to the overall incompleteness of those datasets.<br /></span></p>\r\n<p><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">How complete is your map?</span></strong></span></p>\r\n<p><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif;\">Estimating the level of completeness of our interactome data is difficult given how little we know about the composition of the human protein interactome and methodological biases associated with all interactome mapping assays including Y2H. As described in our HuRI paper, we estimate that HuRI currently covers 2-11% of the human binary protein interactome. Part of the PPIs that we are missing are those that depend on post-translational modifications that the yeast cell does not catalyze (at least under the conditions we used). Furthermore, our estimate of interactome coverage is only valid for binary protein interactions, and therefore does not include PPIs that depend on additional interaction partners (cooperative binding) and protein interactions that represent indirect associations in protein complexes. Complementary interactome mapping efforts, e.g., affinity purification followed by mass spectrometry, that can also be implemented at human proteome scale are needed to further complement and complete the binary interaction maps we provide.</span></p>\r\n<p><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">Is your dataset depleted for protein interactions that are part of stable protein complexes?</span></strong></span></p>\r\n<p><span style=\"font-size: 14pt;\">By integrating our data with three dimensional structural information from protein complexes we observed that our interaction detection platform can detect interactions that are part of stable protein complexes across a wide range of protein complex sizes and we only observe a mild depletion for very large protein complexes (30+ subunits).</span></p>\r\n<p><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">How do the various datasets available for download relate to each other?</span></strong></span></p>\r\n<p><span style=\"font-size: 14pt;\">The full descriptions of all various datasets in the &ldquo;Dataset Downloads&rdquo; page can be found in the &ldquo;About&rdquo; page. &ldquo;HI-union&rdquo; is the union of all published datasets (i.e. HI-I-05, HI-II-14, HuRI, Venkatesan-09, Yu-11, Yang-16, and Test space screens-19) except Lit-BM. The total number of PPIs and proteins listed on the homepage is the union of all datasets, published and unpublished.</span></p>\r\n<p><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">How was this project funded?</span></strong></span></p>\r\n<p><span style=\"font-size: 14pt;\">This work was primarily supported by a National Institutes of Health (NIH) National Human Genome Research Institute (NHGRI) grant U41HG001715 with additional support from NIH grants P50HG004233, U01HL098166, U01HG007690, R01GM109199, Canadian Institute for Health Research (CIHR) Foundation Grants, the Canada Excellence Research Chairs Program and an American Heart Association grant 15CVGPS23430000. <br />For further information, please see the acknowledgement section of the HuRI paper. <br /><br /></span></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p><span style=\"font-size: 14pt;\">&nbsp;</span></p>', '<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; text-align: justify;\"><span style=\"font-size: 18pt; font-family: Arial; color: #a51c30; background-color: transparent; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"><span id=\"docs-internal-guid-9ab43ec0-21cb-0994-6eda-f937ad2e05e7\"><span style=\"background-color: transparent; vertical-align: baseline;\">Publication Moratorium</span></span></span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; text-align: justify;\">&nbsp;</p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; text-align: justify;\"><span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">All users are expected to observe the following guidelines when using preliminary, unpublished data from the CCSB Human Interactome:</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; text-align: justify;\"><span style=\"font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">&middot;</span><span style=\"font-size: 7pt; font-family: \'Times New Roman\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Registered users may download and analyze all verified or validated datasets.</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; text-align: justify;\"><span style=\"font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">&middot;</span><span style=\"font-size: 7pt; font-family: \'Times New Roman\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">There is a \"moratorium\" on dissemination of binary interaction screening data or derived results, including publication of global analysis of the data. The moratorium period for released interaction data ends 12 months after the entire verified data set obtained from one complete screen has been made publicly available or immediately upon publication of the corresponding dataset by CCSB (whichever comes first). We grant an exception to this moratorium for dissemination in the form of presentations or publications that are focused around small numbers of interactions, which we define to be either a set of up to 10 interactions, or all of the interactions involving a specific protein, whichever is less restrictive.</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; text-align: justify;\"><span style=\"font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">&middot;</span><span style=\"font-size: 7pt; font-family: \'Times New Roman\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">The moratorium on dissemination is considered to extend to all forms of public disclosure, including meeting abstracts, oral presentations, and formal electronic submissions to publicly accessible sites (e.g., public websites, web blogs).</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; text-align: justify;\"><span style=\"font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">&middot;</span><span style=\"font-size: 7pt; font-family: \'Times New Roman\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Users are expected to acknowledge the following in all oral or written presentations, disclosures, or publications of the analyses (before or after the moratorium period):</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; text-align: justify;\"><span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">&middot;</span><span style=\"font-size: 7pt; font-family: \'Times New Roman\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> &nbsp;&nbsp;</span> <span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">The Center for Cancer Systems Biology (CCSB) at the Dana-Farber Cancer Institute</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; text-align: justify;\"><span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">&middot;</span><span style=\"font-size: 7pt; font-family: \'Times New Roman\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> &nbsp;&nbsp;</span> <span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">The funding organization(s) that supported the work:</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; margin-left: 36pt; text-align: justify;\"><span style=\"font-size: 11pt; font-family: \'Courier New\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">o</span><span style=\"font-size: 7pt; font-family: \'Times New Roman\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> &nbsp;</span><span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">The National Human Genome Research Institute (NHGRI) of NIH</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; margin-left: 36pt; text-align: justify;\"><span style=\"font-size: 11pt; font-family: \'Courier New\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">o</span><span style=\"font-size: 7pt; font-family: \'Times New Roman\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> &nbsp;</span><span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">The Ellison Foundation, Boston, MA</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; margin-left: 36pt; text-align: justify;\"><span style=\"font-size: 11pt; font-family: \'Courier New\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">o</span><span style=\"font-size: 7pt; font-family: \'Times New Roman\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> &nbsp;</span><span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">The Dana-Farber Cancer Institute Strategic Initiative</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; text-align: justify;\"><span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">&middot;</span><span style=\"font-size: 7pt; font-family: \'Times New Roman\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> &nbsp;&nbsp;</span> <span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">The fact that interactions were verified but not yet validated, where that is the case.</span></p>\r\n<p>&nbsp;</p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; text-align: justify;\"><span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">&middot;</span><span style=\"font-size: 7pt; font-family: \'Times New Roman\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> &nbsp;&nbsp;</span> <span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">The date on which interaction dataset was downloaded, allowing readers the opportunity to efficiently identify which interactions in preliminary datasets might have been subsequently corrected (e.g., due to subsequent failure to validate)</span></p>', '<p><span style=\"font-size: 12pt;\"><span style=\"color: #333333; vertical-align: baseline; white-space: pre-wrap;\"><span style=\"color: #000000;\">Please contact</span> <a href=\"mailto:michael_calderwood@dfci.harvard.edu\">Michael Calderwood</a></span><span style=\"color: #000000; vertical-align: baseline; white-space: pre-wrap;\"> or <a href=\"mailto:tong_hao@dfci.harvard.edu\">Tong Hao</a></span><span style=\"color: #000000; vertical-align: baseline; white-space: pre-wrap;\"> with questions regarding the displayed protein interaction data and all its experimental and computational aspects.</span></span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 12pt;\"><span style=\"color: #000000; vertical-align: baseline; white-space: pre-wrap;\">Please contact <a href=\"mailto:gary.bader@utoronto.ca\">Gary Bader</a></span><span style=\"color: #000000; vertical-align: baseline; white-space: pre-wrap;\"> or </span></span><span style=\"font-size: 16px; vertical-align: baseline; white-space: pre-wrap; color: #2b83ba;\"> <a style=\"color: #2b83ba;\" href=\"mailto:miles.william.mee@gmail.com\">Miles Mee</a></span> <span style=\"white-space: pre-wrap; font-size: 12pt;\">with questions regarding this web portal.</span></p>', 1, 1, '<p style=\"text-align: center;\">&nbsp;</p>\r\n<p style=\"text-align: center;\"><span style=\"font-family: Arial; font-size: 14.6667px; white-space: pre-wrap;\">The HuRI project is directed from the Center for Cancer Systems Biology as a joint effort between the </span><span style=\"color: #2b83ba;\"><a style=\"font-family: Arial; font-size: 14.6667px; white-space: pre-wrap; color: #2b83ba;\" href=\"http://ccsb.dfci.harvard.edu/web/www/ccsb/\" target=\"_blank\">Vidal</a></span><span style=\"font-family: Arial; font-size: 14.6667px; white-space: pre-wrap;\">, </span><a style=\"font-family: Arial; font-size: 14.6667px; white-space: pre-wrap;\" href=\"http://llama.mshri.on.ca/\" target=\"_blank\"><span style=\"color: #2b83ba;\">Roth</span>,</a>&nbsp;<span style=\"color: #2b83ba;\"><a style=\"font-family: Arial; font-size: 14.6667px; white-space: pre-wrap; color: #2b83ba;\" href=\"http://www.vib.be/en/research/scientists/Pages/Jan-Tavernier-Lab.aspx\" target=\"_blank\">Tavernier</a></span><span style=\"font-family: Arial; font-size: 14.6667px; white-space: pre-wrap;\">, and </span><span style=\"color: #2b83ba;\"><a style=\"font-family: Arial; font-size: 14.6667px; white-space: pre-wrap; color: #2b83ba;\" href=\"http://www.baderlab.org\" target=\"_blank\">Bader</a></span><span style=\"font-family: Arial; font-size: 14.6667px; white-space: pre-wrap;\"> labs.</span></p>', '#980000', '#ffffff', '#ffffff', '#ff9900', 'BAD\\nBAK1\\nMCL1\\nBCL2L1\\nBCL2L2\\nBCL2A1\\nBMF\\nBIK\\nREL', 'BAD\\nBAK1\\nMCL1\\nBCL2L1\\nBCL2L2\\nBCL2A1\\nBMF\\nBIK\\nREL', 'BAD\\nBAK1\\nMCL1\\nBCL2L1\\nBCL2L2\\nBCL2A1', '#cc0000', '#3c78d8', '#6aa84f', '#e69138', '#a61c00', '#9955ffff', '3', 'Mission Custom', '<p style=\"text-align: left;\"><span style=\"color: #333333; font-family: \'Gotham HTF\', sans-serif; font-size: 18px;\">Can be changed,</span></p>\r\n<p style=\"text-align: left;\"><span style=\"color: #333333; font-family: \'Gotham HTF\', sans-serif; font-size: 18px;\">The Center for Cancer Systems Biology at Dana-Farber Cancer Institute is generating the first complete reference map of the human protein-protein interactome network. All pairwise combinations of human protein-coding genes are systematically being interrogated to identify which are involved in binary protein-protein interactions.</span></p>', 'Method Custom', '<div class=\"row\" style=\"box-sizing: border-box; margin-right: -15px; margin-left: -15px; color: #333333; font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; font-size: 14px;\">\r\n<div id=\"method_div\" style=\"box-sizing: border-box; max-width: 800px; margin: auto;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 10px; font-family: \'Gotham HTF\', sans-serif; font-size: 18px; text-align: left;\">Can be changed,</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 10px; font-family: \'Gotham HTF\', sans-serif; font-size: 18px; text-align: left;\">Pairwise combinations of human protein-coding genes are tested systematically using high throughput yeast two-hybrid screens to detect protein-protein interactions. The quality of these interactions are further validated in multiple orthogonal assays. Currently 75309 PPIs involving 11999 proteins have been identified using this framework. In addition to systematically identifying PPIs experimentally, HuRI also includes PPIs of comparable high quality extracted from literature. This subset of literature-curated PPIs currently comprises 12589 PPIs.</p>\r\n<p style=\"text-align: left;\">&nbsp;</p>\r\n</div>\r\n</div>');

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
  `name` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
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
  `score` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `removed` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
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
  `selected_by_default` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `include_in_home_page_count` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL
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
  `sequence` varchar(10000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(10000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number_of_interactions_in_database` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL
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

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`) VALUES
(1, 'miles', 'miles', 'miles.william.mee@gmail.com', 'miles.william.mee@gmail.com', 1, NULL, '$2y$13$mgjEPjKWcdpR24IDJ9nxGOCr87Kct2/h8AuuUUFrOUzgKIkr3ESrC', '2019-12-06 14:07:48', NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}'),
(2, 'admin', 'admin', 'miles_mee@hotmail.com', 'miles_mee@hotmail.com', 1, 'pvbskadbm5ck88oos4co4c0cw04448g', '$2y$13$pvbskadbm5ck88oos4co4OyIgXab9BuvUkL.lAcePA4hmX6xDAdcu', '2021-07-17 16:28:53', 'kdadjqDc8z9aAbWdadeMn3Zi6pc5FqR-d60oARvk3EQ', '2016-09-19 03:47:09', 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}'),
(3, 'user', 'user', 'milesmeee@gmail.com', 'milesmeee@gmail.com', 1, NULL, '$2y$13$smH7NTczu1I2O4UqWDHIFe8cOTqV0XrcUJttuq6BQX7m31J9wFCna', '2017-07-02 03:46:33', NULL, NULL, 'a:0:{}'),
(4, 'eladpr', 'eladpr', 'eladprinz@gmail.com', 'eladprinz@gmail.com', 1, NULL, '$2y$13$Jiusnxlh3QNUmsN1QAYstOoz6ua2VfsO5pUUoWQ2rniJ2yQQI7Ba6', '2017-07-24 04:15:38', NULL, NULL, 'a:0:{}'),
(5, 'theosanderson', 'theosanderson', 'theo@sndrsn.co.uk', 'theo@sndrsn.co.uk', 1, NULL, '$2y$13$29CEg7f9hPUXtrgs2OPD1ObYouC7e0OYgEq5Sx5FF8wwvcm27IFQ6', '2017-07-24 13:46:04', NULL, NULL, 'a:0:{}'),
(6, 'irazfan', 'irazfan', 'zahediaa@myumanitoba.ca', 'zahediaa@myumanitoba.ca', 1, NULL, '$2y$13$yajP7lPRCPw4fA0shb64fubYmE3EfRfcE.8GK94zoPAmOOcMz9aji', '2017-07-24 16:09:42', NULL, NULL, 'a:0:{}'),
(7, 'raisahm', 'raisahm', 'rais.ganai@nyumc.org', 'rais.ganai@nyumc.org', 1, NULL, '$2y$13$valCNrBnl8XnDBA2BnkFr.Q8W0EriQmHwYY0lnT9tIeApGpqzxOem', '2017-07-25 18:50:06', NULL, NULL, 'a:0:{}'),
(8, 'carles.pons', 'carles.pons', 'carles.pons@irbbarcelona.org', 'carles.pons@irbbarcelona.org', 1, NULL, '$2y$13$hssUWCTNnKcSo8Sd8Noq2eptAufoU/zHKUgZUMbFEYxcD2evcnW4q', '2017-10-18 01:57:21', NULL, NULL, 'a:0:{}'),
(9, 'fgoebels', 'fgoebels', 'florian.goebels@gmail.com', 'florian.goebels@gmail.com', 1, NULL, '$2y$13$cSmFeEwft7ySdll7m9B/AOzQKNrt8xLg5JOK4wxw1NK8ltsunfXpW', '2017-07-26 10:38:05', NULL, NULL, 'a:0:{}'),
(10, 'jfuxman', 'jfuxman', 'fuxman@bu.edu', 'fuxman@bu.edu', 1, NULL, '$2y$13$FZTQGJmQPHl.8gcFa9K/iel9.gRvi6P513Se6WTdW/v4C38tv4E2e', '2017-10-07 04:03:31', NULL, NULL, 'a:0:{}'),
(11, 'vAirDa', 'vairda', 'veres.v.daniel@gmail.com', 'veres.v.daniel@gmail.com', 1, NULL, '$2y$13$EOo7r9mo1wPVmCb9L8pCDON74EGyl32RKqUO/YmtVzUO6Z4WbqsGS', '2017-07-31 03:37:37', NULL, NULL, 'a:0:{}'),
(12, 'jinmingao', 'jinmingao', 'jinmingao@gmail.com', 'jinmingao@gmail.com', 1, NULL, '$2y$13$thnqZmfBoNx2JB9Tc..0ROc9FGmGOm.BPqAr4Nd8LGBw0Y/Z./1rm', '2017-08-01 07:25:01', NULL, NULL, 'a:0:{}'),
(13, 'DEHill', 'dehill', 'david_hill@dfci.harvard.edu', 'david_hill@dfci.harvard.edu', 1, NULL, '$2y$13$iPxhkMbWKhcbf58z8iFGuuBWH.x7ZRfJ1wvYrZCI2iABJUKp6IxEK', '2017-11-08 06:08:55', 'L0mcHKiGmf20AKFZTUtcWyhKiDu2kH9cJr2lYY8b4Ho', '2017-09-06 11:07:26', 'a:0:{}'),
(14, 'tsganesan', 'tsganesan', 'TSGANESAN@GMAIL.COM', 'tsganesan@gmail.com', 1, NULL, '$2y$13$o3I0Rvfq82IFDfHEFEWPx.Uv0.A7G4MSoeelGySCFrbNIfmP5s9bW', '2017-08-04 01:22:13', NULL, NULL, 'a:0:{}'),
(15, 'garybader', 'garybader', 'gary.bader@utoronto.ca', 'gary.bader@utoronto.ca', 1, NULL, '$2y$13$mX8PFR7z6SQZZSKbOfWUY.FU3hbcNuZ48A1VAgcsIndjUyTH/u.dO', '2017-11-29 21:50:18', NULL, NULL, 'a:0:{}'),
(16, 'stormlovetao', 'stormlovetao', 'wangtao.shandong@gmail.com', 'wangtao.shandong@gmail.com', 1, NULL, '$2y$13$eJfCvceG.Ni9kpu/dyBNeOopAJpLkh6OBv2nTLF3ebOW7HuiQ19jO', '2017-08-07 14:29:02', NULL, NULL, 'a:0:{}'),
(17, 'kimbie', 'kimbie', 'rekrg@channing.harvard.edu', 'rekrg@channing.harvard.edu', 1, NULL, '$2y$13$wQ3D3tpT4M7ZeEIwJ8lM3erwa2r11.ZwMJR9i/F62FkJugTZD0gwu', '2017-08-10 12:17:29', NULL, NULL, 'a:0:{}'),
(18, 'Ancicrox', 'ancicrox', 'morshonka@yandex.ru', 'morshonka@yandex.ru', 1, NULL, '$2y$13$sxmucY1cM31SSvgY0NNECOgXaNQPvdfVi4aj1ATlUDhc6XlR/XTBK', '2017-08-14 07:21:59', NULL, NULL, 'a:0:{}'),
(19, 'W_bingbo', 'w_bingbo', 'w_bingbo@163.com', 'w_bingbo@163.com', 1, NULL, '$2y$13$VXC3llNBCiEGJmE1AgPk8uHhHzgGMtpVj3JM4/hVg7C.RGrNOBsK2', '2017-08-14 22:40:28', NULL, NULL, 'a:0:{}'),
(20, 'klaclair', 'klaclair', 'katherine.laclair@dzne.de', 'katherine.laclair@dzne.de', 1, NULL, '$2y$13$oD.GVpQ/eI/wG7THTltU7e48ahNOZPotPzfpT6PnrHU9qzfk2Iz2O', '2017-08-16 07:52:08', NULL, NULL, 'a:0:{}'),
(21, 'Hekselman', 'hekselman', 'idan.shita@yahoo.com', 'idan.shita@yahoo.com', 1, NULL, '$2y$13$J5DSra.pvDiNWJM.qnAvC.1eJtbPYwsaqq7NNnMqETGjlo3RL8mE6', '2017-08-19 11:03:55', NULL, NULL, 'a:0:{}'),
(22, 'dietmar_pils', 'dietmar_pils', 'dietmar.pils@meduniwien.ac.at', 'dietmar.pils@meduniwien.ac.at', 1, NULL, '$2y$13$W54pxdztZQKUPhD.8O8TNOAeGWueX0qODFmj9vxjfN/RCsSTwZ9Ty', '2017-10-12 23:28:06', NULL, NULL, 'a:0:{}'),
(23, 'isaji@tohoku-mpu.ac.jp', 'isaji@tohoku-mpu.ac.jp', 'isaji@tohoku-mpu.ac.jp', 'isaji@tohoku-mpu.ac.jp', 1, NULL, '$2y$13$9KNR1azTj0R9P8QC9MKslOpsvTPEpUGhy3EcAFcW1cLNAquoDs7IC', '2017-08-20 20:12:57', NULL, NULL, 'a:0:{}'),
(24, 'ken_smith', 'ken_smith', '798160187@qq.com', '798160187@qq.com', 1, NULL, '$2y$13$3oVvnjE6Jmb21BHu8oMoneFmtFHf18bUL0.mFbMppPKGBZ8bYjDHa', '2017-08-20 22:31:26', NULL, NULL, 'a:0:{}'),
(25, 'Yicinen', 'yicinen', 'yicinen@163.com', 'yicinen@163.com', 1, NULL, '$2y$13$d8j27w/9lBEHGU19xaejwu0oZmMtH4daEbfEeyr5hWdiGRcG2KSG6', '2017-08-20 22:57:02', NULL, NULL, 'a:0:{}'),
(26, 'Ian_Gentle', 'ian_gentle', 'ian.gentle@uniklinik-freiburg.de', 'ian.gentle@uniklinik-freiburg.de', 1, NULL, '$2y$13$pAD8FUGqfSpKhHc.OSIW8eqz/ne5T9rXxq5cbPxiS2Jo1lfB.mpju', '2017-08-21 00:13:31', NULL, NULL, 'a:0:{}'),
(27, 'Stéphanie Baulac', 'stéphanie baulac', 'stephanie.baulac@upmc.fr', 'stephanie.baulac@upmc.fr', 1, NULL, '$2y$13$2fUn6OQsGAbNMXrUDcb.uOHDqIQRPxAIh58/kEufQXXdgn59rCroy', '2017-08-21 01:00:21', NULL, NULL, 'a:0:{}'),
(28, 'Kiwon Jang', 'kiwon jang', 'kjang@kaist.ac.kr', 'kjang@kaist.ac.kr', 1, NULL, '$2y$13$jUj8p5x2ZWmQxSvjOR.HYeypojRxcIBQ6HhmBMwGVSC0gQDfy/DUu', '2017-08-21 20:57:11', NULL, NULL, 'a:0:{}'),
(29, 'Midori Iida', 'midori iida', 'greenwhale1110@gmail.com', 'greenwhale1110@gmail.com', 1, NULL, '$2y$13$hNd1cp1kAROHSN6JegCSvuX8JJgUTjhk1KLp2QBOo6WWvA8fEzm/K', '2017-08-21 21:03:24', NULL, NULL, 'a:0:{}'),
(30, 'lucabrand@gmail.com', 'lucabrand@gmail.com', 'lucabrand@gmail.com', 'lucabrand@gmail.com', 1, NULL, '$2y$13$err.gGSypIPjNgyDZrV7beILDtYCV.yw1EVyttRqb5yGohFbSvCaa', '2017-08-24 12:50:17', NULL, NULL, 'a:0:{}'),
(31, 'Thomas230577', 'thomas230577', 'tbdpictureresearch@gmail.com', 'tbdpictureresearch@gmail.com', 1, NULL, '$2y$13$LT.HKpOZCICI2ZYM9LEQI..QyRX.MjqXmrw2e1aOjo8HSWA50YV8u', '2017-08-25 08:04:54', NULL, NULL, 'a:0:{}'),
(32, 'thl27', 'thl27', 'thl27@pitt.edu', 'thl27@pitt.edu', 1, NULL, '$2y$13$Ggf0mKXTyRMEEMkwmUUsSeoBzN/YoRIEAQ88f/eFO.MEQ0BJoq1kq', '2017-09-01 14:30:03', NULL, NULL, 'a:0:{}'),
(33, 'khalique', 'khalique', 'knewaz@nd.edu', 'knewaz@nd.edu', 1, NULL, '$2y$13$9bxAq.9atLhnwoNLhcInzujrgWJvXPbj13.ixNY8SZ1teyw76Q6HC', '2017-09-06 09:12:44', NULL, NULL, 'a:0:{}'),
(34, 'fbai', 'fbai', 'fbai@rice.edu', 'fbai@rice.edu', 1, NULL, '$2y$13$oD0BVQHBRyAailzTAHDUiuKx5ciTmc0muqQoljJ8tK6r2r.e5AW16', '2017-09-06 09:42:05', NULL, NULL, 'a:0:{}'),
(35, 'ttriche', 'ttriche', 'tim.triche@gmail.com', 'tim.triche@gmail.com', 1, NULL, '$2y$13$MpGiK78JniIFgfEoK4xR.OsrEj7PRCfLjULrguB2BHA8uNjlS/8qG', '2017-09-06 09:42:18', NULL, NULL, 'a:0:{}'),
(36, 'pampas', 'pampas', 'paz008@ucsd.edu', 'paz008@ucsd.edu', 1, NULL, '$2y$13$x8lYdH1nEzVPQ5Ue0gH1aeVQyrTnoJdAQ.CyKR7Hp7TWFPesebrPa', '2017-09-06 18:36:43', NULL, NULL, 'a:0:{}'),
(37, 'cziegler', 'cziegler', 'cziegler@mit.edu', 'cziegler@mit.edu', 1, NULL, '$2y$13$jfRpZgd1C5LIz.zekRn9h.pB9bpndYiPnj309QrcD/PW4dXA47aii', '2017-09-08 10:51:10', NULL, NULL, 'a:0:{}'),
(38, 'kent805xsj', 'kent805xsj', 'xiaoshengjun@glmc.edu.cn', 'xiaoshengjun@glmc.edu.cn', 1, NULL, '$2y$13$IUv8TMv9BX9SyddaI7pLveaKRgPDwrQZqHc3XsNVAYSnV6umHZlCq', '2017-09-08 22:34:10', NULL, NULL, 'a:0:{}'),
(39, 'gbal', 'gbal', 'guerkan.bal@charite.de', 'guerkan.bal@charite.de', 1, NULL, '$2y$13$p7qCEp1zqEQjDk/79smYPuMVnCrAVE0fvzLq0H3M/rCniwWU17mT2', '2017-09-10 15:06:22', NULL, NULL, 'a:0:{}'),
(40, 'kkundu', 'kkundu', 'kkundu@umd.edu', 'kkundu@umd.edu', 1, NULL, '$2y$13$WhzlviVbHldrDG6YShC66uPTZKKY6SvbpqNhUPEk47BM38MdyFoPG', '2017-09-10 20:44:23', NULL, NULL, 'a:0:{}'),
(41, 'laijianbin', 'laijianbin', '20141062@m.scnu.edu.cn', '20141062@m.scnu.edu.cn', 1, NULL, '$2y$13$k5lm7C44EGklKUgTqzpZ/OsTcmAfS/IET9Khl8M3pKbkk12/Hxfc2', '2017-09-12 07:50:35', NULL, NULL, 'a:0:{}'),
(42, 'sathya', 'sathya', 'sathyabaarathi@gmail.com', 'sathyabaarathi@gmail.com', 1, NULL, '$2y$13$.SaQJvLQMF3HPeB.UtCsQOlpsAcW.g3DcyV7mWaToUBkac2Bo8/Ky', '2017-09-13 01:31:46', NULL, NULL, 'a:0:{}'),
(43, 'hsooi', 'hsooi', 'hsooi@biomed.au.dk', 'hsooi@biomed.au.dk', 1, NULL, '$2y$13$5L26w6u.JS5crysNS47rB.Az8jeidJlWxTGTTOGxctJgYzWH3xL5q', '2017-11-26 22:41:11', NULL, NULL, 'a:0:{}'),
(44, 'muharif', 'muharif', 'muhammad.arif@scilifelab.se', 'muhammad.arif@scilifelab.se', 1, NULL, '$2y$13$yyqC0YYGJXTU6ISCFHy4BeUt11k4kCGVoAeH9owGa3SK758T0gGiS', '2017-12-06 05:17:55', NULL, NULL, 'a:0:{}'),
(45, 'dforster', 'dforster', 'duncan.forster@mail.utoronto.ca', 'duncan.forster@mail.utoronto.ca', 1, NULL, '$2y$13$nN30KDmBtY5oOOZLwbE8V.LmPG1VlfLCjYgBqckwf7.ofze9bbO56', '2017-09-20 12:40:15', NULL, NULL, 'a:0:{}'),
(46, 'il1001', 'il1001', 'insuklee@yonsei.ac.kr', 'insuklee@yonsei.ac.kr', 1, NULL, '$2y$13$oPwVfhYpsUL/IyyOiDEcnOAdc8J4SDhZ39dLIxv6UQxS7pjz5r5ve', '2017-09-16 00:36:40', NULL, NULL, 'a:0:{}'),
(47, 'Abdulghani', 'abdulghani', 'akhilan@hbku.edu.qa', 'akhilan@hbku.edu.qa', 1, NULL, '$2y$13$2DNkx7Fn7UUb0iumKAQIxOax2vp4TQvySwEbn6esL1vI9izvrPy8K', '2017-09-16 23:15:04', NULL, NULL, 'a:0:{}'),
(48, 'emosca', 'emosca', 'ettore.mosca@itb.cnr.it', 'ettore.mosca@itb.cnr.it', 1, NULL, '$2y$13$pge/c87Ll75CoO3KXIVRPOLgdDMgXdeQPrs3gKp3XmXs33hcK1EAu', '2017-09-18 01:58:34', NULL, NULL, 'a:0:{}'),
(49, 'lizhuang', 'lizhuang', '373594849@qq.com', '373594849@qq.com', 1, NULL, '$2y$13$utvKdmGYFwa9Vt6CypOfoeH0xoFyFuhGFTyh7K.lTo8QmxUfUEsC6', '2017-09-18 05:45:34', NULL, NULL, 'a:0:{}'),
(50, 'cmoore02', 'cmoore02', 'claire.moore@tufts.edu', 'claire.moore@tufts.edu', 1, NULL, '$2y$13$0tHH3f0wxQOj3R25PVtyNOKs/m7jX/P4tqgyjqfRPMSkPtNmf4dCi', '2017-09-18 12:56:17', NULL, NULL, 'a:0:{}'),
(51, 'jmpf', 'jmpf', 'jmpf@uniovi.es', 'jmpf@uniovi.es', 1, NULL, '$2y$13$qIgXjoPE/mnqdkEqiBdj/OdztqCnwj9LOY9iGh4xfKc/FOqZ5gGp2', '2017-09-19 00:54:33', NULL, NULL, 'a:0:{}'),
(52, 'thomsocs', 'thomsocs', 'craig.thomson@cchmc.org', 'craig.thomson@cchmc.org', 1, NULL, '$2y$13$fDNbQrmJL5FlPKxV/PEIZOolxRuZcYqNc6XaFJe5YHdcV9R75J4Em', '2017-09-20 09:58:52', NULL, NULL, 'a:0:{}'),
(53, 'vlad0922', 'vlad0922', 'myrov_vl@aptu.ru', 'myrov_vl@aptu.ru', 1, NULL, '$2y$13$o0XsBhnjMLmq0ICDe/Kug.zyyw.RynWZ1F5CSSsdJGdZhbu9lB.gS', '2017-09-22 22:25:10', NULL, NULL, 'a:0:{}'),
(54, 'drsmith1', 'drsmith1', 'drclsmith@comcast.net', 'drclsmith@comcast.net', 1, NULL, '$2y$13$SsOM/aNL0YrioYciyVlVrOfWoCewjl2tsewPVjD.mGmfZkKh3wCRG', '2017-09-25 10:40:14', NULL, NULL, 'a:0:{}'),
(55, 'Eugenia', 'eugenia', 'ievgeniia.oshurko@ens-lyon.fr', 'ievgeniia.oshurko@ens-lyon.fr', 1, NULL, '$2y$13$bv6Wb6j4eGTMuAPlguz3tO7DB7cUD0FeCZ35T3NLbg4B5YIAHPL5a', '2017-09-26 03:32:38', NULL, NULL, 'a:0:{}'),
(56, 'tonngo', 'tonngo', 'tongo@ucsd.edu', 'tongo@ucsd.edu', 1, NULL, '$2y$13$tYDfy06zCmw3Bi5.57QaMuBRGNgy36VoDbneerYbKUREgSAG7j61a', '2017-09-27 13:46:43', NULL, NULL, 'a:0:{}'),
(57, 'chenjiwang', 'chenjiwang', 'chenjiwang@fudan.edu.cn', 'chenjiwang@fudan.edu.cn', 1, NULL, '$2y$13$3dK4HpU5Rnq5FhfJd6Dtq.V7FviimbcMs8Yqpx8mUj827E9f185e6', '2017-09-27 16:33:44', NULL, NULL, 'a:0:{}'),
(58, 'mirauta', 'mirauta', 'mirauta@ebi.ac.ukl', 'mirauta@ebi.ac.ukl', 1, NULL, '$2y$13$.qT4yg49pC/iryyT1J5lleFjY7kY6ipkhLDwnH/X9iUL9odDP7DB.', '2017-09-28 03:30:36', NULL, NULL, 'a:0:{}'),
(59, 'italodovalle', 'italodovalle', 'italodovalle@gmail.com', 'italodovalle@gmail.com', 1, NULL, '$2y$13$VqHTZyR4R8avSkUmJt1iGOUTJq4riYky3Kk4ML4LQDO7jz7qPhxky', '2017-09-29 05:53:31', NULL, NULL, 'a:0:{}'),
(60, 'daforerog', 'daforerog', 'diego.forero@uan.edu.co', 'diego.forero@uan.edu.co', 1, NULL, '$2y$13$YY2N2rZo7zQy2DMBZsFeCOQQ1aLupdThF5GL8RpeaLnljaZ92B/P.', '2017-09-29 11:48:03', NULL, NULL, 'a:0:{}'),
(61, 'zhenyang', 'zhenyang', 'concer.guo@gmail.com', 'concer.guo@gmail.com', 1, NULL, '$2y$13$ivNElqLaAhvz4q2Bc9OIs.ycSo46/Sb5RIS16diCk/xgt7zFRK1Tu', '2018-01-05 11:18:16', NULL, NULL, 'a:0:{}'),
(62, 'xuwenwang86', 'xuwenwang86', 'xuwenwang86@gmail.com', 'xuwenwang86@gmail.com', 1, NULL, '$2y$13$j8wf0QEbLe5vV9WtsMLp4OBj3cUBN/h6vT1n5i4anndpCnInWyZZC', '2018-01-13 20:24:26', NULL, NULL, 'a:0:{}'),
(63, 'jreiter', 'jreiter', 'jeremy_reiter@hotmail.com', 'jeremy_reiter@hotmail.com', 1, NULL, '$2y$13$QslqMOQ7XR5gdXlO9fmzSOb4qPodiV0kVtoR0bDlqpRDcmx6js00.', '2017-10-03 19:49:53', NULL, NULL, 'a:0:{}'),
(64, 'schneider', 'schneider', 'M.D.SCHNEIDER@IMPERIAL.AC.UK', 'm.d.schneider@imperial.ac.uk', 1, NULL, '$2y$13$qvY.GUzt8bodUKZVNmizte9vJPrFFFQ575F3xuV.YMEciVA9AyurO', '2017-10-04 04:26:02', NULL, NULL, 'a:0:{}'),
(65, 'janetharwood', 'janetharwood', 'Harwodjc@cardiff.ac.uk', 'harwodjc@cardiff.ac.uk', 1, NULL, '$2y$13$h.1HiGqbYcKd4eSb2P9GSOA7zQRb2NVFS7UZryiUb9QRfVdKXUnYC', '2017-10-25 22:37:38', NULL, NULL, 'a:0:{}'),
(66, 'zhanghongsheng-2009', 'zhanghongsheng-2009', 'zhanghongsheng2009@gmail.com', 'zhanghongsheng2009@gmail.com', 1, NULL, '$2y$13$AXqGRnCkec4RARMETZYfFebaGRJh4botbRVZCVAu5CXHq9hXxkRx2', '2017-10-06 15:42:43', NULL, NULL, 'a:0:{}'),
(67, 'biodan25', 'biodan25', 'danieljchin@yahoo.com', 'danieljchin@yahoo.com', 1, NULL, '$2y$13$Bgf0Xn7hUNdOUqUFklc5euByG/hLpv9OCdCmfV/Pbpd5d2J/SmulO', '2017-10-07 14:05:47', NULL, NULL, 'a:0:{}'),
(68, 'vyao', 'vyao', 'vyao@princeton.edu', 'vyao@princeton.edu', 1, NULL, '$2y$13$YdbUn8KqFUaGQTkSAqUb0OgVxGyPJjhGuCXV/GU2.D4E9Tqj6vkyi', '2017-10-09 04:35:09', NULL, NULL, 'a:0:{}'),
(69, 'dongda', 'dongda', '853781787@qq.com', '853781787@qq.com', 1, NULL, '$2y$13$x6pJwGpLy.srt3/BE.Mr4eeF96moHHVBuZswLBczaPEqU20tdv5jO', '2017-10-10 16:43:59', NULL, NULL, 'a:0:{}'),
(70, '1049523801', '1049523801', '1049523801@qq.com', '1049523801@qq.com', 1, NULL, '$2y$13$LuqtG6N7.jV4j6Hf2.URz.v.sI6e.E8H1lZ0f4Z0nB8YX63AExfS2', '2017-10-11 04:59:04', NULL, NULL, 'a:0:{}'),
(71, 'boutrys', 'boutrys', 'simon.boutry@student.uclouvain.be', 'simon.boutry@student.uclouvain.be', 1, NULL, '$2y$13$0/1dl.EWJ.R8HAdfLXz5iuOIvzG3ShyKWEpSSgJGaRNwNnnqTpXHW', '2017-10-12 03:22:43', NULL, NULL, 'a:0:{}'),
(72, 'luck', 'luck', 'katja_luck@dfci.harvard.edu', 'katja_luck@dfci.harvard.edu', 1, NULL, '$2y$13$KntqdjFPThuz4bU0vXq2au0Geh4MLrnjPQWmnkfZ13HFIv6mQ5O4a', '2018-01-20 23:26:46', 'Rc9n0RFlygqwve33DcDZSsSa5eQMI7CxhMKhnD1Jz8g', '2018-01-20 23:18:38', 'a:0:{}'),
(73, 'hym121745032', 'hym121745032', 'yh2989@cumc.columbia.edu', 'yh2989@cumc.columbia.edu', 1, NULL, '$2y$13$pR3Qzhtkb2CoSd/gEXOuHuc5Tv0MBoK6ji5UQezNSrFAxBE3/LEVC', '2017-10-15 12:55:34', NULL, NULL, 'a:0:{}'),
(74, 'sainitin', 'sainitin', 'sainitin.donakonda@tum.de', 'sainitin.donakonda@tum.de', 1, NULL, '$2y$13$DsSaVBnZORYQKr14MjFw/eEQ6fo4b8qsLMMisXCP5g1UpAb0WneX6', '2017-10-18 22:55:12', NULL, NULL, 'a:0:{}'),
(75, 'fjcamlab', 'fjcamlab', 'fjcamlab@gmail.com', 'fjcamlab@gmail.com', 1, NULL, '$2y$13$Nd80qyxuHTyK.mN0nQs7BO/1z.381UwYFH/ses54H2d.NbPa245hq', '2017-10-20 06:06:17', NULL, NULL, 'a:0:{}'),
(76, 'genelab', 'genelab', 'genelab@163.com', 'genelab@163.com', 1, NULL, '$2y$13$bBC.wmjLs.hluTj9Hig90.vy/9ANMyNDbpS1zvkZEfuf7Qdrvq2de', '2017-10-22 10:51:23', NULL, NULL, 'a:0:{}'),
(77, 'dvaldembri', 'dvaldembri', 'donatella.valdembri@ircc.it', 'donatella.valdembri@ircc.it', 1, NULL, '$2y$13$uTKq7gymq72Vnpa9bLnVPurfpoM5IlPNzLRfvrwYte4gaJUFhHjCO', '2017-10-23 03:00:00', NULL, NULL, 'a:0:{}'),
(78, 'xthuang226', 'xthuang226', 'xthuang@xidian.edu.cn', 'xthuang@xidian.edu.cn', 1, NULL, '$2y$13$vJNXbDBClIVE20u..W0nIOtm4MtwxHEjCqGYoggS5H/ptULYoa8wy', '2017-10-26 17:28:37', NULL, NULL, 'a:0:{}'),
(79, 'Arsalech', 'arsalech', 'ar.salehichaleshtori@modares.ac.ir', 'ar.salehichaleshtori@modares.ac.ir', 1, NULL, '$2y$13$nZZ4gaxcCU9zQKFH4mWSWuQdhcSxQ..qjCpSXcAZAGAIyUl/7rmGe', '2017-10-26 20:54:50', NULL, NULL, 'a:0:{}'),
(80, 'VityaVardanyan', 'vityavardanyan', 'v_vardanyan@mb.sci.am', 'v_vardanyan@mb.sci.am', 1, NULL, '$2y$13$.o1C7X/7k7Un1i4vT.TCq.VuorTTxJtxD0kMFPNsEXcWnDZOP9xVi', '2017-11-10 10:58:36', NULL, NULL, 'a:0:{}'),
(81, 'stephanie.florio', 'stephanie.florio', 'stephanie.florio@anagin.com', 'stephanie.florio@anagin.com', 1, NULL, '$2y$13$J2ZbOg1s56M4q/.wmesChOSVMR.fnh1uJ6ajDnHoj961b/f3kmXeO', '2017-10-31 13:51:56', NULL, NULL, 'a:0:{}'),
(82, 'ssybbc', 'ssybbc', 'susy@email.unc.edu', 'susy@email.unc.edu', 1, NULL, '$2y$13$pyqk0xM3JR6wI0PF4Vi45eA4nqeEDpmA19ARCucHg9oZfdOWoOdy.', '2017-11-01 01:03:15', NULL, NULL, 'a:0:{}'),
(83, 'wuxm', 'wuxm', 'wuxm@hznu.edu.cn', 'wuxm@hznu.edu.cn', 1, NULL, '$2y$13$tvxxRwM0Vi1jHwwcsXUNdeUc7UyBxQe0Nx37SKbWmgoNnuoAmjshm', '2017-11-02 02:22:55', NULL, NULL, 'a:0:{}'),
(84, 'sonoampong', 'sonoampong', 'sonoampong@gmail.com', 'sonoampong@gmail.com', 1, NULL, '$2y$13$LOPRqb0w2fBxlYknZmSBsOnXR.lXht3YCnVkCV2mo4pcazSawgLPm', '2017-11-06 09:09:17', NULL, NULL, 'a:0:{}'),
(85, 'jeffreyiliff', 'jeffreyiliff', 'iliffj@ohsu.edu', 'iliffj@ohsu.edu', 1, NULL, '$2y$13$dpPyVBmFBB3uGhsbwCIaVeXTV.mANUgUVf1JbWUJqfpWX2HK7wvZy', '2017-11-03 09:39:32', NULL, NULL, 'a:0:{}'),
(86, 'eyalsim', 'eyalsim', 'eyalsim@post.bgu.ac.il', 'eyalsim@post.bgu.ac.il', 1, NULL, '$2y$13$dADeMWotYC7EaG4M7C27POBMYPug9Dxgz4h8g399hcTRSHUykBvgi', '2017-11-04 22:43:15', NULL, NULL, 'a:0:{}'),
(87, 'dkerseli', 'dkerseli', 'despoina.kerselidou@doct.ulg.ac.be', 'despoina.kerselidou@doct.ulg.ac.be', 1, NULL, '$2y$13$vqpUk.K9Ru/0YtZBcp4MOuj3B3bseOoPfBjpHv/JoF0M4IqprGTze', '2017-11-09 03:39:19', NULL, NULL, 'a:0:{}'),
(88, 'peter.v.nagy', 'peter.v.nagy', 'peter.v.nagy@gmail.com', 'peter.v.nagy@gmail.com', 1, NULL, '$2y$13$hig2XeRimsFpbK17P2zLeeUPOVcUCwhnkmQM1b9UniqThkpvbtngi', '2017-11-10 07:32:54', NULL, NULL, 'a:0:{}'),
(89, 'sztimi', 'sztimi', 'sz.timike89@gmail.com', 'sz.timike89@gmail.com', 1, NULL, '$2y$13$7HU.pRm7nSQVnnBT1JgiUus/YI9quNTGjY3JxI8tM212r.T.1slH.', '2017-11-13 21:52:36', NULL, NULL, 'a:0:{}'),
(90, 'tlzhang', 'tlzhang', 'tlzhang@sibs.ac.cn', 'tlzhang@sibs.ac.cn', 1, NULL, '$2y$13$BqP2.PUKcSYCsrnWwcbNLO2y5V.ve07lGHCmj89lmYSJ4ceH/6Hby', '2017-11-12 20:36:04', NULL, NULL, 'a:0:{}'),
(91, 'sergeigrigoryev', 'sergeigrigoryev', 'sag17@psu.edu', 'sag17@psu.edu', 1, NULL, '$2y$13$pCdc7Acd7ambT3c/lzvCruXZHW1x0TGfyBTaPEi76/gsRYCWk310y', '2017-11-13 09:45:58', NULL, NULL, 'a:0:{}'),
(92, 'Evangelia', 'evangelia', 'petsalaki@ebi.ac.uk', 'petsalaki@ebi.ac.uk', 1, NULL, '$2y$13$osSrzmpku60M1ZiEpAL9Xuxzurq3cdCEleCpnWdTTvvk7ieHzrnOm', '2017-11-21 08:15:47', NULL, NULL, 'a:0:{}'),
(93, 'jkrlo', 'jkrlo', 'giancarlo.simula@gmail.com', 'giancarlo.simula@gmail.com', 1, NULL, '$2y$13$umbKlUfn/uaWVC7zgyr8be5MhZmxnK3ZEIzgK1zbaRd86/vZL81iS', '2017-11-15 09:17:28', NULL, NULL, 'a:0:{}'),
(94, 'Seongyong Park', 'seongyong park', 'sypark0215@kaist.ac.kr', 'sypark0215@kaist.ac.kr', 1, NULL, '$2y$13$S/fTS3HJuEUwWJh25eoS6eWsfeawomqpHxY0ESXU3pywdKtl.N6T2', '2017-11-15 02:19:48', NULL, NULL, 'a:0:{}'),
(95, 'zhengjinfang', 'zhengjinfang', 'zhengjinfang@hust.edu.cn', 'zhengjinfang@hust.edu.cn', 1, NULL, '$2y$13$Q.VYw1lPB507ueEPUL5/COgEQoC1J7auYJfi/fm/ZVRFLZ/Ed1vzy', '2017-11-15 03:18:13', NULL, NULL, 'a:0:{}'),
(96, 'masspeana', 'masspeana', 'peana@uniss.it', 'peana@uniss.it', 1, NULL, '$2y$13$PeEdSZJxlu4iehm.9ynPOOaUq7FN1KbHWLD4JYWl5SCvh0nt8b6Jm', '2017-11-15 21:19:22', NULL, NULL, 'a:0:{}'),
(97, 'jaguirre', 'jaguirre', 'josu.aguirre@vhir.org', 'josu.aguirre@vhir.org', 1, NULL, '$2y$13$.aepSpHN6MJI9ay63nM4WuP1LkhPBcciCdH.EkRO79P74c4Bs.fiq', '2017-11-16 00:58:58', NULL, NULL, 'a:0:{}'),
(98, 'marina', 'marina', 'marina.piccirillo@icar.cnr.it', 'marina.piccirillo@icar.cnr.it', 1, NULL, '$2y$13$8NhpMjHUcWsxAB1GptTaW.avZXup.3How3YzJfmC78b8X.PbSM6Zi', '2017-11-21 04:45:40', NULL, NULL, 'a:0:{}'),
(99, 'Inês', 'inês', 'ines.filipa.fernandes@gmail.com', 'ines.filipa.fernandes@gmail.com', 1, NULL, '$2y$13$USCCpA7K/a.0U6cPzHA.B.cm2f2HyIdQrlRrIFD5q2gfRVkII4hiK', '2017-11-24 11:44:32', NULL, NULL, 'a:0:{}'),
(100, 'dhruvbhu', 'dhruvbhu', 'dhruvbhu@gmail.com', 'dhruvbhu@gmail.com', 1, NULL, '$2y$13$VkW3ZrDpmTMRS9bEfPw1jeGuejZHJ2NdahSiBnM/bYzlcN94MaA/.', '2017-11-27 02:46:50', NULL, NULL, 'a:0:{}'),
(101, 'frpinto', 'frpinto', 'frpinto@fc.ul.pt', 'frpinto@fc.ul.pt', 1, NULL, '$2y$13$LNkfCasx5UbwXsWmFic/UeK.1/4uEjVYsis81ZKsUEa8eUNY9Gh4K', '2017-11-27 05:57:19', NULL, NULL, 'a:0:{}'),
(102, 'mdurocher', 'mdurocher', 'madurocher@ucdavis.edu', 'madurocher@ucdavis.edu', 1, NULL, '$2y$13$qlIVHrJ7NmBa0nFxAL9wMO6s68PJsYuFEojNLUzOEhW9pmCyqJORG', '2017-11-29 15:44:26', NULL, NULL, 'a:0:{}'),
(103, 'JAL', 'jal', 'jalopezmartin@gmail.com', 'jalopezmartin@gmail.com', 1, NULL, '$2y$13$HQ6PPql.YwRUpne036YJ6.lwxhi/wZZm.M8zB6fhjSDHZDLnRoMfC', '2017-12-03 17:17:14', NULL, NULL, 'a:0:{}'),
(104, 'maximinio', 'maximinio', 'admin@lucamassimino.com', 'admin@lucamassimino.com', 1, NULL, '$2y$13$3.T3tKXenfC9HeggaF6jM.q1HsanaOyeF/viLmtsIXL2HlzuRb1pu', '2017-12-12 03:01:13', NULL, NULL, 'a:0:{}'),
(105, 'marinka', 'marinka', 'marinka@cs.stanford.edu', 'marinka@cs.stanford.edu', 1, NULL, '$2y$13$9A.s0k66PIrRRVFVKL9iquOP/cOzvdoddNcioHA216n8ABu5uBlbu', '2017-12-05 17:31:38', 'KXpZcNfkLFDVlPiTvlQ-y_kjlZ1BUzlVjNLM7Sy6l8k', '2017-12-05 17:29:56', 'a:0:{}'),
(106, 'Yuan', 'yuan', 'yuanshi.ys@gmail.com', 'yuanshi.ys@gmail.com', 1, NULL, '$2y$13$mrCWfdFsgpd7Q602IAonNO0s/kKZ0ATs2yd.RmA6LP9B.ZUZAoeAy', '2017-12-06 01:45:30', NULL, NULL, 'a:0:{}'),
(107, 'tapath', 'tapath', 'akashi.path@tmd.ac.jp', 'akashi.path@tmd.ac.jp', 1, NULL, '$2y$13$IMrydAszQ03Wp3qgU.vOXOQddU1Nzz0BylXhMpiGBAD2OMvSIHswS', '2017-12-06 03:19:34', NULL, NULL, 'a:0:{}'),
(108, 'hurishahin', 'hurishahin', 'ada.shahinuzzaman@mavs.uta.edu', 'ada.shahinuzzaman@mavs.uta.edu', 1, NULL, '$2y$13$5Z7aijkJAShuw7u8v7Tx9OS94pEiWz.uAvgV/YP5URMOcXu6JsPwW', '2017-12-06 12:32:59', NULL, NULL, 'a:0:{}'),
(109, 'stelzl', 'stelzl', 'ulrich.stelzl@uni-graz.at', 'ulrich.stelzl@uni-graz.at', 1, NULL, '$2y$13$HuXbMs5/6ihVXQVMjBGAaO61GadQ/rwYSqWOqz7RDK2q20yje.6P.', '2017-12-06 16:18:16', NULL, NULL, 'a:0:{}'),
(110, 'Jared', 'jared', '2638807609@qq.com', '2638807609@qq.com', 1, NULL, '$2y$13$IQ7LmQS5zp2geCVA2ZzRrO4K0jnB8IIAGi4nhDhdmow6KP45mTfRu', '2017-12-08 06:03:51', NULL, NULL, 'a:0:{}'),
(111, 'jtraynelis', 'jtraynelis', 'jtraynelis@gmail.com', 'jtraynelis@gmail.com', 1, NULL, '$2y$13$NAJrxL1EPLKwjSLLGoDl7.ceoqzxVeYnohn72nK25iKA4yPuZCYa.', '2017-12-13 10:56:33', NULL, NULL, 'a:0:{}'),
(112, 'Fridtjof', 'fridtjof', 'fridtjol@gmail.com', 'fridtjol@gmail.com', 1, NULL, '$2y$13$qRZbjyFKTTMxN1zyBCdUxeoHRZcFV1Gi/RsvOEdeJPsB1COR40bPO', '2017-12-14 00:10:24', NULL, NULL, 'a:0:{}'),
(113, 'Skarthik87', 'skarthik87', 'sekar.karthik@nccs.com.sg', 'sekar.karthik@nccs.com.sg', 1, NULL, '$2y$13$MHit54HjLOsHMvY2HoFhCOmbuaDyjlZqFL2VwqcEdG1yZVevDcmKC', '2017-12-19 22:55:46', NULL, NULL, 'a:0:{}'),
(114, 'sujan', 'sujan', 'sujan.dhar@gmail.com', 'sujan.dhar@gmail.com', 1, NULL, '$2y$13$rwuQbNfF70JVkbcnLtPNJeo2B7Vq95QDRS1jRfUkgXquNVilE.CAm', '2017-12-26 00:08:23', NULL, NULL, 'a:0:{}'),
(115, 'nhorton', 'nhorton', 'nhorton@u.arizona.edu', 'nhorton@u.arizona.edu', 1, NULL, '$2y$13$KA1e9JrA.oO3PUghllpq1ujlEzVzeuyMh3l8Ky/n6EQQtDUEF5SXK', '2017-12-26 14:45:42', NULL, NULL, 'a:0:{}'),
(116, 'rtahir', 'rtahir', 'rtahir@jhmi.edu', 'rtahir@jhmi.edu', 1, NULL, '$2y$13$8gK0..XZVFRqZGnURJToj.j7B7I1yM0c28KX2pZklV/SzAlQpnesy', '2017-12-27 12:30:52', NULL, NULL, 'a:0:{}'),
(117, 'Clarissa Ferolla', 'clarissa ferolla', 'clarissaferolla@gmail.com', 'clarissaferolla@gmail.com', 1, NULL, '$2y$13$KnurxpoevWVnPPF2SchMPOKJwVb.wVQMdoaBN96SwF8yhNqpcaEEq', '2018-01-03 08:30:20', NULL, NULL, 'a:0:{}'),
(118, 'Mike', 'mike', 'Michael_Calderwood@dfci.harvard.edu', 'michael_calderwood@dfci.harvard.edu', 1, NULL, '$2y$13$53gnI4XlWBeOt8tVZUAB3eq/3jPYjZ00REnGyzPlKroiz8LBEEbzW', '2018-01-04 06:53:55', NULL, NULL, 'a:0:{}'),
(119, 'janis_pi', 'janis_pi', 'janet.pinero@upf.edu', 'janet.pinero@upf.edu', 1, NULL, '$2y$13$5NK7fIMXTrgE2mkDcDnThe6QgjDdBq72gtGX/D1jumkI/Vb7RAfMO', '2018-01-05 00:09:23', NULL, NULL, 'a:0:{}'),
(120, 'bazhang', 'bazhang', 'Bailin.zhang@sanofi.com', 'bailin.zhang@sanofi.com', 1, NULL, '$2y$13$Y7bOZD71yOX93KnSdjj9ZeC/tZ.jX9wY4z80QFrfdbFswycHE14rG', '2018-01-08 10:14:06', NULL, NULL, 'a:0:{}'),
(121, 'MiguelGonzalez', 'miguelgonzalez', 'm.a.gonzalezlozano@vu.nl', 'm.a.gonzalezlozano@vu.nl', 1, NULL, '$2y$13$ZM24rinYHwkag0ayUf9YR.IygkRQqVghLRbZ8VBpHRmeI9PTalTBS', '2018-01-17 04:42:41', NULL, NULL, 'a:0:{}'),
(122, 'doyoungh', 'doyoungh', 'doyoungh@postech.ac.kr', 'doyoungh@postech.ac.kr', 1, NULL, '$2y$13$IwO/EasWOc0UbHCgtazq0.645Mlp7cmk12lfzEC8v4d94yoXGQxBm', '2018-01-18 21:10:50', NULL, NULL, 'a:0:{}'),
(123, 'engladrox', 'engladrox', 'maratorinko@yandex.ru', 'maratorinko@yandex.ru', 1, NULL, '$2y$13$zk3HAMy/8VC6B9Anha20nO7BZXWVbhTXiwk/tmXUh59hTy6EE5Ki6', '2018-01-23 10:02:36', NULL, NULL, 'a:0:{}'),
(124, 'linkRNA', 'linkrna', 'xaviversalles.8@gmail.com', 'xaviversalles.8@gmail.com', 1, NULL, '$2y$13$zb23tFP9f2InggHbfx2P5OsHhB1qnqDf.SK9fsQZiBfG43.j1tGPW', '2018-01-23 15:22:31', NULL, NULL, 'a:0:{}');

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
  ADD PRIMARY KEY (`annotation_id`,`interaction_id`),
  ADD KEY `IDX_66F8A123E075FC54` (`annotation_id`),
  ADD KEY `IDX_66F8A123886DEE8F` (`interaction_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10128;

--
-- AUTO_INCREMENT for table `fos_group`
--
ALTER TABLE `fos_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `identifier`
--
ALTER TABLE `identifier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36778;

--
-- AUTO_INCREMENT for table `interaction`
--
ALTER TABLE `interaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80428;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15119;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `annotation`
--
ALTER TABLE `annotation`
  ADD CONSTRAINT `FK_2E443EF28F6F87AD` FOREIGN KEY (`annotation_type`) REFERENCES `annotation_type` (`id`);

--
-- Constraints for table `annotation_interaction`
--
ALTER TABLE `annotation_interaction`
  ADD CONSTRAINT `FK_66F8A123886DEE8F` FOREIGN KEY (`interaction_id`) REFERENCES `interaction` (`id`),
  ADD CONSTRAINT `FK_66F8A123E075FC54` FOREIGN KEY (`annotation_id`) REFERENCES `annotation` (`id`);

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
  ADD CONSTRAINT `FK_D7E676B1886DEE8F` FOREIGN KEY (`interaction_id`) REFERENCES `interaction` (`id`),
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
  ADD CONSTRAINT `FK_605705B45B69774A` FOREIGN KEY (`interaction_category_id`) REFERENCES `interaction_category` (`id`),
  ADD CONSTRAINT `FK_605705B4886DEE8F` FOREIGN KEY (`interaction_id`) REFERENCES `interaction` (`id`);

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
