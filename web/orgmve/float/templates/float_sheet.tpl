<html xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1250">
<title>AFFIX Z REPORT HERE</title>
<LINK REL='stylesheet' HREF='../style/multipads/style.css' TYPE='text/css'>

<style type="text/css">
<!--
.style1 {
	font-family: Tahoma;
	font-size: 8.0pt;
}
.style2 {
	font-family: Tahoma;
	font-size: 7.0pt;
}
-->
</style></head>
<body bgcolor="#FFFFFF" lang=HU class=PageBODY>
<form action="" method="post" target="_parent" class='FormHeaderFont'>
  <div class=Section1>
    <table width=865 border=1 cellpadding=0 cellspacing=0 class='FormTABLE'>
      <tr><td class='DataTD' width=225 rowspan=2><p align="left"><b><span lang=EN-US
  style='font-size:24.0pt;font-family:Tahoma'>FLOAT SHEET</span></b></p></td><td class='DataTD' width=569 valign=bottom><p align="left"><b><span lang=EN-US
  style='font-size:10.0pt;font-family:Tahoma'>SHOP      
          </span><span style="font-size:10.0pt;font-family:Tahoma">
          <select name="shopid" id="shopid">
            
          ##{foreach from=$shop key=k item=i}# 
                      
            <option value="##{$i.shopid}#">##{$i.shopname}#</option>
            
                      ##{/foreach}#
                    
          </select>
          </span><span lang=EN-US
  style='font-size:10.0pt;font-family:Tahoma'>               
          DEPT</span></b>
            <select name="compldeptid" id="compldeptid">
                ##{foreach from=$department key=k item=i}# 
                 <option value="##{$i.depid}#">##{$i.depname}#</option>
                  ##{/foreach}#
                </select>
        </p></td>
      </tr>
      <tr><td class='DataTD' width=569 valign=bottom><p align="left"><b><span lang=EN-US
  style='font-size:9.0pt;font-family:Tahoma'>DAY        ##{$daytext}#              DATE         ##{$dataakt2}#</span></b></p></td>
      </tr>
    </table>
    <input name="floatsheedid" type="hidden" id="floatsheedid" value="##{$floatsheetid}#">
</div>
  <div align="center">
    <table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr><td class='DataTD' width="34%" valign="top">&nbsp;</td><td class='DataTD' width="2%" valign="top">&nbsp;</td><td class='DataTD' width="64%" valign="top">&nbsp;</td>
      </tr>
      <tr><td class='DataTD' valign="top"><table border=1 cellspacing=0 cellpadding=0 width=264>
          <tr><td class='DataTD' colspan=3><p align=center style='text-align:center;
  '><b><span lang=EN-US
  style='font-size:18.0pt;font-family:Tahoma'>MORNING FLOAT</span></b></p></td>
          </tr>
          <tr><td class='DataTD' width=66>&nbsp;</td><td class='DataTD'><p align=center style='text-align:center;
  '><b><span lang=EN-US
  style='font-size:9.0pt;font-family:Tahoma'>CASH MONEY</span></b></p></td><td class='DataTD'><p align=center style='text-align:center;
  '><b><span lang=EN-US
  style='font-size:9.0pt;font-family:Tahoma'>MVE VOUCHERS</span></b></p></td>
          </tr>
          <tr><td class='DataTD' width=66><p align=center style='text-align:center;
  '><b><span lang=EN-US
  style='font-size:9.0pt;font-family:Tahoma'>&pound;50</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher2" type="text" id="eveingcount_voucher7" value="##{$floatsvalue.1}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher2" type="text" id="eveingcount_voucher8" value="##{$floatsvalue.2}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' width=66><p align=center style='text-align:center;
  '><b><span lang=EN-US
  style='font-size:9.0pt;font-family:Tahoma'>&pound;20</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher2" type="text" id="eveingcount_voucher8" value="##{$floatsvalue.3}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher2" type="text" id="eveingcount_voucher8" value="##{$floatsvalue.4}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' width=66><p align=center style='text-align:center;
  '><b><span lang=EN-US
  style='font-size:9.0pt;font-family:Tahoma'>&pound;10</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher2" type="text" id="eveingcount_voucher8" value="##{$floatsvalue.5}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher2" type="text" id="eveingcount_voucher8" value="##{$floatsvalue.6}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' width=66><p align=center style='text-align:center;
  '><b><span lang=EN-US
  style='font-size:9.0pt;font-family:Tahoma'>&pound;5</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher2" type="text" id="eveingcount_voucher8" value="##{$floatsvalue.7}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher2" type="text" id="eveingcount_voucher8" value="##{$floatsvalue.8}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' width=66><p align=center style='text-align:center;
  '><b><span lang=EN-US
  style='font-size:9.0pt;font-family:Tahoma'>&pound;2 / &pound;1</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher2" type="text" id="eveingcount_voucher8" value="##{$floatsvalue.9}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher2" type="text" id="eveingcount_voucher8" value="##{$floatsvalue.10}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' width=66><p align=center style='text-align:center;
  '><b><span lang=EN-US
  style='font-size:9.0pt;font-family:Tahoma'>50P</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher2" type="text" id="eveingcount_voucher8" value="##{$floatsvalue.11}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher2" type="text" id="eveingcount_voucher8" value="##{$floatsvalue.12}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' width=66><p align=center style='text-align:center;
  '><b><span lang=EN-US
  style='font-size:9.0pt;font-family:Tahoma'>Small Change</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher2" type="text" id="eveingcount_voucher8" value="##{$floatsvalue.13}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher2" type="text" id="eveingcount_voucher8" value="##{$floatsvalue.14}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' width=66><p align=center style='text-align:center;
  '><b><span lang=EN-US
  style='font-size:9.0pt;font-family:Tahoma'>Till Total</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher2" type="text" id="eveingcount_voucher8" value="##{$floatsvalue.15}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher2" type="text" id="eveingcount_voucher8" value="##{$floatsvalue.16}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' width=66><p align=center style='text-align:center;
  '><b><span lang=EN-US
  style='font-size:9.0pt;font-family:Tahoma'>Buying Reserve</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher2" type="text" id="eveingcount_voucher8" value="##{$floatsvalue.17}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher2" type="text" id="eveingcount_voucher8" value="##{$floatsvalue.18}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' width=66><p align=center style='text-align:center;
  '><b><span lang=EN-US
  style='font-size:9.0pt;font-family:Tahoma'>Change Reserve</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher2" type="text" id="eveingcount_voucher8" value="##{$floatsvalue.19}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher2" type="text" id="eveingcount_voucher8" value="##{$floatsvalue.20}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' width=66><p><b><span lang=EN-US style='font-size:11.0pt;
  font-family:Tahoma'>TOTAL</span></b></p></td><td class='DataTD'><div align="right">
                <input name="eveingcount_voucher2" type="text" id="eveingcount_voucher8" value="##{$floatsvalue.21}#" size="10" maxlength="20">
            </div></td><td class='DataTD'><div align="right">
                <input name="eveingcount_voucher2" type="text" id="eveingcount_voucher8" value="##{$floatsvalue.22}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' colspan=3 valign=top><p><b><span lang=EN-US style='font-size:7.0pt;
  font-family:Tahoma'>COMPLETED BY </span></b></p>
                <label>
                <select name="completedmorning2" id="completedmorning2">
                  <option value="2">1</option>
                </select>
                </label>          </td>
          </tr>
        </table></td><td class='DataTD' valign="top">&nbsp;</td><td class='DataTD' valign="top"><table border=1 cellspacing=0 cellpadding=0 width=267>
          <tr><td class='DataTD' colspan=3><p align=center style='text-align:center;
  '><b><span lang=EN-US
  style='font-size:18.0pt;font-family:Tahoma'>EVENING FLOAT</span></b></p></td>
          </tr>
          <tr><td class='DataTD' width=69>&nbsp;</td><td class='DataTD'><p align=center style='text-align:center;
  '><b><span lang=EN-US
  style='font-size:9.0pt;font-family:Tahoma'>Cash Money</span></b></p></td><td class='DataTD'><p align=center style='text-align:center;
  '><b><span lang=EN-US
  style='font-size:9.0pt;font-family:Tahoma'>MVE Vouchers</span></b></p></td>
          </tr>
          <tr><td class='DataTD' width=69><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:9.0pt;
  font-family:Tahoma'>&pound;50</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.23}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.24}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' width=69><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:9.0pt;
  font-family:Tahoma'>&pound;20</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.25}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.26}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' width=69><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:9.0pt;
  font-family:Tahoma'>&pound;10</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.27}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.28}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' width=69><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:9.0pt;
  font-family:Tahoma'>&pound;5</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.29}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.30}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' width=69><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:9.0pt;
  font-family:Tahoma'>&pound;2 / &pound;1</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.31}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.32}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' width=69><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:9.0pt;
  font-family:Tahoma'>50P</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.33}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.34}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' width=69><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:9.0pt; font-family:Tahoma'>Small Change</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.35}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.36}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' width=69><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:9.0pt;
  font-family:Tahoma'>Till  Total</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.37}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.38}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' width=69><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:9.0pt;
  font-family:Tahoma'>Buying Reserve</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.39}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.40}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' width=69><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:9.0pt; font-family:Tahoma'>Change Reserve</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.41}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.42}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD'><b><span style="font-size:9.0pt;
  font-family:Tahoma">Total</span></b></td><td class='DataTD'><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.43}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.44}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD'><b><span style="font-size:9.0pt; font-family:Tahoma">Voucher Slips</span></b></td><td class='DataTD'><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.45}#" size="10" maxlength="20">
            </div></td><td class='DataTD'><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.46}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD'><b><span style="font-size:9.0pt; font-family:Tahoma">Credit Cards</span></b></td><td class='DataTD'><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.47}#" size="10" maxlength="20">
            </div></td><td class='DataTD'><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.48}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD'><b><span style="font-size:9.0pt; font-family:Tahoma">Cheques</span></b></td><td class='DataTD'><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.49}#" size="10" maxlength="20">
            </div></td><td class='DataTD'><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.50}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' width=69><p><b><span lang=EN-US style='font-size:11.0pt;
  font-family:Tahoma'>Grand Total</span></b></p></td><td class='DataTD'><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.51}#" size="10" maxlength="20">
            </div></td><td class='DataTD'><div align="right">
                <input name="eveingcount_voucher3" type="text" id="eveingcount_voucher9" value="##{$floatsvalue.52}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' colspan=3 valign=top><p><b><span lang=EN-US style='font-size:7.0pt;
  font-family:Tahoma'>COMPLETED BY</span></b></p>
                <p>
                  <select name="completedevening2" id="completedevening2">
                    <option value="2">1</option>
                  </select>
              </p></td>
          </tr>
        </table></td>
      </tr>
      <tr><td class='DataTD' valign="top"><table border=1 cellspacing=0 cellpadding=0 width=389>
          <tr><td class='DataTD' colspan="4"><p style='text-align:justify'><b><span style="font-size:18.0pt;font-family:Tahoma">BANKING &amp; FLOAT</span></b></p></td>
          </tr>
          <tr><td class='DataTD' width=98>&nbsp;</td><td class='DataTD' width=95><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:9.0pt;
  font-family:Tahoma'>Cash Money</span></b></p></td><td class='DataTD' width=91><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:8.0pt;
  font-family:Tahoma'>MEV Vouchers</span></b></p></td><td class='DataTD' width=95><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:8.0pt;
  font-family:Tahoma'>TOTAL</span></b></p></td>
          </tr>
          <tr><td class='DataTD' width=98><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:9.0pt;
  font-family:Tahoma'>Evening count</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_cash" type="text" id="eveingcount_voucher5" value="##{$floatsvalue.53}#" size="10" maxlength="20">
              </div>
                <div align="right"></div></td><td class='DataTD' width=91><div align="right">
                <input name="textfield" type="text" id="eveingcount_voucher" value="##{$floatsvalue.54}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
              <input name="eveingcount_voucher9" type="text" id="eveingcount_voucher13" value="##{$floatsvalue.55}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' width=98><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:9.0pt;
  font-family:Tahoma'>Banking</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher" type="text" id="eveingcount_voucher" value="##{$floatsvalue.56}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=91><div align="right">
                <input name="banking_vouher" type="text" id="eveingcount_voucher3" value="##{$floatsvalue.57}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
              <input name="eveingcount_voucher10" type="text" id="eveingcount_voucher14" value="##{$floatsvalue.58}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' width=98 rowspan=2><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:7.0pt;
  font-family:Tahoma'>Credit Card/voucher Slips</span></b></p></td><td class='DataTD' width=95><p><b><span lang=EN-US style='font-size:5.0pt;font-family:Tahoma'>Credit
              cards</span></b></p></td><td class='DataTD' width=91><p><b><span lang=EN-US style='font-size:5.0pt;font-family:Tahoma'>Voucher
              slips</span></b></p></td><td class='DataTD' width=95 rowspan=2><div align="right">
              <input name="eveingcount_voucher11" type="text" id="eveingcount_voucher15" value="##{$floatsvalue.59}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher" type="text" id="eveingcount_voucher" value="##{$floatsvalue.60}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=91><div align="right">
                <input name="eveingcount_voucher" type="text" id="eveingcount_voucher" value="##{$floatsvalue.61}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' width=98><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:9.0pt;
  font-family:Tahoma'>TOMORROW’S FLOAT</span></b></p></td><td class='DataTD' width=95><div align="right">
              <input name="eveingcount_voucher12" type="text" id="eveingcount_voucher16" value="##{$floatsvalue.62}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=91><div align="right">
              <input name="eveingcount_voucher13" type="text" id="eveingcount_voucher17" value="##{$floatsvalue.63}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
              <input name="eveingcount_voucher14" type="text" id="eveingcount_voucher18" value="##{$floatsvalue.64}#" size="10" maxlength="20">
            </div></td>
          </tr>
        </table></td><td class='DataTD' valign="top">&nbsp;</td><td class='DataTD' valign="top"><table border=1 cellspacing=0 cellpadding=0 width=368>
          <tr><td class='DataTD' colspan=4><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:14.0pt;
  font-family:Tahoma'>OVERRINGs RECORD</span></b></p></td>
          </tr>
          <tr><td class='DataTD' colspan=4><p style='text-align:justify;'><span
  lang=EN-US style='font-size:7.0pt;font-family:Tahoma'>Enter your over-rings
              here during the day.  Enter the dept no
              in the dept column and C or V on the C/V column to show what type of
              transaction it was and whether it was for cash or vouchers.  </span></p></td>
          </tr>
          <tr><td class='DataTD' width=86><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:10.0pt;
  font-family:Tahoma'>Dept</span></b></p></td><td class='DataTD' width=83><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:10.0pt;
  font-family:Tahoma'>C/V</span></b></p></td><td class='DataTD' colspan=2><p align=center style='text-align:center;'><b><span lang=EN-US style='font-family:Tahoma'>Amount</span></b></p></td>
          </tr>
          <tr><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher6" type="text" id="eveingcount_voucher10" value="##{$floatsvalue.8}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=83>&nbsp;</td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher6" type="text" id="eveingcount_voucher10" value="##{$floatsvalue.8}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher6" type="text" id="eveingcount_voucher10" value="##{$floatsvalue.8}#" size="10" maxlength="20">
            </div></td>
          </tr>
        </table></td>
      </tr>
      <tr><td class='DataTD' valign="top"><table border=1 cellspacing=0 cellpadding=0 width=389>
          <tr><td class='DataTD' colspan="4"><p style='text-align:justify'><b><span style="font-size:18.0pt;font-family:Tahoma">END OF DAY REPORT</span></b></p></td>
          </tr>
          <tr><td class='DataTD' width=118 valign=top>&nbsp;</td><td class='DataTD' width=95><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:9.0pt;
  font-family:Tahoma'>CASH</span></b></p></td><td class='DataTD' width=95 valign=top><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:8.5pt;
  font-family:Tahoma'>VOUCHERS</span></b></p></td><td class='DataTD' width=71 valign=top><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:9.0pt;
  font-family:Tahoma'>TOTAL</span></b></p></td>
          </tr>
          <tr><td class='DataTD' width=118><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:8.0pt;
  font-family:Tahoma'>Morning Float</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher4" type="text" id="eveingcount_voucher4" value="##{$floatsvalue.65}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher4" type="text" id="eveingcount_voucher4" value="##{$floatsvalue.66}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=71><div align="right">
              <input name="eveingcount_voucher15" type="text" id="eveingcount_voucher19" value="##{$floatsvalue.67}#" size="10" maxlength="20">
            </div></td>
          </tr>
          
          <tr><td class='DataTD' width=118><p align=center style='text-align:center;
  '><b><span lang=EN-US
  style='font-size:8.0pt;font-family:Tahoma'>Cash Cheque Credit Card &amp;<span class=SpellE> Voucher<br>
            </span>(totals from till Report)</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher4" type="text" id="eveingcount_voucher4" value="##{$floatsvalue.68}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
              <input name="eveingcount_voucher16" type="text" id="eveingcount_voucher20" value="##{$floatsvalue.69}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=71><div align="right">
              <input name="eveingcount_voucher18" type="text" id="eveingcount_voucher22" value="##{$floatsvalue.70}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' width=118><p align=center style='text-align:center;'><strong><span class="style1">Positive Overrings<br>
              To Be Subtracted (Sales etc)</span></strong>.</p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher4" type="text" id="eveingcount_voucher4" value="##{$floatsvalue.71}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher4" type="text" id="eveingcount_voucher4" value="##{$floatsvalue.72}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=71><div align="right">
              <input name="eveingcount_voucher20" type="text" id="eveingcount_voucher24" value="##{$floatsvalue.73}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' width=118><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:8.0pt; font-family:Tahoma'>Negative Overrings<br>
              To Be Added (Payouts etc)</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher4" type="text" id="eveingcount_voucher4" value="##{$floatsvalue.74}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher4" type="text" id="eveingcount_voucher4" value="##{$floatsvalue.75}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=71><div align="right">
              <input name="eveingcount_voucher19" type="text" id="eveingcount_voucher23" value="##{$floatsvalue.76}#" size="10" maxlength="20">
            </div></td>
          </tr>
          <tr><td class='DataTD' width=118><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:10.0pt;
  font-family:Tahoma'>CHECK TOTAL</span></b></p></td><td class='DataTD' width=95><div align="right">
              <input name="eveingcount_voucher21" type="text" id="eveingcount_voucher25" value="##{$floatsvalue.77}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
              <input name="eveingcount_voucher22" type="text" id="eveingcount_voucher26" value="##{$floatsvalue.78}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=71><div align="right">
              <input name="eveingcount_voucher23" type="text" id="eveingcount_voucher27" value="##{$floatsvalue.79}#" size="10" maxlength="20">
            </div></td>
          </tr>
        </table></td><td class='DataTD' valign="top">&nbsp;</td><td class='DataTD' valign="top"><table border=1 cellspacing=0 cellpadding=0 width=358>
          <tr><td class='DataTD' colspan="3"><b><span style="font-size:14.0pt;font-family:Tahoma">PAYOUTS</span></b></td>
          </tr>
          <tr><td class='DataTD' width=46><span style="text-align:center;
  "><b><span style="font-size:10.0pt;font-family:Tahoma">CASH</span></b></span></td><td class='DataTD'><p align=center style='text-align:center;
  '>
                <st1:address w:st="on">
                <st1:Street w:st="on">
                <b><span style="font-size:10.0pt;font-family:Tahoma">VOUCHERS</span></b></p></td><td class='DataTD'><p align=center style='text-align:center;
  '>
                <st1:address w:st="on">
                <st1:Street w:st="on">
                <span
  lang=EN-US style='font-size:14.0pt;font-family:Tahoma'><b>TOTALS</b></span></p></td>
          </tr>
          <tr><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher7" type="text" id="eveingcount_voucher11" value="##{$floatsvalue.8}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher7" type="text" id="eveingcount_voucher11" value="##{$floatsvalue.8}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=74>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr><td class='DataTD' rowspan="2" valign="top"><table border=1 cellspacing=0 cellpadding=0 width=388>
          <tr><td class='DataTD' colspan="4"><p style='text-align:justify'><b><span style="font-size:18.0pt;font-family:Tahoma">DEPARTMENT REPORT</span></b></p></td>
          </tr>
          <tr><td class='DataTD' width=141 valign=top><p align=center style='text-align:center;
  '><b><span lang=EN-US
  style='font-family:Tahoma'>SHOP RESULTS</span></b></p></td><td class='DataTD' width=95><p align=center style='text-align:center;
  '><b><span lang=EN-US
  style='font-size:7.0pt;font-family:Tahoma'>GROSS Total</span></b></p></td><td class='DataTD' width=95><p align=center style='text-align:center;
  '><strong><span class="style2">Overrings</span></strong></p></td><td class='DataTD' width=47><p align=center style='text-align:center;
  '><b><span style="font-size:7.0pt;font-family:Tahoma">Net Total</span></b></p></td>
          </tr>
          <tr><td class='DataTD'><div align="center"><b><span style="font-size:8.0pt; font-family:Tahoma">01SALE</span></b></div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.80}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.81}#" size="10" maxlength="20">
            </div></td><td class='DataTD'>
              <div align="right">
                <input name="eveingcount_voucher17" type="text" id="eveingcount_voucher21" value="##{$floatsvalue.82}#" size="10" maxlength="20">
                </div></td>
          </tr>
          <tr><td class='DataTD' width=141><p align=center style='text-align:center;
  '>
                <st1:address w:st="on">
                <st1:Street w:st="on">
                <b><span lang=EN-US style='font-size:8.0pt; font-family:Tahoma'>02SALE</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.83}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.84}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=47>
              <div align="right">
                <input name="eveingcount_voucher24" type="text" id="eveingcount_voucher28" value="##{$floatsvalue.85}#" size="10" maxlength="20">
                </div></td>
          </tr>
          <tr><td class='DataTD' width=141><p align=center style='text-align:center;
  '>
                <st1:address w:st="on">
                <st1:Street w:st="on">
                <b><span lang=EN-US style='font-size:8.0pt; font-family:Tahoma'>03SALE</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.86}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.87}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=47>
              <div align="right">
                <input name="eveingcount_voucher25" type="text" id="eveingcount_voucher29" value="##{$floatsvalue.88}#" size="10" maxlength="20">
                </div></td>
          </tr>
          <tr><td class='DataTD' width=141><p align=center style='text-align:center;
  '><strong><span class="style1">07STFF</span></strong></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.89}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.90}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=47>
              <div align="right">
                <input name="eveingcount_voucher26" type="text" id="eveingcount_voucher30" value="##{$floatsvalue.91}#" size="10" maxlength="20">
                </div></td>
          </tr>
          <tr><td class='DataTD' width=141><p align=center style='text-align:center;
  '><b><span lang=EN-US
  style='font-size:8.0pt;font-family:Tahoma'>08DEP</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.92}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.93}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=47>
              <div align="right">
                <input name="eveingcount_voucher27" type="text" id="eveingcount_voucher31" value="##{$floatsvalue.94}#" size="10" maxlength="20">
                </div></td>
          </tr>
          <tr><td class='DataTD' width=141><p align=center style='text-align:center;
  '><strong><span class="style1">Payouts</span></strong></p></td><td class='DataTD' width=95><b><span style="font-size:7.0pt;font-family:Tahoma">GROSS Total</span></b></td><td class='DataTD' width=95><strong><span class="style2">Overrings</span></strong></td><td class='DataTD' width=47><div align="right"><b><span style="font-size:7.0pt;font-family:Tahoma">Net Total</span></b></div></td>
          </tr>
          <tr><td class='DataTD' width=141><p align=center style='text-align:center;
  '>
                <st1:address w:st="on">
                <st1:Street w:st="on">
                <b><span lang=EN-US style='font-size:8.0pt; font-family:Tahoma'>04PAY (Cash)</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.95}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.96}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=47>
              <div align="right">
                <input name="eveingcount_voucher28" type="text" id="eveingcount_voucher32" value="##{$floatsvalue.97}#" size="10" maxlength="20">
                </div></td>
          </tr>
          <tr><td class='DataTD' width=141><p align=center style='text-align:center;
  '>
                <st1:address w:st="on">
                <st1:Street w:st="on">
                <b><span lang=EN-US style='font-size:8.0pt; font-family:Tahoma'>05PAY</span></b><b><span style="font-size:8.0pt; font-family:Tahoma"> (Cash)</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.98}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.99}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=47>
              <div align="right">
                <input name="eveingcount_voucher29" type="text" id="eveingcount_voucher33" value="##{$floatsvalue.100}#" size="10" maxlength="20">
                </div></td>
          </tr>
          <tr><td class='DataTD' width=141><p align=center style='text-align:center;
  '>
                <st1:address w:st="on">
                <st1:Street w:st="on">
                <b><span lang=EN-US style='font-size:8.0pt; font-family:Tahoma'>06PAY</span></b><b><span style="font-size:8.0pt; font-family:Tahoma"> (Cash)</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.101}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.102}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=47>
              <div align="right">
                <input name="eveingcount_voucher30" type="text" id="eveingcount_voucher34" value="##{$floatsvalue.103}#" size="10" maxlength="20">
                </div></td>
          </tr>
          <tr><td class='DataTD' width=141><p align=center style='text-align:center;
  '><b><span lang=EN-US
  style='font-size:8.0pt;font-family:Tahoma'>14PAY</span><span style="font-size:8.0pt; font-family:Tahoma"> (Voucher)</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.104}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.105}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=47>
              <div align="right">
                <input name="eveingcount_voucher31" type="text" id="eveingcount_voucher35" value="##{$floatsvalue.105}#" size="10" maxlength="20">
              </div></td>
          </tr>
          <tr><td class='DataTD' width=141><p align=center style='text-align:center;
  '><b><span lang=EN-US
  style='font-size:8.0pt;font-family:Tahoma'>15PAY</span><span style="font-size:8.0pt; font-family:Tahoma"> (Voucher)</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.106}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.107}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=47>
              <div align="right">
                <input name="eveingcount_voucher32" type="text" id="eveingcount_voucher36" value="##{$floatsvalue.108}#" size="10" maxlength="20">
                </div></td>
          </tr>
          <tr><td class='DataTD' width=141><p align=center style='text-align:center;
  '><b><span lang=EN-US
  style='font-size:8.0pt;font-family:Tahoma'>16PAY</span><span style="font-size:8.0pt; font-family:Tahoma"> (Voucher)</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.109}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.110}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=47>
              <div align="right">
                <input name="eveingcount_voucher33" type="text" id="eveingcount_voucher37" value="##{$floatsvalue.111}#" size="10" maxlength="20">
                </div></td>
          </tr>
          <tr><td class='DataTD' width=141><p align=center style='text-align:center;
  '><b><span lang=EN-US
  style='font-size:8.0pt;font-family:Tahoma'>Total Payputs</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.112}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.113}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=47>
              <div align="right">
                <input name="eveingcount_voucher34" type="text" id="eveingcount_voucher38" value="##{$floatsvalue.114}#" size="10" maxlength="20">
                </div></td>
          </tr>
          <tr><td class='DataTD' width=141><p align=center style='text-align:center;
  '><b><span lang=EN-US
  style='font-size:8.0pt;font-family:Tahoma'>Refunds</span></b></p></td><td class='DataTD' width=95><div align="center"><b><span style="font-size:7.0pt;font-family:Tahoma">RETN Total</span></b></div></td><td class='DataTD' width=95><div align="center"><strong><span class="style2">Overring</span></strong></div></td><td class='DataTD' width=47><div align="right"><b><span style="font-size:7.0pt;font-family:Tahoma">Net Total</span></b></div></td>
          </tr>
          <tr><td class='DataTD' width=141><p align=center style='text-align:center;
  '>
                <st1:address w:st="on">
                <st1:Street w:st="on">
                <b><span lang=EN-US style='font-size:8.0pt; font-family:Tahoma'>01SALE</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.115}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.116}#" size="10" maxlength="20">
            </div></td><td class='DataTD'>
              <div align="right">
                <input name="eveingcount_voucher35" type="text" id="eveingcount_voucher39" value="##{$floatsvalue.117}#" size="10" maxlength="20">
                </div></td>
          </tr>
          <tr><td class='DataTD' width=141><p align=center style='text-align:center;
  '>
                <st1:address w:st="on">
                <st1:Street w:st="on">
                <b><span lang=EN-US style='font-size:8.0pt; font-family:Tahoma'>02SALE</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.118}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.119}#" size="10" maxlength="20">
            </div></td><td class='DataTD'>
              <div align="right">
                <input name="eveingcount_voucher36" type="text" id="eveingcount_voucher40" value="##{$floatsvalue.120}#" size="10" maxlength="20">
                </div></td>
          </tr>
          <tr><td class='DataTD' width=141><p align=center style='text-align:center;
  '>
                <st1:address w:st="on">
                <st1:Street w:st="on">
                <b><span lang=EN-US style='font-size:8.0pt; font-family:Tahoma'>03SALE</span></b></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.121}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.122}#" size="10" maxlength="20">
            </div></td><td class='DataTD'>
              <div align="right">
                <input name="eveingcount_voucher37" type="text" id="eveingcount_voucher41" value="##{$floatsvalue.123}#" size="10" maxlength="20">
                </div></td>
          </tr>
          <tr><td class='DataTD' width=141><p align=center style='text-align:center;
  '><strong><span class="style1">07STFF</span></strong></p></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.124}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.125}#" size="10" maxlength="20">
            </div></td><td class='DataTD'>
              <div align="right">
                <input name="eveingcount_voucher38" type="text" id="eveingcount_voucher42" value="##{$floatsvalue.126}#" size="10" maxlength="20">
                </div></td>
          </tr>
          <tr><td class='DataTD'><div align="center"><b><span style="font-size:8.0pt;font-family:Tahoma">08DEP</span></b></div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.127}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
                <input name="eveingcount_voucher5" type="text" id="eveingcount_voucher6" value="##{$floatsvalue.128}#" size="10" maxlength="20">
            </div></td><td class='DataTD'>
              <div align="right">
                <input name="eveingcount_voucher39" type="text" id="eveingcount_voucher43" value="##{$floatsvalue.129}#" size="10" maxlength="20">
                </div></td>
          </tr>
          <tr><td class='DataTD'>&nbsp;</td><td class='DataTD'><div align="center"><b><span style="font-size:7.0pt;font-family:Tahoma">Total</span></b></div></td><td class='DataTD'><div align="center"><strong><span class="style2">Overring</span></strong></div></td><td class='DataTD'><div align="right"><b><span style="font-size:7.0pt;font-family:Tahoma">Net Tota</span></b>l</div></td>
          </tr>
          <tr><td class='DataTD' width=141 height="24"><div align="center"><strong><span class="style1">Expenses Paid Out</span></strong></div></td><td class='DataTD' width=95><div align="right">
              <input name="eveingcount_voucher40" type="text" id="eveingcount_voucher44" value="##{$floatsvalue.130}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=95><div align="right">
              <input name="eveingcount_voucher41" type="text" id="eveingcount_voucher45" value="##{$floatsvalue.131}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=47>
              <div align="right">
                <input name="eveingcount_voucher42" type="text" id="eveingcount_voucher46" value="##{$floatsvalue.132}#" size="10" maxlength="20">
                </div></td>
          </tr>
        </table></td><td class='DataTD' rowspan="2" valign="top">&nbsp;</td><td class='DataTD' valign="top"><table width=358 height="70" border=1 cellpadding=0 cellspacing=0>
          <tr><td class='DataTD' colspan="4"><p><b><span lang=EN-US style='font-size:11.0pt;font-family:Tahoma'>TRANSFERS</span></b></p></td>
          </tr>
          <tr><td class='DataTD' width=104><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:10.0pt;
  font-family:Tahoma'>FROM/TO</span></b></p></td><td class='DataTD' width=108><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:8.0pt;
  font-family:Tahoma'>C/V</span></b></p></td><td class='DataTD' width=244><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:8.0pt;
  font-family:Tahoma'>Amount In</span></b></p></td><td class='DataTD' width=104><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:7.0pt;
  font-family:Tahoma'>Amount Out</span></b></p></td>
          </tr>
          <tr><td class='DataTD' width=104><div align="right">
                <input name="eveingcount_voucher8" type="text" id="eveingcount_voucher12" value="##{$floatsvalue.8}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=108><div align="right">
                <input name="eveingcount_voucher8" type="text" id="eveingcount_voucher12" value="##{$floatsvalue.8}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=244><div align="right">
                <input name="eveingcount_voucher8" type="text" id="eveingcount_voucher12" value="##{$floatsvalue.8}#" size="10" maxlength="20">
            </div></td><td class='DataTD' width=104><div align="right">
                <input name="eveingcount_voucher8" type="text" id="eveingcount_voucher12" value="##{$floatsvalue.8}#" size="10" maxlength="20">
            </div></td>
          </tr>
        </table></td>
      </tr>
      <tr><td class='DataTD' valign="top"><table border=1 cellspacing=0 cellpadding=0 width=358>
          <tr><td class='DataTD' colspan="2"><p align=center style='text-align:center;'><b><span lang=EN-US style='font-size:14.0pt;
  font-family:Tahoma'>EXPENSES</span></b></p></td>
          </tr>
          <tr><td class='DataTD' width=184><b><span style="font-size:10.0pt;font-family:Tahoma">Expense</span></b></td><td class='DataTD' width=168><b><span style="font-size:10.0pt;font-family:Tahoma">Amount</span></b></td>
          </tr>
          <tr><td class='DataTD' width=184><p align=center style='text-align:center;'>&nbsp;</p></td><td class='DataTD' width=95><div align="right">
                <input name="banking_cash" type="text" id="eveingcount_voucher2" value="##{$floatsvalue.8}#" size="10" maxlength="20">
            </div></td>
          </tr>
        </table></td>
      </tr>
      <tr><td class='DataTD' valign="top">&nbsp;</td><td class='DataTD' valign="top">&nbsp;</td><td class='DataTD' valign="top">&nbsp;</td>
      </tr>
      <tr><td class='DataTD' valign="top">&nbsp;</td><td class='DataTD' valign="top">&nbsp;</td><td class='DataTD' valign="top">&nbsp;</td>
      </tr>
      <tr><td class='DataTD' valign="top">&nbsp;</td><td class='DataTD' valign="top">&nbsp;</td><td class='DataTD' valign="top">&nbsp;</td>
      </tr>
      </table>
  </div>
  <p align="center">&nbsp;</p>
  <div class=Section4>
    <div align="center">
      <table border=1 cellspacing=0 cellpadding=0 width=720>
        <tr><td class='DataTD' width=720><p style='text-align:center'><b><span lang=EN-US style='font-size:22.0pt;
  font-family:Tahoma'>REPORT SHEET</span></b></p></td>
        </tr>
        <tr><td class='DataTD' width=720><p><b><span lang=EN-US style='font-size:10.0pt;font-family:Tahoma'> Note clearly any unusual activity about
            today’s transactions here:</span></b></p></td>
        </tr>
        <tr><td class='DataTD' width=720><label>
            <textarea name="textarea" id="textarea" cols="60" rows="5"></textarea>
            </label>          </td>
        </tr>
        <tr><td class='DataTD' width=720><p><b><span lang=EN-US style='font-size:10.0pt;font-family:Tahoma'>NAME
            <select name="completedreport" id="completedreport">
              <option value="2">1</option>
              </select>
          </span></b></p></td>
        </tr>
        <tr><td class='DataTD' width=720><p><b><span lang=EN-US
  style='font-size:10.0pt;font-family:Tahoma'>If you need help completing this form call:                              020
            7229 4546</span></b></p></td>
        </tr>
        <tr><td class='DataTD' width=720><p><b><span lang=EN-US
  style='font-size:10.0pt;font-family:Tahoma'>Other enquiries call:                                                                                      020 7727 2040</span></b></p></td>
        </tr>
      </table>
    </div>
  </div>
</form>
<div class=Section4></div>
</body>
</html>
