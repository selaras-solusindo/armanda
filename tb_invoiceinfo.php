<?php

// Global variable for table object
$tb_invoice = NULL;

//
// Table class for tb_invoice
//
class ctb_invoice extends cTable {
	var $id;
	var $customer_id;
	var $no_invoice;
	var $tgl_invoice;
	var $no_order;
	var $no_referensi;
	var $kegiatan;
	var $tgl_pelaksanaan;
	var $no_sertifikat;
	var $keterangan;
	var $total;
	var $ppn;
	var $total_ppn;
	var $terbilang;
	var $terbayar;
	var $pasal23;
	var $no_kuitansi;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'tb_invoice';
		$this->TableName = 'tb_invoice';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`tb_invoice`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = TRUE; // Allow detail add
		$this->DetailEdit = TRUE; // Allow detail edit
		$this->DetailView = TRUE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 104; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// id
		$this->id = new cField('tb_invoice', 'tb_invoice', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// customer_id
		$this->customer_id = new cField('tb_invoice', 'tb_invoice', 'x_customer_id', 'customer_id', '`customer_id`', '`customer_id`', 3, -1, FALSE, '`customer_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->customer_id->Sortable = TRUE; // Allow sort
		$this->customer_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->customer_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->customer_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['customer_id'] = &$this->customer_id;

		// no_invoice
		$this->no_invoice = new cField('tb_invoice', 'tb_invoice', 'x_no_invoice', 'no_invoice', '`no_invoice`', '`no_invoice`', 200, -1, FALSE, '`no_invoice`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_invoice->Sortable = TRUE; // Allow sort
		$this->fields['no_invoice'] = &$this->no_invoice;

		// tgl_invoice
		$this->tgl_invoice = new cField('tb_invoice', 'tb_invoice', 'x_tgl_invoice', 'tgl_invoice', '`tgl_invoice`', ew_CastDateFieldForLike('`tgl_invoice`', 7, "DB"), 133, 7, FALSE, '`tgl_invoice`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_invoice->Sortable = TRUE; // Allow sort
		$this->tgl_invoice->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['tgl_invoice'] = &$this->tgl_invoice;

		// no_order
		$this->no_order = new cField('tb_invoice', 'tb_invoice', 'x_no_order', 'no_order', '`no_order`', '`no_order`', 200, -1, FALSE, '`no_order`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_order->Sortable = TRUE; // Allow sort
		$this->fields['no_order'] = &$this->no_order;

		// no_referensi
		$this->no_referensi = new cField('tb_invoice', 'tb_invoice', 'x_no_referensi', 'no_referensi', '`no_referensi`', '`no_referensi`', 200, -1, FALSE, '`no_referensi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_referensi->Sortable = TRUE; // Allow sort
		$this->fields['no_referensi'] = &$this->no_referensi;

		// kegiatan
		$this->kegiatan = new cField('tb_invoice', 'tb_invoice', 'x_kegiatan', 'kegiatan', '`kegiatan`', '`kegiatan`', 201, -1, FALSE, '`kegiatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->kegiatan->Sortable = TRUE; // Allow sort
		$this->fields['kegiatan'] = &$this->kegiatan;

		// tgl_pelaksanaan
		$this->tgl_pelaksanaan = new cField('tb_invoice', 'tb_invoice', 'x_tgl_pelaksanaan', 'tgl_pelaksanaan', '`tgl_pelaksanaan`', ew_CastDateFieldForLike('`tgl_pelaksanaan`', 7, "DB"), 133, 7, FALSE, '`tgl_pelaksanaan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_pelaksanaan->Sortable = TRUE; // Allow sort
		$this->tgl_pelaksanaan->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['tgl_pelaksanaan'] = &$this->tgl_pelaksanaan;

		// no_sertifikat
		$this->no_sertifikat = new cField('tb_invoice', 'tb_invoice', 'x_no_sertifikat', 'no_sertifikat', '`no_sertifikat`', '`no_sertifikat`', 200, -1, FALSE, '`no_sertifikat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_sertifikat->Sortable = TRUE; // Allow sort
		$this->fields['no_sertifikat'] = &$this->no_sertifikat;

		// keterangan
		$this->keterangan = new cField('tb_invoice', 'tb_invoice', 'x_keterangan', 'keterangan', '`keterangan`', '`keterangan`', 201, -1, FALSE, '`keterangan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->keterangan->Sortable = TRUE; // Allow sort
		$this->fields['keterangan'] = &$this->keterangan;

		// total
		$this->total = new cField('tb_invoice', 'tb_invoice', 'x_total', 'total', '`total`', '`total`', 4, -1, FALSE, '`total`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->total->Sortable = TRUE; // Allow sort
		$this->total->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['total'] = &$this->total;

		// ppn
		$this->ppn = new cField('tb_invoice', 'tb_invoice', 'x_ppn', 'ppn', '`ppn`', '`ppn`', 3, -1, FALSE, '`ppn`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ppn->Sortable = TRUE; // Allow sort
		$this->ppn->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ppn'] = &$this->ppn;

		// total_ppn
		$this->total_ppn = new cField('tb_invoice', 'tb_invoice', 'x_total_ppn', 'total_ppn', '`total_ppn`', '`total_ppn`', 4, -1, FALSE, '`total_ppn`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->total_ppn->Sortable = TRUE; // Allow sort
		$this->total_ppn->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['total_ppn'] = &$this->total_ppn;

		// terbilang
		$this->terbilang = new cField('tb_invoice', 'tb_invoice', 'x_terbilang', 'terbilang', '`terbilang`', '`terbilang`', 201, -1, FALSE, '`terbilang`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->terbilang->Sortable = TRUE; // Allow sort
		$this->fields['terbilang'] = &$this->terbilang;

		// terbayar
		$this->terbayar = new cField('tb_invoice', 'tb_invoice', 'x_terbayar', 'terbayar', '`terbayar`', '`terbayar`', 16, -1, FALSE, '`terbayar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->terbayar->Sortable = TRUE; // Allow sort
		$this->terbayar->OptionCount = 2;
		$this->terbayar->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['terbayar'] = &$this->terbayar;

		// pasal23
		$this->pasal23 = new cField('tb_invoice', 'tb_invoice', 'x_pasal23', 'pasal23', '`pasal23`', '`pasal23`', 16, -1, FALSE, '`pasal23`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->pasal23->Sortable = TRUE; // Allow sort
		$this->pasal23->OptionCount = 2;
		$this->pasal23->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['pasal23'] = &$this->pasal23;

		// no_kuitansi
		$this->no_kuitansi = new cField('tb_invoice', 'tb_invoice', 'x_no_kuitansi', 'no_kuitansi', '`no_kuitansi`', '`no_kuitansi`', 200, -1, FALSE, '`no_kuitansi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_kuitansi->Sortable = TRUE; // Allow sort
		$this->fields['no_kuitansi'] = &$this->no_kuitansi;
	}

	// Set Field Visibility
	function SetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Current detail table name
	function getCurrentDetailTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE];
	}

	function setCurrentDetailTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE] = $v;
	}

	// Get detail url
	function GetDetailUrl() {

		// Detail url
		$sDetailUrl = "";
		if ($this->getCurrentDetailTable() == "tb_fee") {
			$sDetailUrl = $GLOBALS["tb_fee"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id=" . urlencode($this->id->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "tb_invoicelist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`tb_invoice`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('id', $rs))
				ew_AddFilter($where, ew_QuotedName('id', $this->DBID) . '=' . ew_QuotedValue($rs['id'], $this->id->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`id` = @id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@id@", ew_AdjustSql($this->id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "tb_invoicelist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "tb_invoicelist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("tb_invoiceview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("tb_invoiceview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "tb_invoiceadd.php?" . $this->UrlParm($parm);
		else
			$url = "tb_invoiceadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("tb_invoiceedit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("tb_invoiceedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("tb_invoiceadd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("tb_invoiceadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("tb_invoicedelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id:" . ew_VarToJson($this->id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id->CurrentValue)) {
			$sUrl .= "id=" . urlencode($this->id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();
			if ($isPost && isset($_POST["id"]))
				$arKeys[] = ew_StripSlashes($_POST["id"]);
			elseif (isset($_GET["id"]))
				$arKeys[] = ew_StripSlashes($_GET["id"]);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
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
		$this->no_kuitansi->setDbValue($rs->fields('no_kuitansi'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
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
		// no_kuitansi
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

		// pasal23
		if (strval($this->pasal23->CurrentValue) <> "") {
			$this->pasal23->ViewValue = $this->pasal23->OptionCaption($this->pasal23->CurrentValue);
		} else {
			$this->pasal23->ViewValue = NULL;
		}
		$this->pasal23->ViewCustomAttributes = "";

		// no_kuitansi
		$this->no_kuitansi->ViewValue = $this->no_kuitansi->CurrentValue;
		$this->no_kuitansi->ViewCustomAttributes = "";

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

		// pasal23
		$this->pasal23->LinkCustomAttributes = "";
		$this->pasal23->HrefValue = "";
		$this->pasal23->TooltipValue = "";

		// no_kuitansi
		$this->no_kuitansi->LinkCustomAttributes = "";
		$this->no_kuitansi->HrefValue = "";
		$this->no_kuitansi->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// id
		$this->id->EditAttrs["class"] = "form-control";
		$this->id->EditCustomAttributes = "";
		$this->id->EditValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// customer_id
		$this->customer_id->EditAttrs["class"] = "form-control";
		$this->customer_id->EditCustomAttributes = "";

		// no_invoice
		$this->no_invoice->EditAttrs["class"] = "form-control";
		$this->no_invoice->EditCustomAttributes = "";
		$this->no_invoice->EditValue = $this->no_invoice->CurrentValue;
		$this->no_invoice->PlaceHolder = ew_RemoveHtml($this->no_invoice->FldCaption());

		// tgl_invoice
		$this->tgl_invoice->EditAttrs["class"] = "form-control";
		$this->tgl_invoice->EditCustomAttributes = "";
		$this->tgl_invoice->EditValue = ew_FormatDateTime($this->tgl_invoice->CurrentValue, 7);
		$this->tgl_invoice->PlaceHolder = ew_RemoveHtml($this->tgl_invoice->FldCaption());

		// no_order
		$this->no_order->EditAttrs["class"] = "form-control";
		$this->no_order->EditCustomAttributes = "";
		$this->no_order->EditValue = $this->no_order->CurrentValue;
		$this->no_order->PlaceHolder = ew_RemoveHtml($this->no_order->FldCaption());

		// no_referensi
		$this->no_referensi->EditAttrs["class"] = "form-control";
		$this->no_referensi->EditCustomAttributes = "";
		$this->no_referensi->EditValue = $this->no_referensi->CurrentValue;
		$this->no_referensi->PlaceHolder = ew_RemoveHtml($this->no_referensi->FldCaption());

		// kegiatan
		$this->kegiatan->EditAttrs["class"] = "form-control";
		$this->kegiatan->EditCustomAttributes = "";
		$this->kegiatan->EditValue = $this->kegiatan->CurrentValue;
		$this->kegiatan->PlaceHolder = ew_RemoveHtml($this->kegiatan->FldCaption());

		// tgl_pelaksanaan
		$this->tgl_pelaksanaan->EditAttrs["class"] = "form-control";
		$this->tgl_pelaksanaan->EditCustomAttributes = "";
		$this->tgl_pelaksanaan->EditValue = ew_FormatDateTime($this->tgl_pelaksanaan->CurrentValue, 7);
		$this->tgl_pelaksanaan->PlaceHolder = ew_RemoveHtml($this->tgl_pelaksanaan->FldCaption());

		// no_sertifikat
		$this->no_sertifikat->EditAttrs["class"] = "form-control";
		$this->no_sertifikat->EditCustomAttributes = "";
		$this->no_sertifikat->EditValue = $this->no_sertifikat->CurrentValue;
		$this->no_sertifikat->PlaceHolder = ew_RemoveHtml($this->no_sertifikat->FldCaption());

		// keterangan
		$this->keterangan->EditAttrs["class"] = "form-control";
		$this->keterangan->EditCustomAttributes = "";
		$this->keterangan->EditValue = $this->keterangan->CurrentValue;
		$this->keterangan->PlaceHolder = ew_RemoveHtml($this->keterangan->FldCaption());

		// total
		$this->total->EditAttrs["class"] = "form-control";
		$this->total->EditCustomAttributes = "";
		$this->total->EditValue = $this->total->CurrentValue;
		$this->total->PlaceHolder = ew_RemoveHtml($this->total->FldCaption());
		if (strval($this->total->EditValue) <> "" && is_numeric($this->total->EditValue)) $this->total->EditValue = ew_FormatNumber($this->total->EditValue, -2, -2, -2, -1);

		// ppn
		$this->ppn->EditAttrs["class"] = "form-control";
		$this->ppn->EditCustomAttributes = "";
		$this->ppn->EditValue = $this->ppn->CurrentValue;
		$this->ppn->PlaceHolder = ew_RemoveHtml($this->ppn->FldCaption());

		// total_ppn
		$this->total_ppn->EditAttrs["class"] = "form-control";
		$this->total_ppn->EditCustomAttributes = "";
		$this->total_ppn->EditValue = $this->total_ppn->CurrentValue;
		$this->total_ppn->PlaceHolder = ew_RemoveHtml($this->total_ppn->FldCaption());
		if (strval($this->total_ppn->EditValue) <> "" && is_numeric($this->total_ppn->EditValue)) $this->total_ppn->EditValue = ew_FormatNumber($this->total_ppn->EditValue, -2, -2, -2, -2);

		// terbilang
		$this->terbilang->EditAttrs["class"] = "form-control";
		$this->terbilang->EditCustomAttributes = "";
		$this->terbilang->EditValue = $this->terbilang->CurrentValue;
		$this->terbilang->PlaceHolder = ew_RemoveHtml($this->terbilang->FldCaption());

		// terbayar
		$this->terbayar->EditCustomAttributes = "";
		$this->terbayar->EditValue = $this->terbayar->Options(FALSE);

		// pasal23
		$this->pasal23->EditCustomAttributes = "";
		$this->pasal23->EditValue = $this->pasal23->Options(FALSE);

		// no_kuitansi
		$this->no_kuitansi->EditAttrs["class"] = "form-control";
		$this->no_kuitansi->EditCustomAttributes = "";
		$this->no_kuitansi->EditValue = $this->no_kuitansi->CurrentValue;
		$this->no_kuitansi->PlaceHolder = ew_RemoveHtml($this->no_kuitansi->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->customer_id->Exportable) $Doc->ExportCaption($this->customer_id);
					if ($this->no_invoice->Exportable) $Doc->ExportCaption($this->no_invoice);
					if ($this->tgl_invoice->Exportable) $Doc->ExportCaption($this->tgl_invoice);
					if ($this->no_order->Exportable) $Doc->ExportCaption($this->no_order);
					if ($this->no_referensi->Exportable) $Doc->ExportCaption($this->no_referensi);
					if ($this->kegiatan->Exportable) $Doc->ExportCaption($this->kegiatan);
					if ($this->tgl_pelaksanaan->Exportable) $Doc->ExportCaption($this->tgl_pelaksanaan);
					if ($this->no_sertifikat->Exportable) $Doc->ExportCaption($this->no_sertifikat);
					if ($this->keterangan->Exportable) $Doc->ExportCaption($this->keterangan);
					if ($this->total->Exportable) $Doc->ExportCaption($this->total);
					if ($this->ppn->Exportable) $Doc->ExportCaption($this->ppn);
					if ($this->total_ppn->Exportable) $Doc->ExportCaption($this->total_ppn);
					if ($this->terbilang->Exportable) $Doc->ExportCaption($this->terbilang);
					if ($this->terbayar->Exportable) $Doc->ExportCaption($this->terbayar);
					if ($this->pasal23->Exportable) $Doc->ExportCaption($this->pasal23);
					if ($this->no_kuitansi->Exportable) $Doc->ExportCaption($this->no_kuitansi);
				} else {
					if ($this->customer_id->Exportable) $Doc->ExportCaption($this->customer_id);
					if ($this->no_invoice->Exportable) $Doc->ExportCaption($this->no_invoice);
					if ($this->tgl_invoice->Exportable) $Doc->ExportCaption($this->tgl_invoice);
					if ($this->no_order->Exportable) $Doc->ExportCaption($this->no_order);
					if ($this->no_referensi->Exportable) $Doc->ExportCaption($this->no_referensi);
					if ($this->kegiatan->Exportable) $Doc->ExportCaption($this->kegiatan);
					if ($this->tgl_pelaksanaan->Exportable) $Doc->ExportCaption($this->tgl_pelaksanaan);
					if ($this->no_sertifikat->Exportable) $Doc->ExportCaption($this->no_sertifikat);
					if ($this->keterangan->Exportable) $Doc->ExportCaption($this->keterangan);
					if ($this->total->Exportable) $Doc->ExportCaption($this->total);
					if ($this->ppn->Exportable) $Doc->ExportCaption($this->ppn);
					if ($this->total_ppn->Exportable) $Doc->ExportCaption($this->total_ppn);
					if ($this->terbilang->Exportable) $Doc->ExportCaption($this->terbilang);
					if ($this->terbayar->Exportable) $Doc->ExportCaption($this->terbayar);
					if ($this->pasal23->Exportable) $Doc->ExportCaption($this->pasal23);
					if ($this->no_kuitansi->Exportable) $Doc->ExportCaption($this->no_kuitansi);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->customer_id->Exportable) $Doc->ExportField($this->customer_id);
						if ($this->no_invoice->Exportable) $Doc->ExportField($this->no_invoice);
						if ($this->tgl_invoice->Exportable) $Doc->ExportField($this->tgl_invoice);
						if ($this->no_order->Exportable) $Doc->ExportField($this->no_order);
						if ($this->no_referensi->Exportable) $Doc->ExportField($this->no_referensi);
						if ($this->kegiatan->Exportable) $Doc->ExportField($this->kegiatan);
						if ($this->tgl_pelaksanaan->Exportable) $Doc->ExportField($this->tgl_pelaksanaan);
						if ($this->no_sertifikat->Exportable) $Doc->ExportField($this->no_sertifikat);
						if ($this->keterangan->Exportable) $Doc->ExportField($this->keterangan);
						if ($this->total->Exportable) $Doc->ExportField($this->total);
						if ($this->ppn->Exportable) $Doc->ExportField($this->ppn);
						if ($this->total_ppn->Exportable) $Doc->ExportField($this->total_ppn);
						if ($this->terbilang->Exportable) $Doc->ExportField($this->terbilang);
						if ($this->terbayar->Exportable) $Doc->ExportField($this->terbayar);
						if ($this->pasal23->Exportable) $Doc->ExportField($this->pasal23);
						if ($this->no_kuitansi->Exportable) $Doc->ExportField($this->no_kuitansi);
					} else {
						if ($this->customer_id->Exportable) $Doc->ExportField($this->customer_id);
						if ($this->no_invoice->Exportable) $Doc->ExportField($this->no_invoice);
						if ($this->tgl_invoice->Exportable) $Doc->ExportField($this->tgl_invoice);
						if ($this->no_order->Exportable) $Doc->ExportField($this->no_order);
						if ($this->no_referensi->Exportable) $Doc->ExportField($this->no_referensi);
						if ($this->kegiatan->Exportable) $Doc->ExportField($this->kegiatan);
						if ($this->tgl_pelaksanaan->Exportable) $Doc->ExportField($this->tgl_pelaksanaan);
						if ($this->no_sertifikat->Exportable) $Doc->ExportField($this->no_sertifikat);
						if ($this->keterangan->Exportable) $Doc->ExportField($this->keterangan);
						if ($this->total->Exportable) $Doc->ExportField($this->total);
						if ($this->ppn->Exportable) $Doc->ExportField($this->ppn);
						if ($this->total_ppn->Exportable) $Doc->ExportField($this->total_ppn);
						if ($this->terbilang->Exportable) $Doc->ExportField($this->terbilang);
						if ($this->terbayar->Exportable) $Doc->ExportField($this->terbayar);
						if ($this->pasal23->Exportable) $Doc->ExportField($this->pasal23);
						if ($this->no_kuitansi->Exportable) $Doc->ExportField($this->no_kuitansi);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
		if ($rsold["ppn"] != $rsnew["ppn"]) {
			$total_ppn = $rsold["total"];
			if ($rsnew["ppn"] != 0) {
				$total_ppn = $rsold["total"] + ($rsold["total"] * ($rsnew["ppn"]/100));
			}
			$terbilang = Terbilang($total_ppn);
			ew_Execute("
				UPDATE tb_invoice SET
					total_ppn = ".$total_ppn.",
					terbilang = '".$terbilang."'
				WHERE
					id = ".$rsold["id"]."");
		}
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
