<?php
// starting excel

$excel = new COM("excel.application") or die("Unable to instanciate excel");
print "Loaded excel, version {$excel->Version}\n";

//bring it to front
#$excel->Visible = 1;//NOT
//dont want alerts ... run silent
$excel->DisplayAlerts = 0;

//open  document
$excel->Workbooks->Open("C:\\mydir\\myfile.xls");
//XlFileFormat.xlcsv file format is 6
//saveas command (file,format ......)
$excel->Workbooks[1]->SaveAs("c:\\mydir\\myfile.csv",6);

//closing excel
$excel->Quit();

//free the object
$excel->Release();
$excel = null;
?>