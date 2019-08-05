<html>
<head>
</head>
<body>
<h1>Sending the file...</h1>
<?php

 if ($_FILES['plikuzytkownika']['error'] > 0)
  {
    echo 'Problem: ';
    switch ($_FILES['plikuzytkownika']['error'])
    {
      case 1: echo 'Size of the file is biger than value of upload_max_filesize'; break;
      case 2: echo 'Size of the file  is biger than value of max_file_size'; break;
      case 3: echo 'File sent only partly'; break;
      case 4: echo 'No file has been sent'; break;
    }
    exit;
  }

// czy plik ma prawid³owy typ MIME?

  if ($_FILES['plikuzytkownika']['type'] != 'application/vnd.ms-excel')
  {
    echo 'ERROR: not MS Excel CSV file';
    exit;
  }

// umieszczenie pliku w po¿¹danej lokalizacji
  $lokalizacja = '/home2/www/html/orgmve/images/'.$_FILES['plikuzytkownika']['name'];

  if (is_uploaded_file($_FILES['plikuzytkownika']['tmp_name'])) 
  {
     if (!move_uploaded_file($_FILES['plikuzytkownika']['tmp_name'], $lokalizacja))
     {
        echo 'ERROR: Can not copy the file';
        exit;
     }
  } 
  else 
  {
    echo 'ERROR: Posible attack while sending the file: ';
    echo $_FILES['plikuzytkownika']['name'];
    exit;
  }

  echo 'File sent<br><br>'; 

// ponowne sformatowanie zawartoœci pliku
  $wp = fopen($lokalizacja, 'r');
  $zawartosc = fread ($wp, filesize ($lokalizacja));
  fclose ($wp);
 
  $zawartosc = strip_tags($zawartosc);
  $wp = fopen($lokalizacja, 'w');
  fwrite($wp, $zawartosc);
  fclose($wp);
// pokazanie, co zosta³o wys³ane
  echo 'File contents:<br><hr>';
  echo $zawartosc;
  echo '<br><hr>';

?>
</body>
</html>