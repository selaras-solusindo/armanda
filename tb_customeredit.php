<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "tb_customerinfo.php" ?>
<?php include_once "tb_userinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$tb_customer_edit = NULL; // Initialize page object first

class ctb_customer_edit extends ctb_customer {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{E6C293EF-4D71-4FC6-B668-35B8D3E752AB}";

	// Table name
	var $TableName = 'tb_customer';

	// Page object name
	var $PageObjName = 'tb_customer_edit';

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

		// Table object (tb_customer)
		if (!isset($GLOBALS["tb_customer"]) || get_class($GLOBALS["tb_customer"]) == "ctb_customer") {
			$GLOBALS["tb_customer"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tb_customer"];
		}

		// Table object (tb_user)
		if (!isset($GLOBALS['tb_user'])) $GLOBALS['tb_user'] = new ctb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tb_customer', TRUE);

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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("tb_customerlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		$this->id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->nama->SetVisibility();
		$this->alamat->SetVisibility();
		$this->kota->SetVisibility();
		$this->kodepos->SetVisibility();
		$this->no_npwp->SetVisibility();

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
		global $EW_EXPORT, $tb_customer;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tb_customer);
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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;

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

		// Load key from QueryString
		if (@$_GET["id"] <> "") {
			$this->id->setQueryStringValue($_GET["id"]);
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->id->CurrentValue == "") {
			$this->Page_Terminate("tb_customerlist.php"); // Invalid key, return to list
		}

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("tb_customerlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "tb_customerlist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
		if (!$this->nama->FldIsDetailKey) {
			$this->nama->setFormValue($objForm->GetValue("x_nama"));
		}
		if (!$this->alamat->FldIsDetailKey) {
			$this->alamat->setFormValue($objForm->GetValue("x_alamat"));
		}
		if (!$this->kota->FldIsDetailKey) {
			$this->kota->setFormValue($objForm->GetValue("x_kota"));
		}
		if (!$this->kodepos->FldIsDetailKey) {
			$this->kodepos->setFormValue($objForm->GetValue("x_kodepos"));
		}
		if (!$this->no_npwp->FldIsDetailKey) {
			$this->no_npwp->setFormValue($objForm->GetValue("x_no_npwp"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->nama->CurrentValue = $this->nama->FormValue;
		$this->alamat->CurrentValue = $this->alamat->FormValue;
		$this->kota->CurrentValue = $this->kota->FormValue;
		$this->kodepos->CurrentValue = $this->kodepos->FormValue;
		$this->no_npwp->CurrentValue = $this->no_npwp->FormValue;
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
		$this->nama->setDbValue($rs->fields('nama'));
		$this->alamat->setDbValue($rs->fields('alamat'));
		$this->kota->setDbValue($rs->fields('kota'));
		$this->kodepos->setDbValue($rs->fields('kodepos'));
		$this->no_npwp->setDbValue($rs->fields('no_npwp'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->nama->DbValue = $row['nama'];
		$this->alamat->DbValue = $row['alamat'];
		$this->kota->DbValue = $row['kota'];
		$this->kodepos->DbValue = $row['kodepos'];
		$this->no_npwp->DbValue = $row['no_npwp'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// nama
		// alamat
		// kota
		// kodepos
		// no_npwp

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// nama
		$this->nama->ViewValue = $this->nama->CurrentValue;
		$this->nama->ViewCustomAttributes = "";

		// alamat
		$this->alamat->ViewValue = $this->alamat->CurrentValue;
		$this->alamat->ViewCustomAttributes = "";

		// kota
		$this->kota->ViewValue = $this->kota->CurrentValue;
		$this->kota->ViewCustomAttributes = "";

		// kodepos
		$this->kodepos->ViewValue = $this->kodepos->CurrentValue;
		$this->kodepos->ViewCustomAttributes = "";

		// no_npwp
		$this->no_npwp->ViewValue = $this->no_npwp->CurrentValue;
		$this->no_npwp->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// nama
			$this->nama->LinkCustomAttributes = "";
			$this->nama->HrefValue = "";
			$this->nama->TooltipValue = "";

			// alamat
			$this->alamat->LinkCustomAttributes = "";
			$this->alamat->HrefValue = "";
			$this->alamat->TooltipValue = "";

			// kota
			$this->kota->LinkCustomAttributes = "";
			$this->kota->HrefValue = "";
			$this->kota->TooltipValue = "";

			// kodepos
			$this->kodepos->LinkCustomAttributes = "";
			$this->kodepos->HrefValue = "";
			$this->kodepos->TooltipValue = "";

			// no_npwp
			$this->no_npwp->LinkCustomAttributes = "";
			$this->no_npwp->HrefValue = "";
			$this->no_npwp->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// nama
			$this->nama->EditAttrs["class"] = "form-control";
			$this->nama->EditCustomAttributes = "";
			$this->nama->EditValue = ew_HtmlEncode($this->nama->CurrentValue);
			$this->nama->PlaceHolder = ew_RemoveHtml($this->nama->FldCaption());

			// alamat
			$this->alamat->EditAttrs["class"] = "form-control";
			$this->alamat->EditCustomAttributes = "";
			$this->alamat->EditValue = ew_HtmlEncode($this->alamat->CurrentValue);
			$this->alamat->PlaceHolder = ew_RemoveHtml($this->alamat->FldCaption());

			// kota
			$this->kota->EditAttrs["class"] = "form-control";
			$this->kota->EditCustomAttributes = "";
			$this->kota->EditValue = ew_HtmlEncode($this->kota->CurrentValue);
			$this->kota->PlaceHolder = ew_RemoveHtml($this->kota->FldCaption());

			// kodepos
			$this->kodepos->EditAttrs["class"] = "form-control";
			$this->kodepos->EditCustomAttributes = "";
			$this->kodepos->EditValue = ew_HtmlEncode($this->kodepos->CurrentValue);
			$this->kodepos->PlaceHolder = ew_RemoveHtml($this->kodepos->FldCaption());

			// no_npwp
			$this->no_npwp->EditAttrs["class"] = "form-control";
			$this->no_npwp->EditCustomAttributes = "";
			$this->no_npwp->EditValue = ew_HtmlEncode($this->no_npwp->CurrentValue);
			$this->no_npwp->PlaceHolder = ew_RemoveHtml($this->no_npwp->FldCaption());

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// nama
			$this->nama->LinkCustomAttributes = "";
			$this->nama->HrefValue = "";

			// alamat
			$this->alamat->LinkCustomAttributes = "";
			$this->alamat->HrefValue = "";

			// kota
			$this->kota->LinkCustomAttributes = "";
			$this->kota->HrefValue = "";

			// kodepos
			$this->kodepos->LinkCustomAttributes = "";
			$this->kodepos->HrefValue = "";

			// no_npwp
			$this->no_npwp->LinkCustomAttributes = "";
			$this->no_npwp->HrefValue = "";
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
		if (!$this->nama->FldIsDetailKey && !is_null($this->nama->FormValue) && $this->nama->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nama->FldCaption(), $this->nama->ReqErrMsg));
		}
		if (!$this->alamat->FldIsDetailKey && !is_null($this->alamat->FormValue) && $this->alamat->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->alamat->FldCaption(), $this->alamat->ReqErrMsg));
		}
		if (!$this->kota->FldIsDetailKey && !is_null($this->kota->FormValue) && $this->kota->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kota->FldCaption(), $this->kota->ReqErrMsg));
		}
		if (!$this->kodepos->FldIsDetailKey && !is_null($this->kodepos->FormValue) && $this->kodepos->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kodepos->FldCaption(), $this->kodepos->ReqErrMsg));
		}
		if (!$this->no_npwp->FldIsDetailKey && !is_null($this->no_npwp->FormValue) && $this->no_npwp->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->no_npwp->FldCaption(), $this->no_npwp->ReqErrMsg));
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

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// nama
			$this->nama->SetDbValueDef($rsnew, $this->nama->CurrentValue, "", $this->nama->ReadOnly);

			// alamat
			$this->alamat->SetDbValueDef($rsnew, $this->alamat->CurrentValue, "", $this->alamat->ReadOnly);

			// kota
			$this->kota->SetDbValueDef($rsnew, $this->kota->CurrentValue, "", $this->kota->ReadOnly);

			// kodepos
			$this->kodepos->SetDbValueDef($rsnew, $this->kodepos->CurrentValue, "", $this->kodepos->ReadOnly);

			// no_npwp
			$this->no_npwp->SetDbValueDef($rsnew, $this->no_npwp->CurrentValue, "", $this->no_npwp->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tb_customerlist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
if (!isset($tb_customer_edit)) $tb_customer_edit = new ctb_customer_edit();

// Page init
$tb_customer_edit->Page_Init();

// Page main
$tb_customer_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_customer_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ftb_customeredit = new ew_Form("ftb_customeredit", "edit");

// Validate form
ftb_customeredit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_nama");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_customer->nama->FldCaption(), $tb_customer->nama->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_alamat");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_customer->alamat->FldCaption(), $tb_customer->alamat->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kota");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_customer->kota->FldCaption(), $tb_customer->kota->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kodepos");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_customer->kodepos->FldCaption(), $tb_customer->kodepos->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_no_npwp");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_customer->no_npwp->FldCaption(), $tb_customer->no_npwp->ReqErrMsg)) ?>");

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
ftb_customeredit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftb_customeredit.ValidateRequired = true;
<?php } else { ?>
ftb_customeredit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$tb_customer_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $tb_customer_edit->ShowPageHeader(); ?>
<?php
$tb_customer_edit->ShowMessage();
?>
<form name="ftb_customeredit" id="ftb_customeredit" class="<?php echo $tb_customer_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tb_customer_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tb_customer_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tb_customer">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($tb_customer_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($tb_customer->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_tb_customer_id" class="col-sm-2 control-label ewLabel"><?php echo $tb_customer->id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tb_customer->id->CellAttributes() ?>>
<span id="el_tb_customer_id">
<span<?php echo $tb_customer->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_customer->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="tb_customer" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($tb_customer->id->CurrentValue) ?>">
<?php echo $tb_customer->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_customer->nama->Visible) { // nama ?>
	<div id="r_nama" class="form-group">
		<label id="elh_tb_customer_nama" for="x_nama" class="col-sm-2 control-label ewLabel"><?php echo $tb_customer->nama->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_customer->nama->CellAttributes() ?>>
<span id="el_tb_customer_nama">
<input type="text" data-table="tb_customer" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tb_customer->nama->getPlaceHolder()) ?>" value="<?php echo $tb_customer->nama->EditValue ?>"<?php echo $tb_customer->nama->EditAttributes() ?>>
</span>
<?php echo $tb_customer->nama->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_customer->alamat->Visible) { // alamat ?>
	<div id="r_alamat" class="form-group">
		<label id="elh_tb_customer_alamat" for="x_alamat" class="col-sm-2 control-label ewLabel"><?php echo $tb_customer->alamat->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_customer->alamat->CellAttributes() ?>>
<span id="el_tb_customer_alamat">
<input type="text" data-table="tb_customer" data-field="x_alamat" name="x_alamat" id="x_alamat" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($tb_customer->alamat->getPlaceHolder()) ?>" value="<?php echo $tb_customer->alamat->EditValue ?>"<?php echo $tb_customer->alamat->EditAttributes() ?>>
</span>
<?php echo $tb_customer->alamat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_customer->kota->Visible) { // kota ?>
	<div id="r_kota" class="form-group">
		<label id="elh_tb_customer_kota" for="x_kota" class="col-sm-2 control-label ewLabel"><?php echo $tb_customer->kota->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_customer->kota->CellAttributes() ?>>
<span id="el_tb_customer_kota">
<input type="text" data-table="tb_customer" data-field="x_kota" name="x_kota" id="x_kota" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tb_customer->kota->getPlaceHolder()) ?>" value="<?php echo $tb_customer->kota->EditValue ?>"<?php echo $tb_customer->kota->EditAttributes() ?>>
</span>
<?php echo $tb_customer->kota->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_customer->kodepos->Visible) { // kodepos ?>
	<div id="r_kodepos" class="form-group">
		<label id="elh_tb_customer_kodepos" for="x_kodepos" class="col-sm-2 control-label ewLabel"><?php echo $tb_customer->kodepos->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_customer->kodepos->CellAttributes() ?>>
<span id="el_tb_customer_kodepos">
<input type="text" data-table="tb_customer" data-field="x_kodepos" name="x_kodepos" id="x_kodepos" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tb_customer->kodepos->getPlaceHolder()) ?>" value="<?php echo $tb_customer->kodepos->EditValue ?>"<?php echo $tb_customer->kodepos->EditAttributes() ?>>
</span>
<?php echo $tb_customer->kodepos->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tb_customer->no_npwp->Visible) { // no_npwp ?>
	<div id="r_no_npwp" class="form-group">
		<label id="elh_tb_customer_no_npwp" for="x_no_npwp" class="col-sm-2 control-label ewLabel"><?php echo $tb_customer->no_npwp->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tb_customer->no_npwp->CellAttributes() ?>>
<span id="el_tb_customer_no_npwp">
<input type="text" data-table="tb_customer" data-field="x_no_npwp" name="x_no_npwp" id="x_no_npwp" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tb_customer->no_npwp->getPlaceHolder()) ?>" value="<?php echo $tb_customer->no_npwp->EditValue ?>"<?php echo $tb_customer->no_npwp->EditAttributes() ?>>
</span>
<?php echo $tb_customer->no_npwp->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$tb_customer_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tb_customer_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ftb_customeredit.Init();
</script>
<?php
$tb_customer_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tb_customer_edit->Page_Terminate();
?>
