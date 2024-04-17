<?php
namespace App\Http\Controllers;

use App\Models\Purchase;
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
        $purchases = Purchase::select('purchases.*', 'items.title', 'colors.hex', 'colors.title as ctitle', 'units.title as unit')
            ->leftJoin('items', 'items.id', '=', 'purchases.item_id')
            ->leftJoin('colors', 'colors.id', '=', 'purchases.color_id')
            ->leftJoin('units', 'units.id', '=', 'items.unit_id')
            ->orderBy('date', 'desc')
            ->get();
        
        return view('purchases.index')
            ->withPurchases($purchases);
    }

    public function new(){
        $colors = Color::all();
        $items = Item::select('items.*', 'units.title as unit')
            ->leftJoin('units', 'units.id', '=', 'items.unit_id')
            ->whereNotIn('items.id',
                Consist::select('what_id')
                    ->get()
                    ->toArray())
            ->get();

        return view('purchases.new')
            ->withAct('add')
            ->withColors($colors)
            ->withItems($items)
            ->withNowdate(Carbon::now()->format('Y-m-d'));
    }

    public function add(Request $request){
        Purchase::create([
            'item_id' => explode('|', $request->item)[0],
            'color_id' => explode('|', $request->item)[1] == 1 ? $request->color : null,
            'count' => $request->count,
            'price' => $request->price * $this->exchange($request->currency),
            'date' => $request->date == Carbon::now()->format('Y-m-d') ? Carbon::now() : $request->date
        ]);

        return redirect('/purchases');
    }

    public function edit($id) {
        $purchase = Purchase::find($id);
        
        $colors = Color::all();
        $items = Item::select('items.*', 'units.title as unit')
            ->leftJoin('units', 'units.id', '=', 'items.unit_id')
            ->whereNotIn('items.id',
                Consist::select('what_id')
                    ->get()
                    ->toArray())
            ->get();

        return view('purchases.new')
            ->withEdit($purchase)
            ->withAct('update')
            ->withColors($colors)
            ->withItems($items)
            ->withNowdate(Carbon::now()->format('Y-m-d'));
    }

    public function update($id, Request $request){
        Purchase::find($id)->update([
            'item_id' => explode('|', $request->item)[0],
            'color_id' => explode('|', $request->item)[1] == 1 ? $request->color : null,
            'count' => $request->count,
            'price' => $request->price * $this->exchange($request->currency),
            'date' => $request->date == Carbon::now()->format('Y-m-d') ? Carbon::now() : $request->date
        ]);

        return redirect('/purchases');
    }

    private function exchange($currency){
        $exchange = 1;

        if($currency != 'grn') {
            $response = Http::get('https://minfin.com.ua/ua/currency/' . $currency . '/');

            $crawler = new Crawler($response->body());

            $exchange = str_replace(',', '.', explode('.', $crawler->filter('div.bKmKjX')->text())[0]);
        }

        return $exchange;
    }

}