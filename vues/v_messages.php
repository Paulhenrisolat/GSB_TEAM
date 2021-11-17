<?php

?>
<div class="alert alert-info" role="alert">
    <?php
    foreach ($_REQUEST['messages'] as $message) {
        echo '<p>' . htmlspecialchars($message) . '</p>';
    }
    ?>
</div>