<?php
$url = 'https://graph.facebook.com/v16.0/107259175718091/messages';
$accessToken = 'EAAOrQjFhD0UBINGZAikD4W1VLNmZCN5SLzNJK3jev5UCkKeE0UPcK7zDjB8Kkg4kSctY1XnbrljdUSNOqPiewUmTZBwkTKPYS2GFC1WTRVBQST7nQYqFp9V4pFpEMSkmZArNFZAniiDptmgvmYUEwlrTioCO42uBjuXtTckKqXzhqXCQeePvCDISmmmI2KXYwZDZD';

$data = [
    'messaging_product' => 'whatsapp',
    'to' => '966580058804',
    'type' => 'template',
    'template' => [
        'name' => 'hellow_word',
        'language' => [
            'code' => 'ar'
        ]
    ]
];

// $data = [
//     'messaging_product' => 'whatsapp',
//     'to' => '966580058804',
//     'type' => 'template',
//     'template' => [
//         'name' => 'hellow_word',
//         'language' => [
//             'code' => 'ar'
//         ]
//     ]
// ];
// $data = [
//     'messaging_product' => 'whatsapp',
//     'phone' => '966580058804', // Receivers phone
//     'template' => 'hellow_word', // Template name
//      // Namespace of template
//     'language' =>  ['code' => 'ar', 'policy' => 'deterministic'], // Language parameters
// ];

$headers = [
    'Authorization: Bearer ' . $accessToken,
    'Content-Type: application/json'
];

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($curl);
curl_close($curl);

echo $response;
?>
