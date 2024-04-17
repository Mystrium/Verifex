<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Consist;
use App\Models\Color;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class PurchaseController extends BaseController {

    public function view(){
        $colors = Color::all();
        $items = Item::select('items.*', 'units.title as unit')
            ->leftJoin('units', 'units.id', '=', 'items.unit_id')
            ->whereNotIn('items.id',
                Consist::select('what_id')
                    ->get()
                    ->toArray())
            ->get();
        $purchases = Transaction::select('transactions.*', 'items.title', 'colors.hex', 'colors.title as ctitle', 'units.title as unit')
            ->leftJoin('items', 'items.id', '=', 'transactions.item_id_id')
            ->leftJoin('colors', 'colors.id', '=', 'transactions.color_id')
            ->leftJoin('units', 'units.id', '=', 'items.unit_id')
            ->where('worker_from_id', '=', '1')
            ->where('type_id', '=', 3)
            ->orderBy('date', 'desc')
            ->get();
        
        return view('purchase')
            ->withColors($colors)
            ->withItems($items)
            ->withPurchases($purchases)
            ->withNowdate(Carbon::now()->format('Y-m-d'));
    }

    public function add(Request $request){
        $exchange = 1;
        if($request->valute != 'grn'){
            $response = Http::get('https://minfin.com.ua/ua/currency/' . $request->valute . '/');
            $html = $response->body();

            $crawler = new Crawler($html);

            $exchange = str_replace(',', '.', explode('.', $crawler->filter('div.bKmKjX')->text())[0]);
        }

        Transaction::create([
            'type_id' => 3,
            'worker_from_id' => 1,
            'item_id_id' => explode('|', $request->item)[0],
            'color_id' => explode('|', $request->item)[1] == 1 ? $request->color : null,
            'count' => $request->count,
            'price' => $request->price * $exchange,
            'date' => $request->date==Carbon::now()->format('Y-m-d') ? Carbon::now() : $request->date
        ]);

        return redirect('/purchases');
    }

}