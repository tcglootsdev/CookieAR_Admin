<?php

namespace App\Models;

use App\Helpers\Utils;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'tbl_users';

    protected $fillable = ['username', 'First_name', 'Last_name', 'email', 'phone', 'Address', 'Address_optional', 'City', 'Zipcode', 'State', 'password', 'code', 'act', 'datetime', 'type', 'businessname', 'websitelink', 'instagramtag', 'phonenumber', 'profileicon', 'subscribed', 'subscribe_date', 'subscribe_plan', 'billing_address', 'billing_Address_optional', 'billing_city', 'billing_state', 'billing_Zipcode', 'role'];

    public static function getAvailableFields($client, $role, $op)
    {
        $mapRolesToFields = [
            'web' => [
                'id' => [
                    'r' => ['admin'],
                ],
                'username' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],
                'First_name' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],
                'Last_name' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],
                'email' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],
                'phone' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],
                'Address' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],
                'Address_optional' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],
                'City' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],
                'Zipcode' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],
                'State' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],
                'code' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],
                'act' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],
                'datetime' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],
                'type' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],
                'businessname' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],
                'websitelink' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],
                'instagramtag' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],
                'phonenumber' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],
                'profileicon' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],
                'subscribed' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],
                'subscribe_date' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],
                'subscribe_plan' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],
                'billing_address' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],
                'billing_Address_optional' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],
                'billing_city' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],
                'billing_state' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],
                'billing_Zipcode' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],
                'role' => [
                    'c' => ['admin'],
                    'r' => ['admin'],
                    'u' => ['admin'],
                ],

            ]
        ];
        return Utils::getAvailableFields($mapRolesToFields, $client, $role, $op);
    }
}
