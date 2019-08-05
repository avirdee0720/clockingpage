<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db2 = new CMySQL;
$db3 = new CMySQL;
$tytul='Knowledge  - Keys List';

uprstr($PU,90);


$DepGroup=$_GET['_grp'];
$DepGroupUpper=strtoupper($_GET['_grp']);


$tabletxt = "";

if (!$db->Open()) $db->Kill();
if (!$db2->Open()) $db2->Kill();
if (!$db3->Open()) $db3->Kill();


if(!isset($sort)) {$sort="5";$kier_sql ="DESC";}

        switch ($sort)
                {
                case 1:
                 $sortowanie=" ORDER BY `nombers`.`started` DESC";
                 break;
                case 2:
                 $sortowanie=" ORDER BY `nombers`.`knownas` $kier_sql ";
                 break;
                case 3:
                 $sortowanie=" ORDER BY `nombers`.`surname` $kier_sql";
                 break;
                case 4:
                 $sortowanie=" ORDER BY `nombers`.`cat` $kier_sql,`nombers`.`knownas` ASC ";
                 break;
                case 5:
                 $sortowanie=" ORDER BY `nombers`.`started` $kier_sql,`nombers`.`knownas` ASC";
                 break;
                case 6:
                 $sortowanie=" ORDER BY `regdays`.`datechange` $kier_sql,`nombers`.`knownas` ASC";
                 break;
                case 7:
                 $sortowanie=" ORDER BY `staffdetails`.`decision` $kier_sql";
                 break;
                default:
                 $sortowanie=" ORDER BY `nombers`.`started` $kier_sql ";
                 break;
        $row_count++;
	$row_color = (($row_count % 2) == 0) ? $colour_even : $colour_odd;        }
if(!isset($letter)) $letter='%';
else $letter=$letter.'%';


/*
$q = "SELECT DISTINCT `nombers`.`pno` , `nombers`.`surname` , `nombers`.`firstname` , `nombers`.`knownas` , `nombers`.`cat` , `nombers`.`textperson` ,`nombers`.`sign` ,`nombers`.`regdays`,DATE_FORMAT( `nombers`.`started` , \"%d/%m/%Y\" ) AS d1,  `emplcat`.catname,  `emplcat`.catname_staff  FROM (`nombers` CROSS JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no`) INNER JOIN `emplcat` ON `nombers`.`cat`= `emplcat`.catozn WHERE `nombers`.`status` = 'OK'  
AND  `nombers`.`pno` <> '5'
AND  `nombers`.`pno` <> '555'
AND  `emplcat`.catname_staff Like '$DepGroup'
AND (
`staffdetails`.`decision` <> '4'
AND `staffdetails`.`decision` <> '3'
OR `staffdetails`.`decision` IS NULL
)
";
*/

$colour_odd = "DataTD2"; 
$colour_even = "DataTDGrey2"; 
$row_count=0;

$q= "

SELECT DISTINCT `nombers`.`pno`, `nombers`.`surname` , `nombers`.`firstname` , `nombers`.`knownas`,`emplcat`.catname 
FROM `nombersknowledge`
INNER JOIN nombers ON no = pno
INNER JOIN knowledgelist ON `nombersknowledge`.knowledgeid = knowledgelist.ID
INNER JOIN `emplcat` ON `nombers`.`cat`= `emplcat`.catozn
WHERE `nombersknowledge`.value <>0
AND  `nombers`.`pno` <> '5'
AND  `nombers`.`pno` <> '555'
AND  `emplcat`.catname_staff Like '$DepGroup'
";
$q=$q.$sortowanie;

if ($db2->Query($q)) 
  {
      
      while ($row2=$db2->Row())
       {
        $no = $row2->pno;
$q= "

SELECT `nombers`.`pno` , `nombers`.`surname` , `nombers`.`firstname` , `nombers`.`knownas` , `nombersknowledge`.type, `nombersknowledge`.value, knowledgelist.initials
FROM `nombersknowledge`
INNER JOIN nombers ON no = pno
INNER JOIN knowledgelist ON `nombersknowledge`.knowledgeid = knowledgelist.ID
INNER JOIN `emplcat` ON `nombers`.`cat`= `emplcat`.catozn
WHERE `nombersknowledge`.value <>0
AND  `nombers`.`pno` ='$no'
AND  `emplcat`.catname_staff Like '$DepGroup'
Order by  knowledgelist.initials ASC,   knowledgelist.initials DESC
";


$q= "

(SELECT `nombers`.`pno` , `nombers`.`surname` , `nombers`.`firstname` , `nombers`.`knownas` ,knowledgeid, `nombersknowledge`.type, `nombersknowledge`.value, knowledgelist.initials
FROM `nombersknowledge`
INNER JOIN nombers ON no = pno
INNER JOIN knowledgelist ON `nombersknowledge`.knowledgeid = knowledgelist.ID
INNER JOIN `emplcat` ON `nombers`.`cat`= `emplcat`.catozn
WHERE `nombersknowledge`.value <>0
AND `nombersknowledge`.type ='C'
AND  `nombers`.`pno` ='$no'
AND  `emplcat`.catname_staff Like '$DepGroup'
Order by  knowledgelist.initials ASC,   knowledgelist.initials DESC
)
UNION (
SELECT `nombers`.`pno` , `nombers`.`surname` , `nombers`.`firstname` , `nombers`.`knownas` , knowledgeid,`nombersknowledge`.type, `nombersknowledge`.value, knowledgelist.initials
FROM `nombersknowledge`
INNER JOIN nombers ON no = pno
INNER JOIN knowledgelist ON `nombersknowledge`.knowledgeid = knowledgelist.ID
INNER JOIN `emplcat` ON `nombers`.`cat`= `emplcat`.catozn
WHERE `nombersknowledge`.value <>0
AND `nombersknowledge`.type ='S'
AND  `nombers`.`pno` ='$no'
AND  `emplcat`.catname_staff Like '$DepGroup'
Order by  knowledgelist.initials ASC,   knowledgelist.initials DESC
)
";

$q= "

(SELECT `nombers`.`pno` , `nombers`.`surname` , `nombers`.`firstname` , `nombers`.`knownas` ,knowledgeid, `nombersknowledge`.type, `nombersknowledge`.value, knowledgelist.initials
FROM `nombersknowledge`
INNER JOIN nombers ON no = pno
INNER JOIN knowledgelist ON `nombersknowledge`.knowledgeid = knowledgelist.ID
INNER JOIN `emplcat` ON `nombers`.`cat`= `emplcat`.catozn
WHERE `nombersknowledge`.value <>0
AND `nombersknowledge`.type ='C'
AND  `nombers`.`pno` ='$no'
AND  `emplcat`.catname_staff Like '$DepGroup'
Order by  knowledgelist.initials ASC
)
UNION (
SELECT `nombers`.`pno` , `nombers`.`surname` , `nombers`.`firstname` , `nombers`.`knownas` , knowledgeid,`nombersknowledge`.type, `nombersknowledge`.value, knowledgelist.initials
FROM `nombersknowledge`
INNER JOIN nombers ON no = pno
INNER JOIN knowledgelist ON `nombersknowledge`.knowledgeid = knowledgelist.ID
INNER JOIN `emplcat` ON `nombers`.`cat`= `emplcat`.catozn
WHERE `nombersknowledge`.value <>0
AND `nombersknowledge`.type ='S'
AND  `nombers`.`pno` ='$no'
AND  `emplcat`.catname_staff Like '$DepGroup'
Order by knowledgelist.initials ASC
)
";

//echo $q;
// AND `nombers`.`cat`<>'c'

$knowledgetext="";
$knowledgeextrainfo = "";

  if ($db->Query($q)) 
  {
	$ileich=$db->Rows();
    while ($row=$db->Row())
    {
//     if ($row->knowledgeid < 19) {
    if ($row->type == "C") $knowledgetext .= ucfirst($row->initials).", ";
    if ($row->type == "S") $knowledgetext .= strtolower($row->initials).", ";   
/*
     }
  else
  {
   $q = "SELECT nombersknowledge.id,knowledgeid,type,nombersknowledge.value,`nombersknowledgetext`.`userknowledgeid`,`nombersknowledgetext`.`value` As textvalue  FROM nombersknowledge LEFT JOIN `nombersknowledgetext` ON `nombersknowledgetext`.`userknowledgeid`=nombersknowledge.id where `no` = '$no' AND knowledgeid='$row->knowledgeid'";
  $db3->Query($q);

  while ($rq=$db3->Row())
    {
  if  ($rq->value == '1') {$knowledgeextrainfo.=$rq->textvalue.", ";  }  
     }
   }
   
 */    
	  }
	  
	   $knowledgetext=substr($knowledgetext, 0, -2);
     $knowledgeextrainfo=substr($knowledgeextrainfo, 0, -2);  
	  
     $row_count++;
	  $row_color = (($row_count % 2) == 0) ? $colour_even : $colour_odd;
	 
	  
	  $tabletxt.= "
     <tr>
	<input name='id2[]' type='hidden' value='$row->pno'>
	<td  nowrap=\"nowrap\" width='25'></td>
    <td CLASS='$row_color' nowrap=\"nowrap\"><b>$row2->knownas</b></td>
	<td CLASS='$row_color' nowrap=\"nowrap\"><b>$row2->surname</b></td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><b><div align=\"center\">$row2->catname&nbsp;</div></b></td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><b><div align=\"right\">$knowledgetext</div></b></td>
   </tr>";
	  
   }
   } // End while
} 
else {
	$echo=  " 
  <tr>
    <td CLASS='DataTD'></td>
    <td CLASS='DataTD' colspan='3'>Brak dzialow</td>
  </tr>";
 $db->Kill();
}
	$tabletxt .=  "
</table>

</center>
<BR>
</td></tr>
</table>
<table border='0' cellpadding='3' cellspacing='1' >
            <tr> <td align='right' colspan='2'>
		    
		    <input name='state' type='hidden' value='1'>
		    <input name='sort' type='hidden' value='$sort'>
		 		

</td>  </tr>
</table>
</form>
";
   // class='FormTABLE'
  //   <input class='Button' name='Update' type='submit' value='$SAVEBTN'>	
  
$tabletxt = "  <TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>

<font CLASS='FormHeaderFont'>$tytul&nbsp;&nbsp;   &nbsp;&nbsp;  Total:<b> $ileich</b>
<form action='$PHP_SELF?_grp=$DepGroup' method='post' name='hrlist'>
<table border='0' cellpadding='0' cellspacing='0'>
  <tr>
  <td  nowrap=\"nowrap\"></td>
    <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=2&kier=$kier&_grp=$_grp'>Known as</a>
       </div>  </td>
    <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=3&kier=$kier&_grp=$_grp'>Surname</a>
       </div>  </td>
   <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=4&kier=$kier&_grp=$_grp'>Job title</a></td>
       </div>  </td>
        <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
               Knowledge</div>  </td>
       
     </tr>
".$tabletxt;



echo $tabletxt;
include_once("./footer.php");





?>
