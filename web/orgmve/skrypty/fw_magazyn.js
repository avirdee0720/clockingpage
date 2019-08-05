/**
 * Parametry uruchomienia skryptu fw_menu
 * Realilzacja 2002: Zolty
 * dla: ::magazyn :: PAKT
 */

function fwLoadMenus() {
  if (window.fw_menu_0) return;
  window.fw_menu_0 = new Menu("root",130,30,"Tahoma, Verdana, Arial, Helvetica, sans-serif",12,"#000000","#f3f3f3","#F9F9F9","#0000CC");
  fw_menu_0.addMenuItem("Zamówienia","location='adm_zam.php'");
  fw_menu_0.addMenuItem("Wszystkie","location='adm_zamo.php'");
  fw_menu_0.addMenuItem("Oczekuj¹ce","location='adm_zamo.php'");
  fw_menu_0.addMenuItem("Zrealizowane","location='adm_zamz.php'");
   fw_menu_0.hideOnMouseOut=true;

  window.fw_menu_1 = new Menu("root",100,30,"Tahoma, Verdana, Arial, Helvetica, sans-serif",12,"#000000","#f3f3f3","#F9F9F9","#0000CC");
  fw_menu_1.addMenuItem("Wszystko","location='adm_all.php'");
  fw_menu_1.addMenuItem("Brakuje","location='adm_stan.php'");
  fw_menu_1.addMenuItem("Zabraknie","location='adm_br.php'");
  fw_menu_1.addMenuItem("Z bazy","location='adm_asort.php'");
   fw_menu_1.hideOnMouseOut=true;

  window.fw_menu_2 = new Menu("root",100,30,"Tahoma, Verdana, Arial, Helvetica, sans-serif",12,"#000000","#f3f3f3","#F9F9F9","#0000CC");
  fw_menu_2.addMenuItem("Przyjêcie PZ","location='nie.php'");
  fw_menu_2.addMenuItem("Dodanie towaru","location='nie.php'");
   fw_menu_2.hideOnMouseOut=true;

  window.fw_menu_3 = new Menu("root",120,30,"Tahoma, Verdana, Arial, Helvetica, sans-serif",12,"#000000","#f3f3f3","#F9F9F9","#0000CC");
  fw_menu_3.addMenuItem("WZ","location='nie.php'");
  fw_menu_3.addMenuItem("MM","location='nie.php'");
   fw_menu_3.hideOnMouseOut=true;

  window.fw_menu_33 = new Menu("root",80,30,"Tahoma, Verdana, Arial, Helvetica, sans-serif",12,"#000000","#f3f3f3","#F9F9F9","#0000CC");
  fw_menu_33.addMenuItem("Nowe forum","location='nie.php'");
  fw_menu_33.addMenuItem("Stare forum","location='nie.php'");
   fw_menu_33.hideOnMouseOut=true;

   window.fw_menu_4= new Menu("root",150,30,"Tahoma, Verdana, Arial, Helvetica, sans-serif",12,"#000000","#f3f3f3","#F9F9F9","#0000CC");
  fw_menu_4.addMenuItem("Dostwacy","location='adm_dost.php'");
  fw_menu_4.addMenuItem("Odbiorcy","location='adm_odb.php'");
   fw_menu_4.hideOnMouseOut=true;

  window.fw_menu_5= new Menu("root",130,30,"Tahoma, Verdana, Arial, Helvetica, sans-serif",12,"#000000","#f3f3f3","#F9F9F9","#0000CC");
  fw_menu_5.addMenuItem("Uzytkownicy","location='adm_czl.php'");
  fw_menu_5.addMenuItem("Dzia³y","location='adm_wydz.php'");
  fw_menu_5.addMenuItem("Uprawnienia tabel","location='adm_tab.php'");
  fw_menu_5.addMenuItem("Scie¿ki","location='nie.php'");
  fw_menu_5.addMenuItem("Zmienne","location='nie.php'");
  fw_menu_5.addMenuItem("Logi","location='adm_logi.php'");
   fw_menu_5.hideOnMouseOut=true;

  window.fw_menu_6= new Menu("root",150,30,"Tahoma, Verdana, Arial, Helvetica, sans-serif",12,"#000000","#f3f3f3","#F9F9F9","#0000CC");
  fw_menu_6.addMenuItem("Synchronizacja PAKO","location='load1.php'");
  fw_menu_6.addMenuItem("Inwentaryzacja","location='nie.php'");
  fw_menu_6.addMenuItem("Karta towaru","location='nie.php'");
  fw_menu_6.addMenuItem("Sprawdzanie bazy","location='an1.php'");


   window.fw_menu_7= new Menu("root",130,30,"Tahoma, Verdana, Arial, Helvetica, sans-serif",12,"#000000","#f3f3f3","#F9F9F9","#0000CC");
  fw_menu_7.addMenuItem("O programie","location='./help.php'");

   fw_menu_7.hideOnMouseOut=true;


  fw_menu_1.writeMenus();
}