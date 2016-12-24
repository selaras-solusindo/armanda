<!-- Begin Main Menu -->
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(4, "mmi_tb_customer", $Language->MenuPhrase("4", "MenuText"), "tb_customerlist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(10012, "mmi_tb_barang", $Language->MenuPhrase("10012", "MenuText"), "tb_baranglist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(6, "mmi_tb_invoice", $Language->MenuPhrase("6", "MenuText"), "tb_invoicelist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(10013, "mmi_tb_kuitansi", $Language->MenuPhrase("10013", "MenuText"), "tb_kuitansilist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(10011, "mmi_cetak2_php", $Language->MenuPhrase("10011", "MenuText"), "cetak2.php", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(10015, "mmi_kuitansi_php", $Language->MenuPhrase("10015", "MenuText"), "kuitansi.php", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(10017, "mmi_Report1", $Language->MenuPhrase("10017", "MenuText"), "Report1report.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->Render();
?>
<!-- End Main Menu -->
