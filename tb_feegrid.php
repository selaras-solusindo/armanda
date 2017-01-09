<?php include_once "tb_userinfo.php" ?>
<?php

// Create page object
if (!isset($tb_fee_grid)) $tb_fee_grid = new ctb_fee_grid();

// Page init
$tb_fee_grid->Page_Init();

// Page main
$tb_fee_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_fee_grid->Page_Render();
?>
<?php if ($tb_fee->Export == "") { ?>
<script type="text/javascript">

// Form object
var ftb_feegrid = new ew_Form("ftb_feegrid", "grid");
ftb_feegrid.FormKeyCountName = '<?php echo $tb_fee_grid->FormKeyCountName ?>';

// Validate form
ftb_feegrid.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_invoice_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tb_fee->invoice_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_barang_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_fee->barang_id->FldCaption(), $tb_fee->barang_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_harga");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tb_fee->harga->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_qty");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tb_fee->qty->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_jumlah");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tb_fee->jumlah->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ftb_feegrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "invoice_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "barang_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "harga", false)) return false;
	if (ew_ValueChanged(fobj, infix, "qty", false)) return false;
	if (ew_ValueChanged(fobj, infix, "satuan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "jumlah", false)) return false;
	if (ew_ValueChanged(fobj, infix, "keterangan", false)) return false;
	return true;
}

// Form_CustomValidate event
ftb_feegrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftb_feegrid.ValidateRequired = true;
<?php } else { ?>
ftb_feegrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftb_feegrid.Lists["x_barang_id"] = {"LinkField":"x_barang_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tb_barang"};

// Form object for search
</script>
<?php } ?>
<?php
if ($tb_fee->CurrentAction == "gridadd") {
	if ($tb_fee->CurrentMode == "copy") {
		$bSelectLimit = $tb_fee_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$tb_fee_grid->TotalRecs = $tb_fee->SelectRecordCount();
			$tb_fee_grid->Recordset = $tb_fee_grid->LoadRecordset($tb_fee_grid->StartRec-1, $tb_fee_grid->DisplayRecs);
		} else {
			if ($tb_fee_grid->Recordset = $tb_fee_grid->LoadRecordset())
				$tb_fee_grid->TotalRecs = $tb_fee_grid->Recordset->RecordCount();
		}
		$tb_fee_grid->StartRec = 1;
		$tb_fee_grid->DisplayRecs = $tb_fee_grid->TotalRecs;
	} else {
		$tb_fee->CurrentFilter = "0=1";
		$tb_fee_grid->StartRec = 1;
		$tb_fee_grid->DisplayRecs = $tb_fee->GridAddRowCount;
	}
	$tb_fee_grid->TotalRecs = $tb_fee_grid->DisplayRecs;
	$tb_fee_grid->StopRec = $tb_fee_grid->DisplayRecs;
} else {
	$bSelectLimit = $tb_fee_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($tb_fee_grid->TotalRecs <= 0)
			$tb_fee_grid->TotalRecs = $tb_fee->SelectRecordCount();
	} else {
		if (!$tb_fee_grid->Recordset && ($tb_fee_grid->Recordset = $tb_fee_grid->LoadRecordset()))
			$tb_fee_grid->TotalRecs = $tb_fee_grid->Recordset->RecordCount();
	}
	$tb_fee_grid->StartRec = 1;
	$tb_fee_grid->DisplayRecs = $tb_fee_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$tb_fee_grid->Recordset = $tb_fee_grid->LoadRecordset($tb_fee_grid->StartRec-1, $tb_fee_grid->DisplayRecs);

	// Set no record found message
	if ($tb_fee->CurrentAction == "" && $tb_fee_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$tb_fee_grid->setWarningMessage(ew_DeniedMsg());
		if ($tb_fee_grid->SearchWhere == "0=101")
			$tb_fee_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$tb_fee_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$tb_fee_grid->RenderOtherOptions();
?>
<?php $tb_fee_grid->ShowPageHeader(); ?>
<?php
$tb_fee_grid->ShowMessage();
?>
<?php if ($tb_fee_grid->TotalRecs > 0 || $tb_fee->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid tb_fee">
<div id="ftb_feegrid" class="ewForm form-inline">
<div id="gmp_tb_fee" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_tb_feegrid" class="table ewTable">
<?php echo $tb_fee->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$tb_fee_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$tb_fee_grid->RenderListOptions();

// Render list options (header, left)
$tb_fee_grid->ListOptions->Render("header", "left");
?>
<?php if ($tb_fee->invoice_id->Visible) { // invoice_id ?>
	<?php if ($tb_fee->SortUrl($tb_fee->invoice_id) == "") { ?>
		<th data-name="invoice_id"><div id="elh_tb_fee_invoice_id" class="tb_fee_invoice_id"><div class="ewTableHeaderCaption"><?php echo $tb_fee->invoice_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="invoice_id"><div><div id="elh_tb_fee_invoice_id" class="tb_fee_invoice_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_fee->invoice_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_fee->invoice_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_fee->invoice_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tb_fee->barang_id->Visible) { // barang_id ?>
	<?php if ($tb_fee->SortUrl($tb_fee->barang_id) == "") { ?>
		<th data-name="barang_id"><div id="elh_tb_fee_barang_id" class="tb_fee_barang_id"><div class="ewTableHeaderCaption"><?php echo $tb_fee->barang_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="barang_id"><div><div id="elh_tb_fee_barang_id" class="tb_fee_barang_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_fee->barang_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_fee->barang_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_fee->barang_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tb_fee->harga->Visible) { // harga ?>
	<?php if ($tb_fee->SortUrl($tb_fee->harga) == "") { ?>
		<th data-name="harga"><div id="elh_tb_fee_harga" class="tb_fee_harga"><div class="ewTableHeaderCaption"><?php echo $tb_fee->harga->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="harga"><div><div id="elh_tb_fee_harga" class="tb_fee_harga">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_fee->harga->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_fee->harga->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_fee->harga->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tb_fee->qty->Visible) { // qty ?>
	<?php if ($tb_fee->SortUrl($tb_fee->qty) == "") { ?>
		<th data-name="qty"><div id="elh_tb_fee_qty" class="tb_fee_qty"><div class="ewTableHeaderCaption"><?php echo $tb_fee->qty->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="qty"><div><div id="elh_tb_fee_qty" class="tb_fee_qty">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_fee->qty->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_fee->qty->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_fee->qty->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tb_fee->satuan->Visible) { // satuan ?>
	<?php if ($tb_fee->SortUrl($tb_fee->satuan) == "") { ?>
		<th data-name="satuan"><div id="elh_tb_fee_satuan" class="tb_fee_satuan"><div class="ewTableHeaderCaption"><?php echo $tb_fee->satuan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="satuan"><div><div id="elh_tb_fee_satuan" class="tb_fee_satuan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_fee->satuan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_fee->satuan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_fee->satuan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tb_fee->jumlah->Visible) { // jumlah ?>
	<?php if ($tb_fee->SortUrl($tb_fee->jumlah) == "") { ?>
		<th data-name="jumlah"><div id="elh_tb_fee_jumlah" class="tb_fee_jumlah"><div class="ewTableHeaderCaption"><?php echo $tb_fee->jumlah->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jumlah"><div><div id="elh_tb_fee_jumlah" class="tb_fee_jumlah">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_fee->jumlah->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_fee->jumlah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_fee->jumlah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tb_fee->keterangan->Visible) { // keterangan ?>
	<?php if ($tb_fee->SortUrl($tb_fee->keterangan) == "") { ?>
		<th data-name="keterangan"><div id="elh_tb_fee_keterangan" class="tb_fee_keterangan"><div class="ewTableHeaderCaption"><?php echo $tb_fee->keterangan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="keterangan"><div><div id="elh_tb_fee_keterangan" class="tb_fee_keterangan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_fee->keterangan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_fee->keterangan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_fee->keterangan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$tb_fee_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$tb_fee_grid->StartRec = 1;
$tb_fee_grid->StopRec = $tb_fee_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($tb_fee_grid->FormKeyCountName) && ($tb_fee->CurrentAction == "gridadd" || $tb_fee->CurrentAction == "gridedit" || $tb_fee->CurrentAction == "F")) {
		$tb_fee_grid->KeyCount = $objForm->GetValue($tb_fee_grid->FormKeyCountName);
		$tb_fee_grid->StopRec = $tb_fee_grid->StartRec + $tb_fee_grid->KeyCount - 1;
	}
}
$tb_fee_grid->RecCnt = $tb_fee_grid->StartRec - 1;
if ($tb_fee_grid->Recordset && !$tb_fee_grid->Recordset->EOF) {
	$tb_fee_grid->Recordset->MoveFirst();
	$bSelectLimit = $tb_fee_grid->UseSelectLimit;
	if (!$bSelectLimit && $tb_fee_grid->StartRec > 1)
		$tb_fee_grid->Recordset->Move($tb_fee_grid->StartRec - 1);
} elseif (!$tb_fee->AllowAddDeleteRow && $tb_fee_grid->StopRec == 0) {
	$tb_fee_grid->StopRec = $tb_fee->GridAddRowCount;
}

// Initialize aggregate
$tb_fee->RowType = EW_ROWTYPE_AGGREGATEINIT;
$tb_fee->ResetAttrs();
$tb_fee_grid->RenderRow();
if ($tb_fee->CurrentAction == "gridadd")
	$tb_fee_grid->RowIndex = 0;
if ($tb_fee->CurrentAction == "gridedit")
	$tb_fee_grid->RowIndex = 0;
while ($tb_fee_grid->RecCnt < $tb_fee_grid->StopRec) {
	$tb_fee_grid->RecCnt++;
	if (intval($tb_fee_grid->RecCnt) >= intval($tb_fee_grid->StartRec)) {
		$tb_fee_grid->RowCnt++;
		if ($tb_fee->CurrentAction == "gridadd" || $tb_fee->CurrentAction == "gridedit" || $tb_fee->CurrentAction == "F") {
			$tb_fee_grid->RowIndex++;
			$objForm->Index = $tb_fee_grid->RowIndex;
			if ($objForm->HasValue($tb_fee_grid->FormActionName))
				$tb_fee_grid->RowAction = strval($objForm->GetValue($tb_fee_grid->FormActionName));
			elseif ($tb_fee->CurrentAction == "gridadd")
				$tb_fee_grid->RowAction = "insert";
			else
				$tb_fee_grid->RowAction = "";
		}

		// Set up key count
		$tb_fee_grid->KeyCount = $tb_fee_grid->RowIndex;

		// Init row class and style
		$tb_fee->ResetAttrs();
		$tb_fee->CssClass = "";
		if ($tb_fee->CurrentAction == "gridadd") {
			if ($tb_fee->CurrentMode == "copy") {
				$tb_fee_grid->LoadRowValues($tb_fee_grid->Recordset); // Load row values
				$tb_fee_grid->SetRecordKey($tb_fee_grid->RowOldKey, $tb_fee_grid->Recordset); // Set old record key
			} else {
				$tb_fee_grid->LoadDefaultValues(); // Load default values
				$tb_fee_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$tb_fee_grid->LoadRowValues($tb_fee_grid->Recordset); // Load row values
		}
		$tb_fee->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($tb_fee->CurrentAction == "gridadd") // Grid add
			$tb_fee->RowType = EW_ROWTYPE_ADD; // Render add
		if ($tb_fee->CurrentAction == "gridadd" && $tb_fee->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$tb_fee_grid->RestoreCurrentRowFormValues($tb_fee_grid->RowIndex); // Restore form values
		if ($tb_fee->CurrentAction == "gridedit") { // Grid edit
			if ($tb_fee->EventCancelled) {
				$tb_fee_grid->RestoreCurrentRowFormValues($tb_fee_grid->RowIndex); // Restore form values
			}
			if ($tb_fee_grid->RowAction == "insert")
				$tb_fee->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$tb_fee->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($tb_fee->CurrentAction == "gridedit" && ($tb_fee->RowType == EW_ROWTYPE_EDIT || $tb_fee->RowType == EW_ROWTYPE_ADD) && $tb_fee->EventCancelled) // Update failed
			$tb_fee_grid->RestoreCurrentRowFormValues($tb_fee_grid->RowIndex); // Restore form values
		if ($tb_fee->RowType == EW_ROWTYPE_EDIT) // Edit row
			$tb_fee_grid->EditRowCnt++;
		if ($tb_fee->CurrentAction == "F") // Confirm row
			$tb_fee_grid->RestoreCurrentRowFormValues($tb_fee_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$tb_fee->RowAttrs = array_merge($tb_fee->RowAttrs, array('data-rowindex'=>$tb_fee_grid->RowCnt, 'id'=>'r' . $tb_fee_grid->RowCnt . '_tb_fee', 'data-rowtype'=>$tb_fee->RowType));

		// Render row
		$tb_fee_grid->RenderRow();

		// Render list options
		$tb_fee_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($tb_fee_grid->RowAction <> "delete" && $tb_fee_grid->RowAction <> "insertdelete" && !($tb_fee_grid->RowAction == "insert" && $tb_fee->CurrentAction == "F" && $tb_fee_grid->EmptyRow())) {
?>
	<tr<?php echo $tb_fee->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tb_fee_grid->ListOptions->Render("body", "left", $tb_fee_grid->RowCnt);
?>
	<?php if ($tb_fee->invoice_id->Visible) { // invoice_id ?>
		<td data-name="invoice_id"<?php echo $tb_fee->invoice_id->CellAttributes() ?>>
<?php if ($tb_fee->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($tb_fee->invoice_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $tb_fee_grid->RowCnt ?>_tb_fee_invoice_id" class="form-group tb_fee_invoice_id">
<span<?php echo $tb_fee->invoice_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_fee->invoice_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $tb_fee_grid->RowIndex ?>_invoice_id" name="x<?php echo $tb_fee_grid->RowIndex ?>_invoice_id" value="<?php echo ew_HtmlEncode($tb_fee->invoice_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $tb_fee_grid->RowCnt ?>_tb_fee_invoice_id" class="form-group tb_fee_invoice_id">
<input type="text" data-table="tb_fee" data-field="x_invoice_id" name="x<?php echo $tb_fee_grid->RowIndex ?>_invoice_id" id="x<?php echo $tb_fee_grid->RowIndex ?>_invoice_id" size="30" placeholder="<?php echo ew_HtmlEncode($tb_fee->invoice_id->getPlaceHolder()) ?>" value="<?php echo $tb_fee->invoice_id->EditValue ?>"<?php echo $tb_fee->invoice_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="tb_fee" data-field="x_invoice_id" name="o<?php echo $tb_fee_grid->RowIndex ?>_invoice_id" id="o<?php echo $tb_fee_grid->RowIndex ?>_invoice_id" value="<?php echo ew_HtmlEncode($tb_fee->invoice_id->OldValue) ?>">
<?php } ?>
<?php if ($tb_fee->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($tb_fee->invoice_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $tb_fee_grid->RowCnt ?>_tb_fee_invoice_id" class="form-group tb_fee_invoice_id">
<span<?php echo $tb_fee->invoice_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_fee->invoice_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $tb_fee_grid->RowIndex ?>_invoice_id" name="x<?php echo $tb_fee_grid->RowIndex ?>_invoice_id" value="<?php echo ew_HtmlEncode($tb_fee->invoice_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $tb_fee_grid->RowCnt ?>_tb_fee_invoice_id" class="form-group tb_fee_invoice_id">
<input type="text" data-table="tb_fee" data-field="x_invoice_id" name="x<?php echo $tb_fee_grid->RowIndex ?>_invoice_id" id="x<?php echo $tb_fee_grid->RowIndex ?>_invoice_id" size="30" placeholder="<?php echo ew_HtmlEncode($tb_fee->invoice_id->getPlaceHolder()) ?>" value="<?php echo $tb_fee->invoice_id->EditValue ?>"<?php echo $tb_fee->invoice_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($tb_fee->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tb_fee_grid->RowCnt ?>_tb_fee_invoice_id" class="tb_fee_invoice_id">
<span<?php echo $tb_fee->invoice_id->ViewAttributes() ?>>
<?php echo $tb_fee->invoice_id->ListViewValue() ?></span>
</span>
<?php if ($tb_fee->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tb_fee" data-field="x_invoice_id" name="x<?php echo $tb_fee_grid->RowIndex ?>_invoice_id" id="x<?php echo $tb_fee_grid->RowIndex ?>_invoice_id" value="<?php echo ew_HtmlEncode($tb_fee->invoice_id->FormValue) ?>">
<input type="hidden" data-table="tb_fee" data-field="x_invoice_id" name="o<?php echo $tb_fee_grid->RowIndex ?>_invoice_id" id="o<?php echo $tb_fee_grid->RowIndex ?>_invoice_id" value="<?php echo ew_HtmlEncode($tb_fee->invoice_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tb_fee" data-field="x_invoice_id" name="ftb_feegrid$x<?php echo $tb_fee_grid->RowIndex ?>_invoice_id" id="ftb_feegrid$x<?php echo $tb_fee_grid->RowIndex ?>_invoice_id" value="<?php echo ew_HtmlEncode($tb_fee->invoice_id->FormValue) ?>">
<input type="hidden" data-table="tb_fee" data-field="x_invoice_id" name="ftb_feegrid$o<?php echo $tb_fee_grid->RowIndex ?>_invoice_id" id="ftb_feegrid$o<?php echo $tb_fee_grid->RowIndex ?>_invoice_id" value="<?php echo ew_HtmlEncode($tb_fee->invoice_id->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $tb_fee_grid->PageObjName . "_row_" . $tb_fee_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($tb_fee->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="tb_fee" data-field="x_id" name="x<?php echo $tb_fee_grid->RowIndex ?>_id" id="x<?php echo $tb_fee_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($tb_fee->id->CurrentValue) ?>">
<input type="hidden" data-table="tb_fee" data-field="x_id" name="o<?php echo $tb_fee_grid->RowIndex ?>_id" id="o<?php echo $tb_fee_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($tb_fee->id->OldValue) ?>">
<?php } ?>
<?php if ($tb_fee->RowType == EW_ROWTYPE_EDIT || $tb_fee->CurrentMode == "edit") { ?>
<input type="hidden" data-table="tb_fee" data-field="x_id" name="x<?php echo $tb_fee_grid->RowIndex ?>_id" id="x<?php echo $tb_fee_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($tb_fee->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($tb_fee->barang_id->Visible) { // barang_id ?>
		<td data-name="barang_id"<?php echo $tb_fee->barang_id->CellAttributes() ?>>
<?php if ($tb_fee->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tb_fee_grid->RowCnt ?>_tb_fee_barang_id" class="form-group tb_fee_barang_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $tb_fee_grid->RowIndex ?>_barang_id"><?php echo (strval($tb_fee->barang_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $tb_fee->barang_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_fee->barang_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $tb_fee_grid->RowIndex ?>_barang_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="tb_fee" data-field="x_barang_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_fee->barang_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tb_fee_grid->RowIndex ?>_barang_id" id="x<?php echo $tb_fee_grid->RowIndex ?>_barang_id" value="<?php echo $tb_fee->barang_id->CurrentValue ?>"<?php echo $tb_fee->barang_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $tb_fee_grid->RowIndex ?>_barang_id" id="s_x<?php echo $tb_fee_grid->RowIndex ?>_barang_id" value="<?php echo $tb_fee->barang_id->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="tb_fee" data-field="x_barang_id" name="o<?php echo $tb_fee_grid->RowIndex ?>_barang_id" id="o<?php echo $tb_fee_grid->RowIndex ?>_barang_id" value="<?php echo ew_HtmlEncode($tb_fee->barang_id->OldValue) ?>">
<?php } ?>
<?php if ($tb_fee->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tb_fee_grid->RowCnt ?>_tb_fee_barang_id" class="form-group tb_fee_barang_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $tb_fee_grid->RowIndex ?>_barang_id"><?php echo (strval($tb_fee->barang_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $tb_fee->barang_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_fee->barang_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $tb_fee_grid->RowIndex ?>_barang_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="tb_fee" data-field="x_barang_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_fee->barang_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tb_fee_grid->RowIndex ?>_barang_id" id="x<?php echo $tb_fee_grid->RowIndex ?>_barang_id" value="<?php echo $tb_fee->barang_id->CurrentValue ?>"<?php echo $tb_fee->barang_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $tb_fee_grid->RowIndex ?>_barang_id" id="s_x<?php echo $tb_fee_grid->RowIndex ?>_barang_id" value="<?php echo $tb_fee->barang_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($tb_fee->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tb_fee_grid->RowCnt ?>_tb_fee_barang_id" class="tb_fee_barang_id">
<span<?php echo $tb_fee->barang_id->ViewAttributes() ?>>
<?php echo $tb_fee->barang_id->ListViewValue() ?></span>
</span>
<?php if ($tb_fee->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tb_fee" data-field="x_barang_id" name="x<?php echo $tb_fee_grid->RowIndex ?>_barang_id" id="x<?php echo $tb_fee_grid->RowIndex ?>_barang_id" value="<?php echo ew_HtmlEncode($tb_fee->barang_id->FormValue) ?>">
<input type="hidden" data-table="tb_fee" data-field="x_barang_id" name="o<?php echo $tb_fee_grid->RowIndex ?>_barang_id" id="o<?php echo $tb_fee_grid->RowIndex ?>_barang_id" value="<?php echo ew_HtmlEncode($tb_fee->barang_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tb_fee" data-field="x_barang_id" name="ftb_feegrid$x<?php echo $tb_fee_grid->RowIndex ?>_barang_id" id="ftb_feegrid$x<?php echo $tb_fee_grid->RowIndex ?>_barang_id" value="<?php echo ew_HtmlEncode($tb_fee->barang_id->FormValue) ?>">
<input type="hidden" data-table="tb_fee" data-field="x_barang_id" name="ftb_feegrid$o<?php echo $tb_fee_grid->RowIndex ?>_barang_id" id="ftb_feegrid$o<?php echo $tb_fee_grid->RowIndex ?>_barang_id" value="<?php echo ew_HtmlEncode($tb_fee->barang_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tb_fee->harga->Visible) { // harga ?>
		<td data-name="harga"<?php echo $tb_fee->harga->CellAttributes() ?>>
<?php if ($tb_fee->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tb_fee_grid->RowCnt ?>_tb_fee_harga" class="form-group tb_fee_harga">
<input type="text" data-table="tb_fee" data-field="x_harga" name="x<?php echo $tb_fee_grid->RowIndex ?>_harga" id="x<?php echo $tb_fee_grid->RowIndex ?>_harga" size="30" placeholder="<?php echo ew_HtmlEncode($tb_fee->harga->getPlaceHolder()) ?>" value="<?php echo $tb_fee->harga->EditValue ?>"<?php echo $tb_fee->harga->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_fee" data-field="x_harga" name="o<?php echo $tb_fee_grid->RowIndex ?>_harga" id="o<?php echo $tb_fee_grid->RowIndex ?>_harga" value="<?php echo ew_HtmlEncode($tb_fee->harga->OldValue) ?>">
<?php } ?>
<?php if ($tb_fee->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tb_fee_grid->RowCnt ?>_tb_fee_harga" class="form-group tb_fee_harga">
<input type="text" data-table="tb_fee" data-field="x_harga" name="x<?php echo $tb_fee_grid->RowIndex ?>_harga" id="x<?php echo $tb_fee_grid->RowIndex ?>_harga" size="30" placeholder="<?php echo ew_HtmlEncode($tb_fee->harga->getPlaceHolder()) ?>" value="<?php echo $tb_fee->harga->EditValue ?>"<?php echo $tb_fee->harga->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tb_fee->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tb_fee_grid->RowCnt ?>_tb_fee_harga" class="tb_fee_harga">
<span<?php echo $tb_fee->harga->ViewAttributes() ?>>
<?php echo $tb_fee->harga->ListViewValue() ?></span>
</span>
<?php if ($tb_fee->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tb_fee" data-field="x_harga" name="x<?php echo $tb_fee_grid->RowIndex ?>_harga" id="x<?php echo $tb_fee_grid->RowIndex ?>_harga" value="<?php echo ew_HtmlEncode($tb_fee->harga->FormValue) ?>">
<input type="hidden" data-table="tb_fee" data-field="x_harga" name="o<?php echo $tb_fee_grid->RowIndex ?>_harga" id="o<?php echo $tb_fee_grid->RowIndex ?>_harga" value="<?php echo ew_HtmlEncode($tb_fee->harga->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tb_fee" data-field="x_harga" name="ftb_feegrid$x<?php echo $tb_fee_grid->RowIndex ?>_harga" id="ftb_feegrid$x<?php echo $tb_fee_grid->RowIndex ?>_harga" value="<?php echo ew_HtmlEncode($tb_fee->harga->FormValue) ?>">
<input type="hidden" data-table="tb_fee" data-field="x_harga" name="ftb_feegrid$o<?php echo $tb_fee_grid->RowIndex ?>_harga" id="ftb_feegrid$o<?php echo $tb_fee_grid->RowIndex ?>_harga" value="<?php echo ew_HtmlEncode($tb_fee->harga->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tb_fee->qty->Visible) { // qty ?>
		<td data-name="qty"<?php echo $tb_fee->qty->CellAttributes() ?>>
<?php if ($tb_fee->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tb_fee_grid->RowCnt ?>_tb_fee_qty" class="form-group tb_fee_qty">
<input type="text" data-table="tb_fee" data-field="x_qty" name="x<?php echo $tb_fee_grid->RowIndex ?>_qty" id="x<?php echo $tb_fee_grid->RowIndex ?>_qty" size="30" placeholder="<?php echo ew_HtmlEncode($tb_fee->qty->getPlaceHolder()) ?>" value="<?php echo $tb_fee->qty->EditValue ?>"<?php echo $tb_fee->qty->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_fee" data-field="x_qty" name="o<?php echo $tb_fee_grid->RowIndex ?>_qty" id="o<?php echo $tb_fee_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($tb_fee->qty->OldValue) ?>">
<?php } ?>
<?php if ($tb_fee->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tb_fee_grid->RowCnt ?>_tb_fee_qty" class="form-group tb_fee_qty">
<input type="text" data-table="tb_fee" data-field="x_qty" name="x<?php echo $tb_fee_grid->RowIndex ?>_qty" id="x<?php echo $tb_fee_grid->RowIndex ?>_qty" size="30" placeholder="<?php echo ew_HtmlEncode($tb_fee->qty->getPlaceHolder()) ?>" value="<?php echo $tb_fee->qty->EditValue ?>"<?php echo $tb_fee->qty->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tb_fee->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tb_fee_grid->RowCnt ?>_tb_fee_qty" class="tb_fee_qty">
<span<?php echo $tb_fee->qty->ViewAttributes() ?>>
<?php echo $tb_fee->qty->ListViewValue() ?></span>
</span>
<?php if ($tb_fee->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tb_fee" data-field="x_qty" name="x<?php echo $tb_fee_grid->RowIndex ?>_qty" id="x<?php echo $tb_fee_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($tb_fee->qty->FormValue) ?>">
<input type="hidden" data-table="tb_fee" data-field="x_qty" name="o<?php echo $tb_fee_grid->RowIndex ?>_qty" id="o<?php echo $tb_fee_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($tb_fee->qty->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tb_fee" data-field="x_qty" name="ftb_feegrid$x<?php echo $tb_fee_grid->RowIndex ?>_qty" id="ftb_feegrid$x<?php echo $tb_fee_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($tb_fee->qty->FormValue) ?>">
<input type="hidden" data-table="tb_fee" data-field="x_qty" name="ftb_feegrid$o<?php echo $tb_fee_grid->RowIndex ?>_qty" id="ftb_feegrid$o<?php echo $tb_fee_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($tb_fee->qty->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tb_fee->satuan->Visible) { // satuan ?>
		<td data-name="satuan"<?php echo $tb_fee->satuan->CellAttributes() ?>>
<?php if ($tb_fee->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tb_fee_grid->RowCnt ?>_tb_fee_satuan" class="form-group tb_fee_satuan">
<input type="text" data-table="tb_fee" data-field="x_satuan" name="x<?php echo $tb_fee_grid->RowIndex ?>_satuan" id="x<?php echo $tb_fee_grid->RowIndex ?>_satuan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tb_fee->satuan->getPlaceHolder()) ?>" value="<?php echo $tb_fee->satuan->EditValue ?>"<?php echo $tb_fee->satuan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_fee" data-field="x_satuan" name="o<?php echo $tb_fee_grid->RowIndex ?>_satuan" id="o<?php echo $tb_fee_grid->RowIndex ?>_satuan" value="<?php echo ew_HtmlEncode($tb_fee->satuan->OldValue) ?>">
<?php } ?>
<?php if ($tb_fee->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tb_fee_grid->RowCnt ?>_tb_fee_satuan" class="form-group tb_fee_satuan">
<input type="text" data-table="tb_fee" data-field="x_satuan" name="x<?php echo $tb_fee_grid->RowIndex ?>_satuan" id="x<?php echo $tb_fee_grid->RowIndex ?>_satuan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tb_fee->satuan->getPlaceHolder()) ?>" value="<?php echo $tb_fee->satuan->EditValue ?>"<?php echo $tb_fee->satuan->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tb_fee->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tb_fee_grid->RowCnt ?>_tb_fee_satuan" class="tb_fee_satuan">
<span<?php echo $tb_fee->satuan->ViewAttributes() ?>>
<?php echo $tb_fee->satuan->ListViewValue() ?></span>
</span>
<?php if ($tb_fee->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tb_fee" data-field="x_satuan" name="x<?php echo $tb_fee_grid->RowIndex ?>_satuan" id="x<?php echo $tb_fee_grid->RowIndex ?>_satuan" value="<?php echo ew_HtmlEncode($tb_fee->satuan->FormValue) ?>">
<input type="hidden" data-table="tb_fee" data-field="x_satuan" name="o<?php echo $tb_fee_grid->RowIndex ?>_satuan" id="o<?php echo $tb_fee_grid->RowIndex ?>_satuan" value="<?php echo ew_HtmlEncode($tb_fee->satuan->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tb_fee" data-field="x_satuan" name="ftb_feegrid$x<?php echo $tb_fee_grid->RowIndex ?>_satuan" id="ftb_feegrid$x<?php echo $tb_fee_grid->RowIndex ?>_satuan" value="<?php echo ew_HtmlEncode($tb_fee->satuan->FormValue) ?>">
<input type="hidden" data-table="tb_fee" data-field="x_satuan" name="ftb_feegrid$o<?php echo $tb_fee_grid->RowIndex ?>_satuan" id="ftb_feegrid$o<?php echo $tb_fee_grid->RowIndex ?>_satuan" value="<?php echo ew_HtmlEncode($tb_fee->satuan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tb_fee->jumlah->Visible) { // jumlah ?>
		<td data-name="jumlah"<?php echo $tb_fee->jumlah->CellAttributes() ?>>
<?php if ($tb_fee->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tb_fee_grid->RowCnt ?>_tb_fee_jumlah" class="form-group tb_fee_jumlah">
<input type="text" data-table="tb_fee" data-field="x_jumlah" name="x<?php echo $tb_fee_grid->RowIndex ?>_jumlah" id="x<?php echo $tb_fee_grid->RowIndex ?>_jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($tb_fee->jumlah->getPlaceHolder()) ?>" value="<?php echo $tb_fee->jumlah->EditValue ?>"<?php echo $tb_fee->jumlah->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_fee" data-field="x_jumlah" name="o<?php echo $tb_fee_grid->RowIndex ?>_jumlah" id="o<?php echo $tb_fee_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($tb_fee->jumlah->OldValue) ?>">
<?php } ?>
<?php if ($tb_fee->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tb_fee_grid->RowCnt ?>_tb_fee_jumlah" class="form-group tb_fee_jumlah">
<input type="text" data-table="tb_fee" data-field="x_jumlah" name="x<?php echo $tb_fee_grid->RowIndex ?>_jumlah" id="x<?php echo $tb_fee_grid->RowIndex ?>_jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($tb_fee->jumlah->getPlaceHolder()) ?>" value="<?php echo $tb_fee->jumlah->EditValue ?>"<?php echo $tb_fee->jumlah->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tb_fee->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tb_fee_grid->RowCnt ?>_tb_fee_jumlah" class="tb_fee_jumlah">
<span<?php echo $tb_fee->jumlah->ViewAttributes() ?>>
<?php echo $tb_fee->jumlah->ListViewValue() ?></span>
</span>
<?php if ($tb_fee->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tb_fee" data-field="x_jumlah" name="x<?php echo $tb_fee_grid->RowIndex ?>_jumlah" id="x<?php echo $tb_fee_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($tb_fee->jumlah->FormValue) ?>">
<input type="hidden" data-table="tb_fee" data-field="x_jumlah" name="o<?php echo $tb_fee_grid->RowIndex ?>_jumlah" id="o<?php echo $tb_fee_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($tb_fee->jumlah->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tb_fee" data-field="x_jumlah" name="ftb_feegrid$x<?php echo $tb_fee_grid->RowIndex ?>_jumlah" id="ftb_feegrid$x<?php echo $tb_fee_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($tb_fee->jumlah->FormValue) ?>">
<input type="hidden" data-table="tb_fee" data-field="x_jumlah" name="ftb_feegrid$o<?php echo $tb_fee_grid->RowIndex ?>_jumlah" id="ftb_feegrid$o<?php echo $tb_fee_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($tb_fee->jumlah->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tb_fee->keterangan->Visible) { // keterangan ?>
		<td data-name="keterangan"<?php echo $tb_fee->keterangan->CellAttributes() ?>>
<?php if ($tb_fee->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tb_fee_grid->RowCnt ?>_tb_fee_keterangan" class="form-group tb_fee_keterangan">
<textarea data-table="tb_fee" data-field="x_keterangan" name="x<?php echo $tb_fee_grid->RowIndex ?>_keterangan" id="x<?php echo $tb_fee_grid->RowIndex ?>_keterangan" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($tb_fee->keterangan->getPlaceHolder()) ?>"<?php echo $tb_fee->keterangan->EditAttributes() ?>><?php echo $tb_fee->keterangan->EditValue ?></textarea>
</span>
<input type="hidden" data-table="tb_fee" data-field="x_keterangan" name="o<?php echo $tb_fee_grid->RowIndex ?>_keterangan" id="o<?php echo $tb_fee_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($tb_fee->keterangan->OldValue) ?>">
<?php } ?>
<?php if ($tb_fee->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tb_fee_grid->RowCnt ?>_tb_fee_keterangan" class="form-group tb_fee_keterangan">
<textarea data-table="tb_fee" data-field="x_keterangan" name="x<?php echo $tb_fee_grid->RowIndex ?>_keterangan" id="x<?php echo $tb_fee_grid->RowIndex ?>_keterangan" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($tb_fee->keterangan->getPlaceHolder()) ?>"<?php echo $tb_fee->keterangan->EditAttributes() ?>><?php echo $tb_fee->keterangan->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($tb_fee->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tb_fee_grid->RowCnt ?>_tb_fee_keterangan" class="tb_fee_keterangan">
<span<?php echo $tb_fee->keterangan->ViewAttributes() ?>>
<?php echo $tb_fee->keterangan->ListViewValue() ?></span>
</span>
<?php if ($tb_fee->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tb_fee" data-field="x_keterangan" name="x<?php echo $tb_fee_grid->RowIndex ?>_keterangan" id="x<?php echo $tb_fee_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($tb_fee->keterangan->FormValue) ?>">
<input type="hidden" data-table="tb_fee" data-field="x_keterangan" name="o<?php echo $tb_fee_grid->RowIndex ?>_keterangan" id="o<?php echo $tb_fee_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($tb_fee->keterangan->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tb_fee" data-field="x_keterangan" name="ftb_feegrid$x<?php echo $tb_fee_grid->RowIndex ?>_keterangan" id="ftb_feegrid$x<?php echo $tb_fee_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($tb_fee->keterangan->FormValue) ?>">
<input type="hidden" data-table="tb_fee" data-field="x_keterangan" name="ftb_feegrid$o<?php echo $tb_fee_grid->RowIndex ?>_keterangan" id="ftb_feegrid$o<?php echo $tb_fee_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($tb_fee->keterangan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tb_fee_grid->ListOptions->Render("body", "right", $tb_fee_grid->RowCnt);
?>
	</tr>
<?php if ($tb_fee->RowType == EW_ROWTYPE_ADD || $tb_fee->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ftb_feegrid.UpdateOpts(<?php echo $tb_fee_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($tb_fee->CurrentAction <> "gridadd" || $tb_fee->CurrentMode == "copy")
		if (!$tb_fee_grid->Recordset->EOF) $tb_fee_grid->Recordset->MoveNext();
}
?>
<?php
	if ($tb_fee->CurrentMode == "add" || $tb_fee->CurrentMode == "copy" || $tb_fee->CurrentMode == "edit") {
		$tb_fee_grid->RowIndex = '$rowindex$';
		$tb_fee_grid->LoadDefaultValues();

		// Set row properties
		$tb_fee->ResetAttrs();
		$tb_fee->RowAttrs = array_merge($tb_fee->RowAttrs, array('data-rowindex'=>$tb_fee_grid->RowIndex, 'id'=>'r0_tb_fee', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($tb_fee->RowAttrs["class"], "ewTemplate");
		$tb_fee->RowType = EW_ROWTYPE_ADD;

		// Render row
		$tb_fee_grid->RenderRow();

		// Render list options
		$tb_fee_grid->RenderListOptions();
		$tb_fee_grid->StartRowCnt = 0;
?>
	<tr<?php echo $tb_fee->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tb_fee_grid->ListOptions->Render("body", "left", $tb_fee_grid->RowIndex);
?>
	<?php if ($tb_fee->invoice_id->Visible) { // invoice_id ?>
		<td data-name="invoice_id">
<?php if ($tb_fee->CurrentAction <> "F") { ?>
<?php if ($tb_fee->invoice_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_tb_fee_invoice_id" class="form-group tb_fee_invoice_id">
<span<?php echo $tb_fee->invoice_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_fee->invoice_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $tb_fee_grid->RowIndex ?>_invoice_id" name="x<?php echo $tb_fee_grid->RowIndex ?>_invoice_id" value="<?php echo ew_HtmlEncode($tb_fee->invoice_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_tb_fee_invoice_id" class="form-group tb_fee_invoice_id">
<input type="text" data-table="tb_fee" data-field="x_invoice_id" name="x<?php echo $tb_fee_grid->RowIndex ?>_invoice_id" id="x<?php echo $tb_fee_grid->RowIndex ?>_invoice_id" size="30" placeholder="<?php echo ew_HtmlEncode($tb_fee->invoice_id->getPlaceHolder()) ?>" value="<?php echo $tb_fee->invoice_id->EditValue ?>"<?php echo $tb_fee->invoice_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_tb_fee_invoice_id" class="form-group tb_fee_invoice_id">
<span<?php echo $tb_fee->invoice_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_fee->invoice_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tb_fee" data-field="x_invoice_id" name="x<?php echo $tb_fee_grid->RowIndex ?>_invoice_id" id="x<?php echo $tb_fee_grid->RowIndex ?>_invoice_id" value="<?php echo ew_HtmlEncode($tb_fee->invoice_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tb_fee" data-field="x_invoice_id" name="o<?php echo $tb_fee_grid->RowIndex ?>_invoice_id" id="o<?php echo $tb_fee_grid->RowIndex ?>_invoice_id" value="<?php echo ew_HtmlEncode($tb_fee->invoice_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tb_fee->barang_id->Visible) { // barang_id ?>
		<td data-name="barang_id">
<?php if ($tb_fee->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tb_fee_barang_id" class="form-group tb_fee_barang_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $tb_fee_grid->RowIndex ?>_barang_id"><?php echo (strval($tb_fee->barang_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $tb_fee->barang_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_fee->barang_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $tb_fee_grid->RowIndex ?>_barang_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="tb_fee" data-field="x_barang_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_fee->barang_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tb_fee_grid->RowIndex ?>_barang_id" id="x<?php echo $tb_fee_grid->RowIndex ?>_barang_id" value="<?php echo $tb_fee->barang_id->CurrentValue ?>"<?php echo $tb_fee->barang_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $tb_fee_grid->RowIndex ?>_barang_id" id="s_x<?php echo $tb_fee_grid->RowIndex ?>_barang_id" value="<?php echo $tb_fee->barang_id->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_tb_fee_barang_id" class="form-group tb_fee_barang_id">
<span<?php echo $tb_fee->barang_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_fee->barang_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tb_fee" data-field="x_barang_id" name="x<?php echo $tb_fee_grid->RowIndex ?>_barang_id" id="x<?php echo $tb_fee_grid->RowIndex ?>_barang_id" value="<?php echo ew_HtmlEncode($tb_fee->barang_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tb_fee" data-field="x_barang_id" name="o<?php echo $tb_fee_grid->RowIndex ?>_barang_id" id="o<?php echo $tb_fee_grid->RowIndex ?>_barang_id" value="<?php echo ew_HtmlEncode($tb_fee->barang_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tb_fee->harga->Visible) { // harga ?>
		<td data-name="harga">
<?php if ($tb_fee->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tb_fee_harga" class="form-group tb_fee_harga">
<input type="text" data-table="tb_fee" data-field="x_harga" name="x<?php echo $tb_fee_grid->RowIndex ?>_harga" id="x<?php echo $tb_fee_grid->RowIndex ?>_harga" size="30" placeholder="<?php echo ew_HtmlEncode($tb_fee->harga->getPlaceHolder()) ?>" value="<?php echo $tb_fee->harga->EditValue ?>"<?php echo $tb_fee->harga->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tb_fee_harga" class="form-group tb_fee_harga">
<span<?php echo $tb_fee->harga->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_fee->harga->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tb_fee" data-field="x_harga" name="x<?php echo $tb_fee_grid->RowIndex ?>_harga" id="x<?php echo $tb_fee_grid->RowIndex ?>_harga" value="<?php echo ew_HtmlEncode($tb_fee->harga->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tb_fee" data-field="x_harga" name="o<?php echo $tb_fee_grid->RowIndex ?>_harga" id="o<?php echo $tb_fee_grid->RowIndex ?>_harga" value="<?php echo ew_HtmlEncode($tb_fee->harga->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tb_fee->qty->Visible) { // qty ?>
		<td data-name="qty">
<?php if ($tb_fee->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tb_fee_qty" class="form-group tb_fee_qty">
<input type="text" data-table="tb_fee" data-field="x_qty" name="x<?php echo $tb_fee_grid->RowIndex ?>_qty" id="x<?php echo $tb_fee_grid->RowIndex ?>_qty" size="30" placeholder="<?php echo ew_HtmlEncode($tb_fee->qty->getPlaceHolder()) ?>" value="<?php echo $tb_fee->qty->EditValue ?>"<?php echo $tb_fee->qty->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tb_fee_qty" class="form-group tb_fee_qty">
<span<?php echo $tb_fee->qty->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_fee->qty->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tb_fee" data-field="x_qty" name="x<?php echo $tb_fee_grid->RowIndex ?>_qty" id="x<?php echo $tb_fee_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($tb_fee->qty->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tb_fee" data-field="x_qty" name="o<?php echo $tb_fee_grid->RowIndex ?>_qty" id="o<?php echo $tb_fee_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($tb_fee->qty->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tb_fee->satuan->Visible) { // satuan ?>
		<td data-name="satuan">
<?php if ($tb_fee->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tb_fee_satuan" class="form-group tb_fee_satuan">
<input type="text" data-table="tb_fee" data-field="x_satuan" name="x<?php echo $tb_fee_grid->RowIndex ?>_satuan" id="x<?php echo $tb_fee_grid->RowIndex ?>_satuan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tb_fee->satuan->getPlaceHolder()) ?>" value="<?php echo $tb_fee->satuan->EditValue ?>"<?php echo $tb_fee->satuan->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tb_fee_satuan" class="form-group tb_fee_satuan">
<span<?php echo $tb_fee->satuan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_fee->satuan->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tb_fee" data-field="x_satuan" name="x<?php echo $tb_fee_grid->RowIndex ?>_satuan" id="x<?php echo $tb_fee_grid->RowIndex ?>_satuan" value="<?php echo ew_HtmlEncode($tb_fee->satuan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tb_fee" data-field="x_satuan" name="o<?php echo $tb_fee_grid->RowIndex ?>_satuan" id="o<?php echo $tb_fee_grid->RowIndex ?>_satuan" value="<?php echo ew_HtmlEncode($tb_fee->satuan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tb_fee->jumlah->Visible) { // jumlah ?>
		<td data-name="jumlah">
<?php if ($tb_fee->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tb_fee_jumlah" class="form-group tb_fee_jumlah">
<input type="text" data-table="tb_fee" data-field="x_jumlah" name="x<?php echo $tb_fee_grid->RowIndex ?>_jumlah" id="x<?php echo $tb_fee_grid->RowIndex ?>_jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($tb_fee->jumlah->getPlaceHolder()) ?>" value="<?php echo $tb_fee->jumlah->EditValue ?>"<?php echo $tb_fee->jumlah->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tb_fee_jumlah" class="form-group tb_fee_jumlah">
<span<?php echo $tb_fee->jumlah->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_fee->jumlah->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tb_fee" data-field="x_jumlah" name="x<?php echo $tb_fee_grid->RowIndex ?>_jumlah" id="x<?php echo $tb_fee_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($tb_fee->jumlah->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tb_fee" data-field="x_jumlah" name="o<?php echo $tb_fee_grid->RowIndex ?>_jumlah" id="o<?php echo $tb_fee_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($tb_fee->jumlah->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tb_fee->keterangan->Visible) { // keterangan ?>
		<td data-name="keterangan">
<?php if ($tb_fee->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tb_fee_keterangan" class="form-group tb_fee_keterangan">
<textarea data-table="tb_fee" data-field="x_keterangan" name="x<?php echo $tb_fee_grid->RowIndex ?>_keterangan" id="x<?php echo $tb_fee_grid->RowIndex ?>_keterangan" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($tb_fee->keterangan->getPlaceHolder()) ?>"<?php echo $tb_fee->keterangan->EditAttributes() ?>><?php echo $tb_fee->keterangan->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_tb_fee_keterangan" class="form-group tb_fee_keterangan">
<span<?php echo $tb_fee->keterangan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_fee->keterangan->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tb_fee" data-field="x_keterangan" name="x<?php echo $tb_fee_grid->RowIndex ?>_keterangan" id="x<?php echo $tb_fee_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($tb_fee->keterangan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tb_fee" data-field="x_keterangan" name="o<?php echo $tb_fee_grid->RowIndex ?>_keterangan" id="o<?php echo $tb_fee_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($tb_fee->keterangan->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tb_fee_grid->ListOptions->Render("body", "right", $tb_fee_grid->RowCnt);
?>
<script type="text/javascript">
ftb_feegrid.UpdateOpts(<?php echo $tb_fee_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($tb_fee->CurrentMode == "add" || $tb_fee->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $tb_fee_grid->FormKeyCountName ?>" id="<?php echo $tb_fee_grid->FormKeyCountName ?>" value="<?php echo $tb_fee_grid->KeyCount ?>">
<?php echo $tb_fee_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($tb_fee->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $tb_fee_grid->FormKeyCountName ?>" id="<?php echo $tb_fee_grid->FormKeyCountName ?>" value="<?php echo $tb_fee_grid->KeyCount ?>">
<?php echo $tb_fee_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($tb_fee->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ftb_feegrid">
</div>
<?php

// Close recordset
if ($tb_fee_grid->Recordset)
	$tb_fee_grid->Recordset->Close();
?>
<?php if ($tb_fee_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($tb_fee_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($tb_fee_grid->TotalRecs == 0 && $tb_fee->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($tb_fee_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($tb_fee->Export == "") { ?>
<script type="text/javascript">
ftb_feegrid.Init();
</script>
<?php } ?>
<?php
$tb_fee_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$tb_fee_grid->Page_Terminate();
?>
