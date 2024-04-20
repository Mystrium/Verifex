<?php
namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class ColorController extends BaseController {

    public function view(Request $request){
        $colors = Color::where('title', 'like', '%' . ($request->search??'') . '%')->get();
        return view('color')
            ->withSearch($request->search)
            ->withColors($colors);
    }


    public function add(Request $request){
        Color::create(['title' => $request->title, 'hex' => substr($request->hex, -6)]);

        return redirect('/colors');
    }

    public function edit($id, Request $request){
        Color::find($id)->update(['title' => $request->title, 'hex' => substr($request->hex, -6)]);

        return redirect('/colors');
    }

    public function delete($id){
        $mess = '';
        try {
            Color::destroy($id);
        } catch(\Illuminate\Database\QueryException $ex) {
            $mess = $ex->getCode();
        }
        return back()->with('msg', $mess);
    }

}