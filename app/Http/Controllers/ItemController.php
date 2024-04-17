<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Consist;
use App\Models\Item;
use App\Models\Unit;

class ItemController extends BaseController {
    public function items(){
        $types = Item::select('items.*', 'units.title as unit')
            ->join('units', 'units.id', '=', 'items.unit_id')
            ->whereNotIn('items.id', 
                Consist::select('have_id')
                    ->get()
                    ->toArray())
            ->whereIn('items.id',
                Consist::select('what_id')
                    ->get()
                    ->toArray())
            ->get();
        return view('items/index')
            ->withTitle('Вироби')
            ->withItems($types);
    }

    public function operations(){
        $types = Item::select('items.*', 'units.title as unit')
            ->join('units', 'units.id', '=', 'items.unit_id')
            ->whereIn('items.id', 
                Consist::select('have_id')
                    ->get()
                    ->toArray())
            ->whereIn('items.id',
                Consist::select('what_id')
                    ->get()
                    ->toArray())
            ->get();
        return view('items/index')
            ->withTitle('Операції')
            ->withItems($types);
    }

    public function materials(){
        $types = Item::select('items.*', 'units.title as unit')
            ->join('units', 'units.id', '=', 'items.unit_id')
            ->whereNotIn('items.id',
                Consist::select('what_id')
                    ->get()
                    ->toArray())
            ->get();
        return view('items/index')
            ->withTitle('Матеріали')
            ->withItems($types);
    }

    public function new() {
        $types = Item::all();
        $units = Unit::all();
        return view('items/new')
            ->withItems($types)
            ->withUnits($units)
            ->withAct('add');
    }

    public function add(Request $request){
        $newitm = Item::create([
            'title' => $request->title,
            'unit_id' => $request->unit,
            'hascolor' => $request->hascolor?1:0,
            'price' => $request->price,
            'url_photo' => $request->photo,
            'url_instruction' => $request->instruction,
            'description' => $request->description
        ]);

        if($request->consists){
            for($i=0; $i<count($request->consists); $i++){
                Consist::create([
                    'what_id' => $newitm->id,
                    'have_id' => $request->consists[$i], 
                    'count' => $request->counts[$i]
                ]);
            }
        }

        return redirect('/items');
    }

    public function edit($id) {
        $toedit = Item::where('id', '=', $id)->get()[0];
        $items = Item::where('id', '<>', $id)->get();
        $consist = Consist::where('what_id', '=', $id)->get();
        $units = Unit::all();
        return view('items/new')
            ->withItems($items)
            ->withEdit($toedit)
            ->withUnits($units)
            ->withConsists($consist)
            ->withAct('update');
    }

    public function update($id, Request $request){
        Item::find($id)->update([
            'title' => $request->title,
            'unit_id' => $request->unit,
            'hascolor' => $request->hascolor?1:0,
            'price' => $request->price,
            'url_photo' => $request->photo,
            'url_instruction' => $request->instruction,
            'description' => $request->description
        ]);

        Consist::where('what_id', '=', $id)->delete();
        if($request->consists){
            for($i=0; $i<count($request->consists); $i++){
                Consist::create([
                    'what_id' => $id,
                    'have_id' => $request->consists[$i], 
                    'count' => $request->counts[$i]
                ]);
            }
        }

        return redirect('/items');
    }

    public function delete($id){
        Item::destroy($id);

        return redirect('/items');
    }

}