Here is a COM function that creates an excel spreadsheet with any number of worksheets, containing data from a matching number of SQL queries.  Be ware of the upper limit of excel worksheets.  This function properly shuts down Excel on the server. 
/***************************/
   function WriteExcel($strPath,$astrSheetName,$astrSQL){
/* This function takes a file save path, and array of sheet names and a corresponding array */
/* of SQL queries for each sheet and created a multi-worksheet excel spreadsheet*/
   $C_NAME=__CLASS__."::".__FUNCTION__;
       $dbs=new clsDB;
       $exapp = new COM("Excel.Application") or Die ("Did not connect");
       $intSheetCount=count($astrSheetName);
       $wkb=$exapp->Workbooks->Add();   
           $exapp->Application->Visible = 1;
       for ($int=0;$int<$intSheetCount;$int++){
           $sheet=$wkb->Worksheets($int+1);
           $sheet->activate;
           $sheet->Name=$astrSheetName[$int];
           $intRow=1;
           $qrySQL=$dbs->GetQry($astrSQL[$int],$C_NAME,__LINE__);
           $rstSQL=$qrySQL->fetchRow(DB_FETCHMODE_ASSOC);
           $astrKeyNames=array_keys($rstSQL);
           $intCols=count($astrKeyNames);
           $qrySQL=$dbs->GetQry($astrSQL[$int],$C_NAME,__LINE__);
           while($rstSQL=$qrySQL->fetchRow(DB_FETCHMODE_ASSOC)){
               $strOut="";//initialize the output string
               for ($int2=0;$int2<$intCols;$int2++){//we start at 1 because don't want to output the table's index
                   if($intRow==1){
                       $strOut=$astrKeyNames[$int2];
                   }else{
                       $strOut=$rstSQL[$astrKeyNames[$int2]];
                   }
                       $sheet->activate;
                       $cell=$sheet->Cells($intRow,($int2+1));//->activate;
                       $cell->Activate;
                         $cell->value = $strOut;
                   }//end of colcount for loop
               $intRow++;
           }//end while loop
       }//end sheetcount for loop
       if (file_exists($strPath)) {unlink($strPath);}
       $wkb->SaveAs($strPath);
       $wkb->Close(false);
       unset($sheet);
       $exapp->Workbooks->Close(false);
       unset($wkb);
       $exapp->Quit;
       unset($exapp);
       unset($dbs);
   }//function WriteExcel

