<!-- Begin Main Menu -->
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(4, "mi_tb_customer", $Language->MenuPhrase("4", "MenuText"), "tb_customerlist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(10012, "mi_tb_barang", $Language->MenuPhrase("10012", "MenuText"), "tb_baranglist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(6, "mi_tb_invoice", $Language->MenuPhrase("6", "MenuText"), "tb_invoicelist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(10013, "mi_tb_kuitansi", $Language->MenuPhrase("10013", "MenuText"), "tb_kuitansilist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(10011, "mi_cetak2_php", $Language->MenuPhrase("10011", "MenuText"), "cetak2.php", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(10015, "mi_kuitansi_php", $Language->MenuPhrase("10015", "MenuText"), "kuitansi.php", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(10020, "mri_Report1", $Language->MenuPhrase("10020", "MenuText"), "Report1smry.php", -1, "{22C53325-0767-45B5-9478-ED427BDDCEC3}", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(10022, "mri_Report2", $Language->MenuPhrase("10022", "MenuText"), "Report2smry.php", -1, "{22C53325-0767-45B5-9478-ED427BDDCEC3}", TRUE, FALSE, FALSE);
$RootMenu->Render();
?>
<!-- End Main Menu -->
