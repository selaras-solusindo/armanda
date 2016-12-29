select * from tb_invoice where id not in (select invoice_id from tb_kuitansi)
