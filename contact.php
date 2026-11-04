<?php
header('Content-Type: application/json; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { echo json_encode(['ok'=>false]); exit; }
$clean = function($v){ return trim(str_replace(["\r","\n"], ' ', (string)$v)); };
$name = $clean($_POST['n'] ?? '');
$email = $clean($_POST['e'] ?? '');
$company = $clean($_POST['c'] ?? '');
$message = trim((string)($_POST['m'] ?? ''));
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $message === '') { echo json_encode(['ok'=>false]); exit; }
$to = 'info@brandstudios.net';
$subject = 'Message from brandstudios.net' . ($name !== '' ? ' - ' . $name : '');
$body = "Name: $name\nEmail: $email\nCompany: $company\n\n$message\n";
$headers = "From: Brand Studios <info@brandstudios.net>\r\nReply-To: $email\r\nContent-Type: text/plain; charset=utf-8\r\n";
$ok = mail($to, $subject, $body, $headers);
echo json_encode(['ok'=>$ok]);
