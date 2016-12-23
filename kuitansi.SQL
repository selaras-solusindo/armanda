SELECT tb_kuitansi.*,
  tb_customer.nama,
  tb_invoice.total_ppn AS total_ppn1,
  tb_invoice.terbilang AS terbilang1,
  tb_invoice.keterangan AS keterangan1,
  tb_invoice.no_invoice,
  tb_invoice.tgl_invoice,
  tb_invoice.no_sertifikat
FROM tb_kuitansi
  INNER JOIN tb_invoice ON tb_kuitansi.invoice_id = tb_invoice.id
  INNER JOIN tb_customer ON tb_invoice.customer_id = tb_customer.id
