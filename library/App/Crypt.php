<?php
/**
 * Mourad MANSOUR
 *
 * @category App
 * @package App_Crypt
 * @version $Id$
 *         
 * @since 2014 July
 */

/**
 *
 * @category App
 * @package App_Crypt
 */
class App_Crypt
{
    /**
     * Encrypt a value using AES-256.
     *
     * *Caveat* You cannot properly encrypt/decrypt data with trailing null bytes.
     * Any trailing null bytes will be removed on decryption due to how PHP pads messages
     * with nulls prior to encryption.
     *
     * @param     string     $plain The value to encrypt.
     * @param     string     $key The 256 bit/32 byte key to use as a cipher key.
     * @param     string     $hmacSalt The salt to use for the HMAC process. Leave null to use Security.salt.
     * 
     * @return    string     Encrypted data.
     * 
     * @throws    Zend_Exception 
     */
    public static function encrypt($plain, $key = null, $hmacSalt = null)
    {
        if ($key === null) {
            $key = App_Application::getInstance()->getSecurityKey();
        }
        
        if ($hmacSalt === null) {
            $hmacSalt = App_Application::getInstance()->getSecuritySalt();
        }
        
        self::_checkKey($key, 'encrypt()');
        
        // Generate the encryption and hmac key.
        $key = substr(hash('sha256', $key . $hmacSalt), 0, 32);
        
        $algorithm = MCRYPT_RIJNDAEL_128;
        $mode = MCRYPT_MODE_CBC;
        
        $ivSize = mcrypt_get_iv_size($algorithm, $mode);
        $iv = mcrypt_create_iv($ivSize, MCRYPT_DEV_URANDOM);
        $ciphertext = $iv . mcrypt_encrypt($algorithm, $key, $plain, $mode, $iv);
        $hmac = hash_hmac('sha256', $ciphertext, $key);
        
        return urlencode(base64_encode($hmac . $ciphertext));
    }

    /**
     * Check the encryption key for proper length.
     *
     * @param     string     $key Key to check.
     * @param     string     $method The method the key is being checked for.
     * @return    void
     * @throws    Zend_Exception When key length is not 256 bit/32 bytes
     */
    protected static function _checkKey($key, $method)
    {
        if (strlen($key) < 32) {
            throw new Zend_Exception(' key must be at least 256 bits (32 bytes) long.');
        }
    }

    /**
     * Decrypt a value using AES-256.
     *
     * @param     string $cipher The ciphertext to decrypt.
     * @param     string $key The 256 bit/32 byte key to use as a cipher key.
     * @param     string $hmacSalt The salt to use for the HMAC process. Leave null to use Security.salt.
     * 
     * @return    string Decrypted data. Any trailing null bytes will be removed.
     * 
     * @throws    Zend_Exception
     */
    public static function decrypt($cipher, $key = null, $hmacSalt = null)
    {
        if ($key === null) {
            $key = App_Application::getInstance()->getSecurityKey();
        }
        
        if ($hmacSalt === null) {
            $hmacSalt = App_Application::getInstance()->getSecuritySalt();
        }
        
        $cipher = base64_decode(urldecode($cipher));
        
        self::_checkKey($key, 'decrypt()');
                
        // Generate the encryption and hmac key.
        $key = substr(hash('sha256', $key . $hmacSalt), 0, 32);
        
        // Split out hmac for comparison
        $macSize = 64;
        $hmac = substr($cipher, 0, $macSize);
        $cipher = substr($cipher, $macSize);
        
        $compareHmac = hash_hmac('sha256', $cipher, $key);
        if ($hmac !== $compareHmac) {
            return false;
        }
        
        $algorithm = MCRYPT_RIJNDAEL_128;
        $mode = MCRYPT_MODE_CBC;
        $ivSize = mcrypt_get_iv_size($algorithm, $mode);
        
        $iv = substr($cipher, 0, $ivSize);
        $cipher = substr($cipher, $ivSize);
        
        $plain = mcrypt_decrypt($algorithm, $key, $cipher, $mode, $iv);
        return rtrim($plain, "\0");
    }
}
