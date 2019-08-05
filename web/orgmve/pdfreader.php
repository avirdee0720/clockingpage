<?php

echo 'Current PHP version: ' . phpversion();
// create first file
echo "sss";
$filepdf = pdf_new(); 
echo "fff";
pdf_open_file($filepdf, "firstfile.pdf");
pdf_begin_page($filepdf, 500, 700);

// create shape in first file
pdf_moveto($filepdf, 125, 175);
pdf_lineto($filepdf, 375, 175);
pdf_lineto($filepdf, 375, 525);
pdf_lineto($filepdf, 125, 525);
pdf_closepath_stroke($filepdf);

pdf_end_page($filepdf);
pdf_close($filepdf);
// end of first file

// open second file
$pdf = pdf_new();
pdf_open_file($pdf);

// open open first file and read values
$pdi = pdf_open_pdi($pdf, "firstfile.pdf", "", 0);
$page= pdf_open_pdi_page($pdf, $pdi, 1, "");
$width = pdf_get_pdi_value($pdf, "width", $pdi, $page, 0);
$height = pdf_get_pdi_value($pdf, "height", $pdi, $page, 0);

pdf_begin_page($pdf, $width, $height);

// place page from first file into second file
pdf_place_pdi_page($pdf, $page, 0.0, 0.0, 1.0, 1.0);

// now add some text
$font = pdf_findfont($pdf, "Courier", "host", 0);
pdf_setfont($pdf, $font, 20);
pdf_show_xy($pdf, "Second page", 200, 350);

pdf_close_pdi_page($pdf, $page);

pdf_end_page($pdf);
pdf_close($pdf);

// output complete document
$data = pdf_get_buffer($pdf);
header("Content-type: application/pdf");
header("Content-disposition: inline; filename=test.pdf");
header("Content-length: " . strlen($data));
echo $data;

?>
