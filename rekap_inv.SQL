SELECT tb_invoice.id AS id,
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
  tb_customer.nama AS nama,
  tb_kuitansi.no_kuitansi AS no_kuitansi
FROM (tb_invoice
  JOIN tb_customer ON tb_invoice.customer_id = tb_customer.id)
  LEFT JOIN tb_kuitansi ON tb_kuitansi.invoice_id = tb_invoice.id
