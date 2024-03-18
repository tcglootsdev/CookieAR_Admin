<?php

namespace App\Models;

use App\Helpers\Utils;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'tbl_trans';

    protected $fillable = ['user_id', 'packages', 'labels', 'ship_data', 'price', 'ship_fee', 'order_images'];

    public static function getAvailableFields($client, $role, $op)
    {
        $mapRolesToFields = [
            'web' => [
                'id' => [
                    'r' => ['admin'],
                ],
                'user_id' => [
                    'r' => ['admin'],
                ],
                'packages' => [
                    'r' => ['admin'],
                ],
                'labels' => [
                    'r' => ['admin'],
                ],
                'ship_data' => [
                    'r' => ['admin'],
                ],
                'price' => [
                    'r' => ['admin'],
                ],
                'ship_fee' => [
                    'r' => ['admin'],
                ],
                'order_images' => [
                    'r' => ['admin'],
                ],
                'created_at' => [
                    'r' => ['admin'],
                ],
            ]
        ];
        return Utils::getAvailableFields($mapRolesToFields, $client, $role, $op);
    }
}
