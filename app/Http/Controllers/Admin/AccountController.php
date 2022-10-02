<?php

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\AccountRequest;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        if (request()->page) {
            $accounts = Account::filterByColumns($request->all())
            ->orderBy('id', 'desc')->paginate(20);
        } else {
            $accounts = Account::all();
        }

        return $this->successResponse([
            'accounts' => $accounts
        ], 200);
    }

    public function store(AccountRequest $request)
    {
        $data = $request->validated();

        $account = Account::create($data);

        return $this->successResponse($account, 200);
    }

    public function show($id)
    {
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        Account::whereId($id)->update($data);

        return $this->successResponse([
            'status' => 'success'
        ], 200);
    }
}
