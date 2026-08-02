<?php

namespace App\Repositories;

use App\Interfaces\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface 
{

    public function getTransactionDataFromSession()
    {
        return session('transaction');
    }

    public function saveTransactionDataToSession($data)
    {
        session(['transaction' => $data]);
    }

    public function saveTransaction($data)
    {
        return \App\Models\Transaction::create($data);
    }

    public function getTransactionByCode($code)
    {
        return \App\Models\Transaction::where('code', $code)->first();
    }

    public function getTransactionByCodeEmailPhone($code, $email, $phone)
    {
        return \App\Models\Transaction::where('code', $code)
            ->where('email', $email)
            ->where('phone', $phone)
            ->first();
    }
}