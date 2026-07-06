<?php
require_once __DIR__ . '/../includes/lead-form-handler.php';

$sslVerify = env('SSL_VERIFY', 'true') === 'true';
$sslOpts   = [
    CURLOPT_SSL_VERIFYPEER => $sslVerify,
    CURLOPT_SSL_VERIFYHOST => $sslVerify ? 2 : 0,
];

// reCAPTCHA v3 — skipped in dev when SSL_VERIFY=false, same as before.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recaptchaResponse = $_POST['recaptcha_response'] ?? '';

    if (!$sslVerify) {
        error_log('3bhkinnoida [recaptcha] skipped in dev mode');
    } else {
        $recaptchaFailed = empty($recaptchaResponse);

        if (!$recaptchaFailed) {
            $rch = curl_init('https://www.google.com/recaptcha/api/siteverify');
            curl_setopt_array($rch, $sslOpts + [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => http_build_query([
                    'secret'   => '6Lf-j8kqAAAAAMOzDUGjGA-e1ydJKU6jjKeNyJqq',
                    'response' => $recaptchaResponse,
                    'remoteip' => $_SERVER['REMOTE_ADDR'] ?? '',
                ]),
                CURLOPT_HTTPHEADER     => ['Content-Type: application/x-www-form-urlencoded'],
                CURLOPT_TIMEOUT        => 10,
                CURLOPT_CONNECTTIMEOUT => 5,
            ]);

            $recaptchaResult = curl_exec($rch);
            $recaptchaError  = $recaptchaResult === false ? curl_error($rch) : null;

            if ($recaptchaError !== null) {
                error_log("3bhkinnoida [recaptcha] curl error: $recaptchaError");
                $recaptchaFailed = true;
            } else {
                $recaptchaData = json_decode($recaptchaResult, true);
                error_log('3bhkinnoida [recaptcha] response: ' . $recaptchaResult);
                $recaptchaFailed = empty($recaptchaData['success']) || ($recaptchaData['score'] ?? 0) < 0.5;
            }
        }

        if ($recaptchaFailed) {
            lead_form_finish(false, 'Security verification failed. Please try again.', 'index.php', 422);
        }
    }
}

handleLeadForm([
    'project'      => '3BHK in Noida',
    'city'         => 'Noida',
    'website'      => 'https://3bhkinnoida.in/',
    'redirect'     => 'thankyou.php',
    'phonePattern' => '/^(\d{10}|91\d{9})$/',
    'phoneError'   => 'Please enter a valid 10 digit phone number',
    'extraPayload' => ['project' => '3BHK in Noida'],
    'message'      => 'Thank you for your interest! Our executive will connect with you shortly.',
]);
