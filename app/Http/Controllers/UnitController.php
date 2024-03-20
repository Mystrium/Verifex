<?php
namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class UnitController extends BaseController {

    public function view(){
        $types = Unit::all();
        return view('unit')->withTypes($types);
    }

    public function add(Request $request){
        Unit::create(['title' => $request->title]);

        return redirect('/units');
    }

    public function edit($id, Request $request){
        Unit::find($id)->update(['title' => $request->title]);

        return redirect('/units');
    }

    public function delete($id){
        Unit::destroy($id);

        return redirect('/units');
    }

}