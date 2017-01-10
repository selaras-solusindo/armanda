-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 10, 2017 at 09:23 AM
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
