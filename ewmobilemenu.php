<!-- Begin Main Menu -->
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(4, "mmi_tb_customer", $Language->MenuPhrase("4", "MenuText"), "tb_customerlist.php", -1, "", AllowListMenu('{E6C293EF-4D71-4FC6-B668-35B8D3E752AB}tb_customer'), FALSE, FALSE);
$RootMenu->AddMenuItem(10012, "mmi_tb_barang", $Language->MenuPhrase("10012", "MenuText"), "tb_baranglist.php", -1, "", AllowListMenu('{E6C293EF-4D71-4FC6-B668-35B8D3E752AB}tb_barang'), FALSE, FALSE);
$RootMenu->AddMenuItem(6, "mmi_tb_invoice", $Language->MenuPhrase("6", "MenuText"), "tb_invoicelist.php", -1, "", AllowListMenu('{E6C293EF-4D71-4FC6-B668-35B8D3E752AB}tb_invoice'), FALSE, FALSE);
$RootMenu->AddMenuItem(10069, "mmci_Cetak", $Language->MenuPhrase("10069", "MenuText"), "", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(10011, "mmi_cetak2_php", $Language->MenuPhrase("10011", "MenuText"), "cetak2.php", 10069, "", AllowListMenu('{E6C293EF-4D71-4FC6-B668-35B8D3E752AB}cetak2.php'), FALSE, TRUE);
$RootMenu->AddMenuItem(10040, "mmi_kuitansi_01_php", $Language->MenuPhrase("10040", "MenuText"), "kuitansi_01.php", 10069, "", AllowListMenu('{E6C293EF-4D71-4FC6-B668-35B8D3E752AB}kuitansi_01.php'), FALSE, TRUE);
$RootMenu->AddMenuItem(10070, "mmci_Rekap", $Language->MenuPhrase("10070", "MenuText"), "", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(10028, "mmri_Report1", $Language->MenuPhrase("10028", "MenuText"), "Report1smry.php", 10070, "{22C53325-0767-45B5-9478-ED427BDDCEC3}", AllowListMenu('{22C53325-0767-45B5-9478-ED427BDDCEC3}Report1'), FALSE, FALSE);
$RootMenu->AddMenuItem(10029, "mmri_Report4", $Language->MenuPhrase("10029", "MenuText"), "Report4smry.php", 10070, "{22C53325-0767-45B5-9478-ED427BDDCEC3}", AllowListMenu('{22C53325-0767-45B5-9478-ED427BDDCEC3}Report4'), FALSE, FALSE);
$RootMenu->AddMenuItem(10031, "mmri_Report2", $Language->MenuPhrase("10031", "MenuText"), "Report2smry.php", 10070, "{22C53325-0767-45B5-9478-ED427BDDCEC3}", AllowListMenu('{22C53325-0767-45B5-9478-ED427BDDCEC3}Report2'), FALSE, FALSE);
$RootMenu->AddMenuItem(10034, "mmi_tb_user", $Language->MenuPhrase("10034", "MenuText"), "tb_userlist.php", -1, "", AllowListMenu('{E6C293EF-4D71-4FC6-B668-35B8D3E752AB}tb_user'), FALSE, FALSE);
$RootMenu->AddMenuItem(-2, "mmi_changepwd", $Language->Phrase("ChangePwd"), "changepwd.php", -1, "", IsLoggedIn() && !IsSysAdmin());
$RootMenu->AddMenuItem(-1, "mmi_logout", $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, "mmi_login", $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
<!-- End Main Menu -->
