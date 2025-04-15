<?php

class JWTHandler {

    private static function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function base64url_decode($data) {
        return base64_decode(strtr($data, '-_', '+/'));
    }

    public static function create(array $payload): string {
        $secret = $_ENV['SECRET_KEY_JWT'];

        $header = ['alg' => 'HS256', 'typ' => 'JWT'];
        $header_enc = self::base64url_encode(json_encode($header));
        $payload_enc = self::base64url_encode(json_encode($payload));

        $signature = hash_hmac('sha256', "$header_enc.$payload_enc", $secret, true);
        $signature_enc = self::base64url_encode($signature);

        return "$header_enc.$payload_enc.$signature_enc";
    }

    public static function verify(string $token): bool {
        $secret = $_ENV['SECRET_KEY_JWT'];
        [$header_enc, $payload_enc, $signature_enc] = explode('.', $token);

        $valid_signature = self::base64url_encode(
            hash_hmac('sha256', "$header_enc.$payload_enc", $secret, true)
        );

        return hash_equals($signature_enc, $valid_signature);
    }

    public static function decode(string $token): ?array {
        if (!self::verify($token)) return null;

        [$header_enc, $payload_enc] = explode('.', $token);
        $payload = json_decode(self::base64url_decode($payload_enc), true);

        if (isset($payload['exp']) && time() > $payload['exp']) {
            return null; // Token scaduto
        }

        return $payload;
    }
}
