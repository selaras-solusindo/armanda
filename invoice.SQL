Select tb_customer.nama,
  tb_customer.alamat,
  tb_customer.kota,
  tb_customer.kodepos,
  tb_customer.no_npwp,
  tb_invoice.*,
  tb_fee.harga,
  tb_fee.qty,
  tb_fee.satuan,
  tb_fee.jumlah,
  tb_fee.keterangan As keterangan1
From tb_customer
  Inner Join tb_invoice On tb_invoice.customer_id = tb_customer.id
  Inner Join tb_fee On tb_invoice.id = tb_fee.invoice_id
