<?php
// php translation of asp script by Bill Wooten from
// http://www.4guysfromrolla.com/webtech/082802-1.shtml

function showServices($vComputerName, $vClass)  {
   $objLocator = new COM("WbemScripting.SWbemLocator");

   if($vComputerName == "") $objService = $objLocator->ConnectServer();
   else                    $objService = $objLocator->ConnectServer($vComputerName);

   $objWEBM = $objService->Get($vClass);
   $objProp = $objWEBM->Properties_;
   $objMeth = $objWEBM->Methods_;

   foreach($objMeth as $methItem) echo "Method: " . $methItem->Name ."\r\n";

   echo "\r\n";

   $objWEBMCol = $objWEBM->Instances_();

   foreach($objWEBMCol as $objItem) {

       echo "[" . $objItem->Name . "]\r\n";

       foreach($objProp as $propItem) {
           $tmp = $propItem->Name;
           echo "$tmp: " . $objItem->$tmp . "\r\n";
       }

         echo "\r\n";
   }
}

// Test the function:
showServices("", "Win32_Processor");
showServices("", "Win32_LogicalDisk");

?>