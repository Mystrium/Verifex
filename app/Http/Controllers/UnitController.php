<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Unit;

class UnitController extends BaseController {

    public function view(Request $request){
        $units = Unit::where('title', 'like', '%' . ($request->search??'') . '%')->get();
        return view('unit')
            ->withSearch($request->search)
            ->withUnits($units);
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
        $mess = '';
        try {
            Unit::destroy($id);
        } catch(\Illuminate\Database\QueryException $ex) {
            $mess = $ex->getCode();
        }
        return back()->with('msg', $mess);
    }

}