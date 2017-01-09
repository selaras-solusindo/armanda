SELECT tb_invoice.id,
  tb_pelaksanaan.pelaksanaan_tgl
FROM tb_invoice
  INNER JOIN tb_pelaksanaan ON tb_invoice.id = tb_pelaksanaan.invoice_id
