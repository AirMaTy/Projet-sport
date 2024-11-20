<?php
$motDePasse = 'mdpcoach';
$hash = password_hash($motDePasse, PASSWORD_DEFAULT);

echo "Hash généré : " . $hash;
?>
