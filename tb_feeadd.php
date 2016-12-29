<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "tb_feeinfo.php" ?>
<?php include_once "tb_invoiceinfo.php" ?>
<?php include_once "tb_userinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$tb_fee_add = NULL; // Initialize page object first

class ctb_fee_add extends ctb_fee {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{E6C293EF-4D71-4FC6-B668-35B8D3E752AB}";

	// Table name
	var $TableName = 'tb_fee';

	// Page object name
	var $PageObjName = 'tb_fee_add';

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
	var $AuditTrailOnAdd = TRUE;
	var $AuditTrailOnEdit = FALSE;
	var $AuditTrailOnDelete = FALSE;
	var $AuditTrailOnView = FALSE;
	var $AuditTrailOnViewData = FALSE;
	var $AuditTrailOnSearch = FALSE;

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
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (tb_fee)
		if (!isset($GLOBALS["tb_fee"]) || get_class($GLOBALS["tb_fee"]) == "ctb_fee") {
			$GLOBALS["tb_fee"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tb_fee"];
		}

		// Table object (tb_invoice)
		if (!isset($GLOBALS['tb_invoice'])) $GLOBALS['tb_invoice'] = new ctb_invoice();

		// Table object (tb_user)
		if (!isset($GLOBALS['tb_user'])) $GLOBALS['tb_user'] = new ctb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tb_fee', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (tb_user)
		if (!isset($UserTable)) {
			$UserTable = new ctb_user();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("tb_feelist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->invoice_id->SetVisibility();
		$this->barang_id->SetVisibility();
		$this->harga->SetVisibility();
		$this->qty->SetVisibility();
		$this->satuan->SetVisibility();
		$this->keterangan->SetVisibility();

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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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
		global $EW_EXPORT, $tb_fee;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tb_fee);
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

			// Handle modal response
			if ($this->IsModal) {
				$row = array();
				$row["url"] = $url;
				echo ew_ArrayToJson(array($row));
			} else {
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["id"] != "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->setKey("id", $this->id->CurrentValue); // Set up key
			} else {
				$this->setKey("id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("tb_feelist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "tb_feelist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "tb_feeview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->invoice_id->CurrentValue = NULL;
		$this->invoice_id->OldValue = $this->invoice_id->CurrentValue;
		$this->barang_id->CurrentValue = NULL;
		$this->barang_id->OldValue = $this->barang_id->CurrentValue;
		$this->harga->CurrentValue = NULL;
		$this->harga->OldValue = $this->harga->CurrentValue;
		$this->qty->CurrentValue = NULL;
		$this->qty->OldValue = $this->qty->CurrentValue;
		$this->satuan->CurrentValue = NULL;
		$this->satuan->OldValue = $this->satuan->CurrentValue;
		$this->keterangan->CurrentValue = NULL;
		$this->keterangan->OldValue = $this->keterangan->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->invoice_id->FldIsDetailKey) {
			$this->invoice_id->setFormValue($objForm->GetValue("x_invoice_id"));
		}
		if (!$this->barang_id->FldIsDetailKey) {
			$this->barang_id->setFormValue($objForm->GetValue("x_barang_id"));
		}
		if (!$this->harga->FldIsDetailKey) {
			$this->harga->setFormValue($objForm->GetValue("x_harga"));
		}
		if (!$this->qty->FldIsDetailKey) {
			$this->qty->setFormValue($objForm->GetValue("x_qty"));
		}
		if (!$this->satuan->FldIsDetailKey) {
			$this->satuan->setFormValue($objForm->GetValue("x_satuan"));
		}
		if (!$this->keterangan->FldIsDetailKey) {
			$this->keterangan->setFormValue($objForm->GetValue("x_keterangan"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->invoice_id->CurrentValue = $this->invoice_id->FormValue;
		$this->barang_id->CurrentValue = $this->barang_id->FormValue;
		$this->harga->CurrentValue = $this->harga->FormValue;
		$this->qty->CurrentValue = $this->qty->FormValue;
		$this->satuan->CurrentValue = $this->satuan->FormValue;
		$this->keterangan->CurrentValue = $this->keterangan->FormValue;
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
		$this->invoice_id->setDbValue($rs->fields('invoice_id'));
		$this->barang_id->setDbValue($rs->fields('barang_id'));
		if (array_key_exists('EV__barang_id', $rs->fields)) {
			$this->barang_id->VirtualValue = $rs->fields('EV__barang_id'); // Set up virtual field value
		} else {
			$this->barang_id->VirtualValue = ""; // Clear value
		}
		$this->harga->setDbValue($rs->fields('harga'));
		$this->qty->setDbValue($rs->fields('qty'));
		$this->satuan->setDbValue($rs->fields('satuan'));
		$this->jumlah->setDbValue($rs->fields('jumlah'));
		$this->keterangan->setDbValue($rs->fields('keterangan'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->invoice_id->DbValue = $row['invoice_id'];
		$this->barang_id->DbValue = $row['barang_id'];
		$this->harga->DbValue = $row['harga'];
		$this->qty->DbValue = $row['qty'];
		$this->satuan->DbValue = $row['satuan'];
		$this->jumlah->DbValue = $row['jumlah'];
		$this->keterangan->DbValue = $row['keterangan'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->harga->FormValue == $this->harga->CurrentValue && is_numeric(ew_StrToFloat($this->harga->CurrentValue)))
			$this->harga->CurrentValue = ew_StrToFloat($this->harga->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// invoice_id
		// barang_id
		// harga
		// qty
		// satuan
		// jumlah
		// keterangan

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// invoice_id
		$this->invoice_id->ViewValue = $this->invoice_id->CurrentValue;
		$this->invoice_id->ViewCustomAttributes = "";

		// barang_id
		if ($this->barang_id->VirtualValue <> "") {
			$this->barang_id->ViewValue = $this->barang_id->VirtualValue;
		} else {
			$this->barang_id->ViewValue = $this->barang_id->CurrentValue;
		if (strval($this->barang_id->CurrentValue) <> "") {
			$sFilterWrk = "`barang_id`" . ew_SearchString("=", $this->barang_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `barang_id`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tb_barang`";
		$sWhereWrk = "";
		$this->barang_id->LookupFilters = array("dx1" => "`nama`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->barang_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->barang_id->ViewValue = $this->barang_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->barang_id->ViewValue = $this->barang_id->CurrentValue;
			}
		} else {
			$this->barang_id->ViewValue = NULL;
		}
		}
		$this->barang_id->ViewCustomAttributes = "";

		// harga
		$this->harga->ViewValue = $this->harga->CurrentValue;
		$this->harga->ViewValue = ew_FormatNumber($this->harga->ViewValue, 2, -2, -2, -1);
		$this->harga->CellCssStyle .= "text-align: right;";
		$this->harga->ViewCustomAttributes = "";

		// qty
		$this->qty->ViewValue = $this->qty->CurrentValue;
		$this->qty->ViewCustomAttributes = "";

		// satuan
		$this->satuan->ViewValue = $this->satuan->CurrentValue;
		$this->satuan->ViewCustomAttributes = "";

		// jumlah
		$this->jumlah->ViewValue = $this->jumlah->CurrentValue;
		$this->jumlah->ViewValue = ew_FormatNumber($this->jumlah->ViewValue, 2, -2, -2, -1);
		$this->jumlah->CellCssStyle .= "text-align: right;";
		$this->jumlah->ViewCustomAttributes = "";

		// keterangan
		$this->keterangan->ViewValue = $this->keterangan->CurrentValue;
		$this->keterangan->ViewCustomAttributes = "";

			// invoice_id
			$this->invoice_id->LinkCustomAttributes = "";
			$this->invoice_id->HrefValue = "";
			$this->invoice_id->TooltipValue = "";

			// barang_id
			$this->barang_id->LinkCustomAttributes = "";
			$this->barang_id->HrefValue = "";
			$this->barang_id->TooltipValue = "";

			// harga
			$this->harga->LinkCustomAttributes = "";
			$this->harga->HrefValue = "";
			$this->harga->TooltipValue = "";

			// qty
			$this->qty->LinkCustomAttributes = "";
			$this->qty->HrefValue = "";
			$this->qty->TooltipValue = "";

			// satuan
			$this->satuan->LinkCustomAttributes = "";
			$this->satuan->HrefValue = "";
			$this->satuan->TooltipValue = "";

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";
			$this->keterangan->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// invoice_id
			$this->invoice_id->EditAttrs["class"] = "form-control";
			$this->invoice_id->EditCustomAttributes = "";
			if ($this->invoice_id->getSessionValue() <> "") {
				$this->invoice_id->CurrentValue = $this->invoice_id->getSessionValue();
			$this->invoice_id->ViewValue = $this->invoice_id->CurrentValue;
			$this->invoice_id->ViewCustomAttributes = "";
			} else {
			$this->invoice_id->EditValue = ew_HtmlEncode($this->invoice_id->CurrentValue);
			$this->invoice_id->PlaceHolder = ew_RemoveHtml($this->invoice_id->FldCaption());
			}

			// barang_id
			$this->barang_id->EditAttrs["class"] = "form-control";
			$this->barang_id->EditCustomAttributes = "";
			$this->barang_id->EditValue = ew_HtmlEncode($this->barang_id->CurrentValue);
			if (strval($this->barang_id->CurrentValue) <> "") {
				$sFilterWrk = "`barang_id`" . ew_SearchString("=", $this->barang_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `barang_id`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tb_barang`";
			$sWhereWrk = "";
			$this->barang_id->LookupFilters = array("dx1" => "`nama`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->barang_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->barang_id->EditValue = $this->barang_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->barang_id->EditValue = ew_HtmlEncode($this->barang_id->CurrentValue);
				}
			} else {
				$this->barang_id->EditValue = NULL;
			}
			$this->barang_id->PlaceHolder = ew_RemoveHtml($this->barang_id->FldCaption());

			// harga
			$this->harga->EditAttrs["class"] = "form-control";
			$this->harga->EditCustomAttributes = "";
			$this->harga->EditValue = ew_HtmlEncode($this->harga->CurrentValue);
			$this->harga->PlaceHolder = ew_RemoveHtml($this->harga->FldCaption());
			if (strval($this->harga->EditValue) <> "" && is_numeric($this->harga->EditValue)) $this->harga->EditValue = ew_FormatNumber($this->harga->EditValue, -2, -2, -2, -1);

			// qty
			$this->qty->EditAttrs["class"] = "form-control";
			$this->qty->EditCustomAttributes = "";
			$this->qty->EditValue = ew_HtmlEncode($this->qty->CurrentValue);
			$this->qty->PlaceHolder = ew_RemoveHtml($this->qty->FldCaption());

			// satuan
			$this->satuan->EditAttrs["class"] = "form-control";
			$this->satuan->EditCustomAttributes = "";
			$this->satuan->EditValue = ew_HtmlEncode($this->satuan->CurrentValue);
			$this->satuan->PlaceHolder = ew_RemoveHtml($this->satuan->FldCaption());

			// keterangan
			$this->keterangan->EditAttrs["class"] = "form-control";
			$this->keterangan->EditCustomAttributes = "";
			$this->keterangan->EditValue = ew_HtmlEncode($this->keterangan->CurrentValue);
			$this->keterangan->PlaceHolder = ew_RemoveHtml($this->keterangan->FldCaption());

			// Add refer script
			// invoice_id

			$this->invoice_id->LinkCustomAttributes = "";
			$this->invoice_id->HrefValue = "";

			// barang_id
			$this->barang_id->LinkCustomAttributes = "";
			$this->barang_id->HrefValue = "";

			// harga
			$this->harga->LinkCustomAttributes = "";
			$this->harga->HrefValue = "";

			// qty
			$this->qty->LinkCustomAttributes = "";
			$this->qty->HrefValue = "";

			// satuan
			$this->satuan->LinkCustomAttributes = "";
			$this->satuan->HrefValue = "";

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!ew_CheckInteger($this->invoice_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->invoice_id->FldErrMsg());
		}
		if (!$this->barang_id->FldIsDetailKey && !is_null($this->barang_id->FormValue) && $this->barang_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->barang_id->FldCaption(), $this->barang_id->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->harga->FormValue)) {
			ew_AddMessage($gsFormError, $this->harga->FldErrMsg());
		}
		if (!ew_CheckInteger($this->qty->FormValue)) {
			ew_AddMessage($gsFormError, $this->qty->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// invoice_id
		$this->invoice_id->SetDbValueDef($rsnew, $this->invoice_id->CurrentValue, NULL, FALSE);

		// barang_id
		$this->barang_id->SetDbValueDef($rsnew, $this->barang_id->CurrentValue, 0, FALSE);

		// harga
		$this->harga->SetDbValueDef($rsnew, $this->harga->CurrentValue, NULL, FALSE);

		// qty
		$this->qty->SetDbValueDef($rsnew, $this->qty->CurrentValue, NULL, FALSE);

		// satuan
		$this->satuan->SetDbValueDef($rsnew, $this->satuan->CurrentValue, NULL, FALSE);

		// keterangan
		$this->keterangan->SetDbValueDef($rsnew, $this->keterangan->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->id->setDbValue($conn->Insert_ID());
				$rsnew['id'] = $this->id->DbValue;
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
			$this->WriteAuditTrailOnAdd($rsnew);
		}
		return $AddRow;
	}

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "tb_invoice") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_id"] <> "") {
					$GLOBALS["tb_invoice"]->id->setQueryStringValue($_GET["fk_id"]);
					$this->invoice_id->setQueryStringValue($GLOBALS["tb_invoice"]->id->QueryStringValue);
					$this->invoice_id->setSessionValue($this->invoice_id->QueryStringValue);
					if (!is_numeric($GLOBALS["tb_invoice"]->id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "tb_invoice") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_id"] <> "") {
					$GLOBALS["tb_invoice"]->id->setFormValue($_POST["fk_id"]);
					$this->invoice_id->setFormValue($GLOBALS["tb_invoice"]->id->FormValue);
					$this->invoice_id->setSessionValue($this->invoice_id->FormValue);
					if (!is_numeric($GLOBALS["tb_invoice"]->id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "tb_invoice") {
				if ($this->invoice_id->CurrentValue == "") $this->invoice_id->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tb_feelist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_barang_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `barang_id` AS `LinkFld`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tb_barang`";
			$sWhereWrk = "{filter}";
			$this->barang_id->LookupFilters = array("dx1" => "`nama`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`barang_id` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->barang_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_barang_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `barang_id`, `nama` AS `DispFld` FROM `tb_barang`";
			$sWhereWrk = "`nama` LIKE '{query_value}%'";
			$this->barang_id->LookupFilters = array("dx1" => "`nama`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->barang_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'tb_fee';
		$usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'tb_fee';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserName();
		foreach (array_keys($rs) as $fldname) {
			if ($this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$newvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$newvalue = $rs[$fldname];
					else
						$newvalue = "[MEMO]"; // Memo Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$newvalue = "[XML]"; // XML Field
				} else {
					$newvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $usr, "A", $table, $fldname, $key, "", $newvalue);
			}
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($tb_fee_add)) $tb_fee_add = new ctb_fee_add();

// Page init
$tb_fee_add->Page_Init();

// Page main
$tb_fee_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_fee_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ftb_feeadd = new ew_Form("ftb_feeadd", "add");

// Validate form
ftb_feeadd.Validate = function() {
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

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
ftb_feeadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftb_feeadd.ValidateRequired = true;
<?php } else { ?>
ftb_feeadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftb_feeadd.Lists["x_barang_id"] = {"LinkField":"x_barang_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tb_barang"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$tb_fee_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $tb_fee_add->ShowPageHeader(); ?>
<?php
$tb_fee_add->ShowMessage();
?>
<form name="ftb_feeadd" id="ftb_feeadd" class="<?php echo $tb_fee_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tb_fee_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tb_fee_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tb_fee">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($tb_fee_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($tb_fee->getCurrentMasterTable() == "tb_invoice") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="tb_invoice">
<input type="hidden" name="fk_id" value="<?php echo $tb_fee->invoice_id->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($tb_fee->invoice_id->Visible) { // invoice_id ?>
	<div id="r_invoice_id" class="form-group">
		<label id="elh_tb_fee_invoice_id" for="x_invoice_id" class="col-sm-2 control-label ewLabel"><?php echo $tb_fee->invoice_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tb_fee->invoice_id->CellAttributes() ?>>
<?php if ($tb_fee->invoice_id->getSessionValue() <> "") { ?>
<span id="el_tb_fee_invoice_id">
<span<?php echo $tb_fee->invoice_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_fee->invoice_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_invoice_id" name="x_invoice_id" value="<?php echo ew_HtmlEncode($tb_fee->invoice_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_tb_fee_invoice_id">
<input type="text" data-table="tb_fee" data-field="x_invoice_id" name="x_invoice_id" id="x_invoice_id" size="30" placeholder="<?php echo ew_HtmlEncode($tb_fee->invoice_id->getPlaceHolder()) ?>" value="<?php echo $tb_fee->invoice_id->EditValue ?>"<?php echo $tb_fee->invoice_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $tb_fee->invoice_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_fee->barang_id->Visible) { // barang_id ?>
	<div id="r_barang_id" class="form-group">
		<label id="elh_tb_fee_barang_id" class="col-sm-2 control-label ewLabel"><?php echo $tb_fee->barang_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_fee->barang_id->CellAttributes() ?>>
<span id="el_tb_fee_barang_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_barang_id"><?php echo (strval($tb_fee->barang_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $tb_fee->barang_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_fee->barang_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_barang_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="tb_fee" data-field="x_barang_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_fee->barang_id->DisplayValueSeparatorAttribute() ?>" name="x_barang_id" id="x_barang_id" value="<?php echo $tb_fee->barang_id->CurrentValue ?>"<?php echo $tb_fee->barang_id->EditAttributes() ?>>
<input type="hidden" name="s_x_barang_id" id="s_x_barang_id" value="<?php echo $tb_fee->barang_id->LookupFilterQuery() ?>">
</span>
<?php echo $tb_fee->barang_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_fee->harga->Visible) { // harga ?>
	<div id="r_harga" class="form-group">
		<label id="elh_tb_fee_harga" for="x_harga" class="col-sm-2 control-label ewLabel"><?php echo $tb_fee->harga->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tb_fee->harga->CellAttributes() ?>>
<span id="el_tb_fee_harga">
<input type="text" data-table="tb_fee" data-field="x_harga" name="x_harga" id="x_harga" size="30" placeholder="<?php echo ew_HtmlEncode($tb_fee->harga->getPlaceHolder()) ?>" value="<?php echo $tb_fee->harga->EditValue ?>"<?php echo $tb_fee->harga->EditAttributes() ?>>
</span>
<?php echo $tb_fee->harga->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_fee->qty->Visible) { // qty ?>
	<div id="r_qty" class="form-group">
		<label id="elh_tb_fee_qty" for="x_qty" class="col-sm-2 control-label ewLabel"><?php echo $tb_fee->qty->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tb_fee->qty->CellAttributes() ?>>
<span id="el_tb_fee_qty">
<input type="text" data-table="tb_fee" data-field="x_qty" name="x_qty" id="x_qty" size="30" placeholder="<?php echo ew_HtmlEncode($tb_fee->qty->getPlaceHolder()) ?>" value="<?php echo $tb_fee->qty->EditValue ?>"<?php echo $tb_fee->qty->EditAttributes() ?>>
</span>
<?php echo $tb_fee->qty->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_fee->satuan->Visible) { // satuan ?>
	<div id="r_satuan" class="form-group">
		<label id="elh_tb_fee_satuan" for="x_satuan" class="col-sm-2 control-label ewLabel"><?php echo $tb_fee->satuan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tb_fee->satuan->CellAttributes() ?>>
<span id="el_tb_fee_satuan">
<input type="text" data-table="tb_fee" data-field="x_satuan" name="x_satuan" id="x_satuan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tb_fee->satuan->getPlaceHolder()) ?>" value="<?php echo $tb_fee->satuan->EditValue ?>"<?php echo $tb_fee->satuan->EditAttributes() ?>>
</span>
<?php echo $tb_fee->satuan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_fee->keterangan->Visible) { // keterangan ?>
	<div id="r_keterangan" class="form-group">
		<label id="elh_tb_fee_keterangan" for="x_keterangan" class="col-sm-2 control-label ewLabel"><?php echo $tb_fee->keterangan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tb_fee->keterangan->CellAttributes() ?>>
<span id="el_tb_fee_keterangan">
<textarea data-table="tb_fee" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($tb_fee->keterangan->getPlaceHolder()) ?>"<?php echo $tb_fee->keterangan->EditAttributes() ?>><?php echo $tb_fee->keterangan->EditValue ?></textarea>
</span>
<?php echo $tb_fee->keterangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$tb_fee_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tb_fee_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ftb_feeadd.Init();
</script>
<?php
$tb_fee_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tb_fee_add->Page_Terminate();
?>
