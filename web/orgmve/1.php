In case you are wondering how to group rows or columns in the freshly created EXCEL files, then this may help you

<?php
   /***
   * Grouping Rows optically in Excel Using a COM Object
   *
   * That was not easy, I have spent several hours of trial and error to get
   * this thing to work!!!
   *
   * @author Kulikov Alexey <a.kulikov@gmail.com>
   * @since  13.03.2006
   *
   * @see    Open Excel, Hit Alt+F11, thne Hit F2 -- this is your COM bible
   ***/

   //starting excel
   $excel = new COM("excel.application") or die("Unable to instanciate excel");
   print "Loaded excel, version {$excel->Version}\n";

   //bring it to front
   #$excel->Visible = 1;//NOT

   //dont want alerts ... run silent
   $excel->DisplayAlerts = 0;

   //create a new workbook
   $wkb = $excel->Workbooks->Add();

   //select the default sheet
   $sheet=$wkb->Worksheets(1);

   //make it the active sheet
   $sheet->activate;

   //fill it with some bogus data
   for($row=1;$row<=7;$row++){
       for ($col=1;$col<=5;$col++){

         $sheet->activate;
         $cell=$sheet->Cells($row,$col);
         $cell->Activate;
         $cell->value = 'pool4tool 4eva ' . $row . ' ' . $col . ' ak';
       }//end of colcount for loop
   }

   ///////////
   // Select Rows 2 to 5
   $r = $sheet->Range("2:5")->Rows;

   // group them baby, yeah
   $r->Cells->Group;

   // save the new file
   $strPath = 'tfile.xls';
   if (file_exists($strPath)) {unlink($strPath);}
   $wkb->SaveAs($strPath);

   //close the book
   $wkb->Close(false);
   $excel->Workbooks->Close();

   //free up the RAM
   unset($sheet);

   //closing excel
   $excel->Quit();

   //free the object
   $excel = null;
?>