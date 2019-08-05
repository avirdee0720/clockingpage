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
	private $monthEnd = array(0, 0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	    // Constructor:
    public function StaffDates($CurrentD,$StartedD)
    {
		
		list($this->yC, $this->mC, $this->dC ) = @explode("-",$CurrentD);
		list($this->yS, $this->mS, $this->dS ) = @explode("-",$StartedD);
		$this->CBM = $CurrentD;
    }

    public function __destruct()
    {
    }
    
    function CurrentBonusYearStarted()
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
    
    function CurrentBonusYearStartedPayExpSlip()
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
    
    function CurrentBonusYearEnd()
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
    
    function CurrentBonusYearEndPayExpSlip()
    {
		if ($this->month == 1) 
			{ $this->EYear = $this->Year; } 
		elseif (($this->mS == $this->mC - 1) && ($this->yC <> $this->yS))
			{ $this->EYear = $this->yS + 1; }
		else 
			{ $this->EYear = $this->Year + 1; }
				
		$this->CurrentBonusYearEndValue = @date("Y-m-d",mktime(0, 0, 0, $this->mS, $this->monthEnd[$this->mS + 1],  $this->EYear + $this->NewYear));

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