<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "view6info.php" ?>
<?php include_once "tb_userinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$view6_add = NULL; // Initialize page object first

class cview6_add extends cview6 {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{E6C293EF-4D71-4FC6-B668-35B8D3E752AB}";

	// Table name
	var $TableName = 'view6';

	// Page object name
	var $PageObjName = 'view6_add';

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
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (view6)
		if (!isset($GLOBALS["view6"]) || get_class($GLOBALS["view6"]) == "cview6") {
			$GLOBALS["view6"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["view6"];
		}

		// Table object (tb_user)
		if (!isset($GLOBALS['tb_user'])) $GLOBALS['tb_user'] = new ctb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'view6', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("view6list.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
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
		$this->pasal23->SetVisibility();

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
		global $EW_EXPORT, $view6;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($view6);
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
					$this->Page_Terminate("view6list.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "view6list.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "view6view.php")
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
		$this->customer_id->CurrentValue = NULL;
		$this->customer_id->OldValue = $this->customer_id->CurrentValue;
		$this->no_invoice->CurrentValue = NULL;
		$this->no_invoice->OldValue = $this->no_invoice->CurrentValue;
		$this->tgl_invoice->CurrentValue = NULL;
		$this->tgl_invoice->OldValue = $this->tgl_invoice->CurrentValue;
		$this->no_order->CurrentValue = NULL;
		$this->no_order->OldValue = $this->no_order->CurrentValue;
		$this->no_referensi->CurrentValue = NULL;
		$this->no_referensi->OldValue = $this->no_referensi->CurrentValue;
		$this->kegiatan->CurrentValue = NULL;
		$this->kegiatan->OldValue = $this->kegiatan->CurrentValue;
		$this->tgl_pelaksanaan->CurrentValue = NULL;
		$this->tgl_pelaksanaan->OldValue = $this->tgl_pelaksanaan->CurrentValue;
		$this->no_sertifikat->CurrentValue = NULL;
		$this->no_sertifikat->OldValue = $this->no_sertifikat->CurrentValue;
		$this->keterangan->CurrentValue = NULL;
		$this->keterangan->OldValue = $this->keterangan->CurrentValue;
		$this->total->CurrentValue = NULL;
		$this->total->OldValue = $this->total->CurrentValue;
		$this->ppn->CurrentValue = NULL;
		$this->ppn->OldValue = $this->ppn->CurrentValue;
		$this->total_ppn->CurrentValue = NULL;
		$this->total_ppn->OldValue = $this->total_ppn->CurrentValue;
		$this->terbilang->CurrentValue = NULL;
		$this->terbilang->OldValue = $this->terbilang->CurrentValue;
		$this->terbayar->CurrentValue = NULL;
		$this->terbayar->OldValue = $this->terbayar->CurrentValue;
		$this->pasal23->CurrentValue = 0;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->customer_id->FldIsDetailKey) {
			$this->customer_id->setFormValue($objForm->GetValue("x_customer_id"));
		}
		if (!$this->no_invoice->FldIsDetailKey) {
			$this->no_invoice->setFormValue($objForm->GetValue("x_no_invoice"));
		}
		if (!$this->tgl_invoice->FldIsDetailKey) {
			$this->tgl_invoice->setFormValue($objForm->GetValue("x_tgl_invoice"));
			$this->tgl_invoice->CurrentValue = ew_UnFormatDateTime($this->tgl_invoice->CurrentValue, 0);
		}
		if (!$this->no_order->FldIsDetailKey) {
			$this->no_order->setFormValue($objForm->GetValue("x_no_order"));
		}
		if (!$this->no_referensi->FldIsDetailKey) {
			$this->no_referensi->setFormValue($objForm->GetValue("x_no_referensi"));
		}
		if (!$this->kegiatan->FldIsDetailKey) {
			$this->kegiatan->setFormValue($objForm->GetValue("x_kegiatan"));
		}
		if (!$this->tgl_pelaksanaan->FldIsDetailKey) {
			$this->tgl_pelaksanaan->setFormValue($objForm->GetValue("x_tgl_pelaksanaan"));
			$this->tgl_pelaksanaan->CurrentValue = ew_UnFormatDateTime($this->tgl_pelaksanaan->CurrentValue, 0);
		}
		if (!$this->no_sertifikat->FldIsDetailKey) {
			$this->no_sertifikat->setFormValue($objForm->GetValue("x_no_sertifikat"));
		}
		if (!$this->keterangan->FldIsDetailKey) {
			$this->keterangan->setFormValue($objForm->GetValue("x_keterangan"));
		}
		if (!$this->total->FldIsDetailKey) {
			$this->total->setFormValue($objForm->GetValue("x_total"));
		}
		if (!$this->ppn->FldIsDetailKey) {
			$this->ppn->setFormValue($objForm->GetValue("x_ppn"));
		}
		if (!$this->total_ppn->FldIsDetailKey) {
			$this->total_ppn->setFormValue($objForm->GetValue("x_total_ppn"));
		}
		if (!$this->terbilang->FldIsDetailKey) {
			$this->terbilang->setFormValue($objForm->GetValue("x_terbilang"));
		}
		if (!$this->terbayar->FldIsDetailKey) {
			$this->terbayar->setFormValue($objForm->GetValue("x_terbayar"));
		}
		if (!$this->pasal23->FldIsDetailKey) {
			$this->pasal23->setFormValue($objForm->GetValue("x_pasal23"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->customer_id->CurrentValue = $this->customer_id->FormValue;
		$this->no_invoice->CurrentValue = $this->no_invoice->FormValue;
		$this->tgl_invoice->CurrentValue = $this->tgl_invoice->FormValue;
		$this->tgl_invoice->CurrentValue = ew_UnFormatDateTime($this->tgl_invoice->CurrentValue, 0);
		$this->no_order->CurrentValue = $this->no_order->FormValue;
		$this->no_referensi->CurrentValue = $this->no_referensi->FormValue;
		$this->kegiatan->CurrentValue = $this->kegiatan->FormValue;
		$this->tgl_pelaksanaan->CurrentValue = $this->tgl_pelaksanaan->FormValue;
		$this->tgl_pelaksanaan->CurrentValue = ew_UnFormatDateTime($this->tgl_pelaksanaan->CurrentValue, 0);
		$this->no_sertifikat->CurrentValue = $this->no_sertifikat->FormValue;
		$this->keterangan->CurrentValue = $this->keterangan->FormValue;
		$this->total->CurrentValue = $this->total->FormValue;
		$this->ppn->CurrentValue = $this->ppn->FormValue;
		$this->total_ppn->CurrentValue = $this->total_ppn->FormValue;
		$this->terbilang->CurrentValue = $this->terbilang->FormValue;
		$this->terbayar->CurrentValue = $this->terbayar->FormValue;
		$this->pasal23->CurrentValue = $this->pasal23->FormValue;
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
		$this->pasal23->setDbValue($rs->fields('pasal23'));
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
		$this->pasal23->DbValue = $row['pasal23'];
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
		// pasal23

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// customer_id
		$this->customer_id->ViewValue = $this->customer_id->CurrentValue;
		$this->customer_id->ViewCustomAttributes = "";

		// no_invoice
		$this->no_invoice->ViewValue = $this->no_invoice->CurrentValue;
		$this->no_invoice->ViewCustomAttributes = "";

		// tgl_invoice
		$this->tgl_invoice->ViewValue = $this->tgl_invoice->CurrentValue;
		$this->tgl_invoice->ViewValue = ew_FormatDateTime($this->tgl_invoice->ViewValue, 0);
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
		$this->tgl_pelaksanaan->ViewValue = ew_FormatDateTime($this->tgl_pelaksanaan->ViewValue, 0);
		$this->tgl_pelaksanaan->ViewCustomAttributes = "";

		// no_sertifikat
		$this->no_sertifikat->ViewValue = $this->no_sertifikat->CurrentValue;
		$this->no_sertifikat->ViewCustomAttributes = "";

		// keterangan
		$this->keterangan->ViewValue = $this->keterangan->CurrentValue;
		$this->keterangan->ViewCustomAttributes = "";

		// total
		$this->total->ViewValue = $this->total->CurrentValue;
		$this->total->ViewCustomAttributes = "";

		// ppn
		$this->ppn->ViewValue = $this->ppn->CurrentValue;
		$this->ppn->ViewCustomAttributes = "";

		// total_ppn
		$this->total_ppn->ViewValue = $this->total_ppn->CurrentValue;
		$this->total_ppn->ViewCustomAttributes = "";

		// terbilang
		$this->terbilang->ViewValue = $this->terbilang->CurrentValue;
		$this->terbilang->ViewCustomAttributes = "";

		// terbayar
		$this->terbayar->ViewValue = $this->terbayar->CurrentValue;
		$this->terbayar->ViewCustomAttributes = "";

		// pasal23
		$this->pasal23->ViewValue = $this->pasal23->CurrentValue;
		$this->pasal23->ViewCustomAttributes = "";

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

			// pasal23
			$this->pasal23->LinkCustomAttributes = "";
			$this->pasal23->HrefValue = "";
			$this->pasal23->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// customer_id
			$this->customer_id->EditAttrs["class"] = "form-control";
			$this->customer_id->EditCustomAttributes = "";
			$this->customer_id->EditValue = ew_HtmlEncode($this->customer_id->CurrentValue);
			$this->customer_id->PlaceHolder = ew_RemoveHtml($this->customer_id->FldCaption());

			// no_invoice
			$this->no_invoice->EditAttrs["class"] = "form-control";
			$this->no_invoice->EditCustomAttributes = "";
			$this->no_invoice->EditValue = ew_HtmlEncode($this->no_invoice->CurrentValue);
			$this->no_invoice->PlaceHolder = ew_RemoveHtml($this->no_invoice->FldCaption());

			// tgl_invoice
			$this->tgl_invoice->EditAttrs["class"] = "form-control";
			$this->tgl_invoice->EditCustomAttributes = "";
			$this->tgl_invoice->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_invoice->CurrentValue, 8));
			$this->tgl_invoice->PlaceHolder = ew_RemoveHtml($this->tgl_invoice->FldCaption());

			// no_order
			$this->no_order->EditAttrs["class"] = "form-control";
			$this->no_order->EditCustomAttributes = "";
			$this->no_order->EditValue = ew_HtmlEncode($this->no_order->CurrentValue);
			$this->no_order->PlaceHolder = ew_RemoveHtml($this->no_order->FldCaption());

			// no_referensi
			$this->no_referensi->EditAttrs["class"] = "form-control";
			$this->no_referensi->EditCustomAttributes = "";
			$this->no_referensi->EditValue = ew_HtmlEncode($this->no_referensi->CurrentValue);
			$this->no_referensi->PlaceHolder = ew_RemoveHtml($this->no_referensi->FldCaption());

			// kegiatan
			$this->kegiatan->EditAttrs["class"] = "form-control";
			$this->kegiatan->EditCustomAttributes = "";
			$this->kegiatan->EditValue = ew_HtmlEncode($this->kegiatan->CurrentValue);
			$this->kegiatan->PlaceHolder = ew_RemoveHtml($this->kegiatan->FldCaption());

			// tgl_pelaksanaan
			$this->tgl_pelaksanaan->EditAttrs["class"] = "form-control";
			$this->tgl_pelaksanaan->EditCustomAttributes = "";
			$this->tgl_pelaksanaan->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_pelaksanaan->CurrentValue, 8));
			$this->tgl_pelaksanaan->PlaceHolder = ew_RemoveHtml($this->tgl_pelaksanaan->FldCaption());

			// no_sertifikat
			$this->no_sertifikat->EditAttrs["class"] = "form-control";
			$this->no_sertifikat->EditCustomAttributes = "";
			$this->no_sertifikat->EditValue = ew_HtmlEncode($this->no_sertifikat->CurrentValue);
			$this->no_sertifikat->PlaceHolder = ew_RemoveHtml($this->no_sertifikat->FldCaption());

			// keterangan
			$this->keterangan->EditAttrs["class"] = "form-control";
			$this->keterangan->EditCustomAttributes = "";
			$this->keterangan->EditValue = ew_HtmlEncode($this->keterangan->CurrentValue);
			$this->keterangan->PlaceHolder = ew_RemoveHtml($this->keterangan->FldCaption());

			// total
			$this->total->EditAttrs["class"] = "form-control";
			$this->total->EditCustomAttributes = "";
			$this->total->EditValue = ew_HtmlEncode($this->total->CurrentValue);
			$this->total->PlaceHolder = ew_RemoveHtml($this->total->FldCaption());
			if (strval($this->total->EditValue) <> "" && is_numeric($this->total->EditValue)) $this->total->EditValue = ew_FormatNumber($this->total->EditValue, -2, -1, -2, 0);

			// ppn
			$this->ppn->EditAttrs["class"] = "form-control";
			$this->ppn->EditCustomAttributes = "";
			$this->ppn->EditValue = ew_HtmlEncode($this->ppn->CurrentValue);
			$this->ppn->PlaceHolder = ew_RemoveHtml($this->ppn->FldCaption());

			// total_ppn
			$this->total_ppn->EditAttrs["class"] = "form-control";
			$this->total_ppn->EditCustomAttributes = "";
			$this->total_ppn->EditValue = ew_HtmlEncode($this->total_ppn->CurrentValue);
			$this->total_ppn->PlaceHolder = ew_RemoveHtml($this->total_ppn->FldCaption());
			if (strval($this->total_ppn->EditValue) <> "" && is_numeric($this->total_ppn->EditValue)) $this->total_ppn->EditValue = ew_FormatNumber($this->total_ppn->EditValue, -2, -1, -2, 0);

			// terbilang
			$this->terbilang->EditAttrs["class"] = "form-control";
			$this->terbilang->EditCustomAttributes = "";
			$this->terbilang->EditValue = ew_HtmlEncode($this->terbilang->CurrentValue);
			$this->terbilang->PlaceHolder = ew_RemoveHtml($this->terbilang->FldCaption());

			// terbayar
			$this->terbayar->EditAttrs["class"] = "form-control";
			$this->terbayar->EditCustomAttributes = "";
			$this->terbayar->EditValue = ew_HtmlEncode($this->terbayar->CurrentValue);
			$this->terbayar->PlaceHolder = ew_RemoveHtml($this->terbayar->FldCaption());

			// pasal23
			$this->pasal23->EditAttrs["class"] = "form-control";
			$this->pasal23->EditCustomAttributes = "";
			$this->pasal23->EditValue = ew_HtmlEncode($this->pasal23->CurrentValue);
			$this->pasal23->PlaceHolder = ew_RemoveHtml($this->pasal23->FldCaption());

			// Add refer script
			// customer_id

			$this->customer_id->LinkCustomAttributes = "";
			$this->customer_id->HrefValue = "";

			// no_invoice
			$this->no_invoice->LinkCustomAttributes = "";
			$this->no_invoice->HrefValue = "";

			// tgl_invoice
			$this->tgl_invoice->LinkCustomAttributes = "";
			$this->tgl_invoice->HrefValue = "";

			// no_order
			$this->no_order->LinkCustomAttributes = "";
			$this->no_order->HrefValue = "";

			// no_referensi
			$this->no_referensi->LinkCustomAttributes = "";
			$this->no_referensi->HrefValue = "";

			// kegiatan
			$this->kegiatan->LinkCustomAttributes = "";
			$this->kegiatan->HrefValue = "";

			// tgl_pelaksanaan
			$this->tgl_pelaksanaan->LinkCustomAttributes = "";
			$this->tgl_pelaksanaan->HrefValue = "";

			// no_sertifikat
			$this->no_sertifikat->LinkCustomAttributes = "";
			$this->no_sertifikat->HrefValue = "";

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";

			// total
			$this->total->LinkCustomAttributes = "";
			$this->total->HrefValue = "";

			// ppn
			$this->ppn->LinkCustomAttributes = "";
			$this->ppn->HrefValue = "";

			// total_ppn
			$this->total_ppn->LinkCustomAttributes = "";
			$this->total_ppn->HrefValue = "";

			// terbilang
			$this->terbilang->LinkCustomAttributes = "";
			$this->terbilang->HrefValue = "";

			// terbayar
			$this->terbayar->LinkCustomAttributes = "";
			$this->terbayar->HrefValue = "";

			// pasal23
			$this->pasal23->LinkCustomAttributes = "";
			$this->pasal23->HrefValue = "";
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
		if (!$this->customer_id->FldIsDetailKey && !is_null($this->customer_id->FormValue) && $this->customer_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->customer_id->FldCaption(), $this->customer_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->customer_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->customer_id->FldErrMsg());
		}
		if (!$this->no_invoice->FldIsDetailKey && !is_null($this->no_invoice->FormValue) && $this->no_invoice->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->no_invoice->FldCaption(), $this->no_invoice->ReqErrMsg));
		}
		if (!$this->tgl_invoice->FldIsDetailKey && !is_null($this->tgl_invoice->FormValue) && $this->tgl_invoice->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tgl_invoice->FldCaption(), $this->tgl_invoice->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->tgl_invoice->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_invoice->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tgl_pelaksanaan->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_pelaksanaan->FldErrMsg());
		}
		if (!ew_CheckNumber($this->total->FormValue)) {
			ew_AddMessage($gsFormError, $this->total->FldErrMsg());
		}
		if (!ew_CheckInteger($this->ppn->FormValue)) {
			ew_AddMessage($gsFormError, $this->ppn->FldErrMsg());
		}
		if (!ew_CheckNumber($this->total_ppn->FormValue)) {
			ew_AddMessage($gsFormError, $this->total_ppn->FldErrMsg());
		}
		if (!ew_CheckInteger($this->terbayar->FormValue)) {
			ew_AddMessage($gsFormError, $this->terbayar->FldErrMsg());
		}
		if (!ew_CheckInteger($this->pasal23->FormValue)) {
			ew_AddMessage($gsFormError, $this->pasal23->FldErrMsg());
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

		// customer_id
		$this->customer_id->SetDbValueDef($rsnew, $this->customer_id->CurrentValue, 0, FALSE);

		// no_invoice
		$this->no_invoice->SetDbValueDef($rsnew, $this->no_invoice->CurrentValue, "", FALSE);

		// tgl_invoice
		$this->tgl_invoice->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_invoice->CurrentValue, 0), ew_CurrentDate(), FALSE);

		// no_order
		$this->no_order->SetDbValueDef($rsnew, $this->no_order->CurrentValue, NULL, FALSE);

		// no_referensi
		$this->no_referensi->SetDbValueDef($rsnew, $this->no_referensi->CurrentValue, NULL, FALSE);

		// kegiatan
		$this->kegiatan->SetDbValueDef($rsnew, $this->kegiatan->CurrentValue, NULL, FALSE);

		// tgl_pelaksanaan
		$this->tgl_pelaksanaan->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_pelaksanaan->CurrentValue, 0), NULL, FALSE);

		// no_sertifikat
		$this->no_sertifikat->SetDbValueDef($rsnew, $this->no_sertifikat->CurrentValue, NULL, FALSE);

		// keterangan
		$this->keterangan->SetDbValueDef($rsnew, $this->keterangan->CurrentValue, NULL, FALSE);

		// total
		$this->total->SetDbValueDef($rsnew, $this->total->CurrentValue, NULL, FALSE);

		// ppn
		$this->ppn->SetDbValueDef($rsnew, $this->ppn->CurrentValue, NULL, FALSE);

		// total_ppn
		$this->total_ppn->SetDbValueDef($rsnew, $this->total_ppn->CurrentValue, NULL, FALSE);

		// terbilang
		$this->terbilang->SetDbValueDef($rsnew, $this->terbilang->CurrentValue, NULL, FALSE);

		// terbayar
		$this->terbayar->SetDbValueDef($rsnew, $this->terbayar->CurrentValue, NULL, FALSE);

		// pasal23
		$this->pasal23->SetDbValueDef($rsnew, $this->pasal23->CurrentValue, NULL, strval($this->pasal23->CurrentValue) == "");

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
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("view6list.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($view6_add)) $view6_add = new cview6_add();

// Page init
$view6_add->Page_Init();

// Page main
$view6_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$view6_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fview6add = new ew_Form("fview6add", "add");

// Validate form
fview6add.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_customer_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $view6->customer_id->FldCaption(), $view6->customer_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_customer_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($view6->customer_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_no_invoice");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $view6->no_invoice->FldCaption(), $view6->no_invoice->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tgl_invoice");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $view6->tgl_invoice->FldCaption(), $view6->tgl_invoice->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tgl_invoice");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($view6->tgl_invoice->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tgl_pelaksanaan");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($view6->tgl_pelaksanaan->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_total");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($view6->total->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_ppn");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($view6->ppn->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_total_ppn");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($view6->total_ppn->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_terbayar");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($view6->terbayar->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pasal23");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($view6->pasal23->FldErrMsg()) ?>");

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
fview6add.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fview6add.ValidateRequired = true;
<?php } else { ?>
fview6add.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$view6_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $view6_add->ShowPageHeader(); ?>
<?php
$view6_add->ShowMessage();
?>
<form name="fview6add" id="fview6add" class="<?php echo $view6_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($view6_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $view6_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="view6">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($view6_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($view6->customer_id->Visible) { // customer_id ?>
	<div id="r_customer_id" class="form-group">
		<label id="elh_view6_customer_id" for="x_customer_id" class="col-sm-2 control-label ewLabel"><?php echo $view6->customer_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $view6->customer_id->CellAttributes() ?>>
<span id="el_view6_customer_id">
<input type="text" data-table="view6" data-field="x_customer_id" name="x_customer_id" id="x_customer_id" size="30" placeholder="<?php echo ew_HtmlEncode($view6->customer_id->getPlaceHolder()) ?>" value="<?php echo $view6->customer_id->EditValue ?>"<?php echo $view6->customer_id->EditAttributes() ?>>
</span>
<?php echo $view6->customer_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($view6->no_invoice->Visible) { // no_invoice ?>
	<div id="r_no_invoice" class="form-group">
		<label id="elh_view6_no_invoice" for="x_no_invoice" class="col-sm-2 control-label ewLabel"><?php echo $view6->no_invoice->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $view6->no_invoice->CellAttributes() ?>>
<span id="el_view6_no_invoice">
<input type="text" data-table="view6" data-field="x_no_invoice" name="x_no_invoice" id="x_no_invoice" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($view6->no_invoice->getPlaceHolder()) ?>" value="<?php echo $view6->no_invoice->EditValue ?>"<?php echo $view6->no_invoice->EditAttributes() ?>>
</span>
<?php echo $view6->no_invoice->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($view6->tgl_invoice->Visible) { // tgl_invoice ?>
	<div id="r_tgl_invoice" class="form-group">
		<label id="elh_view6_tgl_invoice" for="x_tgl_invoice" class="col-sm-2 control-label ewLabel"><?php echo $view6->tgl_invoice->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $view6->tgl_invoice->CellAttributes() ?>>
<span id="el_view6_tgl_invoice">
<input type="text" data-table="view6" data-field="x_tgl_invoice" name="x_tgl_invoice" id="x_tgl_invoice" placeholder="<?php echo ew_HtmlEncode($view6->tgl_invoice->getPlaceHolder()) ?>" value="<?php echo $view6->tgl_invoice->EditValue ?>"<?php echo $view6->tgl_invoice->EditAttributes() ?>>
</span>
<?php echo $view6->tgl_invoice->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($view6->no_order->Visible) { // no_order ?>
	<div id="r_no_order" class="form-group">
		<label id="elh_view6_no_order" for="x_no_order" class="col-sm-2 control-label ewLabel"><?php echo $view6->no_order->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $view6->no_order->CellAttributes() ?>>
<span id="el_view6_no_order">
<input type="text" data-table="view6" data-field="x_no_order" name="x_no_order" id="x_no_order" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($view6->no_order->getPlaceHolder()) ?>" value="<?php echo $view6->no_order->EditValue ?>"<?php echo $view6->no_order->EditAttributes() ?>>
</span>
<?php echo $view6->no_order->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($view6->no_referensi->Visible) { // no_referensi ?>
	<div id="r_no_referensi" class="form-group">
		<label id="elh_view6_no_referensi" for="x_no_referensi" class="col-sm-2 control-label ewLabel"><?php echo $view6->no_referensi->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $view6->no_referensi->CellAttributes() ?>>
<span id="el_view6_no_referensi">
<input type="text" data-table="view6" data-field="x_no_referensi" name="x_no_referensi" id="x_no_referensi" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($view6->no_referensi->getPlaceHolder()) ?>" value="<?php echo $view6->no_referensi->EditValue ?>"<?php echo $view6->no_referensi->EditAttributes() ?>>
</span>
<?php echo $view6->no_referensi->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($view6->kegiatan->Visible) { // kegiatan ?>
	<div id="r_kegiatan" class="form-group">
		<label id="elh_view6_kegiatan" for="x_kegiatan" class="col-sm-2 control-label ewLabel"><?php echo $view6->kegiatan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $view6->kegiatan->CellAttributes() ?>>
<span id="el_view6_kegiatan">
<textarea data-table="view6" data-field="x_kegiatan" name="x_kegiatan" id="x_kegiatan" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($view6->kegiatan->getPlaceHolder()) ?>"<?php echo $view6->kegiatan->EditAttributes() ?>><?php echo $view6->kegiatan->EditValue ?></textarea>
</span>
<?php echo $view6->kegiatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($view6->tgl_pelaksanaan->Visible) { // tgl_pelaksanaan ?>
	<div id="r_tgl_pelaksanaan" class="form-group">
		<label id="elh_view6_tgl_pelaksanaan" for="x_tgl_pelaksanaan" class="col-sm-2 control-label ewLabel"><?php echo $view6->tgl_pelaksanaan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $view6->tgl_pelaksanaan->CellAttributes() ?>>
<span id="el_view6_tgl_pelaksanaan">
<input type="text" data-table="view6" data-field="x_tgl_pelaksanaan" name="x_tgl_pelaksanaan" id="x_tgl_pelaksanaan" placeholder="<?php echo ew_HtmlEncode($view6->tgl_pelaksanaan->getPlaceHolder()) ?>" value="<?php echo $view6->tgl_pelaksanaan->EditValue ?>"<?php echo $view6->tgl_pelaksanaan->EditAttributes() ?>>
</span>
<?php echo $view6->tgl_pelaksanaan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($view6->no_sertifikat->Visible) { // no_sertifikat ?>
	<div id="r_no_sertifikat" class="form-group">
		<label id="elh_view6_no_sertifikat" for="x_no_sertifikat" class="col-sm-2 control-label ewLabel"><?php echo $view6->no_sertifikat->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $view6->no_sertifikat->CellAttributes() ?>>
<span id="el_view6_no_sertifikat">
<input type="text" data-table="view6" data-field="x_no_sertifikat" name="x_no_sertifikat" id="x_no_sertifikat" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($view6->no_sertifikat->getPlaceHolder()) ?>" value="<?php echo $view6->no_sertifikat->EditValue ?>"<?php echo $view6->no_sertifikat->EditAttributes() ?>>
</span>
<?php echo $view6->no_sertifikat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($view6->keterangan->Visible) { // keterangan ?>
	<div id="r_keterangan" class="form-group">
		<label id="elh_view6_keterangan" for="x_keterangan" class="col-sm-2 control-label ewLabel"><?php echo $view6->keterangan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $view6->keterangan->CellAttributes() ?>>
<span id="el_view6_keterangan">
<textarea data-table="view6" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($view6->keterangan->getPlaceHolder()) ?>"<?php echo $view6->keterangan->EditAttributes() ?>><?php echo $view6->keterangan->EditValue ?></textarea>
</span>
<?php echo $view6->keterangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($view6->total->Visible) { // total ?>
	<div id="r_total" class="form-group">
		<label id="elh_view6_total" for="x_total" class="col-sm-2 control-label ewLabel"><?php echo $view6->total->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $view6->total->CellAttributes() ?>>
<span id="el_view6_total">
<input type="text" data-table="view6" data-field="x_total" name="x_total" id="x_total" size="30" placeholder="<?php echo ew_HtmlEncode($view6->total->getPlaceHolder()) ?>" value="<?php echo $view6->total->EditValue ?>"<?php echo $view6->total->EditAttributes() ?>>
</span>
<?php echo $view6->total->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($view6->ppn->Visible) { // ppn ?>
	<div id="r_ppn" class="form-group">
		<label id="elh_view6_ppn" for="x_ppn" class="col-sm-2 control-label ewLabel"><?php echo $view6->ppn->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $view6->ppn->CellAttributes() ?>>
<span id="el_view6_ppn">
<input type="text" data-table="view6" data-field="x_ppn" name="x_ppn" id="x_ppn" size="30" placeholder="<?php echo ew_HtmlEncode($view6->ppn->getPlaceHolder()) ?>" value="<?php echo $view6->ppn->EditValue ?>"<?php echo $view6->ppn->EditAttributes() ?>>
</span>
<?php echo $view6->ppn->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($view6->total_ppn->Visible) { // total_ppn ?>
	<div id="r_total_ppn" class="form-group">
		<label id="elh_view6_total_ppn" for="x_total_ppn" class="col-sm-2 control-label ewLabel"><?php echo $view6->total_ppn->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $view6->total_ppn->CellAttributes() ?>>
<span id="el_view6_total_ppn">
<input type="text" data-table="view6" data-field="x_total_ppn" name="x_total_ppn" id="x_total_ppn" size="30" placeholder="<?php echo ew_HtmlEncode($view6->total_ppn->getPlaceHolder()) ?>" value="<?php echo $view6->total_ppn->EditValue ?>"<?php echo $view6->total_ppn->EditAttributes() ?>>
</span>
<?php echo $view6->total_ppn->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($view6->terbilang->Visible) { // terbilang ?>
	<div id="r_terbilang" class="form-group">
		<label id="elh_view6_terbilang" for="x_terbilang" class="col-sm-2 control-label ewLabel"><?php echo $view6->terbilang->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $view6->terbilang->CellAttributes() ?>>
<span id="el_view6_terbilang">
<textarea data-table="view6" data-field="x_terbilang" name="x_terbilang" id="x_terbilang" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($view6->terbilang->getPlaceHolder()) ?>"<?php echo $view6->terbilang->EditAttributes() ?>><?php echo $view6->terbilang->EditValue ?></textarea>
</span>
<?php echo $view6->terbilang->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($view6->terbayar->Visible) { // terbayar ?>
	<div id="r_terbayar" class="form-group">
		<label id="elh_view6_terbayar" for="x_terbayar" class="col-sm-2 control-label ewLabel"><?php echo $view6->terbayar->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $view6->terbayar->CellAttributes() ?>>
<span id="el_view6_terbayar">
<input type="text" data-table="view6" data-field="x_terbayar" name="x_terbayar" id="x_terbayar" size="30" placeholder="<?php echo ew_HtmlEncode($view6->terbayar->getPlaceHolder()) ?>" value="<?php echo $view6->terbayar->EditValue ?>"<?php echo $view6->terbayar->EditAttributes() ?>>
</span>
<?php echo $view6->terbayar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($view6->pasal23->Visible) { // pasal23 ?>
	<div id="r_pasal23" class="form-group">
		<label id="elh_view6_pasal23" for="x_pasal23" class="col-sm-2 control-label ewLabel"><?php echo $view6->pasal23->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $view6->pasal23->CellAttributes() ?>>
<span id="el_view6_pasal23">
<input type="text" data-table="view6" data-field="x_pasal23" name="x_pasal23" id="x_pasal23" size="30" placeholder="<?php echo ew_HtmlEncode($view6->pasal23->getPlaceHolder()) ?>" value="<?php echo $view6->pasal23->EditValue ?>"<?php echo $view6->pasal23->EditAttributes() ?>>
</span>
<?php echo $view6->pasal23->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$view6_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $view6_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fview6add.Init();
</script>
<?php
$view6_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$view6_add->Page_Terminate();
?>
