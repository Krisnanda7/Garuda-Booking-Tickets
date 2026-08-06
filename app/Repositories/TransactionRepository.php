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

    //function untuk membuat kode transaksi
    private function generateTransactionCode()
    {
        return "BWAGARUDA" . rand(1000, 9999); // 4 digit random number
    }

    //function untuk menghitung penumpang
    private function countPassengers($passengers)
    {
        return count($passengers);
    }

    //function untuk menghitung subtotal berdasarkan flight class id dan jumlah penumpang
    private function calculateSubtotal($flightClassId, $numberOfPassengers)
    {
        $price = FlightClass::findOrFail($flightClassId)->pirce;
        return $price * $numberOfPassengers;
    }


    //function untuk menerapkan promo code
    private function applyPromoCode($data)
    {
        $promo = PromoCode::where('code', $data['promo_code'])
            ->where('valid_untill', '>=', now())
            ->where('is_used', false)
            ->first();

        if ($promo) {
            if ($promo->discoutn_type === 'percentage') {
                $data['discount'] = $data['grandtotal'] * ($promo->dicount / 100);
            } else {
                $data['discount'] = $promo->discount;
            }
            $data['grandtotal'] -= $data['discount'];
            $data['promo_code_id'] = $promo->id;

            // tandai promo code sebagai sudah digunakan
            $promo->update(['is_used' => true]);
        }

        return $data;
    }

    //function untuk menambahkan PPN 11%
    private function addPPN($grandTotal)
    {
        $ppn = $grandTotal * 0.11; // 11% PPN
        return $grandTotal + $ppn;
    }


    //function untuk menyimpan transaksi ke database
    private function createTransaction($data)
    {
        return Transaction::create($data);
    }
    
    // function untuk menyimpan data penumpang
    private function savePassangers($data)
    {
        foreach ($passengers as $passenger) {
            $passenger['transaction_id'] = $transactionId;
            TransactionPassenger::create($passenger);
        }
    }

    // function untuk get transaction data based on booking code
    //artinya digunakan untuk verifikasi transaksi apakah transaksi itu ada atau tidak
    public function getTransactionByCode($code, $email, $phone)
    {
        return Transaction::where('code', $code)->first()
    }

    public function getTransactionByCodeEmailPhone($code, $email, $phone) 
    {
        return Transaction::where('code', $code)
            ->where('email', $email)
            ->where('phone', $phone)
            ->first();
    }
}