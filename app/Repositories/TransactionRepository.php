<?php

namespace App\Repositories;

use App\Interfaces\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface 
{

    public function getTransactionDataFromSession()
    {
        return session('transaction');
    }
    
}