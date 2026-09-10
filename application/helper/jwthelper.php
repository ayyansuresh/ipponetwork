<?php

class jwthelper {

    /**
     * Leeway in seconds to account for clock skew between server and client
     * @var int
     */
    public static $leeway = 60;

    /**
     * Supported HMAC algorithms
     * @var array
     */
    public static $supportedAlgs = array(
        'HS256' => 'SHA256',
        'HS384' => 'SHA384',
        'HS512' => 'SHA512'
    );

    /**
     * Get default secret key configured in config or fallback
     * @return string
     */
    public static function getSecretKey() {
        if (defined('JWT_SECRET_KEY') && JWT_SECRET_KEY !== '') {
            return JWT_SECRET_KEY;
        }
        return 'ipponetwork_jwt_secret_key_2026';
    }

    /**
     * Encode payload into a signed JSON Web Token (JWT)
     *
     * @param array $payload
     * @param string|null $key
     * @param string $alg
     * @param array $headers
     * @return string
     */
    public static function encode($payload, $key = null, $alg = 'HS256', $headers = array()) {
        if ($key === null || $key === '') {
            $key = self::getSecretKey();
        }

        if (!isset(self::$supportedAlgs[$alg])) {
            throw new Exception('Unsupported algorithm ' . $alg);
        }

        $headerArr = array_merge(array('typ' => 'JWT', 'alg' => $alg), $headers);

        $headerJson = json_encode($headerArr);
        $payloadJson = json_encode($payload);

        $headerEncoded = self::base64UrlEncode($headerJson);
        $payloadEncoded = self::base64UrlEncode($payloadJson);

        $signingInput = $headerEncoded . '.' . $payloadEncoded;
        $hashAlg = self::$supportedAlgs[$alg];
        $signature = hash_hmac($hashAlg, $signingInput, $key, true);
        $signatureEncoded = self::base64UrlEncode($signature);

        return $signingInput . '.' . $signatureEncoded;
    }

    /**
     * Decode and verify a JSON Web Token (JWT)
     *
     * @param string $jwt
     * @param string|null $key
     * @param bool $verify
     * @param array $allowedAlgs
     * @return array Decoded payload array
     * @throws Exception
     */
    public static function decode($jwt, $key = null, $verify = true, $allowedAlgs = array('HS256', 'HS384', 'HS512')) {
        if (empty($jwt) || !is_string($jwt)) {
            throw new Exception('JWT token cannot be empty');
        }

        $tokenParts = explode('.', trim($jwt));
        if (count($tokenParts) !== 3) {
            throw new Exception('Wrong number of segments in JWT token');
        }

        list($headB64, $bodyB64, $sigB64) = $tokenParts;

        $headerDecoded = self::base64UrlDecode($headB64);
        if ($headerDecoded === false) {
            throw new Exception('Invalid header encoding in JWT token');
        }

        $header = json_decode($headerDecoded, true);
        if ($header === null || !is_array($header)) {
            throw new Exception('Invalid header structure in JWT token');
        }

        $payloadDecoded = self::base64UrlDecode($bodyB64);
        if ($payloadDecoded === false) {
            throw new Exception('Invalid payload encoding in JWT token');
        }

        $payload = json_decode($payloadDecoded, true);
        if ($payload === null || !is_array($payload)) {
            throw new Exception('Invalid payload structure in JWT token');
        }

        if ($verify) {
            if ($key === null || $key === '') {
                $key = self::getSecretKey();
            }

            if (empty($header['alg'])) {
                throw new Exception('Empty algorithm in JWT header');
            }

            $alg = $header['alg'];
            if (!in_array($alg, $allowedAlgs) || !isset(self::$supportedAlgs[$alg])) {
                throw new Exception('Algorithm ' . $alg . ' not allowed or unsupported');
            }

            $sig = self::base64UrlDecode($sigB64);
            $hashAlg = self::$supportedAlgs[$alg];
            $expectedSig = hash_hmac($hashAlg, $headB64 . '.' . $bodyB64, $key, true);

            if (!self::constantTimeCompare($sig, $expectedSig)) {
                throw new Exception('Signature verification failed: Invalid JWT signature');
            }

            $currentTime = time();

            // Check not before (nbf) claim
            if (isset($payload['nbf']) && ($payload['nbf'] > ($currentTime + self::$leeway))) {
                throw new Exception('Cannot handle token prior to ' . date('Y-m-d H:i:s', $payload['nbf']));
            }

            // Check issued at (iat) claim
            if (isset($payload['iat']) && ($payload['iat'] > ($currentTime + self::$leeway))) {
                throw new Exception('Cannot handle token with future issue date ' . date('Y-m-d H:i:s', $payload['iat']));
            }

            // Check expiration (exp) claim
            if (isset($payload['exp']) && (($currentTime - self::$leeway) >= $payload['exp'])) {
                throw new Exception('Token has expired on ' . date('Y-m-d H:i:s', $payload['exp']));
            }
        }

        return $payload;
    }

    /**
     * Extract JWT token from incoming HTTP request (headers, body payload, or query string)
     *
     * @param array $data Request JSON/POST data
     * @return string Extracted token string, or empty string if not found
     */
    public static function extractTokenFromRequest($data = array()) {
        $token = '';

        // 1. Check Authorization Header (standard Bearer token)
        $authHeader = '';
        if (!empty($_SERVER['HTTP_AUTHORIZATION'])) {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
        } else if (!empty($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
            $authHeader = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        } else if (!empty($_SERVER['AUTHORIZATION'])) {
            $authHeader = $_SERVER['AUTHORIZATION'];
        } else if (function_exists('getallheaders')) {
            $headers = getallheaders();
            if (!empty($headers['Authorization'])) {
                $authHeader = $headers['Authorization'];
            } else if (!empty($headers['authorization'])) {
                $authHeader = $headers['authorization'];
            } else if (!empty($headers['jwttoken'])) {
                $token = $headers['jwttoken'];
            } else if (!empty($headers['jwt-token'])) {
                $token = $headers['jwt-token'];
            }
        } else if (function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
            if (!empty($headers['Authorization'])) {
                $authHeader = $headers['Authorization'];
            } else if (!empty($headers['authorization'])) {
                $authHeader = $headers['authorization'];
            } else if (!empty($headers['jwttoken'])) {
                $token = $headers['jwttoken'];
            }
        }

        if (!empty($authHeader)) {
            if (preg_match('/Bearer\s+(\S+)/i', $authHeader, $matches)) {
                $token = $matches[1];
            } else {
                $token = trim($authHeader);
            }
        }

        // 2. Check Custom Server Header $_SERVER['HTTP_JWTTOKEN'] or $_SERVER['HTTP_TOKEN']
        if (empty($token)) {
            if (!empty($_SERVER['HTTP_JWTTOKEN'])) {
                $token = trim($_SERVER['HTTP_JWTTOKEN']);
            } else if (!empty($_SERVER['HTTP_X_JWT_TOKEN'])) {
                $token = trim($_SERVER['HTTP_X_JWT_TOKEN']);
            } else if (!empty($_SERVER['HTTP_TOKEN'])) {
                $token = trim($_SERVER['HTTP_TOKEN']);
            }
        }

        // 3. Check JSON / POST Data payload
        if (empty($token) && !empty($data) && is_array($data)) {
            if (!empty($data['jwttoken'])) {
                $token = trim($data['jwttoken']);
            } else if (!empty($data['jwt_token'])) {
                $token = trim($data['jwt_token']);
            } else if (!empty($data['token'])) {
                $token = trim($data['token']);
            } else if (!empty($data['jwt'])) {
                $token = trim($data['jwt']);
            }
        }

        // 4. Check $_POST parameters
        if (empty($token) && !empty($_POST)) {
            if (!empty($_POST['jwttoken'])) {
                $token = trim($_POST['jwttoken']);
            } else if (!empty($_POST['token'])) {
                $token = trim($_POST['token']);
            } else if (!empty($_POST['jwt'])) {
                $token = trim($_POST['jwt']);
            }
        }

        // 5. Check $_GET query string
        if (empty($token) && !empty($_GET)) {
            if (!empty($_GET['jwttoken'])) {
                $token = trim($_GET['jwttoken']);
            } else if (!empty($_GET['token'])) {
                $token = trim($_GET['token']);
            } else if (!empty($_GET['jwt'])) {
                $token = trim($_GET['jwt']);
            }
        }

        return trim($token);
    }

    /**
     * Verify JWT token from incoming request
     *
     * @param array $data Request payload
     * @param string|null $key
     * @return array array('success' => bool, 'message' => string, 'payload' => array, 'token' => string)
     */
    public static function verifyRequestToken($data = array(), $key = null) {
        $token = self::extractTokenFromRequest($data);

        if (empty($token)) {
            return array(
                'success' => false,
                'message' => 'JWT token is missing. Please provide it in the Authorization header (Bearer <token>), or as jwttoken parameter.',
                'error_code' => 'TOKEN_MISSING'
            );
        }

        try {
            $payload = self::decode($token, $key, true);
            return array(
                'success' => true,
                'message' => 'JWT token verified successfully',
                'payload' => $payload,
                'token' => $token
            );
        } catch (Exception $ex) {
            return array(
                'success' => false,
                'message' => $ex->getMessage(),
                'error_code' => 'TOKEN_INVALID',
                'token' => $token
            );
        }
    }

    /**
     * Generate a sample JWT token for testing/clients
     *
     * @param array $customClaims
     * @param int $expirySeconds (default: 86400 = 24 hours)
     * @param string|null $key
     * @return string
     */
    public static function generateSampleToken($customClaims = array(), $expirySeconds = 86400, $key = null) {
        $now = time();
        $payload = array_merge(array(
            'iss' => 'ipponetwork-api',
            'iat' => $now,
            'nbf' => $now,
            'exp' => $now + $expirySeconds,
            'user' => 'ippo_api_client'
        ), $customClaims);

        return self::encode($payload, $key);
    }

    /**
     * Base64URL encoding according to RFC 7515
     * @param string $data
     * @return string
     */
    public static function base64UrlEncode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * Base64URL decoding according to RFC 7515
     * @param string $data
     * @return string|bool
     */
    public static function base64UrlDecode($data) {
        $remainder = strlen($data) % 4;
        if ($remainder) {
            $padlen = 4 - $remainder;
            $data .= str_repeat('=', $padlen);
        }
        return base64_decode(strtr($data, '-_', '+/'));
    }

    /**
     * Constant time string comparison to prevent timing attacks in PHP 5.3+
     *
     * @param string $a
     * @param string $b
     * @return bool
     */
    public static function constantTimeCompare($a, $b) {
        if (function_exists('hash_equals')) {
            return hash_equals($a, $b);
        }
        if (!is_string($a) || !is_string($b)) {
            return false;
        }
        $len = strlen($a);
        if ($len !== strlen($b)) {
            return false;
        }
        $status = 0;
        for ($i = 0; $i < $len; $i++) {
            $status |= (ord($a[$i]) ^ ord($b[$i]));
        }
        return $status === 0;
    }
}
