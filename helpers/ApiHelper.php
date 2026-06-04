<?php
/**
 * API Helper - Utility functions for API responses
 */

class ApiHelper {
    
    /**
     * Vráti JSON odpoveď s údajmi
     */
    public static function success($data, $message = 'OK', $code = 200) {
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode([
            'success' => true,
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
        exit;
    }
    
    /**
     * Vráti JSON chybovú odpoveď
     */
    public static function error($message, $code = 400, $data = null) {
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode([
            'success' => false,
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
        exit;
    }
    
    /**
     * Validuj vstup
     */
    public static function validate($data, $rules) {
        $errors = [];
        
        foreach ($rules as $field => $rule) {
            if (!isset($data[$field]) && strpos($rule, 'required') !== false) {
                $errors[$field] = "Pole $field je povinné";
            }
        }
        
        return count($errors) > 0 ? $errors : true;
    }
    
    /**
     * Sanitizuj vstup
     */
    public static function sanitize($data) {
        if (is_array($data)) {
            return array_map([self::class, 'sanitize'], $data);
        }
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
}
?>
