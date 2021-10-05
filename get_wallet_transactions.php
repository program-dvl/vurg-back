<?php
$accountId = '';
$url = "https://app.bitgo.com/api/portfolio/v1/portfolios/{$accountId}/transactions";
$balance = file_get_contents($url);
echo ($balance);
?>