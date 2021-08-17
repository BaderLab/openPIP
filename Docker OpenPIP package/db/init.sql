-- MySQL dump 10.13  Distrib 8.0.25, for Win64 (x86_64)
--
-- Host: localhost    Database: huri
-- ------------------------------------------------------
-- Server version	8.0.25

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE IF NOT EXISTS huri;
USE huri;

--
-- Table structure for table `admin_settings`
--

DROP TABLE IF EXISTS `admin_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `short_title` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `version` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `home_page` text COLLATE utf8_unicode_ci,
  `about` text COLLATE utf8_unicode_ci,
  `faq` text COLLATE utf8_unicode_ci,
  `download` text COLLATE utf8_unicode_ci,
  `contact` text COLLATE utf8_unicode_ci,
  `show_downloads` tinyint(1) NOT NULL,
  `show_download_all` tinyint(1) NOT NULL,
  `footer` text COLLATE utf8_unicode_ci,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_settings`
--

LOCK TABLES `admin_settings` WRITE;
/*!40000 ALTER TABLE `admin_settings` DISABLE KEYS */;
INSERT INTO `admin_settings` VALUES (1,'HuRI: The Human Reference Protein Interactome Mapping Project','HuRI','http://openpip.baderlab.org/','3','<p style=\"text-align: center;\"><span style=\"font-family: arial, helvetica, sans-serif; font-size: 18pt; color: #2b83ba;\"><strong><span style=\"background-color: #ffffff; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Human Reference Protein Interactome Project</span></strong></span></p>\r\n<p data-pm-slice=\"1 1 []\"><span style=\"font-size: 12pt;\">One of the long-term goals at the Center for Cancer Systems Biology is to generate a first reference map of the human protein-protein interactome network. To reach this target, we are identifying <strong>binary</strong> protein-protein interactions (PPIs) by <strong>systematically</strong> interrogating all pairwise combinations of predicted human protein-coding genes using proteome-scale technologies. Our approach to map high-quality PPIs is based on using yeast two-hybrid as the primary screening method followed by validation of subsets of PPIs in multiple orthogonal assays for binary PPI detection. As of today, we have identified a total of </span><span style=\"font-size: 12pt;\"><strong>85613 PPIs</strong> involving </span><span style=\"font-size: 12pt;\"><strong>13744 proteins</strong> in systematic screens using this framework.</span></p>\r\n<p><span style=\"font-size: 12pt;\">As part of our interactome mapping effort we are also computationally and experimentally surveying collections of PPIs curated from the literature to extract PPIs with binary experimental evidences that are of comparable high quality to the PPIs identified in our systematic screening efforts. This subset of literature-curated PPIs is equally available for search and download at this web portal and currently comprises </span><span style=\"font-size: 12pt;\"><strong>14595 PPIs</strong> involving <strong>xxx proteins</strong>.</span></p>\r\n<p><span style=\"font-size: 12pt;\">All PPI datasets are described in further details&nbsp;<a href=\"../../about/\">here</a> and are freely available to the research community through the&nbsp;<a href=\"../../search\">search engine</a> or via <a href=\"../download\">download</a>. Preliminary data from ongoing projects are also described and available for search and <a href=\"../download\">download</a> (registration required).</span></p>\r\n<p dir=\"ltr\" style=\"text-align: justify;\">&nbsp;</p>','<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">At CCSB, the Human Reference Interactome Mapping Project has grown in several distinct stages primarily defined by the number of human protein-coding genes amenable to screening for which at least one&nbsp;<a href=\"http://horfdb.dfci.harvard.edu/\">Gateway-cloned Open Reading Frame</a> (ORF) was available at the time of the project. As of today, three proteome-scale human PPI datasets are available via this web portal, in addition to other PPI datasets from CCSB, which were generated to optimize our pipeline, build a framework for quality control, benchmark new Y2H assay versions, or assess network rewiring as a result of alternative splicing (see below for more details). </span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">We also make available a subset of the curated binary protein interactions from the scientific literature that is of comparable quality to interactions identified in systematic screens at CCSB. </span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">All provided PPI datasets on this web portal have been processed using a new pipeline that maps our ORF sequences and resulting PPIs to Ensembl gene, transcript and protein identifiers that are annotated by the GENCODE consortium as protein-coding. As a result of this updated mapping, previously published datasets that are provided for download on this portal vary slightly in their number of PPIs compared to the protein interaction count provided in the original paper. The original datasets can be accessed in the supplementary material of each respective publication. We highly encourage users to use the updated datasets provided on this web portal for their research. </span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">All datasets are available for download as simple tab-separated file with the interacting protein pairs being indicated as pairs of Ensembl gene IDs. All CCSB interaction data is also available for download in PSI-MI format containing detailed experimental information and isoform-specific ORF, transcript and protein identifiers for each interaction.</span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\"><span id=\"proteome\" style=\"font-size: 18pt; font-family: arial, helvetica, sans-serif; color: #2b83ba; background-color: #ffffff; font-weight: bold; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">CCSB Proteome-scale efforts</span></span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\"><span style=\"color: #3282b8;\">HI-I-05</span>: Our first iteration at mapping the human protein interactome (<a href=\"https://www.ncbi.nlm.nih.gov/pubmed/16189514\">Rual et al Nature 2005</a>) screened a space (Space I) of ~8,000 ORFs corresponding to ~7,000 genes, and identified ~2,700 high-quality binary PPIs. This search space represents ~12% of the complete search space, assuming a total of ~20,000 protein-coding genes.</span><br /><br /><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\"><span style=\"color: #3282b8;\">HI-II-14</span>: The second phase of the human interactome mapping project (<a href=\"https://www.ncbi.nlm.nih.gov/pubmed/25416956\">Rolland et al Cell 2014</a>) generated a dataset of ~14,000 binary PPIs following two screens of a matrix of ~13,000 x 13,000 proteins (Space II). This search space covers ~42% of the complete search space, a more than 3 fold increase with respect to our first attempt.</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\"><span style=\"color: #3282b8;\">HuRI</span>: In the third phase of the project (Luck et al under review, <a href=\"https://www.biorxiv.org/content/10.1101/605451v1\">BioRxiv</a>) the human ORF collection being screened has been expanded to ~17,500 unique genes (Space III) and covers ~77% of the complete search space. ~53,000 PPIs identified from screening space III nine times with three variations of the Y2H assay are provided for search and download. This dataset is also referred to as HI-III-19.</span><br /><br /><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"><span style=\"color: #3282b8;\">HI-union</span>:&nbsp;<a href=\"https://www.biorxiv.org/content/10.1101/605451v1\">HI-union</a> is an aggregate of all PPIs identified in HI-I-05, HI-II-14, HuRI, Venkatesan-09, Yu-11, Yang-16, and Test space screens-19 (see below)<span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\"> transcript and protein identifiers for each interaction.</span></span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\">&nbsp;</p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\"><span id=\"proteome\" style=\"font-size: 18pt; font-family: arial, helvetica, sans-serif; color: #2b83ba; background-color: #ffffff; font-weight: bold; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Other CCSB protein interaction mapping efforts</span></span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"><span style=\"color: #3282b8;\">Venkatesan-09</span>: </span><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">To estimate the coverage and size of the human interactome (<a href=\"https://www.ncbi.nlm.nih.gov/pubmed/19060904\">Venkatesan et al Nature Methods 2009</a>), four Y2H screens were performed on a set of ~1,800 DB-X fusion proteins (or baits, representing ~1,700 unique genes) against ~1,800 AD-Y proteins (or preys, representing ~1,800 unique genes), corresponding to ~10% of the available genes and ~1% of the full search space. This dataset contains ~200 high-quality binary PPIs.</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 14pt;\">&nbsp;</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"><span style=\"color: #3282b8;\">Yu-11</span>: </span><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">To develop a novel Stitch-seq interactome mapping protocol, a Y2H screen was carried out inside Space II (<a href=\"https://www.ncbi.nlm.nih.gov/pubmed/21516116\">Yu et al Nature Methods 2011</a>). Stitch-seq combines PCR stitching with next-generation sequencing, and increases the efficiency and cost effectiveness of Y2H screening. The resulting dataset contains ~1,200 PPIs among proteins encoded by ~1,100 human genes.</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 14pt;\">&nbsp;</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"><span style=\"color: #3282b8;\">Yang-16</span>: </span><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif;\">To assess the extent to which different protein isoforms generated by alternative splicing from the same gene perform different functions within the cell, we have successfully cloned multiple isoforms for 161 genes and screened those for PPIs against all human ORFs from space II (<a href=\"https://www.ncbi.nlm.nih.gov/pubmed/26871637\">Yang et al Cell 2016</a>). ~700 PPIs have been identified.</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 14pt;\">&nbsp;</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 12pt; font-family: arial, helvetica, sans-serif; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"><span style=\"font-size: 14pt;\"><span style=\"color: #3282b8;\">Test space screens-19</span>: </span></span><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif;\">To develop, optimize, and benchmark improvements to the mapping pipeline and variations of the Y2H assay, independent, reciprocal screens on a search space of ~1,800 x ~1,800 genes were completed, constituting ~1% of the full search space. In total, 1,159 PPIs have been identified in these screens and those have been published as part of the paper describing <a href=\"https://www.biorxiv.org/content/10.1101/605451v1\">HuRI</a>. </span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\">&nbsp;</p>\r\n<p style=\"text-align: left;\"><span style=\"font-family: arial, helvetica, sans-serif; font-size: 18pt;\"><span id=\"other-data\" style=\"font-family: arial, helvetica, sans-serif; color: #2b83ba; background-color: #ffffff; font-weight: bold; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Literature</span></span></p>\r\n<p style=\"text-align: left;\"><span style=\"font-family: arial, helvetica, sans-serif; font-size: 12pt;\"><span style=\"font-size: 14pt;\"><span style=\"color: #3282b8;\">Lit-BM</span>: Previously published work (Rolland et al Cell 2014) identified that a subset of the curated interactions from the scientific literature that have at least two pieces of experimental evidence (two different methods or two different papers) of which at least one stems from a binary protein interaction detection assay (Literature binary multiple = Lit-BM) retested at comparable rates in protein interaction detection assays compared to interactions identified in the CCSB screening efforts. Binary PPIs with only one piece of experimental evidence retested at significantly lower rate. Here, we provide an updated set of all PPIs in Lit-BM that we obtained from filtering and classifying PPIs from the&nbsp;<a href=\"https://www.ncbi.nlm.nih.gov/pubmed/23900247\">Mentha</a> resource. Details of the filtering and classification are described in the&nbsp;<a href=\"https://www.biorxiv.org/content/10.1101/605451v1\">HuRI</a> paper.</span><br /></span></p>\r\n<p style=\"text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif; font-size: 18pt;\"><span id=\"yeast\" style=\"font-family: arial, helvetica, sans-serif; color: #2b83ba; background-color: transparent; font-weight: bold; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"><span id=\"yeast\" style=\"font-family: arial, helvetica, sans-serif; color: #2b83ba; background-color: transparent; font-weight: bold; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Description of the Y2H screening pipeline</span></span></span></p>\r\n<p style=\"text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">Details on our screening, pairwise test, and validation protocols are available as part of the HuRI paper and previously published protocols (Choi et al Methods Mol Biol 2018, Dreze et al Methods Enzymol 2010). Briefly, ORFs from the hORFeome collection were transferred into DNA-binding (DB) and activation domain (AD) Y2H destination vectors (see below). The vectors were consequently used to transform yeast strains (see below). Strong DB autoactivators were removed prior to screening. Yeast strains with 1,000 different AD-ORFs were pooled and mated with a single DB-ORF yeast strain. Growing yeast colonies were picked and sequenced to identify likely interacting pairs (First Pass Pairs = FiPPs). FiPPs were consequently individually tested in quadruplicate in a Y2H pairwise test and sequence confirmed resulting in a dataset of verified PPIs. A random subset of these verified PPIs are selected and tested in orthogonal protein interaction detection assays along with sets of known PPIs (positive control) and random pairs of proteins (negative control) to test for the quality of the identified PPIs.&nbsp; If found to be of high biophysical quality, the dataset is considered as validated and as such meets our criteria for publication. Of note, validation controls for the biophysical quality of the identified interactions. Dissecting the functional relevance of a given PPI requires extensive experimental follow-up.</span></p>\r\n<p><span style=\"font-size: 18pt; font-family: arial, helvetica, sans-serif; color: #2b83ba; background-color: transparent; font-weight: bold; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Vector details</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\">&nbsp;</p>\r\n<div dir=\"ltr\" style=\"margin-left: 0pt;\">\r\n<table style=\"border: none; border-collapse: collapse;\"><colgroup><col width=\"102\" /><col width=\"102\" /><col width=\"97\" /><col width=\"207\" /><col width=\"100\" /></colgroup>\r\n<tbody>\r\n<tr style=\"height: 0px;\">\r\n<td style=\"vertical-align: top; background-color: #bfbfbf; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: #bfbfbf; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Name</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; background-color: #bfbfbf; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: #bfbfbf; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">pDEST-DB</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; background-color: #bfbfbf; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: #bfbfbf; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">pDEST-AD-</span><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: #bfbfbf; font-weight: bold; font-style: italic; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">CHY2</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; background-color: #bfbfbf; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: #bfbfbf; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">pDEST-QZ213</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; background-color: #bfbfbf; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: #bfbfbf; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">pDEST-AD-AR68</span></p>\r\n</td>\r\n</tr>\r\n<tr style=\"height: 0px;\">\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Fusion</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Gal4-DB</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">(aa 1-147)</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Gal4-AD</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">(aa 768-881)</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Gal4-AD</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">(aa 768-881)</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Gal4-AD</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">(aa 768-881)</span></p>\r\n</td>\r\n</tr>\r\n<tr style=\"height: 0px;\">\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Fusion location</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">N-term</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">N-term</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">N-term</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">C-term</span></p>\r\n</td>\r\n</tr>\r\n<tr style=\"height: 0px;\">\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Promoter</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Truncated </span><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: italic; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">ADH1</span><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> promoter (-701 to +1)</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Truncated </span><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: italic; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">ADH1</span><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> promoter (-701 to +1)</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Truncated </span><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: italic; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">ADH1</span><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> promoter (-410 to +1)</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Truncated </span><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: italic; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">ADH1 </span><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">promoter (-410 to +1)</span></p>\r\n</td>\r\n</tr>\r\n<tr style=\"height: 0px;\">\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Yeast replication ori</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">CEN</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">CEN</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">2micron</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">2micron</span></p>\r\n</td>\r\n</tr>\r\n<tr style=\"height: 0px;\">\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Linker</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">SRSNQ</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">GGSNQ</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">ICMAYPYDVPDYASLGGHMAMEAPS</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">VDGTA</span></p>\r\n</td>\r\n</tr>\r\n<tr style=\"height: 0px;\">\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Terminator</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: italic; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">ADH1</span><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> Term</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: italic; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">ADH1 </span><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Term</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: italic; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">ADH1</span><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> Term</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: italic; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">ADH1</span><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> Term</span></p>\r\n</td>\r\n</tr>\r\n<tr style=\"height: 0px;\">\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Selection marker</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">AmpR</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">AmpR</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">AmpR</span></p>\r\n</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;\"><span style=\"font-size: 10.666666666666666px; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">AmpR</span></p>\r\n</td>\r\n</tr>\r\n<tr style=\"height: 0px;\">\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">&nbsp;</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">&nbsp;</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">&nbsp;</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">&nbsp;</td>\r\n<td style=\"vertical-align: top; padding: 7px 7px 7px 7px; border: solid #000000 1px;\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</div>\r\n<p>&nbsp;</p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 18pt;\"><span style=\"font-family: arial, helvetica, sans-serif; color: #2b83ba; background-color: transparent; font-weight: bold; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Y2H assay versions</span></span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">Combinations of different yeast strains and vectors result in different Y2H assay versions as described in the table below. </span><br /><br /><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">Assay version 0 was used to generate the datasets HI-I-05 and Venkatesan-09. Assay version 1 was used to generate HI-II-14, Yu-11, Yang-16, some of the test space screens, and the screens 1-3 of HuRI. Assay version 2 was used to generate screens 4-6 and some test space screens and assay version 3 for screens 7-9 of HuRI and some test space screens.</span></p>\r\n<div dir=\"ltr\" style=\"margin-left: 0pt;\">\r\n<table class=\"MsoNormalTable\" style=\"width: 518px; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; border-collapse: collapse; height: 190px;\" border=\"0\" width=\"623\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr style=\"mso-yfti-irow: 0; mso-yfti-firstrow: yes; height: 12.1pt;\">\r\n<td style=\"border: solid black 1.0pt; mso-border-alt: solid black .75pt; background: #BFBFBF; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><strong><span style=\"font-size: 10pt; font-family: Arial, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Assay version</span></strong></p>\r\n</td>\r\n<td style=\"border: solid black 1.0pt; border-left: none; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; background: #BFBFBF; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><strong><span style=\"font-size: 10pt; font-family: Arial, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">DB vector</span></strong></p>\r\n</td>\r\n<td style=\"border: solid black 1.0pt; border-left: none; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; background: #BFBFBF; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><strong><span style=\"font-size: 10pt; font-family: Arial, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">AD vector</span></strong></p>\r\n</td>\r\n<td style=\"border: solid black 1.0pt; border-left: none; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; background: #BFBFBF; padding: .75pt .75pt .75pt .75pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><strong><span style=\"font-size: 10pt; font-family: Arial, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">DB yeast strain &nbsp;</span></strong></p>\r\n</td>\r\n<td style=\"border: solid black 1.0pt; border-left: none; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; background: #BFBFBF; padding: .75pt .75pt .75pt .75pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><strong><span style=\"font-size: 10pt; font-family: Arial, sans-serif; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">AD yeast strain</span></strong></p>\r\n</td>\r\n</tr>\r\n<tr style=\"mso-yfti-irow: 1; height: 12.9pt;\">\r\n<td style=\"border: solid black 1.0pt; border-top: none; mso-border-top-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.9pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: center; line-height: normal;\" align=\"center\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">0</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.9pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">pDEST-DB</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.9pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">pDEST-AD-<em>CHY2</em></span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: .75pt .75pt .75pt .75pt; height: 12.9pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">MaV203</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: .75pt .75pt .75pt .75pt; height: 12.9pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">MaV103</span></p>\r\n</td>\r\n</tr>\r\n<tr style=\"mso-yfti-irow: 2; height: 12.1pt;\">\r\n<td style=\"border: solid black 1.0pt; border-top: none; mso-border-top-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: center; line-height: normal;\" align=\"center\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">1</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">pDEST-DB</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">pDEST-AD-<em>CHY2</em></span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: .75pt .75pt .75pt .75pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">Y8930</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: .75pt .75pt .75pt .75pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">Y8800</span></p>\r\n</td>\r\n</tr>\r\n<tr style=\"mso-yfti-irow: 3; height: 12.1pt;\">\r\n<td style=\"border: solid black 1.0pt; border-top: none; mso-border-top-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: center; line-height: normal;\" align=\"center\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">2</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">pDEST-DB</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">pDEST-QZ213</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: .75pt .75pt .75pt .75pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">Y8930</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: .75pt .75pt .75pt .75pt; height: 12.1pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">Y8800</span></p>\r\n</td>\r\n</tr>\r\n<tr style=\"mso-yfti-irow: 4; mso-yfti-lastrow: yes; height: 12.9pt;\">\r\n<td style=\"border: solid black 1.0pt; border-top: none; mso-border-top-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.9pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: center; line-height: normal;\" align=\"center\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">3</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.9pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">pDEST-DB</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: 5.25pt 5.25pt 5.25pt 5.25pt; height: 12.9pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">pDEST-AD-AR68</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: .75pt .75pt .75pt .75pt; height: 12.9pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">Y8930</span></p>\r\n</td>\r\n<td style=\"border-top: none; border-left: none; border-bottom: solid black 1.0pt; border-right: solid black 1.0pt; mso-border-top-alt: solid black .75pt; mso-border-left-alt: solid black .75pt; mso-border-alt: solid black .75pt; padding: .75pt .75pt .75pt .75pt; height: 12.9pt;\" valign=\"top\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: normal;\"><span style=\"font-size: 10pt; font-family: Arial, sans-serif;\">Y8800</span></p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</div>\r\n<p>&nbsp;</p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 18pt;\"><span style=\"font-family: arial, helvetica, sans-serif; color: #2b83ba; background-color: transparent; font-weight: bold; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Search options</span></span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">By default the search function of the web portal will return all query proteins with their interaction partners and all interactions between these proteins that have been identified in any of the PPI datasets described above. The results can be limited to interactions between query proteins and between query proteins and their interaction partners only. For larger queries and for cases when there is no need to display the results as network, the results can be directly retreived as a data file.</span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 18pt;\"><span style=\"font-family: arial, helvetica, sans-serif; color: #2b83ba; background-color: transparent; font-weight: bold; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Filter options</span></span></p>\r\n<p><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif;\"><span style=\"color: #3282b8;\">Confidence Score</span>:</span><br /><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif;\">This score is intended to rank human binary protein-protein interactions (PPIs) identified in systematic screens at CCSB based on their biophysical quality. A random subset of PPIs (~5%) from all Y2H screens are tested in orthogonal binary PPI detection assays, such as MAPPIT and GPCA, to demonstrate the high overall quality of each screen prior to release. The confidence score can be used to further prioritize interactions for experimental follow-up wherever needed. The score is based on information from the Y2H experiments and retest rates of specific subsets of PPIs in MAPPIT and GPCA. The score is the output of a statistical model of the MAPPIT and GPCA tests, which corrects for lower retest rates as a result of differences in the experimental detectability of PPIs rather than differences in their biophysical quality (see HuRI paper on detectability of PPIs).</span><br /><br /><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif;\">Specifically, the probability of a PPI testing positive in GPCA/MAPPIT data is modeled as being composed of two components, formulated as the regularized product of two logistic functions, both with the same input features. The first component represents the probability of a pair to be a false positive, the second represents the probability to test positive for a real interaction. This second component is constrained by data from testing PPIs found in Y2H which have additional independent literature evidence. The confidence score is calculated as the first component, scaled to an estimate of the overall precision of the dataset, obtained using the procedure described in Venkatesan et al Nature Methods 2009. The six features of a PPI used are: the number of screens in which it was detected; the number of different versions of the Y2H assay in which it was detected; the strength of growth of the yeast; whether the interaction between proteins X and Y was detected with both combinations of DNA-binding domain (DB) and activation domain (AD) fusions, i.e. DB-X with AD-Y and DB-Y with AD-X; the number of interaction partners of the two proteins; and the length of the ORF.</span><br /><br /><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif;\"><span style=\"color: #3282b8;\">Interaction status</span>:</span><br /><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif;\">The results can also be restricted to either only show PPIs from CCSB or from the literature. The user can choose to display tissue expression levels and levels of tissue specific expression of nodes in the network in combination with the selection of a tissue (see below).</span><br /><br /><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif;\"><span style=\"color: #3282b8;\">Tissue expression</span>:</span><br /><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif;\">One or multiple tissues can be selected to filter the protein interaction data for proteins that are expressed in at least one of the selected tissues. Only interactions between the expressed proteins will be displayed. By default, expression abundance levels will be represented on the network by increasing the node size. Specificity of expression is indicated by varying the intensity of the color of the nodes (only applicable to cases where a single tissue has been selected). The tissue gene expression data has been extracted from the GTEx portal and has been processed and normalized as described in Paulson et al BMC Bioinformatics 2017. The preferential expression of a given gene in a given tissue was calculated as described in Sonawane et al Cell Reports 2017. More details are also provided in the HuRI paper.</span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 18pt;\"><span style=\"font-family: arial, helvetica, sans-serif; color: #2b83ba; background-color: transparent; font-weight: bold; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Export options</span></span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 12pt;\"><span style=\"font-size: 14pt;\">The network can be exported to Cytoscape by clicking the little orange network icon in the bottom left corner of the network browser, if Cytoscape is installed and running. The proteins displayed in the network can directly be exported as list into a variety of external resources to calculate functional enrichments and perform other network-related searches.</span> </span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 18pt;\"><span style=\"font-family: arial, helvetica, sans-serif; color: #2b83ba; background-color: transparent; font-weight: bold; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Save options</span></span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">The search results can be saved as image (if a network was displayed) or in various text file formats as lists of proteins and interactions. Furthermore, the web portal offers to users the possibility to create an account. If the user is logged in, an extra Save button will appear on the results page allowing the user to save the search result and the exact network representation or session that the user generated. Later, the user can select a saved network/session and reload it into the network browser for further manipulation. Of note, users need to login first prior to performing a search or the search results will be lost.</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 18pt; font-family: arial, helvetica, sans-serif; color: #2b83ba; background-color: #ffffff; font-weight: bold; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Requirements to run the HuRI portal</span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 12pt;\"><span style=\"font-size: 14pt;\">The web browser must be configured to accept cookies and JavaScript must be enabled.</span>&nbsp; </span><span style=\"color: #2b83ba;\"><br /></span></p>\r\n<p id=\"acknowledgments\" dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 18pt; font-family: Arial; color: #2b83ba; background-color: #ffffff; font-weight: bold; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Acknowledgments</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">CCSB interactome mapping and ORFeome cloning efforts are supported by federal grants from the National Human Genome Research Institute of NIH, the Ellison Foundation, the Dana-Farber Cancer Institute Strategic Initiative, the Canada Excellence Research Chairs program, and the Canadian Institutes of Health Research.</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;\">&nbsp;</p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;\">&nbsp;</p>','<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">Where does the interaction data available for search and download on this web portal come from?</span></strong></span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">The interaction data comes from two sources. The majority comes from a series of systematic screens of human open reading frame (ORF) clone collections performed in the Vidal, Tavernier and Roth labs at Dana-Farber Cancer Institute/Harvard Medical School, Vlaams Instituut voor Biotechnologie/Ghent University and University of Toronto, respectively. These interactions were found using a systematic binary mapping pipeline based upon a high-throughput yeast two-hybrid assay as the primary screen, followed by pairwise retesting in quadruplicate of all primary pairs, and subsequent validation of a random subset using two or more orthogonal assays.<br />The remainder of the data are from databases of curated interactions reported in the literature. The publicly available interaction data was filtered to identify the high-quality binary interactions as described in the</span><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\"> <a href=\"https://www.biorxiv.org/content/10.1101/605451v1\">HuRI paper</a>.<br /></span></p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">Does the interaction data originate from experiments and/or predictions?</span></strong></span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">All of the systematic data come from our systematic experimental screening pipeline and have at least one piece of supporting experimental evidence. This systematic dataset has been shown to have quality (fraction correct) that is on par with high-quality literature curated binary interactions, defined by having at least two pieces of experimental evidence from original publications, curated from the literature.</span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\"><span style=\"font-size: 14pt;\"><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\"><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">Why is the number of interactions for a given dataset different from the number reported in the original publication?</span></strong></span></span></strong></span></span></span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">We map our ORF sequences to GENCODE (v27) gene annotation models to identify the gene, transcript, and protein to which our ORF belongs to. Because the genome is highly redundant, and genome annotation is difficult, there are changes between different GENCODE versions which can result in changes in the genes and proteins to which our ORFs map best. Furthermore, we only provide interactions for ORFs that, based on the gene annotation model, map to protein coding genes. The identification of which genes encode proteins is also subject to change between different gene annotation models.</span></p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"font-size: 14pt;\"><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">I have my query genes in a different identifier format (neither gene symbols nor Uniprot IDs). What can I do to still use them as query on this web portal?</span></strong></span><em><span style=\"font-family: Helvetica, sans-serif;\"> <br /></span></em></span></p>\r\n<p><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif;\">Currently our portal can only be searched using either gene symbols or UniProt accession numbers. You can convert your list of query genes into gene symbols or UniProt IDs at these websites (<a href=\"http://www.uniprot.org/uploadlists/\">http://www.uniprot.org/uploadlists/</a>, <a href=\"https://david.ncifcrf.gov/conversion.jsp)\">https://david.ncifcrf.gov/conversion.jsp)</a>.</span></p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">Why does my search not return any PPIs?</span></strong></span></p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">We have tested the ORFs corresponding to over 17,000 human protein-coding genes using our binary interaction mapping pipeline (a full list of the genes we have tested is available at http://horfdb.dfci.harvard.edu/). However, we may not have screened your gene of interest yet because we do not currently have an ORF clone available for this gene.<br />The other possibility is that even though we have screened for PPIs with an ORF from your gene of interest, the expressed protein may not have resulted in any PPIs. While our binary interaction mapping pipeline is designed to be systematic and unbiased, there are some proteins which may prove to be refractory to the assays used. For example, (i) proteins that are secreted, are intrinsic membrane proteins or require significant post-translational modification may not form stable interactions under our assay conditions, (ii) some human proteins may be unstable or not fold correctly when expressed in yeast, (iii) some proteins may only interact as parts of large complexes and not as binary pairs, or (iv) some proteins may be incapable of interaction due, e.g., to errors or natural sequence variation in the clones, or due to the influence of the fused tags.<br /></span></p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">What would be a good confidence score cutoff to filter the interactions?</span></strong></span></p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"font-size: 14pt;\"><span style=\"font-family: arial, helvetica, sans-serif;\">All CCSB datasets have been validated of their high biophysical quality by testing random subsets of PPIs in independent assays. The confidence score is intended to further rank the identified interactions, for example in cases where too many PPIs result and only a subset of all identified interactions can be used for experimental follow-up. In that sense, a cutoff can be defined based on the number of interactions that a user wants to consider. This score quantifies only a small part of the variance in biophysical quality within the dataset and therefore should not be used to discard PPIs for quality concerns.</span></span></p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"font-size: 14pt;\"><span style=\"font-family: arial, helvetica, sans-serif;\"><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">In which format do I need to save the search results for upload into Cytoscape?</span></strong></span></span></span></p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"font-size: 14pt;\"><span style=\"font-family: arial, helvetica, sans-serif;\">To upload the search results into Cytoscape, export them as a .csv file.</span></span></p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">Why is there not a confidence score for every PPI?&nbsp;</span></strong></span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">The confidence score of a pair is calculated based on several features of how the interaction was detected during screening. This data is only available for pairs detected in the most recent screens (HuRI), and hence we are only able to calculate confidence scores for these pairs.</span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\"><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">How should I cite the interaction data and web portal?<br /></span></strong></span></span></p>\r\n<p>&nbsp;</p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">How can I get information on the clone used to identify an interaction returned from my search?</span></strong></span></p>\r\n<p class=\"MsoNormal\" style=\"text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">The clones used in our screens come from the Human ORFeome clone collection assembled at</span><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\"><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\"> <a href=\"http://horfdb.dfci.harvard.edu\">CCSB</a> and via the&nbsp;<a href=\"http://www.orfeomecollaboration.org\">ORFeome Collaboration</a></span>. Clicking the ORF identifiers will redirect the user to our ORFeome web portal where details on the cloning strategy, source material and nucleotide sequence are provided.</span></p>\r\n<p><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\"><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">How can I get detailed experimental information on an interaction of interest?</span></strong></span></span></strong></span></p>\r\n<p><span style=\"color: #000000; font-size: 14pt; font-family: arial, helvetica, sans-serif;\"><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">By clicking on the edge that represents the interaction of interest in the network visualization on the results page, the user can obtain information on the individual experiments in which that interaction was identified along with information on the corresponding ORF identities. <br /></span></span></p>\r\n<p><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">Isn\'t yeast two-hybrid data full of false positives?</span></strong></span></p>\r\n<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 14pt;\">Like any other experimental approach, the quality of the data generated is dependent on the careful design of the experiment and rigorous attention to detail in performing the experiments. We first remove all proteins which can autoactivate the yeast reporter genes (i.e., a single protein (as bait or prey in Y2) is able to induce reporter gene expression in the absence of any other partner protein). In addition, our modern binary interaction mapping pipeline contains numerous quality control measures implemented after primary screening, including pairwise verification (regenerating and retesting mated diploids from fresh glycerol stocks) and sequencing to confirm ORF identity. A random sample of verified primary yeast two-hybrid datasets are validated by testing a subset of interactions in at least two orthogonal assays that have been calibrated using positive and random reference sets. We only consider a dataset validated if the biophysical quality of the dataset is equal to, or greater than, a representative sample of interactions selected from the literature.<br />We note that this process can establish that our interactions are of high biophysical quality, meaning that the reported pair of proteins is highly likely to interact when both proteins are expressed together. The assays employed however, cannot inform on whether the identified interactions are physiologically or biologically relevant. Demonstrating such relevance for an individual PPI requires an additional battery of molecular and cellular assays, which we are unable to perform on the more than 60,000 PPIs reported. However, we show that our datasets are highly enriched in linking proteins of similar functional annotation compared to random networks and in follow-up studies we provide evidence for the functional relevance of a number&nbsp; of PPIs (see our published work). Integration of Y2H interactome data with current data on contextual gene and protein expression and protein localization data can prioritize PPIs that are more likely to be physiologically relevant in the selected cellular context. However, one should not necessarily rule out any PPI in our dataset because of lack of contextual data due to the overall incompleteness of those datasets.<br /></span></p>\r\n<p><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">How complete is your map?</span></strong></span></p>\r\n<p><span style=\"font-size: 14pt; font-family: arial, helvetica, sans-serif;\">Estimating the level of completeness of our interactome data is difficult given how little we know about the composition of the human protein interactome and methodological biases associated with all interactome mapping assays including Y2H. As described in our HuRI paper, we estimate that HuRI currently covers 2-11% of the human binary protein interactome. Part of the PPIs that we are missing are those that depend on post-translational modifications that the yeast cell does not catalyze (at least under the conditions we used). Furthermore, our estimate of interactome coverage is only valid for binary protein interactions, and therefore does not include PPIs that depend on additional interaction partners (cooperative binding) and protein interactions that represent indirect associations in protein complexes. Complementary interactome mapping efforts, e.g., affinity purification followed by mass spectrometry, that can also be implemented at human proteome scale are needed to further complement and complete the binary interaction maps we provide.</span></p>\r\n<p><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">Is your dataset depleted for protein interactions that are part of stable protein complexes?</span></strong></span></p>\r\n<p><span style=\"font-size: 14pt;\">By integrating our data with three dimensional structural information from protein complexes we observed that our interaction detection platform can detect interactions that are part of stable protein complexes across a wide range of protein complex sizes and we only observe a mild depletion for very large protein complexes (30+ subunits).</span></p>\r\n<p><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">How do the various datasets available for download relate to each other?</span></strong></span></p>\r\n<p><span style=\"font-size: 14pt;\">The full descriptions of all various datasets in the &ldquo;Dataset Downloads&rdquo; page can be found in the &ldquo;About&rdquo; page. &ldquo;HI-union&rdquo; is the union of all published datasets (i.e. HI-I-05, HI-II-14, HuRI, Venkatesan-09, Yu-11, Yang-16, and Test space screens-19) except Lit-BM. The total number of PPIs and proteins listed on the homepage is the union of all datasets, published and unpublished.</span></p>\r\n<p><span style=\"color: #4985c9; font-size: 18pt;\"><strong><span style=\"font-family: Helvetica, sans-serif;\">How was this project funded?</span></strong></span></p>\r\n<p><span style=\"font-size: 14pt;\">This work was primarily supported by a National Institutes of Health (NIH) National Human Genome Research Institute (NHGRI) grant U41HG001715 with additional support from NIH grants P50HG004233, U01HL098166, U01HG007690, R01GM109199, Canadian Institute for Health Research (CIHR) Foundation Grants, the Canada Excellence Research Chairs Program and an American Heart Association grant 15CVGPS23430000. <br />For further information, please see the acknowledgement section of the HuRI paper. <br /><br /></span></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p><span style=\"font-size: 14pt;\">&nbsp;</span></p>','<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; text-align: justify;\"><span style=\"font-size: 18pt; font-family: Arial; color: #a51c30; background-color: transparent; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"><span id=\"docs-internal-guid-9ab43ec0-21cb-0994-6eda-f937ad2e05e7\"><span style=\"background-color: transparent; vertical-align: baseline;\">Publication Moratorium</span></span></span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; text-align: justify;\">&nbsp;</p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; text-align: justify;\"><span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">All users are expected to observe the following guidelines when using preliminary, unpublished data from the CCSB Human Interactome:</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; text-align: justify;\"><span style=\"font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">&middot;</span><span style=\"font-size: 7pt; font-family: \'Times New Roman\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Registered users may download and analyze all verified or validated datasets.</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; text-align: justify;\"><span style=\"font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">&middot;</span><span style=\"font-size: 7pt; font-family: \'Times New Roman\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">There is a \"moratorium\" on dissemination of binary interaction screening data or derived results, including publication of global analysis of the data. The moratorium period for released interaction data ends 12 months after the entire verified data set obtained from one complete screen has been made publicly available or immediately upon publication of the corresponding dataset by CCSB (whichever comes first). We grant an exception to this moratorium for dissemination in the form of presentations or publications that are focused around small numbers of interactions, which we define to be either a set of up to 10 interactions, or all of the interactions involving a specific protein, whichever is less restrictive.</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; text-align: justify;\"><span style=\"font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">&middot;</span><span style=\"font-size: 7pt; font-family: \'Times New Roman\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">The moratorium on dissemination is considered to extend to all forms of public disclosure, including meeting abstracts, oral presentations, and formal electronic submissions to publicly accessible sites (e.g., public websites, web blogs).</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; text-align: justify;\"><span style=\"font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">&middot;</span><span style=\"font-size: 7pt; font-family: \'Times New Roman\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Users are expected to acknowledge the following in all oral or written presentations, disclosures, or publications of the analyses (before or after the moratorium period):</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; text-align: justify;\"><span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">&middot;</span><span style=\"font-size: 7pt; font-family: \'Times New Roman\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> &nbsp;&nbsp;</span> <span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">The Center for Cancer Systems Biology (CCSB) at the Dana-Farber Cancer Institute</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; text-align: justify;\"><span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">&middot;</span><span style=\"font-size: 7pt; font-family: \'Times New Roman\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> &nbsp;&nbsp;</span> <span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">The funding organization(s) that supported the work:</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; margin-left: 36pt; text-align: justify;\"><span style=\"font-size: 11pt; font-family: \'Courier New\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">o</span><span style=\"font-size: 7pt; font-family: \'Times New Roman\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> &nbsp;</span><span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">The National Human Genome Research Institute (NHGRI) of NIH</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; margin-left: 36pt; text-align: justify;\"><span style=\"font-size: 11pt; font-family: \'Courier New\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">o</span><span style=\"font-size: 7pt; font-family: \'Times New Roman\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> &nbsp;</span><span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">The Ellison Foundation, Boston, MA</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; margin-left: 36pt; text-align: justify;\"><span style=\"font-size: 11pt; font-family: \'Courier New\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">o</span><span style=\"font-size: 7pt; font-family: \'Times New Roman\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> &nbsp;</span><span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">The Dana-Farber Cancer Institute Strategic Initiative</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; text-align: justify;\"><span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">&middot;</span><span style=\"font-size: 7pt; font-family: \'Times New Roman\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> &nbsp;&nbsp;</span> <span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">The fact that interactions were verified but not yet validated, where that is the case.</span></p>\r\n<p>&nbsp;</p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 4pt; text-align: justify;\"><span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">&middot;</span><span style=\"font-size: 7pt; font-family: \'Times New Roman\'; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> &nbsp;&nbsp;</span> <span style=\"font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">The date on which interaction dataset was downloaded, allowing readers the opportunity to efficiently identify which interactions in preliminary datasets might have been subsequently corrected (e.g., due to subsequent failure to validate)</span></p>','<p><span style=\"font-size: 12pt;\"><span style=\"color: #333333; vertical-align: baseline; white-space: pre-wrap;\"><span style=\"color: #000000;\">Please contact</span> <a href=\"mailto:michael_calderwood@dfci.harvard.edu\">Michael Calderwood</a></span><span style=\"color: #000000; vertical-align: baseline; white-space: pre-wrap;\"> or <a href=\"mailto:tong_hao@dfci.harvard.edu\">Tong Hao</a></span><span style=\"color: #000000; vertical-align: baseline; white-space: pre-wrap;\"> with questions regarding the displayed protein interaction data and all its experimental and computational aspects.</span></span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 12pt;\"><span style=\"color: #000000; vertical-align: baseline; white-space: pre-wrap;\">Please contact <a href=\"mailto:gary.bader@utoronto.ca\">Gary Bader</a></span><span style=\"color: #000000; vertical-align: baseline; white-space: pre-wrap;\"> or </span></span><span style=\"font-size: 16px; vertical-align: baseline; white-space: pre-wrap; color: #2b83ba;\"> <a style=\"color: #2b83ba;\" href=\"mailto:miles.william.mee@gmail.com\">Miles Mee</a></span> <span style=\"white-space: pre-wrap; font-size: 12pt;\">with questions regarding this web portal.</span></p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;\">&nbsp;</p>\r\n<p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;\">You can add further fields here in settings.</p>',1,1,'<p style=\"text-align: center;\">&nbsp;</p>\r\n<p style=\"text-align: center;\"><span style=\"font-family: Arial; font-size: 14.6667px; white-space: pre-wrap;\">The HuRI project is directed from the Center for Cancer Systems Biology as a joint effort between the </span><span style=\"color: #2b83ba;\"><a style=\"font-family: Arial; font-size: 14.6667px; white-space: pre-wrap; color: #2b83ba;\" href=\"http://ccsb.dfci.harvard.edu/web/www/ccsb/\" target=\"_blank\">Vidal</a></span><span style=\"font-family: Arial; font-size: 14.6667px; white-space: pre-wrap;\">, </span><a style=\"font-family: Arial; font-size: 14.6667px; white-space: pre-wrap;\" href=\"http://llama.mshri.on.ca/\" target=\"_blank\"><span style=\"color: #2b83ba;\">Roth</span>,</a>&nbsp;<span style=\"color: #2b83ba;\"><a style=\"font-family: Arial; font-size: 14.6667px; white-space: pre-wrap; color: #2b83ba;\" href=\"http://www.vib.be/en/research/scientists/Pages/Jan-Tavernier-Lab.aspx\" target=\"_blank\">Tavernier</a></span><span style=\"font-family: Arial; font-size: 14.6667px; white-space: pre-wrap;\">, and </span><span style=\"color: #2b83ba;\"><a style=\"font-family: Arial; font-size: 14.6667px; white-space: pre-wrap; color: #2b83ba;\" href=\"http://www.baderlab.org\" target=\"_blank\">Bader</a></span><span style=\"font-family: Arial; font-size: 14.6667px; white-space: pre-wrap;\"> labs.</span></p>','#980000','#ffffff','#ffffff','#0c343d','BAD\\nBAK1\\nMCL1\\nBCL2L1\\nBCL2L2\\nBCL2A1\\nBMF\\nBIK\\nREL','BAD\\nBAK1\\nMCL1\\nBCL2L1\\nBCL2L2\\nBCL2A1\\nBMF\\nBIK\\nREL','BAD\\nBAK1\\nMCL1\\nBCL2L1\\nBCL2L2\\nBCL2A1','#cc0000','#3c78d8','#6aa84f','#e69138','#a61c00','#9955ffff');
/*!40000 ALTER TABLE `admin_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `annotation`
--

DROP TABLE IF EXISTS `annotation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `annotation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `annotation_type` int DEFAULT NULL,
  `identifier` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `annotation` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2E443EF28F6F87AD` (`annotation_type`),
  CONSTRAINT `FK_2E443EF28F6F87AD` FOREIGN KEY (`annotation_type`) REFERENCES `annotation_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `annotation`
--

LOCK TABLES `annotation` WRITE;
/*!40000 ALTER TABLE `annotation` DISABLE KEYS */;
/*!40000 ALTER TABLE `annotation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `annotation_interaction`
--

DROP TABLE IF EXISTS `annotation_interaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `annotation_interaction` (
  `annotation_id` int NOT NULL,
  `interaction_id` int NOT NULL,
  PRIMARY KEY (`annotation_id`,`interaction_id`),
  KEY `IDX_66F8A123E075FC54` (`annotation_id`),
  KEY `IDX_66F8A123886DEE8F` (`interaction_id`),
  CONSTRAINT `FK_66F8A123886DEE8F` FOREIGN KEY (`interaction_id`) REFERENCES `interaction` (`id`),
  CONSTRAINT `FK_66F8A123E075FC54` FOREIGN KEY (`annotation_id`) REFERENCES `annotation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `annotation_interaction`
--

LOCK TABLES `annotation_interaction` WRITE;
/*!40000 ALTER TABLE `annotation_interaction` DISABLE KEYS */;
/*!40000 ALTER TABLE `annotation_interaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `annotation_protein`
--

DROP TABLE IF EXISTS `annotation_protein`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `annotation_protein` (
  `annotation_id` int NOT NULL,
  `protein_id` int NOT NULL,
  PRIMARY KEY (`annotation_id`,`protein_id`),
  KEY `IDX_439A14E8E075FC54` (`annotation_id`),
  KEY `IDX_439A14E854985755` (`protein_id`),
  CONSTRAINT `FK_439A14E854985755` FOREIGN KEY (`protein_id`) REFERENCES `protein` (`id`),
  CONSTRAINT `FK_439A14E8E075FC54` FOREIGN KEY (`annotation_id`) REFERENCES `annotation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `annotation_protein`
--

LOCK TABLES `annotation_protein` WRITE;
/*!40000 ALTER TABLE `annotation_protein` DISABLE KEYS */;
/*!40000 ALTER TABLE `annotation_protein` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `annotation_type`
--

DROP TABLE IF EXISTS `annotation_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `annotation_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `show_in_table` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `show_in_filter` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `filter` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fields` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `boolean` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `filter_name` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `annotation_type`
--

LOCK TABLES `annotation_type` WRITE;
/*!40000 ALTER TABLE `annotation_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `annotation_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `announcement`
--

DROP TABLE IF EXISTS `announcement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `announcement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `text` varchar(4000) COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `show` tinyint(1) NOT NULL,
  `show_on_home_page` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcement`
--

LOCK TABLES `announcement` WRITE;
/*!40000 ALTER TABLE `announcement` DISABLE KEYS */;
/*!40000 ALTER TABLE `announcement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `complex`
--

DROP TABLE IF EXISTS `complex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `complex` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `complex`
--

LOCK TABLES `complex` WRITE;
/*!40000 ALTER TABLE `complex` DISABLE KEYS */;
/*!40000 ALTER TABLE `complex` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `complex_protein`
--

DROP TABLE IF EXISTS `complex_protein`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `complex_protein` (
  `complex_id` int NOT NULL,
  `protein_id` int NOT NULL,
  PRIMARY KEY (`complex_id`,`protein_id`),
  KEY `IDX_9CA559D6E4695F7C` (`complex_id`),
  KEY `IDX_9CA559D654985755` (`protein_id`),
  CONSTRAINT `FK_9CA559D654985755` FOREIGN KEY (`protein_id`) REFERENCES `protein` (`id`),
  CONSTRAINT `FK_9CA559D6E4695F7C` FOREIGN KEY (`complex_id`) REFERENCES `complex` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `complex_protein`
--

LOCK TABLES `complex_protein` WRITE;
/*!40000 ALTER TABLE `complex_protein` DISABLE KEYS */;
/*!40000 ALTER TABLE `complex_protein` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_file`
--

DROP TABLE IF EXISTS `data_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `data_file` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dataset_id` int DEFAULT NULL,
  `name` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `method` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_type` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_37D0FDF2D47C2D1B` (`dataset_id`),
  CONSTRAINT `FK_37D0FDF2D47C2D1B` FOREIGN KEY (`dataset_id`) REFERENCES `dataset` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_file`
--

LOCK TABLES `data_file` WRITE;
/*!40000 ALTER TABLE `data_file` DISABLE KEYS */;
/*!40000 ALTER TABLE `data_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dataset`
--

DROP TABLE IF EXISTS `dataset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dataset` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pubmed_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `author` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `year` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `interaction_status` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number_of_interactions` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_path` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dataset`
--

LOCK TABLES `dataset` WRITE;
/*!40000 ALTER TABLE `dataset` DISABLE KEYS */;
/*!40000 ALTER TABLE `dataset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dataset_request`
--

DROP TABLE IF EXISTS `dataset_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dataset_request` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `md5` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `request` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dataset_request`
--

LOCK TABLES `dataset_request` WRITE;
/*!40000 ALTER TABLE `dataset_request` DISABLE KEYS */;
/*!40000 ALTER TABLE `dataset_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dataset_request_dataset`
--

DROP TABLE IF EXISTS `dataset_request_dataset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dataset_request_dataset` (
  `dataset_id` int NOT NULL,
  `dataset_request_id` int NOT NULL,
  PRIMARY KEY (`dataset_id`,`dataset_request_id`),
  KEY `IDX_938C0834D47C2D1B` (`dataset_id`),
  KEY `IDX_938C0834678591AA` (`dataset_request_id`),
  CONSTRAINT `FK_938C0834678591AA` FOREIGN KEY (`dataset_request_id`) REFERENCES `dataset_request` (`id`),
  CONSTRAINT `FK_938C0834D47C2D1B` FOREIGN KEY (`dataset_id`) REFERENCES `dataset` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dataset_request_dataset`
--

LOCK TABLES `dataset_request_dataset` WRITE;
/*!40000 ALTER TABLE `dataset_request_dataset` DISABLE KEYS */;
/*!40000 ALTER TABLE `dataset_request_dataset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `domain`
--

DROP TABLE IF EXISTS `domain`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `domain` (
  `id` int NOT NULL AUTO_INCREMENT,
  `protein_id` int DEFAULT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_position` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `end_position` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sequence` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A7A91E0B54985755` (`protein_id`),
  CONSTRAINT `FK_A7A91E0B54985755` FOREIGN KEY (`protein_id`) REFERENCES `protein` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `domain`
--

LOCK TABLES `domain` WRITE;
/*!40000 ALTER TABLE `domain` DISABLE KEYS */;
/*!40000 ALTER TABLE `domain` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `domain_organism`
--

DROP TABLE IF EXISTS `domain_organism`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `domain_organism` (
  `organism_id` int NOT NULL,
  `domain_id` int NOT NULL,
  PRIMARY KEY (`organism_id`,`domain_id`),
  KEY `IDX_1EDDC56364180A36` (`organism_id`),
  KEY `IDX_1EDDC563115F0EE5` (`domain_id`),
  CONSTRAINT `FK_1EDDC563115F0EE5` FOREIGN KEY (`domain_id`) REFERENCES `domain` (`id`),
  CONSTRAINT `FK_1EDDC56364180A36` FOREIGN KEY (`organism_id`) REFERENCES `organism` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `domain_organism`
--

LOCK TABLES `domain_organism` WRITE;
/*!40000 ALTER TABLE `domain_organism` DISABLE KEYS */;
/*!40000 ALTER TABLE `domain_organism` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `external_link`
--

DROP TABLE IF EXISTS `external_link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `external_link` (
  `id` int NOT NULL AUTO_INCREMENT,
  `protein_id` int DEFAULT NULL,
  `database_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A3B3F9DD54985755` (`protein_id`),
  CONSTRAINT `FK_A3B3F9DD54985755` FOREIGN KEY (`protein_id`) REFERENCES `protein` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `external_link`
--

LOCK TABLES `external_link` WRITE;
/*!40000 ALTER TABLE `external_link` DISABLE KEYS */;
/*!40000 ALTER TABLE `external_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fos_group`
--

DROP TABLE IF EXISTS `fos_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fos_group` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_4B019DDB5E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fos_group`
--

LOCK TABLES `fos_group` WRITE;
/*!40000 ALTER TABLE `fos_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `fos_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fos_user_user_group`
--

DROP TABLE IF EXISTS `fos_user_user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fos_user_user_group` (
  `user_id` int NOT NULL,
  `group_id` int NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`),
  KEY `IDX_B3C77447A76ED395` (`user_id`),
  KEY `IDX_B3C77447FE54D947` (`group_id`),
  CONSTRAINT `FK_B3C77447A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_B3C77447FE54D947` FOREIGN KEY (`group_id`) REFERENCES `fos_group` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fos_user_user_group`
--

LOCK TABLES `fos_user_user_group` WRITE;
/*!40000 ALTER TABLE `fos_user_user_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `fos_user_user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `identifier`
--

DROP TABLE IF EXISTS `identifier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `identifier` (
  `id` int NOT NULL AUTO_INCREMENT,
  `identifier` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `naming_convention` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `identifier`
--

LOCK TABLES `identifier` WRITE;
/*!40000 ALTER TABLE `identifier` DISABLE KEYS */;
/*!40000 ALTER TABLE `identifier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `interaction`
--

DROP TABLE IF EXISTS `interaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `interaction` (
  `id` int NOT NULL AUTO_INCREMENT,
  `score` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `binding_start` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `binding_end` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `removed` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `interactor_A` int DEFAULT NULL,
  `interactor_B` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_378DFDA76C944D70` (`interactor_A`),
  KEY `IDX_378DFDA7F59D1CCA` (`interactor_B`),
  CONSTRAINT `FK_378DFDA76C944D70` FOREIGN KEY (`interactor_A`) REFERENCES `protein` (`id`),
  CONSTRAINT `FK_378DFDA7F59D1CCA` FOREIGN KEY (`interactor_B`) REFERENCES `protein` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interaction`
--

LOCK TABLES `interaction` WRITE;
/*!40000 ALTER TABLE `interaction` DISABLE KEYS */;
/*!40000 ALTER TABLE `interaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `interaction_category`
--

DROP TABLE IF EXISTS `interaction_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `interaction_category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `admin_settings_id` int DEFAULT NULL,
  `category_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color_scheme` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `selected_by_default` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `include_in_home_page_count` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3C990E38C48ED181` (`admin_settings_id`),
  CONSTRAINT `FK_3C990E38C48ED181` FOREIGN KEY (`admin_settings_id`) REFERENCES `admin_settings` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interaction_category`
--

LOCK TABLES `interaction_category` WRITE;
/*!40000 ALTER TABLE `interaction_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `interaction_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `interaction_dataset`
--

DROP TABLE IF EXISTS `interaction_dataset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `interaction_dataset` (
  `dataset_id` int NOT NULL,
  `interaction_id` int NOT NULL,
  PRIMARY KEY (`dataset_id`,`interaction_id`),
  KEY `IDX_D7E676B1D47C2D1B` (`dataset_id`),
  KEY `IDX_D7E676B1886DEE8F` (`interaction_id`),
  CONSTRAINT `FK_D7E676B1886DEE8F` FOREIGN KEY (`interaction_id`) REFERENCES `interaction` (`id`),
  CONSTRAINT `FK_D7E676B1D47C2D1B` FOREIGN KEY (`dataset_id`) REFERENCES `dataset` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interaction_dataset`
--

LOCK TABLES `interaction_dataset` WRITE;
/*!40000 ALTER TABLE `interaction_dataset` DISABLE KEYS */;
/*!40000 ALTER TABLE `interaction_dataset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `interaction_domain`
--

DROP TABLE IF EXISTS `interaction_domain`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `interaction_domain` (
  `domain_id` int NOT NULL,
  `interaction_id` int NOT NULL,
  PRIMARY KEY (`domain_id`,`interaction_id`),
  KEY `IDX_5110AA94115F0EE5` (`domain_id`),
  KEY `IDX_5110AA94886DEE8F` (`interaction_id`),
  CONSTRAINT `FK_5110AA94115F0EE5` FOREIGN KEY (`domain_id`) REFERENCES `domain` (`id`),
  CONSTRAINT `FK_5110AA94886DEE8F` FOREIGN KEY (`interaction_id`) REFERENCES `interaction` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interaction_domain`
--

LOCK TABLES `interaction_domain` WRITE;
/*!40000 ALTER TABLE `interaction_domain` DISABLE KEYS */;
/*!40000 ALTER TABLE `interaction_domain` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `interaction_interaction_category`
--

DROP TABLE IF EXISTS `interaction_interaction_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `interaction_interaction_category` (
  `interaction_category_id` int NOT NULL,
  `interaction_id` int NOT NULL,
  PRIMARY KEY (`interaction_category_id`,`interaction_id`),
  KEY `IDX_605705B45B69774A` (`interaction_category_id`),
  KEY `IDX_605705B4886DEE8F` (`interaction_id`),
  CONSTRAINT `FK_605705B45B69774A` FOREIGN KEY (`interaction_category_id`) REFERENCES `interaction_category` (`id`),
  CONSTRAINT `FK_605705B4886DEE8F` FOREIGN KEY (`interaction_id`) REFERENCES `interaction` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interaction_interaction_category`
--

LOCK TABLES `interaction_interaction_category` WRITE;
/*!40000 ALTER TABLE `interaction_interaction_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `interaction_interaction_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `interaction_interaction_networks`
--

DROP TABLE IF EXISTS `interaction_interaction_networks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `interaction_interaction_networks` (
  `interaction_network_id` int NOT NULL,
  `interaction_id` int NOT NULL,
  PRIMARY KEY (`interaction_network_id`,`interaction_id`),
  KEY `IDX_BFA2A85E72BF6E77` (`interaction_network_id`),
  KEY `IDX_BFA2A85E886DEE8F` (`interaction_id`),
  CONSTRAINT `FK_BFA2A85E72BF6E77` FOREIGN KEY (`interaction_network_id`) REFERENCES `interaction_network` (`id`),
  CONSTRAINT `FK_BFA2A85E886DEE8F` FOREIGN KEY (`interaction_id`) REFERENCES `interaction` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interaction_interaction_networks`
--

LOCK TABLES `interaction_interaction_networks` WRITE;
/*!40000 ALTER TABLE `interaction_interaction_networks` DISABLE KEYS */;
/*!40000 ALTER TABLE `interaction_interaction_networks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `interaction_network`
--

DROP TABLE IF EXISTS `interaction_network`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `interaction_network` (
  `id` int NOT NULL AUTO_INCREMENT,
  `interactor_query_string` varchar(3000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `score_parameter` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_array` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tissue_expression_array` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `query` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interaction_network`
--

LOCK TABLES `interaction_network` WRITE;
/*!40000 ALTER TABLE `interaction_network` DISABLE KEYS */;
/*!40000 ALTER TABLE `interaction_network` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `interaction_support_information`
--

DROP TABLE IF EXISTS `interaction_support_information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `interaction_support_information` (
  `id` int NOT NULL AUTO_INCREMENT,
  `interaction_id` int DEFAULT NULL,
  `support_information_id` int DEFAULT NULL,
  `value` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_815A6518886DEE8F` (`interaction_id`),
  KEY `IDX_815A6518E7A44270` (`support_information_id`),
  CONSTRAINT `FK_815A6518886DEE8F` FOREIGN KEY (`interaction_id`) REFERENCES `interaction` (`id`),
  CONSTRAINT `FK_815A6518E7A44270` FOREIGN KEY (`support_information_id`) REFERENCES `support_information` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interaction_support_information`
--

LOCK TABLES `interaction_support_information` WRITE;
/*!40000 ALTER TABLE `interaction_support_information` DISABLE KEYS */;
/*!40000 ALTER TABLE `interaction_support_information` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organism`
--

DROP TABLE IF EXISTS `organism`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `organism` (
  `id` int NOT NULL AUTO_INCREMENT,
  `taxid_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `common_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `class` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `scientific_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organism`
--

LOCK TABLES `organism` WRITE;
/*!40000 ALTER TABLE `organism` DISABLE KEYS */;
/*!40000 ALTER TABLE `organism` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `protein`
--

DROP TABLE IF EXISTS `protein`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `protein` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uniprot_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `protein_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ensembl_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entrez_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gene_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sequence` varchar(10000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(10000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number_of_interactions_in_database` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `protein`
--

LOCK TABLES `protein` WRITE;
/*!40000 ALTER TABLE `protein` DISABLE KEYS */;
/*!40000 ALTER TABLE `protein` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `protein_identifier`
--

DROP TABLE IF EXISTS `protein_identifier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `protein_identifier` (
  `identifier_id` int NOT NULL,
  `protein_id` int NOT NULL,
  PRIMARY KEY (`identifier_id`,`protein_id`),
  KEY `IDX_1AE91CD9EF794DF6` (`identifier_id`),
  KEY `IDX_1AE91CD954985755` (`protein_id`),
  CONSTRAINT `FK_1AE91CD954985755` FOREIGN KEY (`protein_id`) REFERENCES `protein` (`id`),
  CONSTRAINT `FK_1AE91CD9EF794DF6` FOREIGN KEY (`identifier_id`) REFERENCES `identifier` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `protein_identifier`
--

LOCK TABLES `protein_identifier` WRITE;
/*!40000 ALTER TABLE `protein_identifier` DISABLE KEYS */;
/*!40000 ALTER TABLE `protein_identifier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `protein_isoform`
--

DROP TABLE IF EXISTS `protein_isoform`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `protein_isoform` (
  `protein_id` int NOT NULL,
  `isoform_id` int NOT NULL,
  PRIMARY KEY (`protein_id`,`isoform_id`),
  KEY `IDX_3BA1014954985755` (`protein_id`),
  KEY `IDX_3BA10149CC074EC8` (`isoform_id`),
  CONSTRAINT `FK_3BA1014954985755` FOREIGN KEY (`protein_id`) REFERENCES `protein` (`id`),
  CONSTRAINT `FK_3BA10149CC074EC8` FOREIGN KEY (`isoform_id`) REFERENCES `protein` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `protein_isoform`
--

LOCK TABLES `protein_isoform` WRITE;
/*!40000 ALTER TABLE `protein_isoform` DISABLE KEYS */;
/*!40000 ALTER TABLE `protein_isoform` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `protein_organism`
--

DROP TABLE IF EXISTS `protein_organism`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `protein_organism` (
  `organism_id` int NOT NULL,
  `protein_id` int NOT NULL,
  PRIMARY KEY (`organism_id`,`protein_id`),
  KEY `IDX_ACDFE23864180A36` (`organism_id`),
  KEY `IDX_ACDFE23854985755` (`protein_id`),
  CONSTRAINT `FK_ACDFE23854985755` FOREIGN KEY (`protein_id`) REFERENCES `protein` (`id`),
  CONSTRAINT `FK_ACDFE23864180A36` FOREIGN KEY (`organism_id`) REFERENCES `organism` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `protein_organism`
--

LOCK TABLES `protein_organism` WRITE;
/*!40000 ALTER TABLE `protein_organism` DISABLE KEYS */;
/*!40000 ALTER TABLE `protein_organism` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support_information`
--

DROP TABLE IF EXISTS `support_information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `support_information` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_information`
--

LOCK TABLES `support_information` WRITE;
/*!40000 ALTER TABLE `support_information` DISABLE KEYS */;
/*!40000 ALTER TABLE `support_information` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
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
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D64992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_8D93D649A0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_8D93D649C05FB297` (`confirmation_token`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'miles','miles','miles.william.mee@gmail.com','miles.william.mee@gmail.com',1,'4zagvmqdqqw484k84wkgg080wc8sk0k','$2y$13$4zagvmqdqqw484k84wkggupogfarhdqxDDXrHfgtV1mCAybkQfauu','2019-12-06 21:50:02','0oy8UrcdBog8cdjAQJCn9-OeS09nylaTpMwC07_QX-A','2019-12-05 17:27:34','a:1:{i:0;s:10:\"ROLE_ADMIN\";}'),(2,'admin','admin','miles_mee@hotmail.com','miles_mee@hotmail.com',1,'pvbskadbm5ck88oos4co4c0cw04448g','$2y$13$pvbskadbm5ck88oos4co4OyIgXab9BuvUkL.lAcePA4hmX6xDAdcu','2021-06-11 16:17:08','kdadjqDc8z9aAbWdadeMn3Zi6pc5FqR-d60oARvk3EQ','2016-09-19 03:47:09','a:1:{i:0;s:10:\"ROLE_ADMIN\";}'),(3,'user','user','milesmeee@gmail.com','milesmeee@gmail.com',1,NULL,'$2y$13$smH7NTczu1I2O4UqWDHIFe8cOTqV0XrcUJttuq6BQX7m31J9wFCna','2017-07-02 03:46:33',NULL,NULL,'a:0:{}'),(4,'aniket','aniket','aranjan@iitkgp.ac.in','aranjan@iitkgp.ac.in',1,NULL,'$2y$13$agT/z4H3guYOFEHYSYgQnOF4CZuY9uLJt2sGRFoCZU5kkidbtQHXW','2021-06-14 06:02:42',NULL,NULL,'a:1:{i:0;s:10:\"ROLE_ADMIN\";}');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_datasets`
--

DROP TABLE IF EXISTS `user_datasets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_datasets` (
  `dataset_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`dataset_id`,`user_id`),
  KEY `IDX_7DE7599ED47C2D1B` (`dataset_id`),
  KEY `IDX_7DE7599EA76ED395` (`user_id`),
  CONSTRAINT `FK_7DE7599EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_7DE7599ED47C2D1B` FOREIGN KEY (`dataset_id`) REFERENCES `dataset` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_datasets`
--

LOCK TABLES `user_datasets` WRITE;
/*!40000 ALTER TABLE `user_datasets` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_datasets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_interaction_networks`
--

DROP TABLE IF EXISTS `user_interaction_networks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_interaction_networks` (
  `interaction_network_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`interaction_network_id`,`user_id`),
  KEY `IDX_5D4D70AD72BF6E77` (`interaction_network_id`),
  KEY `IDX_5D4D70ADA76ED395` (`user_id`),
  CONSTRAINT `FK_5D4D70AD72BF6E77` FOREIGN KEY (`interaction_network_id`) REFERENCES `interaction_network` (`id`),
  CONSTRAINT `FK_5D4D70ADA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_interaction_networks`
--

LOCK TABLES `user_interaction_networks` WRITE;
/*!40000 ALTER TABLE `user_interaction_networks` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_interaction_networks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_protein`
--

DROP TABLE IF EXISTS `user_protein`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_protein` (
  `protein_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`protein_id`,`user_id`),
  KEY `IDX_C0F5FFB854985755` (`protein_id`),
  KEY `IDX_C0F5FFB8A76ED395` (`user_id`),
  CONSTRAINT `FK_C0F5FFB854985755` FOREIGN KEY (`protein_id`) REFERENCES `protein` (`id`),
  CONSTRAINT `FK_C0F5FFB8A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_protein`
--

LOCK TABLES `user_protein` WRITE;
/*!40000 ALTER TABLE `user_protein` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_protein` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-06-20 22:38:53
