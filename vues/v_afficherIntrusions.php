<?php
foreach($lesIntrusions as $intrusion) {
        echo $intrusion['horodatage'];
        ?><br><?php
        echo $intrusion['login'];
        echo $intrusion['pays'];
        echo $intrusion['navigateur'];
        echo $intrusion['os'];
}
