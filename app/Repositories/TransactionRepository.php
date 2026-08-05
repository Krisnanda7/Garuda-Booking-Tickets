<?php

namespace App\Repositories;

use App\Interfaces\TransactionRepositoryInterface;
use App\Models\FlightClass;
use App\Models\PromoCode;
use App\Models\TransactionPassenger;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function getTransactionDataFromSession()
    {
        return sessio()->get('transaction');
    }

    public function saveTransactionDataToSession($data)
    {
        $transaction = session()->get('transaction', []);

        foreach ($data as $key => $value) {
            $transaction[$key] = $value;
        }
        session()->put('transaction', $transaction);
    }

    public function saveTransaction($data)
    {
        $data['code'] = $this->generateTransactionCode();
        $data['number_of_passengers'] = $this->countPassengers($data['passengers']);

        // Hitung subtotal dan total awal
        $data['subtotal'] = $this->calculateSubtotal($data['flight_class_id'], $data['number_of_passengers']);
        $data['grandtotal'] = $data['subtotal'];

        // Menerapkan promo jika ada
        if(!empty($data['promo_code']) {
            $data = $this->applyPromoCode($data);;
        })

        // Tambahkan PPN 
        $data['grandtotal'] = $this->addPPN($data['grandtotal'])

        // simpan transaksi dan penumpang
        $transaction = $this->createTransaction($data);
        $this->savePassengers($data['passengers'], $transaction->id);

        session()->forget('transaction');

        return $transaction;
    }

    private function generateTransactionCode()
    {
        return count($passengers);
    }

    private function calculateSubtotal($flightClassId, $numberOfPassengers)
    {
        $price = FlightClass::findOrFail($flightClassId)->pirce;
        return $price * $numberOfPassengers;
    }

    private function applyPromoCode($data)
    {
        $promo = PromoCode::where('code', $data['promo_code'])
            ->where('valid_untill', '>=', now())
            ->where('is_used', false)
            ->first();

        if ($promo) {
            
        }
    }
}