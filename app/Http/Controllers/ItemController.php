<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Consist;
use App\Models\Item;
use App\Models\Unit;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
            ->orderBy('id', 'desc')
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
            ->orderBy('id', 'desc')
            ->get();

        $materials = Item::select('items.*', 'units.title as unit', 'categoryes.title as category')
            ->join('units', 'units.id', '=', 'items.unit_id')
            ->join('categoryes', 'categoryes.id', '=', 'items.category_id', 'left outer')
            ->whereNotIn('items.id',
                Consist::select('what_id')
                    ->get()
                    ->toArray())
            ->orderBy('id', 'desc')
            ->get();

        return view('items/index')
            ->withItems($items)
            ->withOperations($operations)
            ->withMaterials($materials);
    }

    public function new() {
        $types = Item::orderBy('id', 'desc')->get();
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
            Storage::put('images/' . $fileName, file_get_contents($image));
            $photo = asset('images/' . $fileName);
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
        $items = Item::where('id', '<>', $id)->orderBy('id', 'desc')->get();
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
            Storage::put('images/' . $fileName, file_get_contents($image));
            $photo = asset('images/' . $fileName);
        } else
            $photo = $request->image;

        $to_edit = Item::find($id);

        $filename = explode('/', $to_edit->url_photo);
        $path = 'public/images/' . end($filename);
        if(Storage::exists($path))
            Storage::delete($path);

        $to_edit->update([
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
            $path = 'public/images/' . end($filename);
            if(Storage::exists($path))
                Storage::delete($path);
            $to_dell->delete();
        } catch(\Illuminate\Database\QueryException $ex) {
            $mess = $ex->getCode();
        }
        return back()->with('msg', $mess);
    }

}