Select tb_customer.nama As nama,
  tb_invoice.no_invoice As no_invoice,
  tb_invoice.total_ppn As total_ppn,
  tb_invoice.tgl_pelaksanaan As tgl_pelaksanaan,
  tb_invoice.no_kuitansi
From tb_invoice
  Left Join tb_customer On tb_invoice.customer_id = tb_customer.id
Where tb_invoice.terbayar = 0
