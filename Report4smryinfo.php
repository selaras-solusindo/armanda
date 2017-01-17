<?php

// Global variable for table object
$Report4 = NULL;

//
// Table class for Report4
//
class crReport4 extends crTableBase {
	var $tgl_invoice;
	var $nama;
	var $no_kuitansi;
	var $no_referensi;
	var $total_ppn;
	var $id;
	var $customer_id;
	var $no_invoice;
	var $no_order;
	var $kegiatan;
	var $tgl_pelaksanaan;
	var $no_sertifikat;
	var $keterangan;
	var $total;
	var $ppn;
	var $terbilang;

	//
	// Table class constructor
	//
	function __construct() {
		global $ReportLanguage;
		$this->TableVar = 'Report4';
		$this->TableName = 'Report4';
		$this->TableType = 'REPORT';
		$this->DBID = 'DB';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0;

		// tgl_invoice
		$this->tgl_invoice = new crField('Report4', 'Report4', 'x_tgl_invoice', 'tgl_invoice', '`tgl_invoice`', 133, EWR_DATATYPE_DATE, -1);
		$this->tgl_invoice->GroupingFieldId = 1;
		$this->tgl_invoice->FldDefaultErrMsg = str_replace("%s", "/", $ReportLanguage->Phrase("IncorrectDateYMD"));
		$this->fields['tgl_invoice'] = &$this->tgl_invoice;
		$this->tgl_invoice->DateFilter = "";
		$this->tgl_invoice->SqlSelect = "";
		$this->tgl_invoice->SqlOrderBy = "";
		$this->tgl_invoice->FldGroupByType = "";
		$this->tgl_invoice->FldGroupInt = "0";
		$this->tgl_invoice->FldGroupSql = "";

		// nama
		$this->nama = new crField('Report4', 'Report4', 'x_nama', 'nama', '`nama`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['nama'] = &$this->nama;
		$this->nama->DateFilter = "";
		$this->nama->SqlSelect = "";
		$this->nama->SqlOrderBy = "";

		// no_kuitansi
		$this->no_kuitansi = new crField('Report4', 'Report4', 'x_no_kuitansi', 'no_kuitansi', '`no_kuitansi`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['no_kuitansi'] = &$this->no_kuitansi;
		$this->no_kuitansi->DateFilter = "";
		$this->no_kuitansi->SqlSelect = "";
		$this->no_kuitansi->SqlOrderBy = "";

		// no_referensi
		$this->no_referensi = new crField('Report4', 'Report4', 'x_no_referensi', 'no_referensi', '`no_referensi`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['no_referensi'] = &$this->no_referensi;
		$this->no_referensi->DateFilter = "";
		$this->no_referensi->SqlSelect = "";
		$this->no_referensi->SqlOrderBy = "";

		// total_ppn
		$this->total_ppn = new crField('Report4', 'Report4', 'x_total_ppn', 'total_ppn', '`total_ppn`', 4, EWR_DATATYPE_NUMBER, -1);
		$this->total_ppn->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['total_ppn'] = &$this->total_ppn;
		$this->total_ppn->DateFilter = "";
		$this->total_ppn->SqlSelect = "";
		$this->total_ppn->SqlOrderBy = "";

		// id
		$this->id = new crField('Report4', 'Report4', 'x_id', 'id', '`id`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->id->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;
		$this->id->DateFilter = "";
		$this->id->SqlSelect = "";
		$this->id->SqlOrderBy = "";

		// customer_id
		$this->customer_id = new crField('Report4', 'Report4', 'x_customer_id', 'customer_id', '`customer_id`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->customer_id->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['customer_id'] = &$this->customer_id;
		$this->customer_id->DateFilter = "";
		$this->customer_id->SqlSelect = "";
		$this->customer_id->SqlOrderBy = "";

		// no_invoice
		$this->no_invoice = new crField('Report4', 'Report4', 'x_no_invoice', 'no_invoice', '`no_invoice`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['no_invoice'] = &$this->no_invoice;
		$this->no_invoice->DateFilter = "";
		$this->no_invoice->SqlSelect = "";
		$this->no_invoice->SqlOrderBy = "";

		// no_order
		$this->no_order = new crField('Report4', 'Report4', 'x_no_order', 'no_order', '`no_order`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['no_order'] = &$this->no_order;
		$this->no_order->DateFilter = "";
		$this->no_order->SqlSelect = "";
		$this->no_order->SqlOrderBy = "";

		// kegiatan
		$this->kegiatan = new crField('Report4', 'Report4', 'x_kegiatan', 'kegiatan', '`kegiatan`', 201, EWR_DATATYPE_MEMO, -1);
		$this->fields['kegiatan'] = &$this->kegiatan;
		$this->kegiatan->DateFilter = "";
		$this->kegiatan->SqlSelect = "";
		$this->kegiatan->SqlOrderBy = "";

		// tgl_pelaksanaan
		$this->tgl_pelaksanaan = new crField('Report4', 'Report4', 'x_tgl_pelaksanaan', 'tgl_pelaksanaan', '`tgl_pelaksanaan`', 133, EWR_DATATYPE_DATE, 5);
		$this->tgl_pelaksanaan->FldDefaultErrMsg = str_replace("%s", "/", $ReportLanguage->Phrase("IncorrectDateYMD"));
		$this->fields['tgl_pelaksanaan'] = &$this->tgl_pelaksanaan;
		$this->tgl_pelaksanaan->DateFilter = "";
		$this->tgl_pelaksanaan->SqlSelect = "";
		$this->tgl_pelaksanaan->SqlOrderBy = "";

		// no_sertifikat
		$this->no_sertifikat = new crField('Report4', 'Report4', 'x_no_sertifikat', 'no_sertifikat', '`no_sertifikat`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['no_sertifikat'] = &$this->no_sertifikat;
		$this->no_sertifikat->DateFilter = "";
		$this->no_sertifikat->SqlSelect = "";
		$this->no_sertifikat->SqlOrderBy = "";

		// keterangan
		$this->keterangan = new crField('Report4', 'Report4', 'x_keterangan', 'keterangan', '`keterangan`', 201, EWR_DATATYPE_MEMO, -1);
		$this->fields['keterangan'] = &$this->keterangan;
		$this->keterangan->DateFilter = "";
		$this->keterangan->SqlSelect = "";
		$this->keterangan->SqlOrderBy = "";

		// total
		$this->total = new crField('Report4', 'Report4', 'x_total', 'total', '`total`', 4, EWR_DATATYPE_NUMBER, -1);
		$this->total->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['total'] = &$this->total;
		$this->total->DateFilter = "";
		$this->total->SqlSelect = "";
		$this->total->SqlOrderBy = "";

		// ppn
		$this->ppn = new crField('Report4', 'Report4', 'x_ppn', 'ppn', '`ppn`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->ppn->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['ppn'] = &$this->ppn;
		$this->ppn->DateFilter = "";
		$this->ppn->SqlSelect = "";
		$this->ppn->SqlOrderBy = "";

		// terbilang
		$this->terbilang = new crField('Report4', 'Report4', 'x_terbilang', 'terbilang', '`terbilang`', 201, EWR_DATATYPE_MEMO, -1);
		$this->fields['terbilang'] = &$this->terbilang;
		$this->terbilang->DateFilter = "";
		$this->terbilang->SqlSelect = "";
		$this->terbilang->SqlOrderBy = "";
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
		} else {
			if ($ofld->GroupingFieldId == 0) $ofld->setSort("");
		}
	}

	// Get Sort SQL
	function SortSql() {
		$sDtlSortSql = "";
		$argrps = array();
		foreach ($this->fields as $fld) {
			if ($fld->getSort() <> "") {
				if ($fld->GroupingFieldId > 0) {
					if ($fld->FldGroupSql <> "")
						$argrps[$fld->GroupingFieldId] = str_replace("%s", $fld->FldExpression, $fld->FldGroupSql) . " " . $fld->getSort();
					else
						$argrps[$fld->GroupingFieldId] = $fld->FldExpression . " " . $fld->getSort();
				} else {
					if ($sDtlSortSql <> "") $sDtlSortSql .= ", ";
					$sDtlSortSql .= $fld->FldExpression . " " . $fld->getSort();
				}
			}
		}
		$sSortSql = "";
		foreach ($argrps as $grp) {
			if ($sSortSql <> "") $sSortSql .= ", ";
			$sSortSql .= $grp;
		}
		if ($sDtlSortSql <> "") {
			if ($sSortSql <> "") $sSortSql .= ",";
			$sSortSql .= $sDtlSortSql;
		}
		return $sSortSql;
	}

	// Table level SQL
	// From

	var $_SqlFrom = "";

	function getSqlFrom() {
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`view5`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}

	// Select
	var $_SqlSelect = "";

	function getSqlSelect() {
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}

	// Where
	var $_SqlWhere = "";

	function getSqlWhere() {
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}

	// Group By
	var $_SqlGroupBy = "";

	function getSqlGroupBy() {
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}

	// Having
	var $_SqlHaving = "";

	function getSqlHaving() {
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}

	// Order By
	var $_SqlOrderBy = "";

	function getSqlOrderBy() {
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`tgl_invoice` ASC";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Table Level Group SQL
	// First Group Field

	var $_SqlFirstGroupField = "";

	function getSqlFirstGroupField() {
		return ($this->_SqlFirstGroupField <> "") ? $this->_SqlFirstGroupField : "`tgl_invoice`";
	}

	function SqlFirstGroupField() { // For backward compatibility
		return $this->getSqlFirstGroupField();
	}

	function setSqlFirstGroupField($v) {
		$this->_SqlFirstGroupField = $v;
	}

	// Select Group
	var $_SqlSelectGroup = "";

	function getSqlSelectGroup() {
		return ($this->_SqlSelectGroup <> "") ? $this->_SqlSelectGroup : "SELECT DISTINCT " . $this->getSqlFirstGroupField() . " FROM " . $this->getSqlFrom();
	}

	function SqlSelectGroup() { // For backward compatibility
		return $this->getSqlSelectGroup();
	}

	function setSqlSelectGroup($v) {
		$this->_SqlSelectGroup = $v;
	}

	// Order By Group
	var $_SqlOrderByGroup = "";

	function getSqlOrderByGroup() {
		return ($this->_SqlOrderByGroup <> "") ? $this->_SqlOrderByGroup : "`tgl_invoice` ASC";
	}

	function SqlOrderByGroup() { // For backward compatibility
		return $this->getSqlOrderByGroup();
	}

	function setSqlOrderByGroup($v) {
		$this->_SqlOrderByGroup = $v;
	}

	// Select Aggregate
	var $_SqlSelectAgg = "";

	function getSqlSelectAgg() {
		return ($this->_SqlSelectAgg <> "") ? $this->_SqlSelectAgg : "SELECT SUM(`total_ppn`) AS `sum_total_ppn` FROM " . $this->getSqlFrom();
	}

	function SqlSelectAgg() { // For backward compatibility
		return $this->getSqlSelectAgg();
	}

	function setSqlSelectAgg($v) {
		$this->_SqlSelectAgg = $v;
	}

	// Aggregate Prefix
	var $_SqlAggPfx = "";

	function getSqlAggPfx() {
		return ($this->_SqlAggPfx <> "") ? $this->_SqlAggPfx : "";
	}

	function SqlAggPfx() { // For backward compatibility
		return $this->getSqlAggPfx();
	}

	function setSqlAggPfx($v) {
		$this->_SqlAggPfx = $v;
	}

	// Aggregate Suffix
	var $_SqlAggSfx = "";

	function getSqlAggSfx() {
		return ($this->_SqlAggSfx <> "") ? $this->_SqlAggSfx : "";
	}

	function SqlAggSfx() { // For backward compatibility
		return $this->getSqlAggSfx();
	}

	function setSqlAggSfx($v) {
		$this->_SqlAggSfx = $v;
	}

	// Select Count
	var $_SqlSelectCount = "";

	function getSqlSelectCount() {
		return ($this->_SqlSelectCount <> "") ? $this->_SqlSelectCount : "SELECT COUNT(*) FROM " . $this->getSqlFrom();
	}

	function SqlSelectCount() { // For backward compatibility
		return $this->getSqlSelectCount();
	}

	function setSqlSelectCount($v) {
		$this->_SqlSelectCount = $v;
	}

	// Sort URL
	function SortUrl(&$fld) {
		return "";
	}

	// Table level events
	// Page Selecting event
	function Page_Selecting(&$filter) {

		// Enter your code here	
	}

	// Page Breaking event
	function Page_Breaking(&$break, &$content) {

		// Example:
		//$break = FALSE; // Skip page break, or
		//$content = "<div style=\"page-break-after:always;\">&nbsp;</div>"; // Modify page break content

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Cell Rendered event
	function Cell_Rendered(&$Field, $CurrentValue, &$ViewValue, &$ViewAttrs, &$CellAttrs, &$HrefValue, &$LinkAttrs) {

		//$ViewValue = "xxx";
		//$ViewAttrs["style"] = "xxx";

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

	// Load Filters event
	function Page_FilterLoad() {

		// Enter your code here
		// Example: Register/Unregister Custom Extended Filter
		//ewr_RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A', 'GetStartsWithAFilter'); // With function, or
		//ewr_RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A'); // No function, use Page_Filtering event
		//ewr_UnregisterFilter($this-><Field>, 'StartsWithA');

	}

	// Page Filter Validated event
	function Page_FilterValidated() {

		// Example:
		//$this->MyField1->SearchValue = "your search criteria"; // Search value

	}

	// Page Filtering event
	function Page_Filtering(&$fld, &$filter, $typ, $opr = "", $val = "", $cond = "", $opr2 = "", $val2 = "") {

		// Note: ALWAYS CHECK THE FILTER TYPE ($typ)! Example:
		// if ($typ == "dropdown" && $fld->FldName == "MyField") // Dropdown filter
		//     $filter = "..."; // Modify the filter
		// if ($typ == "extended" && $fld->FldName == "MyField") // Extended filter
		//     $filter = "..."; // Modify the filter
		// if ($typ == "popup" && $fld->FldName == "MyField") // Popup filter
		//     $filter = "..."; // Modify the filter
		// if ($typ == "custom" && $opr == "..." && $fld->FldName == "MyField") // Custom filter, $opr is the custom filter ID
		//     $filter = "..."; // Modify the filter

	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		// Enter your code here
	}
}
?>
