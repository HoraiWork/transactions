<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
    <meta name="generator" content="PSPad editor, www.pspad.com">
    <title></title>
</head>
<body>

<?php
$salt="66475b8a-bdef-4a48-880d-55348a93c8fd";
$data=array('ORDERID=3','AMOUNT=1500','PSPID=transdep','CURRENCY=EUR','LANGUAGE=en_US', 'EXCLPMLIST=MasterCard;visa');
$url="https://secure.ogone.com/ncol/prod/orderstandard_utf8.asp?".implode("&",$data);
sort($data, SORT_NATURAL | SORT_FLAG_CASE);
$string=implode($salt,$data);
$string.=$salt;
print_r($string);
echo "<br>";
$sha = hash('sha1',$string);
$url.='&SHASIGN='.$sha;
print_r($url);
echo "<br>";
print_r('   <a href="'.$url.'"  target="_blank" />here</a>');
?>



<form method="get" action="https://secure.ogone.com/ncol/prod/orderstandard_utf8.asp" id=form1 name=form1>


    <!-- general parameters: see Form parameters -->

    <input type="hidden" name="PSPID" value="transdep">

    <input type="hidden" name="ORDERID" value="3">

    <input type="hidden" name="AMOUNT" value="1500">

    <input type="hidden" name="CURRENCY" value="EUR">

    <input type="hidden" name="LANGUAGE" value="en_US">
    <input type="hidden" name="EXCLPMLIST" value="MasterCard;vasa">


    <input type="hidden" name="SHASIGN" value="<?php echo $sha; ?>">


    <input type="submit" value="" id=submit2 name=submit2>



</form>


</body>
</html>