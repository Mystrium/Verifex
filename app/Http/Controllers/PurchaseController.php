<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Consist;
use App\Models\Worker;
use App\Models\Color;
use App\Models\Item;
use App\Models\Ceh;
use Carbon\Carbon;

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

    public function material_ceh(Request $request) {
        $filename = public_path() . '\materialceh.txt';
        $contents = file_get_contents($filename);
        $ceh_worker = explode(':', $contents);

        $cehs = Ceh::select('ceh.id', 'ceh.title', 'ceh_types.title as type')
            ->join('ceh_types', 'ceh.type_id', '=', 'ceh_types.id')
            ->get();

        $workers = Worker::select('ceh_id', 'workers.id', 'workers.pib', 'work_types.title')
            ->join('work_types', 'workers.role_id', '=', 'work_types.id')
            ->where('operations', 'like', '%1%')
            ->get();

        return view('purchases.ceh')
            ->withCehs($cehs)
            ->withWorkers($workers)
            ->withSave($ceh_worker);
    }

    public function ceh_update(Request $request) {
        $filename = public_path() . '\materialceh.txt';
        file_put_contents($filename, $request->initceh . ':' . $request->initworker);
        return redirect()->back();
    }
}