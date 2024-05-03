<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Consist;
use App\Models\Item;
use App\Models\Unit;
use Illuminate\Support\Facades\File;

class ItemController extends BaseController {
    public function items(){
        $items = Item::select('items.*', 'units.title as unit', 'categoryes.title as category')
            ->join('units', 'units.id', '=', 'items.unit_id')
            ->join('categoryes', 'categoryes.id', '=', 'items.category_id', 'left outer')
            ->whereNotIn('items.id', 
                Consist::select('have_id')
                    ->get()
                    ->toArray())
            ->whereIn('items.id',
                Consist::select('what_id')
                    ->get()
                    ->toArray())
            ->get();

        $operations = Item::select('items.*', 'units.title as unit', 'categoryes.title as category')
            ->join('units', 'units.id', '=', 'items.unit_id')
            ->join('categoryes', 'categoryes.id', '=', 'items.category_id', 'left outer')
            ->whereIn('items.id', 
                Consist::select('have_id')
                    ->get()
                    ->toArray())
            ->whereIn('items.id',
                Consist::select('what_id')
                    ->get()
                    ->toArray())
            ->get();

        $materials = Item::select('items.*', 'units.title as unit', 'categoryes.title as category')
            ->join('units', 'units.id', '=', 'items.unit_id')
            ->join('categoryes', 'categoryes.id', '=', 'items.category_id', 'left outer')
            ->whereNotIn('items.id',
                Consist::select('what_id')
                    ->get()
                    ->toArray())
            ->get();

        return view('items/index')
            ->withItems($items)
            ->withOperations($operations)
            ->withMaterials($materials);
    }

    public function new() {
        $types = Item::all();
        $units = Unit::all();
        $categoryes = Category::all();
        return view('items/new')
            ->withItems($types)
            ->withUnits($units)
            ->withCategoryes($categoryes)
            ->withAct('add');
    }

    public function add(Request $request){
        $photo = '';
        if($request->hasFile('image')){
            $image = $request->file('image');
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $photo = asset($image->storeAs('images', $fileName, 'public'));
        } else
            $photo = $request->image;

        $newitm = Item::create([
            'title' => $request->title,
            'unit_id' => $request->unit,
            'category_id' => $request->category,
            'hascolor' => $request->hascolor ? 1 : 0,
            'price' => $request->price ?? 0,
            'url_photo' => $photo,
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
        $categoryes = Category::all();
        return view('items/new')
            ->withItems($items)
            ->withEdit($toedit)
            ->withUnits($units)
            ->withConsists($consist)
            ->withCategoryes($categoryes)
            ->withAct('update');
    }

    public function update($id, Request $request){
        $photo = '';
        if($request->hasFile('image')){
            $image = $request->file('image');
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $photo = asset($image->storeAs('images', $fileName, 'public'));
        } else
            $photo = $request->image;

        Item::find($id)->update([
            'title' => $request->title,
            'unit_id' => $request->unit,
            'category_id' => $request->category,
            'hascolor' => $request->hascolor ? 1 : 0,
            'price' => $request->price ?? 0,
            'url_photo' => $photo,
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
        $mess = '';
        try {
            $to_dell = Item::find($id);
            $filename = explode('/', $to_dell->url_photo);
            if(file_exists(public_path('images/' . end($filename))))
                File::delete(public_path('images/' . end($filename)));
            $to_dell->delete();
        } catch(\Illuminate\Database\QueryException $ex) {
            $mess = $ex->getCode();
        }
        return back()->with('msg', $mess);
    }

}