<?php

namespace App\Http\Controllers;

use App\linetable;
use App\shopifygather;
use Illuminate\Http\Request;

use App\Http\Requests;

class ApiController extends Controller
{

    public function listen(Request $request)
    {
        if (count($request->json()->all())) {
            $postbody = $request->json()->all();
        }

        foreach ($postbody['line_items'] as $r) {

            linetable::create([
                'order_id' => $postbody['id'],
                'order_created_at'=> $postbody['created_at'],
                'product_id'=> $r['product_id'],
                'title'=> $r['title'],
                'quantity'=> $r['quantity'],
                'price'=> $r['price'],
                'fulfillable_quantity'=> $r['fulfillable_quantity'],

            ]);
        }

        $shit = $postbody['email'];


        return $shit;
    }
}
