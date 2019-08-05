<?php
/* Class StaffDates by Alex Zolczynski 05.2007
gives you staff start bonus year & previous
usage: 	
	
	$PYBS = new StaffDates($ddo,$emp->started); 
	$BonusYearStart = $PYBS->CurrentBonusYearStarted();
	$CurrentBonusYearEnd = $PYBS->CurrentBonusYearEnd();
	$PrevBonusYearStarted = $PYBS->PrevBonusYearStarted();
	$PrevBonusYearEnd = $PYBS->PrevBonusYearEnd();

*/

define("StaffDates_Included","1");

class StaffDates
{
    public $CurrentBonusYearStartedValue = "";
    public $CurrentBonusYearEndValue = "";
    public $PrevBonusYearStartedValue = "";
	public $PrevBonusYearEndValue = "";
	private $yC = 0;
	private $mC = 0;
	private $dC = 0;
	private $yS = 0; 
	private $mS = 0;
	private $dS = 0;
	private $month = 0;
	private $Year = 0;
	private $EYear = 0;
	private $NewYear = 0;
	private $CBM = 0;
	private $SBM = 0;
	private $monthEnd = array(0, 0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	    // Constructor:
    public function StaffDates($CurrentD,$StartedD)
    {
		
		list($this->yC, $this->mC, $this->dC ) = @explode("-",$CurrentD);
		list($this->yS, $this->mS, $this->dS ) = @explode("-",$StartedD);
		$this->CBM = $CurrentD;
		$this->SBM = $StartedD;
    }

    public function __destruct()
    {
    }
    
    function CurrentBonusYearStartedEx()
    {
		if ($this->mS == 12) 
			{	$this->month = 1; } 
		elseif ($this->mS == $this->mC - 1) 
			{	$this->NewYear = 1; 
				$this->month = $this->mS + 1; }
		else 
			{	$this->month = $this->mS + 1; }
		
		if (($this->mC == $this->month || $this->mC < $this->month) && ($this->yC <> $this->yS)) 
			{ $this->Year = $this->yC - 1; } 
		elseif ($this->yC == $this->yS) 
			{ $this->Year = $this->yC; }
		else 
			{ $this->Year = $this->yC; }
		
		$this->CurrentBonusYearStartedValue = @date("Y-m-d",mktime(0, 0, 0, $this->month, 01,  $this->Year + $this->NewYear));

        return $this->CurrentBonusYearStartedValue;
    } 
    
    function CurrentBonusYearStartedEx2()
    {
		if ($this->mS == 12) 
			{	$this->month = 1; } 
		elseif (($this->mS == $this->mC - 1) && ($this->yC <> $this->yS))
			{	$this->NewYear = 1; 
				$this->month = $this->mS + 1; }
		else 
			{	$this->month = $this->mS + 1; }
		
		if (($this->mC == $this->month || $this->mC < $this->month) && ($this->yC <> $this->yS)) 
			{ $this->Year = $this->yC - 1; } 
		elseif ($this->yC == $this->yS) 
			{ $this->Year = $this->yC; }
		else 
			{ $this->Year = $this->yC; }
		
		$this->CurrentBonusYearStartedValue = @date("Y-m-d",mktime(0, 0, 0, $this->month, 01,  $this->Year + $this->NewYear));

        return $this->CurrentBonusYearStartedValue;
    }  
    
    function CurrentBonusYearStarted()
    {
    //include("./config.php");
     $cbdb = new CMySQL; 
     if (!$cbdb->Open()) $cbdb->Kill();
     $cbdbsql = "SELECT  STR_TO_DATE( concat( '01/', MONTH( DATE_ADD( STR_TO_DATE('$this->SBM', '%Y-%m-%d' ), INTERVAL 1
MONTH ) ) , '/', YEAR( STR_TO_DATE( '$this->CBM', '%Y-%m-%d' ) ) -1 ) , '%d/%m/%Y' ) AS bonus1, 
STR_TO_DATE( concat( '01/', MONTH( DATE_ADD( STR_TO_DATE('$this->SBM', '%Y-%m-%d' ), INTERVAL 1
MONTH ) ) , '/', YEAR( STR_TO_DATE( '$this->CBM', '%Y-%m-%d' ) ) ) , '%d/%m/%Y' ) AS bonus2, 
LAST_DAY( DATE_ADD(DATE_SUB(STR_TO_DATE( concat( '01/', MONTH( DATE_ADD( STR_TO_DATE('$this->SBM', '%Y-%m-%d' ), INTERVAL 1
MONTH ) ) , '/', YEAR( STR_TO_DATE( '$this->CBM', '%Y-%m-%d' ) ) -1 ) , '%d/%m/%Y' ), INTERVAL 1 DAY),INTERVAL 1 YEAR)  ) AS endbonus1,
LAST_DAY( DATE_ADD(DATE_SUB(STR_TO_DATE( concat( '01/', MONTH( DATE_ADD( STR_TO_DATE('$this->SBM', '%Y-%m-%d' ), INTERVAL 1
MONTH ) ) , '/', YEAR( STR_TO_DATE( '$this->CBM', '%Y-%m-%d' ) ) ) , '%d/%m/%Y' ), INTERVAL 1 DAY),INTERVAL 1 YEAR)) AS endbonus2

";

		if (!$cbdb->Query($cbdbsql)) $cbdb->Kill();
		$cbdbrow=$cbdb->Row();
		$bonus1=$cbdbrow->bonus1;
		$bonus2=$cbdbrow->bonus2;
		$endbonus1=$cbdbrow->endbonus1;
		$endbonus2=$cbdbrow->endbonus2;
//echo $cbdbsql." <br> $bonus1 - $bonus2 - $endbonus1 - $endbonus2<br>";

// $date1 = date("l", mktime(0, 0, 0, 7, 1, 2000)
$date1 = strtotime($this->CBM);
$date2 = strtotime($bonus2);
if ($date2 > $date1)	$this->CurrentBonusYearStartedValue = $bonus1;
else 	$this->CurrentBonusYearStartedValue = $bonus2;	
 
        return $this->CurrentBonusYearStartedValue;
    }  
    
    function CurrentBonusYearEndEx()
    {
		if ($this->month == 1) 
			{ $this->EYear = $this->Year; } 
		elseif ($this->yC == $this->yS) 
			{ $this->EYear = $this->yS + 1; }
		else 
			{ $this->EYear = $this->Year + 1; }
				
		$this->CurrentBonusYearEndValue = @date("Y-m-d",mktime(0, 0, 0, $this->mS, $this->monthEnd[$this->mS + 1],  $this->EYear + $this->NewYear));

        return $this->CurrentBonusYearEndValue;

    }  
    
    function CurrentBonusYearEndEx2()
    {
		if ($this->month == 1) 
			{ $this->EYear = $this->Year; } 
		elseif (($this->mS == $this->mC - 1) && ($this->yC <> $this->yS))
			{ $this->EYear = $this->Year + 1; }
		else 
			{ $this->EYear = $this->Year + 1; }
				
		$this->CurrentBonusYearEndValue = @date("Y-m-d",mktime(0, 0, 0, $this->mS, $this->monthEnd[$this->mS + 1],  $this->EYear  + $this->NewYear));

        return $this->CurrentBonusYearEndValue;

    }  
    
    function CurrentBonusYearEnd()
    {
    
    
    //include("./config.php");
     $cbdb = new CMySQL; 
     if (!$cbdb->Open()) $cbdb->Kill();
     $cbdbsql = "SELECT  STR_TO_DATE( concat( '01/', MONTH( DATE_ADD( STR_TO_DATE('$this->SBM', '%Y-%m-%d' ), INTERVAL 1
MONTH ) ) , '/', YEAR( STR_TO_DATE( '$this->CBM', '%Y-%m-%d' ) ) -1 ) , '%d/%m/%Y' ) AS bonus1, 
STR_TO_DATE( concat( '01/', MONTH( DATE_ADD( STR_TO_DATE('$this->SBM', '%Y-%m-%d' ), INTERVAL 1
MONTH ) ) , '/', YEAR( STR_TO_DATE( '$this->CBM', '%Y-%m-%d' ) ) ) , '%d/%m/%Y' ) AS bonus2, 
LAST_DAY( DATE_ADD(DATE_SUB(STR_TO_DATE( concat( '01/', MONTH( DATE_ADD( STR_TO_DATE('$this->SBM', '%Y-%m-%d' ), INTERVAL 1
MONTH ) ) , '/', YEAR( STR_TO_DATE( '$this->CBM', '%Y-%m-%d' ) ) -1 ) , '%d/%m/%Y' ), INTERVAL 1 DAY),INTERVAL 1 YEAR)  ) AS endbonus1,
LAST_DAY( DATE_ADD(DATE_SUB(STR_TO_DATE( concat( '01/', MONTH( DATE_ADD( STR_TO_DATE('$this->SBM', '%Y-%m-%d' ), INTERVAL 1
MONTH ) ) , '/', YEAR( STR_TO_DATE( '$this->CBM', '%Y-%m-%d' ) ) ) , '%d/%m/%Y' ), INTERVAL 1 DAY),INTERVAL 1 YEAR)) AS endbonus2

";
//echo $cbdbsql."<br>";
		if (!$cbdb->Query($cbdbsql)) $cbdb->Kill();
		$cbdbrow=$cbdb->Row();
		$bonus1=$cbdbrow->bonus1;
		$bonus2=$cbdbrow->bonus2;
		$endbonus1=$cbdbrow->endbonus1;
		$endbonus2=$cbdbrow->endbonus2;
//echo $cbdbsql." <br> $bonus1 - $bonus2 - $endbonus1 - $endbonus2<br>";

// $date1 = date("l", mktime(0, 0, 0, 7, 1, 2000)
$date1 = strtotime($this->CBM);
$date2 = strtotime($bonus2);
if ($date2 > $date1)	$this->CurrentBonusYearEndValue = $endbonus1;
else 	$this->CurrentBonusYearEndValue = $endbonus2;	
 
        return $this->CurrentBonusYearEndValue;

    }  
    
    function PrevBonusYearStarted()
    {
		if ($this->mS == 12) 
			{ $this->month = 1; } 
		elseif ($this->mS == $this->mC - 1) 
			{ $this->NewYear = 1; $this->month = $this->mS+1;}
		else 
			{ $this->month = $this->mS+1; }
		
		if (($this->mC == $this->month || $this->mC < $this->month) && ($this->yC <> $this->yS)) 
			{ $this->Year = $this->yC - 1; } 
		elseif ($this->yC == $this->yS) 
			{ $this->Year = $this->yC; }
		else 
			{ $this->Year = $this->yC; }
			
		$this->Year = $this->Year -1;
		
		if(($this->yC !== $this->yS)) $this->PrevBonusYearStartedValue = @date("Y-m-d",mktime(0, 0, 0, $this->month, 01,  $this->Year + $this->NewYear));  
			else $this->PrevBonusYearStartedValue = "no";
			
		return $this->PrevBonusYearStartedValue;
    }
    
    function PrevBonusYearEnd()
    {
    	if ($this->month == 1) 
			{ $this->EYear = $this->Year; } 
		elseif ($this->yC == $this->yS) 
			{ $this->EYear = $this->yS + 1; }
		else 
			{ $this->EYear = $this->Year + 1; }
		
		$this->Year = $this->Year -1;
		
		if(($this->yC !== $this->yS)) $this->PrevBonusYearEndValue = @date("Y-m-d",mktime(0, 0, 0, $this->mS, $this->monthEnd[$this->mS + 1],  $this->EYear + $this->NewYear));
			else $this->PrevBonusYearEndValue = "forget it";
	
        return $this->PrevBonusYearEndValue;
    }  

}
?>