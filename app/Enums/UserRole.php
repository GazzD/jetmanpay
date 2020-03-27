<?php

namespace App\Enums;


abstract class UserRole extends Enums
{
    const CLIENT = 'CLIENT';
    const OPERATOR = 'OPERATOR';
    const MANAGER = 'MANAGER';
    const STAFF = 'STAFF';
    const REVIEWER = 'REVIEWER';
    
    public static function values() {
        return array(
            'CLIENT'    => UserRole::CLIENT,
            'OPERATOR'  => UserRole::OPERATOR,
            'MANAGER'   => UserRole::MANAGER,
            'STAFF'     => UserRole::STAFF,
            'REVIEWER'  => UserRole::REVIEWER
        );
    }
    
    public static function getFriendlyName($enum) {
        return __('messages.'.strtolower($enum));
    }
}