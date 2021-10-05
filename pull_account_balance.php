<?php
$accountId = '';
$url = "https://app.bitgo.com/api/prime/trading/v1/accounts/{$accountId}/balances";
$balance = file_get_contents($url);
echo ($balance);
?>