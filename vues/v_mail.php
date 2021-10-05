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