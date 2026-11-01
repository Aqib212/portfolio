<?php
// Contact form handler. assets/vendor/php-email-form/validate.js posts here
// and shows "sent" only when the response body is exactly "OK".
// Sending needs a working mail setup on the server (php.ini sendmail/SMTP;
// in Laragon: Menu > Preferences > Mail Sender).

$to = 'aqibzahiruddin@gmail.com';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit('Method not allowed.');
}

// Strip CR/LF from anything that ends up in a mail header (header injection).
function field(string $key, int $max): string {
  $value = trim((string) ($_POST[$key] ?? ''));
  return mb_substr($value, 0, $max);
}

$name    = str_replace(["\r", "\n"], ' ', field('name', 100));
$email   = field('email', 254);
$subject = str_replace(["\r", "\n"], ' ', field('subject', 150));
$message = field('message', 5000);

if ($name === '' || $subject === '' || $message === '') {
  exit('Please fill in every field.');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  exit('Please enter a valid email address.');
}

$body = "Name: $name\nEmail: $email\n\n$message\n";
$headers = implode("\r\n", [
  "From: Portfolio Contact <$to>",
  "Reply-To: $email",
  'Content-Type: text/plain; charset=UTF-8',
]);

echo mail($to, "[Portfolio] $subject", $body, $headers)
  ? 'OK'
  : 'Sorry, the message could not be sent. Please email aqibzahiruddin@gmail.com directly.';
