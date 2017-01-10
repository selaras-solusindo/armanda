Select tb_invoice.id As id,
  tb_invoice.customer_id As customer_id,
  tb_invoice.no_invoice As no_invoice,
  tb_invoice.tgl_invoice As tgl_invoice,
  tb_invoice.no_order As no_order,
  tb_invoice.no_referensi As no_referensi,
  tb_invoice.kegiatan As kegiatan,
  tb_invoice.tgl_pelaksanaan As tgl_pelaksanaan,
  tb_invoice.no_sertifikat As no_sertifikat,
  tb_invoice.keterangan As keterangan,
  tb_invoice.total As total,
  tb_invoice.ppn As ppn,
  tb_invoice.total_ppn As total_ppn,
  tb_invoice.terbilang As terbilang,
  tb_customer.nama As nama,
  tb_invoice.no_kuitansi As no_kuitansi,
  (tb_invoice.ppn / 100) * tb_invoice.total As ppn_nilai
From (tb_invoice
  Join tb_customer On tb_invoice.customer_id = tb_customer.id)
  Left Join tb_kuitansi On tb_kuitansi.invoice_id = tb_invoice.id
Where tb_invoice.ppn <> 0
