<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        parent::__construct(
            model: User::class,
        );
    }

    protected function beforeGet(): array
    {
        $user = Auth::user();

        $conditions = [];

        if ($user->role === 'admin') {
            $conditions[] = ['role', '!=', 'admin'];
        }

        return $conditions;
    }

    public function getPurchaseHistoryById(Request $request, $id)
    {
        return $this->getOthersById($request, $id, Transaction::class, 'user_id');
    }
}
