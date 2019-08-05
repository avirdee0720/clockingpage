<html>
<head>
<script type="text/javascript">
function submitform()
{
    document.forms["myform"].submit();
}
</script>
</head>

<body>
    
<?php
if (!isset($_POST['deletememo']))
    $deletememo = "NONE";
else $deletememo = $_POST['deletememo'];

$clno=$_POST['clno'];
$state=$_POST['state'];
echo "CLNO:$clno<br>";
echo "STATE:$state<br>";

echo "deletememo is:<br>";
var_dump($deletememo);

?>

<form id="myform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
Search: <input type='text' name='deletememo'>
</form>
Not in form:
<a href="javascript: submitform()">Submit</a>

</body>
</html>



