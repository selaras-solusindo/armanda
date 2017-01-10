-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 10, 2017 at 09:17 AM
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
-- Stand-in structure for view `cetak_invoice_fee`
--
CREATE TABLE IF NOT EXISTS `cetak_invoice_fee` (
`nama` varchar(50)
,`alamat` text
,`kota` varchar(50)
,`kodepos` varchar(10)
,`no_npwp` varchar(50)
,`no_invoice` varchar(100)
,`tgl_invoice` date
,`no_order` varchar(100)
,`no_referensi` varchar(100)
,`kegiatan` text
,`no_sertifikat` varchar(100)
,`keterangan` text
,`total` float(10,2)
,`ppn` int(11)
,`total_ppn` float(10,2)
,`terbilang` text
,`terbayar` tinyint(1)
,`pasal23` tinyint(1)
,`no_kuitansi` varchar(25)
,`barang_id` int(11)
,`harga` double
,`qty` int(11)
,`satuan` varchar(50)
,`jumlah` float(10,2)
,`keterangan1` text
,`nama1` text
,`id` int(11)
);
-- --------------------------------------------------------

--
-- Table structure for table `cetak_invoice_tgl_pelaksanaan`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `db_armanda`.`cetak_invoice_tgl_pelaksanaan` AS select `db_armanda`.`tb_invoice`.`id` AS `id`,`db_armanda`.`tb_pelaksanaan`.`pelaksanaan_tgl` AS `pelaksanaan_tgl` from (`db_armanda`.`tb_invoice` join `db_armanda`.`tb_pelaksanaan` on((`db_armanda`.`tb_invoice`.`id` = `db_armanda`.`tb_pelaksanaan`.`invoice_id`)));

--
-- Dumping data for table `cetak_invoice_tgl_pelaksanaan`
--

INSERT INTO `cetak_invoice_tgl_pelaksanaan` (`id`, `pelaksanaan_tgl`) VALUES
(8, '2017-01-09'),
(8, '2017-01-10'),
(9, '2017-01-09'),
(9, '2017-01-10'),
(9, '2017-01-11'),
(9, '2017-01-12'),
(9, '2017-01-13');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `sequence` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `type` varchar(24) NOT NULL,
  `required` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `product_id`, `sequence`, `name`, `type`, `required`) VALUES
(1, 1, 1, 'colors', 'Detail', 0),
(2, 2, 1, 'aset', 'Detail', 0),
(3, 2, 2, 'bangunan', 'Detail', 0);

-- --------------------------------------------------------

--
-- Table structure for table `option_values`
--

CREATE TABLE IF NOT EXISTS `option_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `price` float(10,2) NOT NULL,
  `weight` float(10,2) NOT NULL,
  `sequence` int(11) NOT NULL,
  `limit` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `option_values`
--

INSERT INTO `option_values` (`id`, `option_id`, `name`, `value`, `price`, `weight`, `sequence`, `limit`) VALUES
(1, 1, 'pink', '', 299.99, 0.00, 0, NULL),
(2, 1, 'black', '', 289.99, 0.00, 1, NULL),
(3, 1, 'blue', '', 289.99, 0.00, 2, NULL),
(4, 1, 'white', '', 289.99, 0.00, 3, NULL),
(5, 2, 'laptop', '1', 1.00, 1.00, 0, NULL),
(6, 2, 'cpu', '2', 2.00, 2.00, 1, NULL),
(7, 3, 'gedung', '3', 3.00, 3.00, 0, NULL),
(8, 3, 'tanah', '4', 4.00, 4.00, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sku` varchar(30) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `slug` varchar(128) DEFAULT NULL,
  `route_id` int(11) NOT NULL,
  `description` text,
  `excerpt` text,
  `price` float(10,2) NOT NULL DEFAULT '0.00',
  `saleprice` float(10,2) NOT NULL DEFAULT '0.00',
  `free_shipping` tinyint(1) NOT NULL DEFAULT '0',
  `shippable` tinyint(1) NOT NULL DEFAULT '1',
  `weight` varchar(10) NOT NULL DEFAULT '0',
  `in_stock` tinyint(1) NOT NULL DEFAULT '1',
  `related_products` text,
  `images` text,
  `seo_title` text,
  `meta` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `sku`, `name`, `slug`, `route_id`, `description`, `excerpt`, `price`, `saleprice`, `free_shipping`, `shippable`, `weight`, `in_stock`, `related_products`, `images`, `seo_title`, `meta`) VALUES
(1, 'Dell Mini 1010', 'Dell Mini 1010', 'dell-mini-1010', 0, NULL, NULL, 299.99, 289.99, 0, 1, '100', 1, NULL, '{"4290ad590980741054145abf2991848b":{"filename":"4290ad590980741054145abf2991848b.jpg","alt":"","caption":"","primary":true}}', NULL, NULL),
(2, '', 'pt amr', 'pt-amr', 0, NULL, NULL, 0.00, 0.00, 0, 1, '0', 1, NULL, 'null', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rekap_invoice`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `db_armanda`.`rekap_invoice` AS select `db_armanda`.`tb_invoice`.`id` AS `id`,`db_armanda`.`tb_invoice`.`customer_id` AS `customer_id`,`db_armanda`.`tb_invoice`.`no_invoice` AS `no_invoice`,`db_armanda`.`tb_invoice`.`tgl_invoice` AS `tgl_invoice`,`db_armanda`.`tb_invoice`.`no_order` AS `no_order`,`db_armanda`.`tb_invoice`.`no_referensi` AS `no_referensi`,`db_armanda`.`tb_invoice`.`kegiatan` AS `kegiatan`,`db_armanda`.`tb_invoice`.`tgl_pelaksanaan` AS `tgl_pelaksanaan`,`db_armanda`.`tb_invoice`.`no_sertifikat` AS `no_sertifikat`,`db_armanda`.`tb_invoice`.`keterangan` AS `keterangan`,`db_armanda`.`tb_invoice`.`total` AS `total`,`db_armanda`.`tb_invoice`.`ppn` AS `ppn`,`db_armanda`.`tb_invoice`.`total_ppn` AS `total_ppn`,`db_armanda`.`tb_invoice`.`terbilang` AS `terbilang`,`db_armanda`.`tb_customer`.`nama` AS `nama`,`db_armanda`.`tb_kuitansi`.`no_kuitansi` AS `no_kuitansi` from ((`db_armanda`.`tb_invoice` join `db_armanda`.`tb_customer` on((`db_armanda`.`tb_invoice`.`customer_id` = `db_armanda`.`tb_customer`.`id`))) left join `db_armanda`.`tb_kuitansi` on((`db_armanda`.`tb_kuitansi`.`invoice_id` = `db_armanda`.`tb_invoice`.`id`)));

--
-- Dumping data for table `rekap_invoice`
--

INSERT INTO `rekap_invoice` (`id`, `customer_id`, `no_invoice`, `tgl_invoice`, `no_order`, `no_referensi`, `kegiatan`, `tgl_pelaksanaan`, `no_sertifikat`, `keterangan`, `total`, `ppn`, `total_ppn`, `terbilang`, `nama`, `no_kuitansi`) VALUES
(1, 1, '170001/AN/SBA/I/2017', '2016-12-20', NULL, NULL, NULL, NULL, NULL, NULL, 810000.00, NULL, 810000.00, ' delapan ratus sepuluh ribu ', 'PT. Angkasa Buana Cipta', NULL),
(2, 1, 'q123', '2016-12-20', NULL, NULL, NULL, NULL, NULL, NULL, 555000.00, 10, 610500.00, ' enam ratus sepuluh ribu lima ratus ', 'PT. Angkasa Buana Cipta', NULL),
(3, 1, '007', '2016-12-20', '7', '8', 'tes', '2016-12-21', '9', '-', 56000.00, 10, 61600.00, ' enam puluh satu ribu enam ratus ', 'PT. Angkasa Buana Cipta', NULL),
(8, 1, 'popok', '2017-01-09', NULL, NULL, NULL, NULL, NULL, NULL, 70000.00, NULL, 70000.00, ' tujuh puluh  ribu ', 'PT. Angkasa Buana Cipta', NULL),
(9, 1, 'asdfghj', '2017-01-09', NULL, NULL, NULL, NULL, NULL, NULL, 1130.00, NULL, 1130.00, ' seribu seratus tiga puluh ', 'PT. Angkasa Buana Cipta', NULL),
(4, 2, 'mjs123', '2016-12-20', NULL, NULL, NULL, NULL, NULL, NULL, 60000.00, 10, 66000.00, ' enam puluh enam ribu ', 'MJS, PT', NULL),
(5, 2, '1313', '2016-12-23', NULL, NULL, NULL, NULL, NULL, NULL, 31500.00, NULL, 31500.00, ' tiga puluh satu ribu lima ratus ', 'MJS, PT', 'NK131313'),
(6, 2, 'tyty', '2017-01-02', NULL, NULL, NULL, NULL, NULL, NULL, 3600.00, NULL, 3600.00, ' tiga ribu enam ratus ', 'MJS, PT', NULL),
(7, 2, 'kol', '2017-01-09', NULL, NULL, NULL, NULL, NULL, NULL, 27000.00, NULL, 27000.00, ' dua puluh tujuh ribu ', 'MJS, PT', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_barang`
--

CREATE TABLE IF NOT EXISTS `tb_barang` (
  `barang_id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` text NOT NULL,
  PRIMARY KEY (`barang_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tb_barang`
--

INSERT INTO `tb_barang` (`barang_id`, `nama`) VALUES
(1, 'Barang 1'),
(2, 'Barang 2');

-- --------------------------------------------------------

--
-- Table structure for table `tb_customer`
--

CREATE TABLE IF NOT EXISTS `tb_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `kota` varchar(50) NOT NULL,
  `kodepos` varchar(10) NOT NULL,
  `no_npwp` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tb_customer`
--

INSERT INTO `tb_customer` (`id`, `nama`, `alamat`, `kota`, `kodepos`, `no_npwp`) VALUES
(1, 'PT. Angkasa Buana Cipta', 'Jl. Tenggilis Mejoyo Blok U No. 36', 'Surabaya', '60262', '02.525.076.2-641.000'),
(2, 'MJS, PT', 'Manyar', 'Sby', '88888', '8080888');

-- --------------------------------------------------------

--
-- Table structure for table `tb_fee`
--

CREATE TABLE IF NOT EXISTS `tb_fee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) DEFAULT NULL,
  `barang_id` int(11) NOT NULL,
  `harga` double DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `satuan` varchar(50) DEFAULT NULL,
  `jumlah` float(10,2) DEFAULT NULL,
  `keterangan` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `tb_fee`
--

INSERT INTO `tb_fee` (`id`, `invoice_id`, `barang_id`, `harga`, `qty`, `satuan`, `jumlah`, `keterangan`) VALUES
(1, 1, 1, 70000, 7, 'unit', 490000.00, '-'),
(2, 1, 2, 80000, 4, 'unit', 320000.00, '-'),
(3, 2, 0, 20000, 10, 'unit', 200000.00, '-'),
(4, 2, 0, 10000, 10, 'u', 100000.00, NULL),
(10, 2, 0, 35000, 3, NULL, 105000.00, NULL),
(8, 2, 0, 15000, 10, NULL, 150000.00, NULL),
(7, 3, 1, 8000, 7, NULL, 56000.00, NULL),
(13, 4, 0, 12000, 5, NULL, 60000.00, NULL),
(14, 5, 1, 10500, 3, NULL, 31500.00, NULL),
(15, 5, 1, NULL, NULL, NULL, 0.00, NULL),
(16, 6, 1, 60, 60, NULL, 3600.00, NULL),
(17, 7, 1, 9000, 3, NULL, 27000.00, NULL),
(18, 8, 1, 7500, 4, NULL, 30000.00, NULL),
(19, 8, 2, 8000, 5, NULL, 40000.00, NULL),
(20, 9, 1, 70, 7, NULL, 490.00, NULL),
(21, 9, 2, 80, 8, NULL, 640.00, NULL);

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
  `no_kuitansi` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `tb_invoice`
--

INSERT INTO `tb_invoice` (`id`, `customer_id`, `no_invoice`, `tgl_invoice`, `no_order`, `no_referensi`, `kegiatan`, `tgl_pelaksanaan`, `no_sertifikat`, `keterangan`, `total`, `ppn`, `total_ppn`, `terbilang`, `terbayar`, `pasal23`, `no_kuitansi`) VALUES
(1, 1, '170001/AN/SBA/I/2017', '2016-12-20', NULL, NULL, NULL, NULL, NULL, NULL, 810000.00, NULL, 810000.00, ' delapan ratus sepuluh ribu ', 1, 0, 'xx1'),
(2, 1, 'q123', '2016-12-20', NULL, NULL, NULL, NULL, NULL, NULL, 555000.00, 10, 610500.00, ' enam ratus sepuluh ribu lima ratus ', 0, 0, NULL),
(3, 1, '007', '2016-12-20', '7', '8', 'tes', '2016-12-21', '9', '-', 56000.00, 10, 61600.00, ' enam puluh satu ribu enam ratus ', 0, 0, 'x2x2'),
(4, 2, 'mjs123', '2016-12-20', NULL, NULL, NULL, NULL, NULL, NULL, 60000.00, 10, 66000.00, ' enam puluh enam ribu ', 0, 0, NULL),
(5, 2, '1313', '2016-12-23', NULL, NULL, NULL, NULL, NULL, NULL, 31500.00, NULL, 31500.00, ' tiga puluh satu ribu lima ratus ', 0, 1, 'xx2'),
(6, 2, 'tyty', '2017-01-02', NULL, NULL, NULL, NULL, NULL, NULL, 3600.00, NULL, 3600.00, ' tiga ribu enam ratus ', 1, 1, NULL),
(7, 2, 'kol', '2017-01-09', NULL, NULL, NULL, NULL, NULL, NULL, 27000.00, NULL, 27000.00, ' dua puluh tujuh ribu ', NULL, 0, '-'),
(8, 1, 'popok', '2017-01-09', NULL, NULL, NULL, NULL, NULL, NULL, 70000.00, NULL, 70000.00, ' tujuh puluh  ribu ', NULL, 0, NULL),
(9, 1, 'asdfghj', '2017-01-09', NULL, NULL, NULL, NULL, NULL, NULL, 1130.00, NULL, 1130.00, ' seribu seratus tiga puluh ', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_kuitansi`
--

CREATE TABLE IF NOT EXISTS `tb_kuitansi` (
  `kuitansi_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `no_kuitansi` varchar(25) NOT NULL,
  PRIMARY KEY (`kuitansi_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tb_kuitansi`
--

INSERT INTO `tb_kuitansi` (`kuitansi_id`, `invoice_id`, `no_kuitansi`) VALUES
(2, 5, 'NK131313');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pelaksanaan`
--

CREATE TABLE IF NOT EXISTS `tb_pelaksanaan` (
  `pelaksanaan_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `pelaksanaan_tgl` date NOT NULL,
  PRIMARY KEY (`pelaksanaan_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tb_pelaksanaan`
--

INSERT INTO `tb_pelaksanaan` (`pelaksanaan_id`, `invoice_id`, `pelaksanaan_tgl`) VALUES
(1, 8, '2017-01-09'),
(2, 8, '2017-01-10'),
(3, 9, '2017-01-09'),
(4, 9, '2017-01-10'),
(5, 9, '2017-01-11'),
(6, 9, '2017-01-12'),
(7, 9, '2017-01-13');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE IF NOT EXISTS `tb_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `userlevel` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `username`, `password`, `userlevel`) VALUES
(2, 'admin2', 'admin2', -1);

-- --------------------------------------------------------

--
-- Table structure for table `view1`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `db_armanda`.`view1` AS select `db_armanda`.`tb_invoice`.`id` AS `id`,`db_armanda`.`tb_invoice`.`customer_id` AS `customer_id`,`db_armanda`.`tb_invoice`.`no_invoice` AS `no_invoice`,`db_armanda`.`tb_invoice`.`tgl_invoice` AS `tgl_invoice`,`db_armanda`.`tb_invoice`.`no_order` AS `no_order`,`db_armanda`.`tb_invoice`.`no_referensi` AS `no_referensi`,`db_armanda`.`tb_invoice`.`kegiatan` AS `kegiatan`,`db_armanda`.`tb_invoice`.`no_sertifikat` AS `no_sertifikat`,`db_armanda`.`tb_invoice`.`keterangan` AS `keterangan`,`db_armanda`.`tb_invoice`.`total` AS `total`,`db_armanda`.`tb_invoice`.`ppn` AS `ppn`,`db_armanda`.`tb_invoice`.`total_ppn` AS `total_ppn`,`db_armanda`.`tb_invoice`.`terbilang` AS `terbilang`,`db_armanda`.`tb_invoice`.`terbayar` AS `terbayar`,`db_armanda`.`tb_invoice`.`pasal23` AS `pasal23`,`db_armanda`.`tb_invoice`.`no_kuitansi` AS `no_kuitansi`,`db_armanda`.`tb_customer`.`nama` AS `nama`,`db_armanda`.`tb_customer`.`alamat` AS `alamat`,`db_armanda`.`tb_customer`.`kota` AS `kota`,`db_armanda`.`tb_customer`.`kodepos` AS `kodepos`,`db_armanda`.`tb_customer`.`no_npwp` AS `no_npwp`,`db_armanda`.`tb_barang`.`nama` AS `nama1`,`db_armanda`.`tb_pelaksanaan`.`pelaksanaan_tgl` AS `pelaksanaan_tgl`,`db_armanda`.`tb_fee`.`barang_id` AS `barang_id`,`db_armanda`.`tb_fee`.`harga` AS `harga`,`db_armanda`.`tb_fee`.`qty` AS `qty`,`db_armanda`.`tb_fee`.`satuan` AS `satuan`,`db_armanda`.`tb_fee`.`jumlah` AS `jumlah`,`db_armanda`.`tb_fee`.`keterangan` AS `keterangan1` from ((((`db_armanda`.`tb_invoice` left join `db_armanda`.`tb_customer` on((`db_armanda`.`tb_invoice`.`customer_id` = `db_armanda`.`tb_customer`.`id`))) left join `db_armanda`.`tb_fee` on((`db_armanda`.`tb_invoice`.`id` = `db_armanda`.`tb_fee`.`invoice_id`))) left join `db_armanda`.`tb_barang` on((`db_armanda`.`tb_fee`.`barang_id` = `db_armanda`.`tb_barang`.`barang_id`))) left join `db_armanda`.`tb_pelaksanaan` on((`db_armanda`.`tb_invoice`.`id` = `db_armanda`.`tb_pelaksanaan`.`invoice_id`)));

--
-- Dumping data for table `view1`
--

INSERT INTO `view1` (`id`, `customer_id`, `no_invoice`, `tgl_invoice`, `no_order`, `no_referensi`, `kegiatan`, `no_sertifikat`, `keterangan`, `total`, `ppn`, `total_ppn`, `terbilang`, `terbayar`, `pasal23`, `no_kuitansi`, `nama`, `alamat`, `kota`, `kodepos`, `no_npwp`, `nama1`, `pelaksanaan_tgl`, `barang_id`, `harga`, `qty`, `satuan`, `jumlah`, `keterangan1`) VALUES
(1, 1, '170001/AN/SBA/I/2017', '2016-12-20', NULL, NULL, NULL, NULL, NULL, 810000.00, NULL, 810000.00, ' delapan ratus sepuluh ribu ', 1, 0, 'xx1', 'PT. Angkasa Buana Cipta', 'Jl. Tenggilis Mejoyo Blok U No. 36', 'Surabaya', '60262', '02.525.076.2-641.000', 'Barang 1', NULL, 1, 70000, 7, 'unit', 490000.00, '-'),
(1, 1, '170001/AN/SBA/I/2017', '2016-12-20', NULL, NULL, NULL, NULL, NULL, 810000.00, NULL, 810000.00, ' delapan ratus sepuluh ribu ', 1, 0, 'xx1', 'PT. Angkasa Buana Cipta', 'Jl. Tenggilis Mejoyo Blok U No. 36', 'Surabaya', '60262', '02.525.076.2-641.000', 'Barang 2', NULL, 2, 80000, 4, 'unit', 320000.00, '-'),
(2, 1, 'q123', '2016-12-20', NULL, NULL, NULL, NULL, NULL, 555000.00, 10, 610500.00, ' enam ratus sepuluh ribu lima ratus ', 0, 0, NULL, 'PT. Angkasa Buana Cipta', 'Jl. Tenggilis Mejoyo Blok U No. 36', 'Surabaya', '60262', '02.525.076.2-641.000', NULL, NULL, 0, 20000, 10, 'unit', 200000.00, '-'),
(2, 1, 'q123', '2016-12-20', NULL, NULL, NULL, NULL, NULL, 555000.00, 10, 610500.00, ' enam ratus sepuluh ribu lima ratus ', 0, 0, NULL, 'PT. Angkasa Buana Cipta', 'Jl. Tenggilis Mejoyo Blok U No. 36', 'Surabaya', '60262', '02.525.076.2-641.000', NULL, NULL, 0, 10000, 10, 'u', 100000.00, NULL),
(2, 1, 'q123', '2016-12-20', NULL, NULL, NULL, NULL, NULL, 555000.00, 10, 610500.00, ' enam ratus sepuluh ribu lima ratus ', 0, 0, NULL, 'PT. Angkasa Buana Cipta', 'Jl. Tenggilis Mejoyo Blok U No. 36', 'Surabaya', '60262', '02.525.076.2-641.000', NULL, NULL, 0, 35000, 3, NULL, 105000.00, NULL),
(2, 1, 'q123', '2016-12-20', NULL, NULL, NULL, NULL, NULL, 555000.00, 10, 610500.00, ' enam ratus sepuluh ribu lima ratus ', 0, 0, NULL, 'PT. Angkasa Buana Cipta', 'Jl. Tenggilis Mejoyo Blok U No. 36', 'Surabaya', '60262', '02.525.076.2-641.000', NULL, NULL, 0, 15000, 10, NULL, 150000.00, NULL),
(3, 1, '007', '2016-12-20', '7', '8', 'tes', '9', '-', 56000.00, 10, 61600.00, ' enam puluh satu ribu enam ratus ', 0, 0, 'x2x2', 'PT. Angkasa Buana Cipta', 'Jl. Tenggilis Mejoyo Blok U No. 36', 'Surabaya', '60262', '02.525.076.2-641.000', 'Barang 1', NULL, 1, 8000, 7, NULL, 56000.00, NULL),
(4, 2, 'mjs123', '2016-12-20', NULL, NULL, NULL, NULL, NULL, 60000.00, 10, 66000.00, ' enam puluh enam ribu ', 0, 0, NULL, 'MJS, PT', 'Manyar', 'Sby', '88888', '8080888', NULL, NULL, 0, 12000, 5, NULL, 60000.00, NULL),
(5, 2, '1313', '2016-12-23', NULL, NULL, NULL, NULL, NULL, 31500.00, NULL, 31500.00, ' tiga puluh satu ribu lima ratus ', 0, 1, 'xx2', 'MJS, PT', 'Manyar', 'Sby', '88888', '8080888', 'Barang 1', NULL, 1, 10500, 3, NULL, 31500.00, NULL),
(5, 2, '1313', '2016-12-23', NULL, NULL, NULL, NULL, NULL, 31500.00, NULL, 31500.00, ' tiga puluh satu ribu lima ratus ', 0, 1, 'xx2', 'MJS, PT', 'Manyar', 'Sby', '88888', '8080888', 'Barang 1', NULL, 1, NULL, NULL, NULL, 0.00, NULL),
(6, 2, 'tyty', '2017-01-02', NULL, NULL, NULL, NULL, NULL, 3600.00, NULL, 3600.00, ' tiga ribu enam ratus ', 1, 1, NULL, 'MJS, PT', 'Manyar', 'Sby', '88888', '8080888', 'Barang 1', NULL, 1, 60, 60, NULL, 3600.00, NULL),
(7, 2, 'kol', '2017-01-09', NULL, NULL, NULL, NULL, NULL, 27000.00, NULL, 27000.00, ' dua puluh tujuh ribu ', NULL, 0, '-', 'MJS, PT', 'Manyar', 'Sby', '88888', '8080888', 'Barang 1', NULL, 1, 9000, 3, NULL, 27000.00, NULL),
(8, 1, 'popok', '2017-01-09', NULL, NULL, NULL, NULL, NULL, 70000.00, NULL, 70000.00, ' tujuh puluh  ribu ', NULL, 0, NULL, 'PT. Angkasa Buana Cipta', 'Jl. Tenggilis Mejoyo Blok U No. 36', 'Surabaya', '60262', '02.525.076.2-641.000', 'Barang 1', '2017-01-09', 1, 7500, 4, NULL, 30000.00, NULL),
(8, 1, 'popok', '2017-01-09', NULL, NULL, NULL, NULL, NULL, 70000.00, NULL, 70000.00, ' tujuh puluh  ribu ', NULL, 0, NULL, 'PT. Angkasa Buana Cipta', 'Jl. Tenggilis Mejoyo Blok U No. 36', 'Surabaya', '60262', '02.525.076.2-641.000', 'Barang 1', '2017-01-10', 1, 7500, 4, NULL, 30000.00, NULL),
(8, 1, 'popok', '2017-01-09', NULL, NULL, NULL, NULL, NULL, 70000.00, NULL, 70000.00, ' tujuh puluh  ribu ', NULL, 0, NULL, 'PT. Angkasa Buana Cipta', 'Jl. Tenggilis Mejoyo Blok U No. 36', 'Surabaya', '60262', '02.525.076.2-641.000', 'Barang 2', '2017-01-09', 2, 8000, 5, NULL, 40000.00, NULL),
(8, 1, 'popok', '2017-01-09', NULL, NULL, NULL, NULL, NULL, 70000.00, NULL, 70000.00, ' tujuh puluh  ribu ', NULL, 0, NULL, 'PT. Angkasa Buana Cipta', 'Jl. Tenggilis Mejoyo Blok U No. 36', 'Surabaya', '60262', '02.525.076.2-641.000', 'Barang 2', '2017-01-10', 2, 8000, 5, NULL, 40000.00, NULL),
(9, 1, 'asdfghj', '2017-01-09', NULL, NULL, NULL, NULL, NULL, 1130.00, NULL, 1130.00, ' seribu seratus tiga puluh ', NULL, 0, NULL, 'PT. Angkasa Buana Cipta', 'Jl. Tenggilis Mejoyo Blok U No. 36', 'Surabaya', '60262', '02.525.076.2-641.000', 'Barang 1', '2017-01-09', 1, 70, 7, NULL, 490.00, NULL),
(9, 1, 'asdfghj', '2017-01-09', NULL, NULL, NULL, NULL, NULL, 1130.00, NULL, 1130.00, ' seribu seratus tiga puluh ', NULL, 0, NULL, 'PT. Angkasa Buana Cipta', 'Jl. Tenggilis Mejoyo Blok U No. 36', 'Surabaya', '60262', '02.525.076.2-641.000', 'Barang 1', '2017-01-10', 1, 70, 7, NULL, 490.00, NULL),
(9, 1, 'asdfghj', '2017-01-09', NULL, NULL, NULL, NULL, NULL, 1130.00, NULL, 1130.00, ' seribu seratus tiga puluh ', NULL, 0, NULL, 'PT. Angkasa Buana Cipta', 'Jl. Tenggilis Mejoyo Blok U No. 36', 'Surabaya', '60262', '02.525.076.2-641.000', 'Barang 1', '2017-01-11', 1, 70, 7, NULL, 490.00, NULL),
(9, 1, 'asdfghj', '2017-01-09', NULL, NULL, NULL, NULL, NULL, 1130.00, NULL, 1130.00, ' seribu seratus tiga puluh ', NULL, 0, NULL, 'PT. Angkasa Buana Cipta', 'Jl. Tenggilis Mejoyo Blok U No. 36', 'Surabaya', '60262', '02.525.076.2-641.000', 'Barang 1', '2017-01-12', 1, 70, 7, NULL, 490.00, NULL),
(9, 1, 'asdfghj', '2017-01-09', NULL, NULL, NULL, NULL, NULL, 1130.00, NULL, 1130.00, ' seribu seratus tiga puluh ', NULL, 0, NULL, 'PT. Angkasa Buana Cipta', 'Jl. Tenggilis Mejoyo Blok U No. 36', 'Surabaya', '60262', '02.525.076.2-641.000', 'Barang 1', '2017-01-13', 1, 70, 7, NULL, 490.00, NULL),
(9, 1, 'asdfghj', '2017-01-09', NULL, NULL, NULL, NULL, NULL, 1130.00, NULL, 1130.00, ' seribu seratus tiga puluh ', NULL, 0, NULL, 'PT. Angkasa Buana Cipta', 'Jl. Tenggilis Mejoyo Blok U No. 36', 'Surabaya', '60262', '02.525.076.2-641.000', 'Barang 2', '2017-01-09', 2, 80, 8, NULL, 640.00, NULL),
(9, 1, 'asdfghj', '2017-01-09', NULL, NULL, NULL, NULL, NULL, 1130.00, NULL, 1130.00, ' seribu seratus tiga puluh ', NULL, 0, NULL, 'PT. Angkasa Buana Cipta', 'Jl. Tenggilis Mejoyo Blok U No. 36', 'Surabaya', '60262', '02.525.076.2-641.000', 'Barang 2', '2017-01-10', 2, 80, 8, NULL, 640.00, NULL),
(9, 1, 'asdfghj', '2017-01-09', NULL, NULL, NULL, NULL, NULL, 1130.00, NULL, 1130.00, ' seribu seratus tiga puluh ', NULL, 0, NULL, 'PT. Angkasa Buana Cipta', 'Jl. Tenggilis Mejoyo Blok U No. 36', 'Surabaya', '60262', '02.525.076.2-641.000', 'Barang 2', '2017-01-11', 2, 80, 8, NULL, 640.00, NULL),
(9, 1, 'asdfghj', '2017-01-09', NULL, NULL, NULL, NULL, NULL, 1130.00, NULL, 1130.00, ' seribu seratus tiga puluh ', NULL, 0, NULL, 'PT. Angkasa Buana Cipta', 'Jl. Tenggilis Mejoyo Blok U No. 36', 'Surabaya', '60262', '02.525.076.2-641.000', 'Barang 2', '2017-01-12', 2, 80, 8, NULL, 640.00, NULL),
(9, 1, 'asdfghj', '2017-01-09', NULL, NULL, NULL, NULL, NULL, 1130.00, NULL, 1130.00, ' seribu seratus tiga puluh ', NULL, 0, NULL, 'PT. Angkasa Buana Cipta', 'Jl. Tenggilis Mejoyo Blok U No. 36', 'Surabaya', '60262', '02.525.076.2-641.000', 'Barang 2', '2017-01-13', 2, 80, 8, NULL, 640.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `view2`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `db_armanda`.`view2` AS select `db_armanda`.`tb_kuitansi`.`kuitansi_id` AS `kuitansi_id`,`db_armanda`.`tb_kuitansi`.`invoice_id` AS `invoice_id`,`db_armanda`.`tb_kuitansi`.`no_kuitansi` AS `no_kuitansi`,`db_armanda`.`tb_customer`.`nama` AS `nama`,`db_armanda`.`tb_invoice`.`total_ppn` AS `total_ppn1`,`db_armanda`.`tb_invoice`.`terbilang` AS `terbilang1`,`db_armanda`.`tb_invoice`.`keterangan` AS `keterangan1`,`db_armanda`.`tb_invoice`.`no_invoice` AS `no_invoice`,`db_armanda`.`tb_invoice`.`tgl_invoice` AS `tgl_invoice`,`db_armanda`.`tb_invoice`.`no_sertifikat` AS `no_sertifikat`,`db_armanda`.`tb_invoice`.`pasal23` AS `pasal23`,`db_armanda`.`tb_invoice`.`total` AS `total` from ((`db_armanda`.`tb_kuitansi` join `db_armanda`.`tb_invoice` on((`db_armanda`.`tb_kuitansi`.`invoice_id` = `db_armanda`.`tb_invoice`.`id`))) join `db_armanda`.`tb_customer` on((`db_armanda`.`tb_invoice`.`customer_id` = `db_armanda`.`tb_customer`.`id`)));

--
-- Dumping data for table `view2`
--

INSERT INTO `view2` (`kuitansi_id`, `invoice_id`, `no_kuitansi`, `nama`, `total_ppn1`, `terbilang1`, `keterangan1`, `no_invoice`, `tgl_invoice`, `no_sertifikat`, `pasal23`, `total`) VALUES
(2, 5, 'NK131313', 'MJS, PT', 31500.00, ' tiga puluh satu ribu lima ratus ', NULL, '1313', '2016-12-23', NULL, 1, 31500.00);

-- --------------------------------------------------------

--
-- Table structure for table `view3`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `db_armanda`.`view3` AS select `db_armanda`.`tb_invoice`.`id` AS `id`,`db_armanda`.`tb_invoice`.`customer_id` AS `customer_id`,`db_armanda`.`tb_invoice`.`no_invoice` AS `no_invoice`,`db_armanda`.`tb_invoice`.`tgl_invoice` AS `tgl_invoice`,`db_armanda`.`tb_invoice`.`no_order` AS `no_order`,`db_armanda`.`tb_invoice`.`no_referensi` AS `no_referensi`,`db_armanda`.`tb_invoice`.`kegiatan` AS `kegiatan`,`db_armanda`.`tb_invoice`.`tgl_pelaksanaan` AS `tgl_pelaksanaan`,`db_armanda`.`tb_invoice`.`no_sertifikat` AS `no_sertifikat`,`db_armanda`.`tb_invoice`.`keterangan` AS `keterangan`,`db_armanda`.`tb_invoice`.`total` AS `total`,`db_armanda`.`tb_invoice`.`ppn` AS `ppn`,`db_armanda`.`tb_invoice`.`total_ppn` AS `total_ppn`,`db_armanda`.`tb_invoice`.`terbilang` AS `terbilang`,`db_armanda`.`tb_customer`.`nama` AS `nama`,`db_armanda`.`tb_kuitansi`.`no_kuitansi` AS `no_kuitansi` from ((`db_armanda`.`tb_invoice` join `db_armanda`.`tb_customer` on((`db_armanda`.`tb_invoice`.`customer_id` = `db_armanda`.`tb_customer`.`id`))) left join `db_armanda`.`tb_kuitansi` on((`db_armanda`.`tb_kuitansi`.`invoice_id` = `db_armanda`.`tb_invoice`.`id`)));

--
-- Dumping data for table `view3`
--

INSERT INTO `view3` (`id`, `customer_id`, `no_invoice`, `tgl_invoice`, `no_order`, `no_referensi`, `kegiatan`, `tgl_pelaksanaan`, `no_sertifikat`, `keterangan`, `total`, `ppn`, `total_ppn`, `terbilang`, `nama`, `no_kuitansi`) VALUES
(1, 1, '170001/AN/SBA/I/2017', '2016-12-20', NULL, NULL, NULL, NULL, NULL, NULL, 810000.00, NULL, 810000.00, ' delapan ratus sepuluh ribu ', 'PT. Angkasa Buana Cipta', NULL),
(2, 1, 'q123', '2016-12-20', NULL, NULL, NULL, NULL, NULL, NULL, 555000.00, 10, 610500.00, ' enam ratus sepuluh ribu lima ratus ', 'PT. Angkasa Buana Cipta', NULL),
(3, 1, '007', '2016-12-20', '7', '8', 'tes', '2016-12-21', '9', '-', 56000.00, 10, 61600.00, ' enam puluh satu ribu enam ratus ', 'PT. Angkasa Buana Cipta', NULL),
(8, 1, 'popok', '2017-01-09', NULL, NULL, NULL, NULL, NULL, NULL, 70000.00, NULL, 70000.00, ' tujuh puluh  ribu ', 'PT. Angkasa Buana Cipta', NULL),
(9, 1, 'asdfghj', '2017-01-09', NULL, NULL, NULL, NULL, NULL, NULL, 1130.00, NULL, 1130.00, ' seribu seratus tiga puluh ', 'PT. Angkasa Buana Cipta', NULL),
(4, 2, 'mjs123', '2016-12-20', NULL, NULL, NULL, NULL, NULL, NULL, 60000.00, 10, 66000.00, ' enam puluh enam ribu ', 'MJS, PT', NULL),
(5, 2, '1313', '2016-12-23', NULL, NULL, NULL, NULL, NULL, NULL, 31500.00, NULL, 31500.00, ' tiga puluh satu ribu lima ratus ', 'MJS, PT', 'NK131313'),
(6, 2, 'tyty', '2017-01-02', NULL, NULL, NULL, NULL, NULL, NULL, 3600.00, NULL, 3600.00, ' tiga ribu enam ratus ', 'MJS, PT', NULL),
(7, 2, 'kol', '2017-01-09', NULL, NULL, NULL, NULL, NULL, NULL, 27000.00, NULL, 27000.00, ' dua puluh tujuh ribu ', 'MJS, PT', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `view4`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `db_armanda`.`view4` AS select `db_armanda`.`tb_customer`.`nama` AS `nama`,`db_armanda`.`tb_kuitansi`.`no_kuitansi` AS `no_kuitansi`,`db_armanda`.`tb_invoice`.`no_invoice` AS `no_invoice`,`db_armanda`.`tb_invoice`.`total_ppn` AS `total_ppn`,`db_armanda`.`tb_invoice`.`tgl_pelaksanaan` AS `tgl_pelaksanaan` from ((`db_armanda`.`tb_invoice` left join `db_armanda`.`tb_customer` on((`db_armanda`.`tb_invoice`.`customer_id` = `db_armanda`.`tb_customer`.`id`))) left join `db_armanda`.`tb_kuitansi` on((`db_armanda`.`tb_kuitansi`.`invoice_id` = `db_armanda`.`tb_invoice`.`id`))) where (`db_armanda`.`tb_invoice`.`terbayar` = 0);

--
-- Dumping data for table `view4`
--

INSERT INTO `view4` (`nama`, `no_kuitansi`, `no_invoice`, `total_ppn`, `tgl_pelaksanaan`) VALUES
('PT. Angkasa Buana Cipta', NULL, 'q123', 610500.00, NULL),
('PT. Angkasa Buana Cipta', NULL, '007', 61600.00, '2016-12-21'),
('MJS, PT', NULL, 'mjs123', 66000.00, NULL),
('MJS, PT', 'NK131313', '1313', 31500.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `view5`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `db_armanda`.`view5` AS select `db_armanda`.`tb_invoice`.`id` AS `id`,`db_armanda`.`tb_invoice`.`customer_id` AS `customer_id`,`db_armanda`.`tb_invoice`.`no_invoice` AS `no_invoice`,`db_armanda`.`tb_invoice`.`tgl_invoice` AS `tgl_invoice`,`db_armanda`.`tb_invoice`.`no_order` AS `no_order`,`db_armanda`.`tb_invoice`.`no_referensi` AS `no_referensi`,`db_armanda`.`tb_invoice`.`kegiatan` AS `kegiatan`,`db_armanda`.`tb_invoice`.`tgl_pelaksanaan` AS `tgl_pelaksanaan`,`db_armanda`.`tb_invoice`.`no_sertifikat` AS `no_sertifikat`,`db_armanda`.`tb_invoice`.`keterangan` AS `keterangan`,`db_armanda`.`tb_invoice`.`total` AS `total`,`db_armanda`.`tb_invoice`.`ppn` AS `ppn`,`db_armanda`.`tb_invoice`.`total_ppn` AS `total_ppn`,`db_armanda`.`tb_invoice`.`terbilang` AS `terbilang`,`db_armanda`.`tb_customer`.`nama` AS `nama`,`db_armanda`.`tb_invoice`.`no_kuitansi` AS `no_kuitansi` from ((`db_armanda`.`tb_invoice` join `db_armanda`.`tb_customer` on((`db_armanda`.`tb_invoice`.`customer_id` = `db_armanda`.`tb_customer`.`id`))) left join `db_armanda`.`tb_kuitansi` on((`db_armanda`.`tb_kuitansi`.`invoice_id` = `db_armanda`.`tb_invoice`.`id`))) where (`db_armanda`.`tb_invoice`.`ppn` <> 0);

--
-- Dumping data for table `view5`
--

INSERT INTO `view5` (`id`, `customer_id`, `no_invoice`, `tgl_invoice`, `no_order`, `no_referensi`, `kegiatan`, `tgl_pelaksanaan`, `no_sertifikat`, `keterangan`, `total`, `ppn`, `total_ppn`, `terbilang`, `nama`, `no_kuitansi`) VALUES
(2, 1, 'q123', '2016-12-20', NULL, NULL, NULL, NULL, NULL, NULL, 555000.00, 10, 610500.00, ' enam ratus sepuluh ribu lima ratus ', 'PT. Angkasa Buana Cipta', NULL),
(3, 1, '007', '2016-12-20', '7', '8', 'tes', '2016-12-21', '9', '-', 56000.00, 10, 61600.00, ' enam puluh satu ribu enam ratus ', 'PT. Angkasa Buana Cipta', 'x2x2'),
(4, 2, 'mjs123', '2016-12-20', NULL, NULL, NULL, NULL, NULL, NULL, 60000.00, 10, 66000.00, ' enam puluh enam ribu ', 'MJS, PT', NULL);

-- --------------------------------------------------------

--
-- Structure for view `cetak_invoice_fee`
--
DROP TABLE IF EXISTS `cetak_invoice_fee`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cetak_invoice_fee` AS select `tb_customer`.`nama` AS `nama`,`tb_customer`.`alamat` AS `alamat`,`tb_customer`.`kota` AS `kota`,`tb_customer`.`kodepos` AS `kodepos`,`tb_customer`.`no_npwp` AS `no_npwp`,`tb_invoice`.`no_invoice` AS `no_invoice`,`tb_invoice`.`tgl_invoice` AS `tgl_invoice`,`tb_invoice`.`no_order` AS `no_order`,`tb_invoice`.`no_referensi` AS `no_referensi`,`tb_invoice`.`kegiatan` AS `kegiatan`,`tb_invoice`.`no_sertifikat` AS `no_sertifikat`,`tb_invoice`.`keterangan` AS `keterangan`,`tb_invoice`.`total` AS `total`,`tb_invoice`.`ppn` AS `ppn`,`tb_invoice`.`total_ppn` AS `total_ppn`,`tb_invoice`.`terbilang` AS `terbilang`,`tb_invoice`.`terbayar` AS `terbayar`,`tb_invoice`.`pasal23` AS `pasal23`,`tb_invoice`.`no_kuitansi` AS `no_kuitansi`,`tb_fee`.`barang_id` AS `barang_id`,`tb_fee`.`harga` AS `harga`,`tb_fee`.`qty` AS `qty`,`tb_fee`.`satuan` AS `satuan`,`tb_fee`.`jumlah` AS `jumlah`,`tb_fee`.`keterangan` AS `keterangan1`,`tb_barang`.`nama` AS `nama1`,`tb_invoice`.`id` AS `id` from (((`tb_invoice` join `tb_customer` on((`tb_invoice`.`customer_id` = `tb_customer`.`id`))) join `tb_fee` on((`tb_invoice`.`id` = `tb_fee`.`invoice_id`))) join `tb_barang` on((`tb_fee`.`barang_id` = `tb_barang`.`barang_id`)));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
