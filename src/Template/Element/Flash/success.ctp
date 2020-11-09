<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="message success  alert alert-success alert-dismissable mt10 w98 " onclick="this.classList.add('hidden')"><?= $message ?></div>
