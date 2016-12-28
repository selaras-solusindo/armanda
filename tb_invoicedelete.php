<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "tb_invoiceinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$tb_invoice_delete = NULL; // Initialize page object first

class ctb_invoice_delete extends ctb_invoice {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{E6C293EF-4D71-4FC6-B668-35B8D3E752AB}";

	// Table name
	var $TableName = 'tb_invoice';

	// Page object name
	var $PageObjName = 'tb_invoice_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (tb_invoice)
		if (!isset($GLOBALS["tb_invoice"]) || get_class($GLOBALS["tb_invoice"]) == "ctb_invoice") {
			$GLOBALS["tb_invoice"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tb_invoice"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tb_invoice', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		$this->id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->customer_id->SetVisibility();
		$this->no_invoice->SetVisibility();
		$this->tgl_invoice->SetVisibility();
		$this->no_order->SetVisibility();
		$this->no_referensi->SetVisibility();
		$this->kegiatan->SetVisibility();
		$this->tgl_pelaksanaan->SetVisibility();
		$this->no_sertifikat->SetVisibility();
		$this->keterangan->SetVisibility();
		$this->total->SetVisibility();
		$this->ppn->SetVisibility();
		$this->total_ppn->SetVisibility();
		$this->terbilang->SetVisibility();
		$this->terbayar->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $tb_invoice;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tb_invoice);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("tb_invoicelist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in tb_invoice class, tb_invoiceinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("tb_invoicelist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->id->setDbValue($rs->fields('id'));
		$this->customer_id->setDbValue($rs->fields('customer_id'));
		$this->no_invoice->setDbValue($rs->fields('no_invoice'));
		$this->tgl_invoice->setDbValue($rs->fields('tgl_invoice'));
		$this->no_order->setDbValue($rs->fields('no_order'));
		$this->no_referensi->setDbValue($rs->fields('no_referensi'));
		$this->kegiatan->setDbValue($rs->fields('kegiatan'));
		$this->tgl_pelaksanaan->setDbValue($rs->fields('tgl_pelaksanaan'));
		$this->no_sertifikat->setDbValue($rs->fields('no_sertifikat'));
		$this->keterangan->setDbValue($rs->fields('keterangan'));
		$this->total->setDbValue($rs->fields('total'));
		$this->ppn->setDbValue($rs->fields('ppn'));
		$this->total_ppn->setDbValue($rs->fields('total_ppn'));
		$this->terbilang->setDbValue($rs->fields('terbilang'));
		$this->terbayar->setDbValue($rs->fields('terbayar'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->customer_id->DbValue = $row['customer_id'];
		$this->no_invoice->DbValue = $row['no_invoice'];
		$this->tgl_invoice->DbValue = $row['tgl_invoice'];
		$this->no_order->DbValue = $row['no_order'];
		$this->no_referensi->DbValue = $row['no_referensi'];
		$this->kegiatan->DbValue = $row['kegiatan'];
		$this->tgl_pelaksanaan->DbValue = $row['tgl_pelaksanaan'];
		$this->no_sertifikat->DbValue = $row['no_sertifikat'];
		$this->keterangan->DbValue = $row['keterangan'];
		$this->total->DbValue = $row['total'];
		$this->ppn->DbValue = $row['ppn'];
		$this->total_ppn->DbValue = $row['total_ppn'];
		$this->terbilang->DbValue = $row['terbilang'];
		$this->terbayar->DbValue = $row['terbayar'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->total->FormValue == $this->total->CurrentValue && is_numeric(ew_StrToFloat($this->total->CurrentValue)))
			$this->total->CurrentValue = ew_StrToFloat($this->total->CurrentValue);

		// Convert decimal values if posted back
		if ($this->total_ppn->FormValue == $this->total_ppn->CurrentValue && is_numeric(ew_StrToFloat($this->total_ppn->CurrentValue)))
			$this->total_ppn->CurrentValue = ew_StrToFloat($this->total_ppn->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// customer_id
		if (strval($this->customer_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->customer_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tb_customer`";
		$sWhereWrk = "";
		$this->customer_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->customer_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->customer_id->ViewValue = $this->customer_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->customer_id->ViewValue = $this->customer_id->CurrentValue;
			}
		} else {
			$this->customer_id->ViewValue = NULL;
		}
		$this->customer_id->ViewCustomAttributes = "";

		// no_invoice
		$this->no_invoice->ViewValue = $this->no_invoice->CurrentValue;
		$this->no_invoice->ViewCustomAttributes = "";

		// tgl_invoice
		$this->tgl_invoice->ViewValue = $this->tgl_invoice->CurrentValue;
		$this->tgl_invoice->ViewValue = ew_FormatDateTime($this->tgl_invoice->ViewValue, 7);
		$this->tgl_invoice->ViewCustomAttributes = "";

		// no_order
		$this->no_order->ViewValue = $this->no_order->CurrentValue;
		$this->no_order->ViewCustomAttributes = "";

		// no_referensi
		$this->no_referensi->ViewValue = $this->no_referensi->CurrentValue;
		$this->no_referensi->ViewCustomAttributes = "";

		// kegiatan
		$this->kegiatan->ViewValue = $this->kegiatan->CurrentValue;
		$this->kegiatan->ViewCustomAttributes = "";

		// tgl_pelaksanaan
		$this->tgl_pelaksanaan->ViewValue = $this->tgl_pelaksanaan->CurrentValue;
		$this->tgl_pelaksanaan->ViewValue = ew_FormatDateTime($this->tgl_pelaksanaan->ViewValue, 7);
		$this->tgl_pelaksanaan->ViewCustomAttributes = "";

		// no_sertifikat
		$this->no_sertifikat->ViewValue = $this->no_sertifikat->CurrentValue;
		$this->no_sertifikat->ViewCustomAttributes = "";

		// keterangan
		$this->keterangan->ViewValue = $this->keterangan->CurrentValue;
		$this->keterangan->ViewCustomAttributes = "";

		// total
		$this->total->ViewValue = $this->total->CurrentValue;
		$this->total->ViewValue = ew_FormatNumber($this->total->ViewValue, 2, -2, -2, -1);
		$this->total->CellCssStyle .= "text-align: right;";
		$this->total->ViewCustomAttributes = "";

		// ppn
		$this->ppn->ViewValue = $this->ppn->CurrentValue;
		$this->ppn->ViewCustomAttributes = "";

		// total_ppn
		$this->total_ppn->ViewValue = $this->total_ppn->CurrentValue;
		$this->total_ppn->ViewValue = ew_FormatNumber($this->total_ppn->ViewValue, 2, -2, -2, -2);
		$this->total_ppn->CellCssStyle .= "text-align: right;";
		$this->total_ppn->ViewCustomAttributes = "";

		// terbilang
		$this->terbilang->ViewValue = $this->terbilang->CurrentValue;
		$this->terbilang->ViewCustomAttributes = "";

		// terbayar
		if (strval($this->terbayar->CurrentValue) <> "") {
			$this->terbayar->ViewValue = $this->terbayar->OptionCaption($this->terbayar->CurrentValue);
		} else {
			$this->terbayar->ViewValue = NULL;
		}
		$this->terbayar->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// customer_id
			$this->customer_id->LinkCustomAttributes = "";
			$this->customer_id->HrefValue = "";
			$this->customer_id->TooltipValue = "";

			// no_invoice
			$this->no_invoice->LinkCustomAttributes = "";
			$this->no_invoice->HrefValue = "";
			$this->no_invoice->TooltipValue = "";

			// tgl_invoice
			$this->tgl_invoice->LinkCustomAttributes = "";
			$this->tgl_invoice->HrefValue = "";
			$this->tgl_invoice->TooltipValue = "";

			// no_order
			$this->no_order->LinkCustomAttributes = "";
			$this->no_order->HrefValue = "";
			$this->no_order->TooltipValue = "";

			// no_referensi
			$this->no_referensi->LinkCustomAttributes = "";
			$this->no_referensi->HrefValue = "";
			$this->no_referensi->TooltipValue = "";

			// kegiatan
			$this->kegiatan->LinkCustomAttributes = "";
			$this->kegiatan->HrefValue = "";
			$this->kegiatan->TooltipValue = "";

			// tgl_pelaksanaan
			$this->tgl_pelaksanaan->LinkCustomAttributes = "";
			$this->tgl_pelaksanaan->HrefValue = "";
			$this->tgl_pelaksanaan->TooltipValue = "";

			// no_sertifikat
			$this->no_sertifikat->LinkCustomAttributes = "";
			$this->no_sertifikat->HrefValue = "";
			$this->no_sertifikat->TooltipValue = "";

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";
			$this->keterangan->TooltipValue = "";

			// total
			$this->total->LinkCustomAttributes = "";
			$this->total->HrefValue = "";
			$this->total->TooltipValue = "";

			// ppn
			$this->ppn->LinkCustomAttributes = "";
			$this->ppn->HrefValue = "";
			$this->ppn->TooltipValue = "";

			// total_ppn
			$this->total_ppn->LinkCustomAttributes = "";
			$this->total_ppn->HrefValue = "";
			$this->total_ppn->TooltipValue = "";

			// terbilang
			$this->terbilang->LinkCustomAttributes = "";
			$this->terbilang->HrefValue = "";
			$this->terbilang->TooltipValue = "";

			// terbayar
			$this->terbayar->LinkCustomAttributes = "";
			$this->terbayar->HrefValue = "";
			$this->terbayar->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tb_invoicelist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($tb_invoice_delete)) $tb_invoice_delete = new ctb_invoice_delete();

// Page init
$tb_invoice_delete->Page_Init();

// Page main
$tb_invoice_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_invoice_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ftb_invoicedelete = new ew_Form("ftb_invoicedelete", "delete");

// Form_CustomValidate event
ftb_invoicedelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftb_invoicedelete.ValidateRequired = true;
<?php } else { ?>
ftb_invoicedelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftb_invoicedelete.Lists["x_customer_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tb_customer"};
ftb_invoicedelete.Lists["x_terbayar"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftb_invoicedelete.Lists["x_terbayar"].Options = <?php echo json_encode($tb_invoice->terbayar->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $tb_invoice_delete->ShowPageHeader(); ?>
<?php
$tb_invoice_delete->ShowMessage();
?>
<form name="ftb_invoicedelete" id="ftb_invoicedelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tb_invoice_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tb_invoice_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tb_invoice">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($tb_invoice_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $tb_invoice->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($tb_invoice->id->Visible) { // id ?>
		<th><span id="elh_tb_invoice_id" class="tb_invoice_id"><?php echo $tb_invoice->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_invoice->customer_id->Visible) { // customer_id ?>
		<th><span id="elh_tb_invoice_customer_id" class="tb_invoice_customer_id"><?php echo $tb_invoice->customer_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_invoice->no_invoice->Visible) { // no_invoice ?>
		<th><span id="elh_tb_invoice_no_invoice" class="tb_invoice_no_invoice"><?php echo $tb_invoice->no_invoice->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_invoice->tgl_invoice->Visible) { // tgl_invoice ?>
		<th><span id="elh_tb_invoice_tgl_invoice" class="tb_invoice_tgl_invoice"><?php echo $tb_invoice->tgl_invoice->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_invoice->no_order->Visible) { // no_order ?>
		<th><span id="elh_tb_invoice_no_order" class="tb_invoice_no_order"><?php echo $tb_invoice->no_order->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_invoice->no_referensi->Visible) { // no_referensi ?>
		<th><span id="elh_tb_invoice_no_referensi" class="tb_invoice_no_referensi"><?php echo $tb_invoice->no_referensi->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_invoice->kegiatan->Visible) { // kegiatan ?>
		<th><span id="elh_tb_invoice_kegiatan" class="tb_invoice_kegiatan"><?php echo $tb_invoice->kegiatan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_invoice->tgl_pelaksanaan->Visible) { // tgl_pelaksanaan ?>
		<th><span id="elh_tb_invoice_tgl_pelaksanaan" class="tb_invoice_tgl_pelaksanaan"><?php echo $tb_invoice->tgl_pelaksanaan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_invoice->no_sertifikat->Visible) { // no_sertifikat ?>
		<th><span id="elh_tb_invoice_no_sertifikat" class="tb_invoice_no_sertifikat"><?php echo $tb_invoice->no_sertifikat->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_invoice->keterangan->Visible) { // keterangan ?>
		<th><span id="elh_tb_invoice_keterangan" class="tb_invoice_keterangan"><?php echo $tb_invoice->keterangan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_invoice->total->Visible) { // total ?>
		<th><span id="elh_tb_invoice_total" class="tb_invoice_total"><?php echo $tb_invoice->total->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_invoice->ppn->Visible) { // ppn ?>
		<th><span id="elh_tb_invoice_ppn" class="tb_invoice_ppn"><?php echo $tb_invoice->ppn->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_invoice->total_ppn->Visible) { // total_ppn ?>
		<th><span id="elh_tb_invoice_total_ppn" class="tb_invoice_total_ppn"><?php echo $tb_invoice->total_ppn->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_invoice->terbilang->Visible) { // terbilang ?>
		<th><span id="elh_tb_invoice_terbilang" class="tb_invoice_terbilang"><?php echo $tb_invoice->terbilang->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tb_invoice->terbayar->Visible) { // terbayar ?>
		<th><span id="elh_tb_invoice_terbayar" class="tb_invoice_terbayar"><?php echo $tb_invoice->terbayar->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$tb_invoice_delete->RecCnt = 0;
$i = 0;
while (!$tb_invoice_delete->Recordset->EOF) {
	$tb_invoice_delete->RecCnt++;
	$tb_invoice_delete->RowCnt++;

	// Set row properties
	$tb_invoice->ResetAttrs();
	$tb_invoice->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$tb_invoice_delete->LoadRowValues($tb_invoice_delete->Recordset);

	// Render row
	$tb_invoice_delete->RenderRow();
?>
	<tr<?php echo $tb_invoice->RowAttributes() ?>>
<?php if ($tb_invoice->id->Visible) { // id ?>
		<td<?php echo $tb_invoice->id->CellAttributes() ?>>
<span id="el<?php echo $tb_invoice_delete->RowCnt ?>_tb_invoice_id" class="tb_invoice_id">
<span<?php echo $tb_invoice->id->ViewAttributes() ?>>
<?php echo $tb_invoice->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_invoice->customer_id->Visible) { // customer_id ?>
		<td<?php echo $tb_invoice->customer_id->CellAttributes() ?>>
<span id="el<?php echo $tb_invoice_delete->RowCnt ?>_tb_invoice_customer_id" class="tb_invoice_customer_id">
<span<?php echo $tb_invoice->customer_id->ViewAttributes() ?>>
<?php echo $tb_invoice->customer_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_invoice->no_invoice->Visible) { // no_invoice ?>
		<td<?php echo $tb_invoice->no_invoice->CellAttributes() ?>>
<span id="el<?php echo $tb_invoice_delete->RowCnt ?>_tb_invoice_no_invoice" class="tb_invoice_no_invoice">
<span<?php echo $tb_invoice->no_invoice->ViewAttributes() ?>>
<?php echo $tb_invoice->no_invoice->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_invoice->tgl_invoice->Visible) { // tgl_invoice ?>
		<td<?php echo $tb_invoice->tgl_invoice->CellAttributes() ?>>
<span id="el<?php echo $tb_invoice_delete->RowCnt ?>_tb_invoice_tgl_invoice" class="tb_invoice_tgl_invoice">
<span<?php echo $tb_invoice->tgl_invoice->ViewAttributes() ?>>
<?php echo $tb_invoice->tgl_invoice->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_invoice->no_order->Visible) { // no_order ?>
		<td<?php echo $tb_invoice->no_order->CellAttributes() ?>>
<span id="el<?php echo $tb_invoice_delete->RowCnt ?>_tb_invoice_no_order" class="tb_invoice_no_order">
<span<?php echo $tb_invoice->no_order->ViewAttributes() ?>>
<?php echo $tb_invoice->no_order->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_invoice->no_referensi->Visible) { // no_referensi ?>
		<td<?php echo $tb_invoice->no_referensi->CellAttributes() ?>>
<span id="el<?php echo $tb_invoice_delete->RowCnt ?>_tb_invoice_no_referensi" class="tb_invoice_no_referensi">
<span<?php echo $tb_invoice->no_referensi->ViewAttributes() ?>>
<?php echo $tb_invoice->no_referensi->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_invoice->kegiatan->Visible) { // kegiatan ?>
		<td<?php echo $tb_invoice->kegiatan->CellAttributes() ?>>
<span id="el<?php echo $tb_invoice_delete->RowCnt ?>_tb_invoice_kegiatan" class="tb_invoice_kegiatan">
<span<?php echo $tb_invoice->kegiatan->ViewAttributes() ?>>
<?php echo $tb_invoice->kegiatan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_invoice->tgl_pelaksanaan->Visible) { // tgl_pelaksanaan ?>
		<td<?php echo $tb_invoice->tgl_pelaksanaan->CellAttributes() ?>>
<span id="el<?php echo $tb_invoice_delete->RowCnt ?>_tb_invoice_tgl_pelaksanaan" class="tb_invoice_tgl_pelaksanaan">
<span<?php echo $tb_invoice->tgl_pelaksanaan->ViewAttributes() ?>>
<?php echo $tb_invoice->tgl_pelaksanaan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_invoice->no_sertifikat->Visible) { // no_sertifikat ?>
		<td<?php echo $tb_invoice->no_sertifikat->CellAttributes() ?>>
<span id="el<?php echo $tb_invoice_delete->RowCnt ?>_tb_invoice_no_sertifikat" class="tb_invoice_no_sertifikat">
<span<?php echo $tb_invoice->no_sertifikat->ViewAttributes() ?>>
<?php echo $tb_invoice->no_sertifikat->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_invoice->keterangan->Visible) { // keterangan ?>
		<td<?php echo $tb_invoice->keterangan->CellAttributes() ?>>
<span id="el<?php echo $tb_invoice_delete->RowCnt ?>_tb_invoice_keterangan" class="tb_invoice_keterangan">
<span<?php echo $tb_invoice->keterangan->ViewAttributes() ?>>
<?php echo $tb_invoice->keterangan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_invoice->total->Visible) { // total ?>
		<td<?php echo $tb_invoice->total->CellAttributes() ?>>
<span id="el<?php echo $tb_invoice_delete->RowCnt ?>_tb_invoice_total" class="tb_invoice_total">
<span<?php echo $tb_invoice->total->ViewAttributes() ?>>
<?php echo $tb_invoice->total->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_invoice->ppn->Visible) { // ppn ?>
		<td<?php echo $tb_invoice->ppn->CellAttributes() ?>>
<span id="el<?php echo $tb_invoice_delete->RowCnt ?>_tb_invoice_ppn" class="tb_invoice_ppn">
<span<?php echo $tb_invoice->ppn->ViewAttributes() ?>>
<?php echo $tb_invoice->ppn->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_invoice->total_ppn->Visible) { // total_ppn ?>
		<td<?php echo $tb_invoice->total_ppn->CellAttributes() ?>>
<span id="el<?php echo $tb_invoice_delete->RowCnt ?>_tb_invoice_total_ppn" class="tb_invoice_total_ppn">
<span<?php echo $tb_invoice->total_ppn->ViewAttributes() ?>>
<?php echo $tb_invoice->total_ppn->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_invoice->terbilang->Visible) { // terbilang ?>
		<td<?php echo $tb_invoice->terbilang->CellAttributes() ?>>
<span id="el<?php echo $tb_invoice_delete->RowCnt ?>_tb_invoice_terbilang" class="tb_invoice_terbilang">
<span<?php echo $tb_invoice->terbilang->ViewAttributes() ?>>
<?php echo $tb_invoice->terbilang->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tb_invoice->terbayar->Visible) { // terbayar ?>
		<td<?php echo $tb_invoice->terbayar->CellAttributes() ?>>
<span id="el<?php echo $tb_invoice_delete->RowCnt ?>_tb_invoice_terbayar" class="tb_invoice_terbayar">
<span<?php echo $tb_invoice->terbayar->ViewAttributes() ?>>
<?php echo $tb_invoice->terbayar->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$tb_invoice_delete->Recordset->MoveNext();
}
$tb_invoice_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tb_invoice_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ftb_invoicedelete.Init();
</script>
<?php
$tb_invoice_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tb_invoice_delete->Page_Terminate();
?>
