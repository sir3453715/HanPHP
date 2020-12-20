<?php
class Password {
    const HASH = PASSWORD_DEFAULT;
    // const COST = 14;
    const COST = 14;
    public static function hash($password) {
        return password_hash($password, self::HASH, ['cost' => self::COST]);
    }
 
    public static function verify($password,$hash) {
        if(password_verify($password, $hash)){
            return true;
        }else{
            return false;
        }
    }
    public static function rehash($password) {
        $hash = password_hash($password, self::HASH, ['cost' => self::COST]);
        if (password_needs_rehash($hash, self::HASH, ['cost' => self::COST])) {
            // If so, create a new hash, and replace the old one
            return true;
        }else{
            return false;
        }
    }
}