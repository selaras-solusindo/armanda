-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 10, 2017 at 09:24 AM
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
