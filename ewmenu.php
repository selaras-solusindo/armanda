<!-- Begin Main Menu -->
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(10011, "mi_cetak2_php", $Language->MenuPhrase("10011", "MenuText"), "cetak2.php", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(4, "mi_tb_customer", $Language->MenuPhrase("4", "MenuText"), "tb_customerlist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(6, "mi_tb_invoice", $Language->MenuPhrase("6", "MenuText"), "tb_invoicelist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->Render();
?>
<!-- End Main Menu -->
