SELECT tb_customer.nama AS nama,
  tb_customer.alamat AS alamat,
  tb_customer.kota AS kota,
  tb_customer.kodepos AS kodepos,
  tb_customer.no_npwp AS no_npwp,
  tb_invoice.id AS id,
  tb_invoice.customer_id AS customer_id,
  tb_invoice.no_invoice AS no_invoice,
  tb_invoice.tgl_invoice AS tgl_invoice,
  tb_invoice.no_order AS no_order,
  tb_invoice.no_referensi AS no_referensi,
  tb_invoice.kegiatan AS kegiatan,
  tb_invoice.tgl_pelaksanaan AS tgl_pelaksanaan,
  tb_invoice.no_sertifikat AS no_sertifikat,
  tb_invoice.keterangan AS keterangan,
  tb_invoice.total AS total,
  tb_invoice.ppn AS ppn,
  tb_invoice.total_ppn AS total_ppn,
  tb_invoice.terbilang AS terbilang,
  tb_fee.harga AS harga,
  tb_fee.qty AS qty,
  tb_fee.satuan AS satuan,
  tb_fee.jumlah AS jumlah,
  tb_fee.keterangan AS keterangan1,
  tb_barang.nama AS nama1
FROM (tb_customer
  JOIN tb_invoice ON tb_invoice.customer_id = tb_customer.id)
  JOIN tb_fee ON tb_invoice.id = tb_fee.invoice_id
  INNER JOIN tb_barang ON tb_fee.barang_id = tb_barang.barang_id
