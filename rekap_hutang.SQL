Select tb_customer.nama As nama,
  tb_kuitansi.no_kuitansi As no_kuitansi,
  tb_invoice.no_invoice As no_invoice,
  tb_invoice.total_ppn As total_ppn,
  tb_invoice.tgl_pelaksanaan As tgl_pelaksanaan
From (tb_invoice
  Left Join tb_customer On tb_invoice.customer_id = tb_customer.id)
  Left Join tb_kuitansi On tb_kuitansi.invoice_id = tb_invoice.id
Where tb_invoice.terbayar = 0