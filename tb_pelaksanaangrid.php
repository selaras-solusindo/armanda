<?php include_once "tb_userinfo.php" ?>
<?php

// Create page object
if (!isset($tb_pelaksanaan_grid)) $tb_pelaksanaan_grid = new ctb_pelaksanaan_grid();

// Page init
$tb_pelaksanaan_grid->Page_Init();

// Page main
$tb_pelaksanaan_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_pelaksanaan_grid->Page_Render();
?>
<?php if ($tb_pelaksanaan->Export == "") { ?>
<script type="text/javascript">

// Form object
var ftb_pelaksanaangrid = new ew_Form("ftb_pelaksanaangrid", "grid");
ftb_pelaksanaangrid.FormKeyCountName = '<?php echo $tb_pelaksanaan_grid->FormKeyCountName ?>';

// Validate form
ftb_pelaksanaangrid.Validate = function() {
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
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_pelaksanaan->invoice_id->FldCaption(), $tb_pelaksanaan->invoice_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_invoice_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tb_pelaksanaan->invoice_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pelaksanaan_tgl");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_pelaksanaan->pelaksanaan_tgl->FldCaption(), $tb_pelaksanaan->pelaksanaan_tgl->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pelaksanaan_tgl");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tb_pelaksanaan->pelaksanaan_tgl->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ftb_pelaksanaangrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "invoice_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "pelaksanaan_tgl", false)) return false;
	return true;
}

// Form_CustomValidate event
ftb_pelaksanaangrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftb_pelaksanaangrid.ValidateRequired = true;
<?php } else { ?>
ftb_pelaksanaangrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($tb_pelaksanaan->CurrentAction == "gridadd") {
	if ($tb_pelaksanaan->CurrentMode == "copy") {
		$bSelectLimit = $tb_pelaksanaan_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$tb_pelaksanaan_grid->TotalRecs = $tb_pelaksanaan->SelectRecordCount();
			$tb_pelaksanaan_grid->Recordset = $tb_pelaksanaan_grid->LoadRecordset($tb_pelaksanaan_grid->StartRec-1, $tb_pelaksanaan_grid->DisplayRecs);
		} else {
			if ($tb_pelaksanaan_grid->Recordset = $tb_pelaksanaan_grid->LoadRecordset())
				$tb_pelaksanaan_grid->TotalRecs = $tb_pelaksanaan_grid->Recordset->RecordCount();
		}
		$tb_pelaksanaan_grid->StartRec = 1;
		$tb_pelaksanaan_grid->DisplayRecs = $tb_pelaksanaan_grid->TotalRecs;
	} else {
		$tb_pelaksanaan->CurrentFilter = "0=1";
		$tb_pelaksanaan_grid->StartRec = 1;
		$tb_pelaksanaan_grid->DisplayRecs = $tb_pelaksanaan->GridAddRowCount;
	}
	$tb_pelaksanaan_grid->TotalRecs = $tb_pelaksanaan_grid->DisplayRecs;
	$tb_pelaksanaan_grid->StopRec = $tb_pelaksanaan_grid->DisplayRecs;
} else {
	$bSelectLimit = $tb_pelaksanaan_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($tb_pelaksanaan_grid->TotalRecs <= 0)
			$tb_pelaksanaan_grid->TotalRecs = $tb_pelaksanaan->SelectRecordCount();
	} else {
		if (!$tb_pelaksanaan_grid->Recordset && ($tb_pelaksanaan_grid->Recordset = $tb_pelaksanaan_grid->LoadRecordset()))
			$tb_pelaksanaan_grid->TotalRecs = $tb_pelaksanaan_grid->Recordset->RecordCount();
	}
	$tb_pelaksanaan_grid->StartRec = 1;
	$tb_pelaksanaan_grid->DisplayRecs = $tb_pelaksanaan_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$tb_pelaksanaan_grid->Recordset = $tb_pelaksanaan_grid->LoadRecordset($tb_pelaksanaan_grid->StartRec-1, $tb_pelaksanaan_grid->DisplayRecs);

	// Set no record found message
	if ($tb_pelaksanaan->CurrentAction == "" && $tb_pelaksanaan_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$tb_pelaksanaan_grid->setWarningMessage(ew_DeniedMsg());
		if ($tb_pelaksanaan_grid->SearchWhere == "0=101")
			$tb_pelaksanaan_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$tb_pelaksanaan_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$tb_pelaksanaan_grid->RenderOtherOptions();
?>
<?php $tb_pelaksanaan_grid->ShowPageHeader(); ?>
<?php
$tb_pelaksanaan_grid->ShowMessage();
?>
<?php if ($tb_pelaksanaan_grid->TotalRecs > 0 || $tb_pelaksanaan->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid tb_pelaksanaan">
<div id="ftb_pelaksanaangrid" class="ewForm form-inline">
<div id="gmp_tb_pelaksanaan" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_tb_pelaksanaangrid" class="table ewTable">
<?php echo $tb_pelaksanaan->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$tb_pelaksanaan_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$tb_pelaksanaan_grid->RenderListOptions();

// Render list options (header, left)
$tb_pelaksanaan_grid->ListOptions->Render("header", "left");
?>
<?php if ($tb_pelaksanaan->invoice_id->Visible) { // invoice_id ?>
	<?php if ($tb_pelaksanaan->SortUrl($tb_pelaksanaan->invoice_id) == "") { ?>
		<th data-name="invoice_id"><div id="elh_tb_pelaksanaan_invoice_id" class="tb_pelaksanaan_invoice_id"><div class="ewTableHeaderCaption"><?php echo $tb_pelaksanaan->invoice_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="invoice_id"><div><div id="elh_tb_pelaksanaan_invoice_id" class="tb_pelaksanaan_invoice_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_pelaksanaan->invoice_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_pelaksanaan->invoice_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_pelaksanaan->invoice_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tb_pelaksanaan->pelaksanaan_tgl->Visible) { // pelaksanaan_tgl ?>
	<?php if ($tb_pelaksanaan->SortUrl($tb_pelaksanaan->pelaksanaan_tgl) == "") { ?>
		<th data-name="pelaksanaan_tgl"><div id="elh_tb_pelaksanaan_pelaksanaan_tgl" class="tb_pelaksanaan_pelaksanaan_tgl"><div class="ewTableHeaderCaption"><?php echo $tb_pelaksanaan->pelaksanaan_tgl->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pelaksanaan_tgl"><div><div id="elh_tb_pelaksanaan_pelaksanaan_tgl" class="tb_pelaksanaan_pelaksanaan_tgl">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_pelaksanaan->pelaksanaan_tgl->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_pelaksanaan->pelaksanaan_tgl->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_pelaksanaan->pelaksanaan_tgl->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$tb_pelaksanaan_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$tb_pelaksanaan_grid->StartRec = 1;
$tb_pelaksanaan_grid->StopRec = $tb_pelaksanaan_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($tb_pelaksanaan_grid->FormKeyCountName) && ($tb_pelaksanaan->CurrentAction == "gridadd" || $tb_pelaksanaan->CurrentAction == "gridedit" || $tb_pelaksanaan->CurrentAction == "F")) {
		$tb_pelaksanaan_grid->KeyCount = $objForm->GetValue($tb_pelaksanaan_grid->FormKeyCountName);
		$tb_pelaksanaan_grid->StopRec = $tb_pelaksanaan_grid->StartRec + $tb_pelaksanaan_grid->KeyCount - 1;
	}
}
$tb_pelaksanaan_grid->RecCnt = $tb_pelaksanaan_grid->StartRec - 1;
if ($tb_pelaksanaan_grid->Recordset && !$tb_pelaksanaan_grid->Recordset->EOF) {
	$tb_pelaksanaan_grid->Recordset->MoveFirst();
	$bSelectLimit = $tb_pelaksanaan_grid->UseSelectLimit;
	if (!$bSelectLimit && $tb_pelaksanaan_grid->StartRec > 1)
		$tb_pelaksanaan_grid->Recordset->Move($tb_pelaksanaan_grid->StartRec - 1);
} elseif (!$tb_pelaksanaan->AllowAddDeleteRow && $tb_pelaksanaan_grid->StopRec == 0) {
	$tb_pelaksanaan_grid->StopRec = $tb_pelaksanaan->GridAddRowCount;
}

// Initialize aggregate
$tb_pelaksanaan->RowType = EW_ROWTYPE_AGGREGATEINIT;
$tb_pelaksanaan->ResetAttrs();
$tb_pelaksanaan_grid->RenderRow();
if ($tb_pelaksanaan->CurrentAction == "gridadd")
	$tb_pelaksanaan_grid->RowIndex = 0;
if ($tb_pelaksanaan->CurrentAction == "gridedit")
	$tb_pelaksanaan_grid->RowIndex = 0;
while ($tb_pelaksanaan_grid->RecCnt < $tb_pelaksanaan_grid->StopRec) {
	$tb_pelaksanaan_grid->RecCnt++;
	if (intval($tb_pelaksanaan_grid->RecCnt) >= intval($tb_pelaksanaan_grid->StartRec)) {
		$tb_pelaksanaan_grid->RowCnt++;
		if ($tb_pelaksanaan->CurrentAction == "gridadd" || $tb_pelaksanaan->CurrentAction == "gridedit" || $tb_pelaksanaan->CurrentAction == "F") {
			$tb_pelaksanaan_grid->RowIndex++;
			$objForm->Index = $tb_pelaksanaan_grid->RowIndex;
			if ($objForm->HasValue($tb_pelaksanaan_grid->FormActionName))
				$tb_pelaksanaan_grid->RowAction = strval($objForm->GetValue($tb_pelaksanaan_grid->FormActionName));
			elseif ($tb_pelaksanaan->CurrentAction == "gridadd")
				$tb_pelaksanaan_grid->RowAction = "insert";
			else
				$tb_pelaksanaan_grid->RowAction = "";
		}

		// Set up key count
		$tb_pelaksanaan_grid->KeyCount = $tb_pelaksanaan_grid->RowIndex;

		// Init row class and style
		$tb_pelaksanaan->ResetAttrs();
		$tb_pelaksanaan->CssClass = "";
		if ($tb_pelaksanaan->CurrentAction == "gridadd") {
			if ($tb_pelaksanaan->CurrentMode == "copy") {
				$tb_pelaksanaan_grid->LoadRowValues($tb_pelaksanaan_grid->Recordset); // Load row values
				$tb_pelaksanaan_grid->SetRecordKey($tb_pelaksanaan_grid->RowOldKey, $tb_pelaksanaan_grid->Recordset); // Set old record key
			} else {
				$tb_pelaksanaan_grid->LoadDefaultValues(); // Load default values
				$tb_pelaksanaan_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$tb_pelaksanaan_grid->LoadRowValues($tb_pelaksanaan_grid->Recordset); // Load row values
		}
		$tb_pelaksanaan->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($tb_pelaksanaan->CurrentAction == "gridadd") // Grid add
			$tb_pelaksanaan->RowType = EW_ROWTYPE_ADD; // Render add
		if ($tb_pelaksanaan->CurrentAction == "gridadd" && $tb_pelaksanaan->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$tb_pelaksanaan_grid->RestoreCurrentRowFormValues($tb_pelaksanaan_grid->RowIndex); // Restore form values
		if ($tb_pelaksanaan->CurrentAction == "gridedit") { // Grid edit
			if ($tb_pelaksanaan->EventCancelled) {
				$tb_pelaksanaan_grid->RestoreCurrentRowFormValues($tb_pelaksanaan_grid->RowIndex); // Restore form values
			}
			if ($tb_pelaksanaan_grid->RowAction == "insert")
				$tb_pelaksanaan->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$tb_pelaksanaan->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($tb_pelaksanaan->CurrentAction == "gridedit" && ($tb_pelaksanaan->RowType == EW_ROWTYPE_EDIT || $tb_pelaksanaan->RowType == EW_ROWTYPE_ADD) && $tb_pelaksanaan->EventCancelled) // Update failed
			$tb_pelaksanaan_grid->RestoreCurrentRowFormValues($tb_pelaksanaan_grid->RowIndex); // Restore form values
		if ($tb_pelaksanaan->RowType == EW_ROWTYPE_EDIT) // Edit row
			$tb_pelaksanaan_grid->EditRowCnt++;
		if ($tb_pelaksanaan->CurrentAction == "F") // Confirm row
			$tb_pelaksanaan_grid->RestoreCurrentRowFormValues($tb_pelaksanaan_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$tb_pelaksanaan->RowAttrs = array_merge($tb_pelaksanaan->RowAttrs, array('data-rowindex'=>$tb_pelaksanaan_grid->RowCnt, 'id'=>'r' . $tb_pelaksanaan_grid->RowCnt . '_tb_pelaksanaan', 'data-rowtype'=>$tb_pelaksanaan->RowType));

		// Render row
		$tb_pelaksanaan_grid->RenderRow();

		// Render list options
		$tb_pelaksanaan_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($tb_pelaksanaan_grid->RowAction <> "delete" && $tb_pelaksanaan_grid->RowAction <> "insertdelete" && !($tb_pelaksanaan_grid->RowAction == "insert" && $tb_pelaksanaan->CurrentAction == "F" && $tb_pelaksanaan_grid->EmptyRow())) {
?>
	<tr<?php echo $tb_pelaksanaan->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tb_pelaksanaan_grid->ListOptions->Render("body", "left", $tb_pelaksanaan_grid->RowCnt);
?>
	<?php if ($tb_pelaksanaan->invoice_id->Visible) { // invoice_id ?>
		<td data-name="invoice_id"<?php echo $tb_pelaksanaan->invoice_id->CellAttributes() ?>>
<?php if ($tb_pelaksanaan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($tb_pelaksanaan->invoice_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $tb_pelaksanaan_grid->RowCnt ?>_tb_pelaksanaan_invoice_id" class="form-group tb_pelaksanaan_invoice_id">
<span<?php echo $tb_pelaksanaan->invoice_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_pelaksanaan->invoice_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_invoice_id" name="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_invoice_id" value="<?php echo ew_HtmlEncode($tb_pelaksanaan->invoice_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $tb_pelaksanaan_grid->RowCnt ?>_tb_pelaksanaan_invoice_id" class="form-group tb_pelaksanaan_invoice_id">
<input type="text" data-table="tb_pelaksanaan" data-field="x_invoice_id" name="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_invoice_id" id="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_invoice_id" size="30" placeholder="<?php echo ew_HtmlEncode($tb_pelaksanaan->invoice_id->getPlaceHolder()) ?>" value="<?php echo $tb_pelaksanaan->invoice_id->EditValue ?>"<?php echo $tb_pelaksanaan->invoice_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="tb_pelaksanaan" data-field="x_invoice_id" name="o<?php echo $tb_pelaksanaan_grid->RowIndex ?>_invoice_id" id="o<?php echo $tb_pelaksanaan_grid->RowIndex ?>_invoice_id" value="<?php echo ew_HtmlEncode($tb_pelaksanaan->invoice_id->OldValue) ?>">
<?php } ?>
<?php if ($tb_pelaksanaan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($tb_pelaksanaan->invoice_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $tb_pelaksanaan_grid->RowCnt ?>_tb_pelaksanaan_invoice_id" class="form-group tb_pelaksanaan_invoice_id">
<span<?php echo $tb_pelaksanaan->invoice_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_pelaksanaan->invoice_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_invoice_id" name="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_invoice_id" value="<?php echo ew_HtmlEncode($tb_pelaksanaan->invoice_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $tb_pelaksanaan_grid->RowCnt ?>_tb_pelaksanaan_invoice_id" class="form-group tb_pelaksanaan_invoice_id">
<input type="text" data-table="tb_pelaksanaan" data-field="x_invoice_id" name="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_invoice_id" id="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_invoice_id" size="30" placeholder="<?php echo ew_HtmlEncode($tb_pelaksanaan->invoice_id->getPlaceHolder()) ?>" value="<?php echo $tb_pelaksanaan->invoice_id->EditValue ?>"<?php echo $tb_pelaksanaan->invoice_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($tb_pelaksanaan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tb_pelaksanaan_grid->RowCnt ?>_tb_pelaksanaan_invoice_id" class="tb_pelaksanaan_invoice_id">
<span<?php echo $tb_pelaksanaan->invoice_id->ViewAttributes() ?>>
<?php echo $tb_pelaksanaan->invoice_id->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="tb_pelaksanaan" data-field="x_invoice_id" name="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_invoice_id" id="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_invoice_id" value="<?php echo ew_HtmlEncode($tb_pelaksanaan->invoice_id->FormValue) ?>">
<input type="hidden" data-table="tb_pelaksanaan" data-field="x_invoice_id" name="o<?php echo $tb_pelaksanaan_grid->RowIndex ?>_invoice_id" id="o<?php echo $tb_pelaksanaan_grid->RowIndex ?>_invoice_id" value="<?php echo ew_HtmlEncode($tb_pelaksanaan->invoice_id->OldValue) ?>">
<?php } ?>
<a id="<?php echo $tb_pelaksanaan_grid->PageObjName . "_row_" . $tb_pelaksanaan_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($tb_pelaksanaan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="tb_pelaksanaan" data-field="x_pelaksanaan_id" name="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_pelaksanaan_id" id="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_pelaksanaan_id" value="<?php echo ew_HtmlEncode($tb_pelaksanaan->pelaksanaan_id->CurrentValue) ?>">
<input type="hidden" data-table="tb_pelaksanaan" data-field="x_pelaksanaan_id" name="o<?php echo $tb_pelaksanaan_grid->RowIndex ?>_pelaksanaan_id" id="o<?php echo $tb_pelaksanaan_grid->RowIndex ?>_pelaksanaan_id" value="<?php echo ew_HtmlEncode($tb_pelaksanaan->pelaksanaan_id->OldValue) ?>">
<?php } ?>
<?php if ($tb_pelaksanaan->RowType == EW_ROWTYPE_EDIT || $tb_pelaksanaan->CurrentMode == "edit") { ?>
<input type="hidden" data-table="tb_pelaksanaan" data-field="x_pelaksanaan_id" name="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_pelaksanaan_id" id="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_pelaksanaan_id" value="<?php echo ew_HtmlEncode($tb_pelaksanaan->pelaksanaan_id->CurrentValue) ?>">
<?php } ?>
	<?php if ($tb_pelaksanaan->pelaksanaan_tgl->Visible) { // pelaksanaan_tgl ?>
		<td data-name="pelaksanaan_tgl"<?php echo $tb_pelaksanaan->pelaksanaan_tgl->CellAttributes() ?>>
<?php if ($tb_pelaksanaan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tb_pelaksanaan_grid->RowCnt ?>_tb_pelaksanaan_pelaksanaan_tgl" class="form-group tb_pelaksanaan_pelaksanaan_tgl">
<input type="text" data-table="tb_pelaksanaan" data-field="x_pelaksanaan_tgl" data-format="7" name="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_pelaksanaan_tgl" id="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_pelaksanaan_tgl" placeholder="<?php echo ew_HtmlEncode($tb_pelaksanaan->pelaksanaan_tgl->getPlaceHolder()) ?>" value="<?php echo $tb_pelaksanaan->pelaksanaan_tgl->EditValue ?>"<?php echo $tb_pelaksanaan->pelaksanaan_tgl->EditAttributes() ?>>
<?php if (!$tb_pelaksanaan->pelaksanaan_tgl->ReadOnly && !$tb_pelaksanaan->pelaksanaan_tgl->Disabled && !isset($tb_pelaksanaan->pelaksanaan_tgl->EditAttrs["readonly"]) && !isset($tb_pelaksanaan->pelaksanaan_tgl->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ftb_pelaksanaangrid", "x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_pelaksanaan_tgl", 7);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="tb_pelaksanaan" data-field="x_pelaksanaan_tgl" name="o<?php echo $tb_pelaksanaan_grid->RowIndex ?>_pelaksanaan_tgl" id="o<?php echo $tb_pelaksanaan_grid->RowIndex ?>_pelaksanaan_tgl" value="<?php echo ew_HtmlEncode($tb_pelaksanaan->pelaksanaan_tgl->OldValue) ?>">
<?php } ?>
<?php if ($tb_pelaksanaan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tb_pelaksanaan_grid->RowCnt ?>_tb_pelaksanaan_pelaksanaan_tgl" class="form-group tb_pelaksanaan_pelaksanaan_tgl">
<input type="text" data-table="tb_pelaksanaan" data-field="x_pelaksanaan_tgl" data-format="7" name="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_pelaksanaan_tgl" id="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_pelaksanaan_tgl" placeholder="<?php echo ew_HtmlEncode($tb_pelaksanaan->pelaksanaan_tgl->getPlaceHolder()) ?>" value="<?php echo $tb_pelaksanaan->pelaksanaan_tgl->EditValue ?>"<?php echo $tb_pelaksanaan->pelaksanaan_tgl->EditAttributes() ?>>
<?php if (!$tb_pelaksanaan->pelaksanaan_tgl->ReadOnly && !$tb_pelaksanaan->pelaksanaan_tgl->Disabled && !isset($tb_pelaksanaan->pelaksanaan_tgl->EditAttrs["readonly"]) && !isset($tb_pelaksanaan->pelaksanaan_tgl->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ftb_pelaksanaangrid", "x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_pelaksanaan_tgl", 7);
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($tb_pelaksanaan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tb_pelaksanaan_grid->RowCnt ?>_tb_pelaksanaan_pelaksanaan_tgl" class="tb_pelaksanaan_pelaksanaan_tgl">
<span<?php echo $tb_pelaksanaan->pelaksanaan_tgl->ViewAttributes() ?>>
<?php echo $tb_pelaksanaan->pelaksanaan_tgl->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="tb_pelaksanaan" data-field="x_pelaksanaan_tgl" name="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_pelaksanaan_tgl" id="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_pelaksanaan_tgl" value="<?php echo ew_HtmlEncode($tb_pelaksanaan->pelaksanaan_tgl->FormValue) ?>">
<input type="hidden" data-table="tb_pelaksanaan" data-field="x_pelaksanaan_tgl" name="o<?php echo $tb_pelaksanaan_grid->RowIndex ?>_pelaksanaan_tgl" id="o<?php echo $tb_pelaksanaan_grid->RowIndex ?>_pelaksanaan_tgl" value="<?php echo ew_HtmlEncode($tb_pelaksanaan->pelaksanaan_tgl->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tb_pelaksanaan_grid->ListOptions->Render("body", "right", $tb_pelaksanaan_grid->RowCnt);
?>
	</tr>
<?php if ($tb_pelaksanaan->RowType == EW_ROWTYPE_ADD || $tb_pelaksanaan->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ftb_pelaksanaangrid.UpdateOpts(<?php echo $tb_pelaksanaan_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($tb_pelaksanaan->CurrentAction <> "gridadd" || $tb_pelaksanaan->CurrentMode == "copy")
		if (!$tb_pelaksanaan_grid->Recordset->EOF) $tb_pelaksanaan_grid->Recordset->MoveNext();
}
?>
<?php
	if ($tb_pelaksanaan->CurrentMode == "add" || $tb_pelaksanaan->CurrentMode == "copy" || $tb_pelaksanaan->CurrentMode == "edit") {
		$tb_pelaksanaan_grid->RowIndex = '$rowindex$';
		$tb_pelaksanaan_grid->LoadDefaultValues();

		// Set row properties
		$tb_pelaksanaan->ResetAttrs();
		$tb_pelaksanaan->RowAttrs = array_merge($tb_pelaksanaan->RowAttrs, array('data-rowindex'=>$tb_pelaksanaan_grid->RowIndex, 'id'=>'r0_tb_pelaksanaan', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($tb_pelaksanaan->RowAttrs["class"], "ewTemplate");
		$tb_pelaksanaan->RowType = EW_ROWTYPE_ADD;

		// Render row
		$tb_pelaksanaan_grid->RenderRow();

		// Render list options
		$tb_pelaksanaan_grid->RenderListOptions();
		$tb_pelaksanaan_grid->StartRowCnt = 0;
?>
	<tr<?php echo $tb_pelaksanaan->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tb_pelaksanaan_grid->ListOptions->Render("body", "left", $tb_pelaksanaan_grid->RowIndex);
?>
	<?php if ($tb_pelaksanaan->invoice_id->Visible) { // invoice_id ?>
		<td data-name="invoice_id">
<?php if ($tb_pelaksanaan->CurrentAction <> "F") { ?>
<?php if ($tb_pelaksanaan->invoice_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_tb_pelaksanaan_invoice_id" class="form-group tb_pelaksanaan_invoice_id">
<span<?php echo $tb_pelaksanaan->invoice_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_pelaksanaan->invoice_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_invoice_id" name="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_invoice_id" value="<?php echo ew_HtmlEncode($tb_pelaksanaan->invoice_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_tb_pelaksanaan_invoice_id" class="form-group tb_pelaksanaan_invoice_id">
<input type="text" data-table="tb_pelaksanaan" data-field="x_invoice_id" name="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_invoice_id" id="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_invoice_id" size="30" placeholder="<?php echo ew_HtmlEncode($tb_pelaksanaan->invoice_id->getPlaceHolder()) ?>" value="<?php echo $tb_pelaksanaan->invoice_id->EditValue ?>"<?php echo $tb_pelaksanaan->invoice_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_tb_pelaksanaan_invoice_id" class="form-group tb_pelaksanaan_invoice_id">
<span<?php echo $tb_pelaksanaan->invoice_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_pelaksanaan->invoice_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tb_pelaksanaan" data-field="x_invoice_id" name="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_invoice_id" id="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_invoice_id" value="<?php echo ew_HtmlEncode($tb_pelaksanaan->invoice_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tb_pelaksanaan" data-field="x_invoice_id" name="o<?php echo $tb_pelaksanaan_grid->RowIndex ?>_invoice_id" id="o<?php echo $tb_pelaksanaan_grid->RowIndex ?>_invoice_id" value="<?php echo ew_HtmlEncode($tb_pelaksanaan->invoice_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tb_pelaksanaan->pelaksanaan_tgl->Visible) { // pelaksanaan_tgl ?>
		<td data-name="pelaksanaan_tgl">
<?php if ($tb_pelaksanaan->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tb_pelaksanaan_pelaksanaan_tgl" class="form-group tb_pelaksanaan_pelaksanaan_tgl">
<input type="text" data-table="tb_pelaksanaan" data-field="x_pelaksanaan_tgl" data-format="7" name="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_pelaksanaan_tgl" id="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_pelaksanaan_tgl" placeholder="<?php echo ew_HtmlEncode($tb_pelaksanaan->pelaksanaan_tgl->getPlaceHolder()) ?>" value="<?php echo $tb_pelaksanaan->pelaksanaan_tgl->EditValue ?>"<?php echo $tb_pelaksanaan->pelaksanaan_tgl->EditAttributes() ?>>
<?php if (!$tb_pelaksanaan->pelaksanaan_tgl->ReadOnly && !$tb_pelaksanaan->pelaksanaan_tgl->Disabled && !isset($tb_pelaksanaan->pelaksanaan_tgl->EditAttrs["readonly"]) && !isset($tb_pelaksanaan->pelaksanaan_tgl->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ftb_pelaksanaangrid", "x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_pelaksanaan_tgl", 7);
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_tb_pelaksanaan_pelaksanaan_tgl" class="form-group tb_pelaksanaan_pelaksanaan_tgl">
<span<?php echo $tb_pelaksanaan->pelaksanaan_tgl->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_pelaksanaan->pelaksanaan_tgl->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tb_pelaksanaan" data-field="x_pelaksanaan_tgl" name="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_pelaksanaan_tgl" id="x<?php echo $tb_pelaksanaan_grid->RowIndex ?>_pelaksanaan_tgl" value="<?php echo ew_HtmlEncode($tb_pelaksanaan->pelaksanaan_tgl->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tb_pelaksanaan" data-field="x_pelaksanaan_tgl" name="o<?php echo $tb_pelaksanaan_grid->RowIndex ?>_pelaksanaan_tgl" id="o<?php echo $tb_pelaksanaan_grid->RowIndex ?>_pelaksanaan_tgl" value="<?php echo ew_HtmlEncode($tb_pelaksanaan->pelaksanaan_tgl->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tb_pelaksanaan_grid->ListOptions->Render("body", "right", $tb_pelaksanaan_grid->RowCnt);
?>
<script type="text/javascript">
ftb_pelaksanaangrid.UpdateOpts(<?php echo $tb_pelaksanaan_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($tb_pelaksanaan->CurrentMode == "add" || $tb_pelaksanaan->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $tb_pelaksanaan_grid->FormKeyCountName ?>" id="<?php echo $tb_pelaksanaan_grid->FormKeyCountName ?>" value="<?php echo $tb_pelaksanaan_grid->KeyCount ?>">
<?php echo $tb_pelaksanaan_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($tb_pelaksanaan->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $tb_pelaksanaan_grid->FormKeyCountName ?>" id="<?php echo $tb_pelaksanaan_grid->FormKeyCountName ?>" value="<?php echo $tb_pelaksanaan_grid->KeyCount ?>">
<?php echo $tb_pelaksanaan_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($tb_pelaksanaan->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ftb_pelaksanaangrid">
</div>
<?php

// Close recordset
if ($tb_pelaksanaan_grid->Recordset)
	$tb_pelaksanaan_grid->Recordset->Close();
?>
<?php if ($tb_pelaksanaan_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($tb_pelaksanaan_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($tb_pelaksanaan_grid->TotalRecs == 0 && $tb_pelaksanaan->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($tb_pelaksanaan_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($tb_pelaksanaan->Export == "") { ?>
<script type="text/javascript">
ftb_pelaksanaangrid.Init();
</script>
<?php } ?>
<?php
$tb_pelaksanaan_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$tb_pelaksanaan_grid->Page_Terminate();
?>
