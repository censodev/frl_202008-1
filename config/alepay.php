<?php

return [
    'URL_DEMO'          => env('APP_URL'). '/alepay-installment/',
    'URL_CALLBACK'      => env('APP_URL'). '/cart_success',
    'config' => [
        "apiKey"        => "vjI7pWOnD4AI6yOBqthv4b2HzqetNs", //Là key dùng để xác định tài khoản nào đang được sử dụng.
        "encryptKey"    => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCGZ4G8WiBCtVjP0GTJWbjBP6jsz5fN/9muuN4PGJ8JiDbhD86GeyoNWWiEpy+3mE+Tmt6kD+dg1sASKfaILZaSGsEA71cA8XqmzOx3PLHQlSYFXTzT7zjpYLiuNdnQ3k/4ayr8L9arTKR1TBNDNPC1apQDyelWgStAA8TGH+UGwwIDAQAB", //Là key dùng để mã hóa dữ liệu truyền tới Alepay.
        "checksumKey"   => "xOBZPGRnd88v8TkLYQH05nSoNIg8or", //Là key dùng để tạo checksum data.
        "callbackUrl"   => env('APP_URL').'/cart_success',
        "env"           => "test"
    ]
];

?>
