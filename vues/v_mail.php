<?php

//destinataire
$to = "Papercut@papercut.com";

//sujet
$subject = "TestEnvoiMail";

//msg
$message = "Yeet Yeet\r Yeeeet";

//entete
$headers =array('From'=> 'GSB@gmail.com');

mail($to,$subject,$message, $headers);

?>

<h2>Nous Contactez :</h2>
<h3>-- Mail --</h3>
<form action="testmail.php" method="post">
    <a>Adresse Mail</a>
    <p><input type="text" maxlength="255" id="addmail"/></p>
    <a>Sujet</a>
    <p><input type="text" maxlength="255" id="sub"/></p>
    <a>Message</a>
    <p><input type="text" maxlength="255" id="msg"/></p>    
    <p><input type="submit" Value="Ok"></p>
</form>