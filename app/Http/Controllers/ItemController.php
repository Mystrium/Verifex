<?php
namespace App\Http\Controllers;

use App\Models\Consist;
use App\Models\Item;
use App\Models\Unit;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class ItemController extends BaseController {

    public function view(){
        $types = Item::all();
        $units = Unit::all();
        return view('item')->withItems($types)->withUnits($units);
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

    public function edit($id, Request $request){
        Item::find($id)->update([
            'title' => $request->title,
            'unit_id' => $request->unit,
            'hascolor' => $request->hascolor,
            'price' => $request->price,
            'url_photo' => $request->photo,
            'url_instruction' => $request->instruction,
            'description' => $request->description
        ]);

        return redirect('/items');
    }

    public function delete($id){
        Item::destroy($id);

        return redirect('/items');
    }

}