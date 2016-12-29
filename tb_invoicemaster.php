<?php

// customer_id
// no_invoice
// tgl_invoice
// no_order
// no_referensi
// kegiatan
// tgl_pelaksanaan
// no_sertifikat
// keterangan
// total
// ppn
// total_ppn
// terbilang
// terbayar
// pasal23

?>
<?php if ($tb_invoice->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $tb_invoice->TableCaption() ?></h4> -->
<table id="tbl_tb_invoicemaster" class="table table-bordered table-striped ewViewTable">
<?php echo $tb_invoice->TableCustomInnerHtml ?>
	<tbody>
<?php if ($tb_invoice->customer_id->Visible) { // customer_id ?>
		<tr id="r_customer_id">
			<td><?php echo $tb_invoice->customer_id->FldCaption() ?></td>
			<td<?php echo $tb_invoice->customer_id->CellAttributes() ?>>
<span id="el_tb_invoice_customer_id">
<span<?php echo $tb_invoice->customer_id->ViewAttributes() ?>>
<?php echo $tb_invoice->customer_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tb_invoice->no_invoice->Visible) { // no_invoice ?>
		<tr id="r_no_invoice">
			<td><?php echo $tb_invoice->no_invoice->FldCaption() ?></td>
			<td<?php echo $tb_invoice->no_invoice->CellAttributes() ?>>
<span id="el_tb_invoice_no_invoice">
<span<?php echo $tb_invoice->no_invoice->ViewAttributes() ?>>
<?php echo $tb_invoice->no_invoice->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tb_invoice->tgl_invoice->Visible) { // tgl_invoice ?>
		<tr id="r_tgl_invoice">
			<td><?php echo $tb_invoice->tgl_invoice->FldCaption() ?></td>
			<td<?php echo $tb_invoice->tgl_invoice->CellAttributes() ?>>
<span id="el_tb_invoice_tgl_invoice">
<span<?php echo $tb_invoice->tgl_invoice->ViewAttributes() ?>>
<?php echo $tb_invoice->tgl_invoice->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tb_invoice->no_order->Visible) { // no_order ?>
		<tr id="r_no_order">
			<td><?php echo $tb_invoice->no_order->FldCaption() ?></td>
			<td<?php echo $tb_invoice->no_order->CellAttributes() ?>>
<span id="el_tb_invoice_no_order">
<span<?php echo $tb_invoice->no_order->ViewAttributes() ?>>
<?php echo $tb_invoice->no_order->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tb_invoice->no_referensi->Visible) { // no_referensi ?>
		<tr id="r_no_referensi">
			<td><?php echo $tb_invoice->no_referensi->FldCaption() ?></td>
			<td<?php echo $tb_invoice->no_referensi->CellAttributes() ?>>
<span id="el_tb_invoice_no_referensi">
<span<?php echo $tb_invoice->no_referensi->ViewAttributes() ?>>
<?php echo $tb_invoice->no_referensi->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tb_invoice->kegiatan->Visible) { // kegiatan ?>
		<tr id="r_kegiatan">
			<td><?php echo $tb_invoice->kegiatan->FldCaption() ?></td>
			<td<?php echo $tb_invoice->kegiatan->CellAttributes() ?>>
<span id="el_tb_invoice_kegiatan">
<span<?php echo $tb_invoice->kegiatan->ViewAttributes() ?>>
<?php echo $tb_invoice->kegiatan->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tb_invoice->tgl_pelaksanaan->Visible) { // tgl_pelaksanaan ?>
		<tr id="r_tgl_pelaksanaan">
			<td><?php echo $tb_invoice->tgl_pelaksanaan->FldCaption() ?></td>
			<td<?php echo $tb_invoice->tgl_pelaksanaan->CellAttributes() ?>>
<span id="el_tb_invoice_tgl_pelaksanaan">
<span<?php echo $tb_invoice->tgl_pelaksanaan->ViewAttributes() ?>>
<?php echo $tb_invoice->tgl_pelaksanaan->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tb_invoice->no_sertifikat->Visible) { // no_sertifikat ?>
		<tr id="r_no_sertifikat">
			<td><?php echo $tb_invoice->no_sertifikat->FldCaption() ?></td>
			<td<?php echo $tb_invoice->no_sertifikat->CellAttributes() ?>>
<span id="el_tb_invoice_no_sertifikat">
<span<?php echo $tb_invoice->no_sertifikat->ViewAttributes() ?>>
<?php echo $tb_invoice->no_sertifikat->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tb_invoice->keterangan->Visible) { // keterangan ?>
		<tr id="r_keterangan">
			<td><?php echo $tb_invoice->keterangan->FldCaption() ?></td>
			<td<?php echo $tb_invoice->keterangan->CellAttributes() ?>>
<span id="el_tb_invoice_keterangan">
<span<?php echo $tb_invoice->keterangan->ViewAttributes() ?>>
<?php echo $tb_invoice->keterangan->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tb_invoice->total->Visible) { // total ?>
		<tr id="r_total">
			<td><?php echo $tb_invoice->total->FldCaption() ?></td>
			<td<?php echo $tb_invoice->total->CellAttributes() ?>>
<span id="el_tb_invoice_total">
<span<?php echo $tb_invoice->total->ViewAttributes() ?>>
<?php echo $tb_invoice->total->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tb_invoice->ppn->Visible) { // ppn ?>
		<tr id="r_ppn">
			<td><?php echo $tb_invoice->ppn->FldCaption() ?></td>
			<td<?php echo $tb_invoice->ppn->CellAttributes() ?>>
<span id="el_tb_invoice_ppn">
<span<?php echo $tb_invoice->ppn->ViewAttributes() ?>>
<?php echo $tb_invoice->ppn->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tb_invoice->total_ppn->Visible) { // total_ppn ?>
		<tr id="r_total_ppn">
			<td><?php echo $tb_invoice->total_ppn->FldCaption() ?></td>
			<td<?php echo $tb_invoice->total_ppn->CellAttributes() ?>>
<span id="el_tb_invoice_total_ppn">
<span<?php echo $tb_invoice->total_ppn->ViewAttributes() ?>>
<?php echo $tb_invoice->total_ppn->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tb_invoice->terbilang->Visible) { // terbilang ?>
		<tr id="r_terbilang">
			<td><?php echo $tb_invoice->terbilang->FldCaption() ?></td>
			<td<?php echo $tb_invoice->terbilang->CellAttributes() ?>>
<span id="el_tb_invoice_terbilang">
<span<?php echo $tb_invoice->terbilang->ViewAttributes() ?>>
<?php echo $tb_invoice->terbilang->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tb_invoice->terbayar->Visible) { // terbayar ?>
		<tr id="r_terbayar">
			<td><?php echo $tb_invoice->terbayar->FldCaption() ?></td>
			<td<?php echo $tb_invoice->terbayar->CellAttributes() ?>>
<span id="el_tb_invoice_terbayar">
<span<?php echo $tb_invoice->terbayar->ViewAttributes() ?>>
<?php echo $tb_invoice->terbayar->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tb_invoice->pasal23->Visible) { // pasal23 ?>
		<tr id="r_pasal23">
			<td><?php echo $tb_invoice->pasal23->FldCaption() ?></td>
			<td<?php echo $tb_invoice->pasal23->CellAttributes() ?>>
<span id="el_tb_invoice_pasal23">
<span<?php echo $tb_invoice->pasal23->ViewAttributes() ?>>
<?php echo $tb_invoice->pasal23->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
