<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use App\Models\Siparis;

class SiparisController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders;

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    public function show($orderCode)
    {
        $orders= auth()->user()->orders()->find($orderCode);

        if (!$orders) {
            return response()->json([
                'success' => false,
                'message' => 'Sipariş Uygun Değil! '
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $orders->toArray()
        ], 400);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'productId' => 'required',
            'quantity' => 'required',
            'address' => 'required',
            'shippingDate' => 'required'
        ]);

        $orders = new Siparis();
        $orders->productId = $request->productId;
        $orders->quantity = $request->quantity;
        $orders->address = $request->address;
        $orders->shippingDate = $request->shippingDate;

        if (auth()->user()->orders()->save($orders))
            return response()->json([
                'success' => true,
                'data' => $orders->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Sipariş Eklenemedi!'
            ], 500);
    }

    public function update(Request $request, $orderCode)
    {
        $orders = auth()->user()->orders()->find($orderCode);

        if (!$orders) {
            return response()->json([
                'success' => false,
                'message' => 'Sipariş Bulunamadı!'
            ], 400);
        }
        $tarih = new DateTime(auth()->user()->orders()->find($orderCode)->shippingDate);
        $tarih2 = new DateTime(date("Y-m-d"));
        if($tarih > $tarih2)
        {
            $updated = $orders->fill($request->all())->save();

            if ($updated)
                return response()->json([
                    'success' => true,
                    'message' => 'success'
                ]);
            else
                return response()->json([
                    'success' => false,
                    'message' => 'Sipariş Güncellenemedi!'
                ], 500);

        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Sipariş Tarihi Geçmiş!'
            ], 500);

        }


    }

    public function destroy($orderCode)
    {
        $orders = auth()->user()->orders()->find($orderCode);

        if (!$orders) {
            return response()->json([
                'success' => false,
                'message' => 'Sipariş Bulunamadı!'
            ], 400);
        }

        if ($orders->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sipariş silinemedi!'
            ], 500);
        }
    }
}
