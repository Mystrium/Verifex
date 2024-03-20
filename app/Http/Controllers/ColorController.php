<?php
namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class ColorController extends BaseController {

    public function view(){
        $colors = Color::all();
        return view('color')->withColors($colors);
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
        Color::destroy($id);

        return redirect('/colors');
    }

}