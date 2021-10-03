<?php
$accountId = '';
$walletID = '';
$url = "https://app.bitgo.com/api/v2/{coin}/wallet/{$walletId}/address/{$accountId}";
$balance = file_get_contents($url);
echo ($balance);
?>