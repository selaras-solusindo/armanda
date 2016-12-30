-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 30, 2016 at 01:58 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_armanda`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_invoice`
--

CREATE TABLE IF NOT EXISTS `tb_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `no_invoice` varchar(100) NOT NULL,
  `tgl_invoice` date NOT NULL,
  `no_order` varchar(100) DEFAULT NULL,
  `no_referensi` varchar(100) DEFAULT NULL,
  `kegiatan` text,
  `tgl_pelaksanaan` date DEFAULT NULL,
  `no_sertifikat` varchar(100) DEFAULT NULL,
  `keterangan` text,
  `total` float(10,2) DEFAULT NULL,
  `ppn` int(11) DEFAULT NULL,
  `total_ppn` float(10,2) DEFAULT NULL,
  `terbilang` text,
  `terbayar` tinyint(1) DEFAULT NULL,
  `pasal23` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tb_invoice`
--

INSERT INTO `tb_invoice` (`id`, `customer_id`, `no_invoice`, `tgl_invoice`, `no_order`, `no_referensi`, `kegiatan`, `tgl_pelaksanaan`, `no_sertifikat`, `keterangan`, `total`, `ppn`, `total_ppn`, `terbilang`, `terbayar`, `pasal23`) VALUES
(1, 1, '11', '2016-12-20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0),
(2, 1, 'q123', '2016-12-20', NULL, NULL, NULL, NULL, NULL, NULL, 555000.00, 10, 610500.00, ' enam ratus sepuluh ribu lima ratus ', 0, 0),
(3, 1, '007', '2016-12-20', '7', '8', 'tes', '2016-12-21', '9', '-', 56000.00, 10, 61600.00, ' enam puluh satu ribu enam ratus ', 0, 0),
(4, 2, 'mjs123', '2016-12-20', NULL, NULL, NULL, NULL, NULL, NULL, 60000.00, 10, 66000.00, ' enam puluh enam ribu ', 0, 0),
(5, 2, '1313', '2016-12-23', NULL, NULL, NULL, NULL, NULL, NULL, 31500.00, NULL, 31500.00, ' tiga puluh satu ribu lima ratus ', 0, 1),
(6, 2, 'tyty', '2017-01-02', NULL, NULL, NULL, NULL, NULL, NULL, 3600.00, NULL, 3600.00, ' tiga ribu enam ratus ', 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
