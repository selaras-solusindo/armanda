<!-- Begin Main Menu -->
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(10011, "mmi_cetak2_php", $Language->MenuPhrase("10011", "MenuText"), "cetak2.php", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(4, "mmi_tb_customer", $Language->MenuPhrase("4", "MenuText"), "tb_customerlist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(6, "mmi_tb_invoice", $Language->MenuPhrase("6", "MenuText"), "tb_invoicelist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->Render();
?>
<!-- End Main Menu -->
