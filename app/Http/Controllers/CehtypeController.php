<?php
namespace App\Http\Controllers;

use App\Models\CehType;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class CehtypeController extends BaseController {

    public function view(){
        $types = CehType::all();
        return view('cehtype')->withTypes($types);
    }

    public function addType(Request $request){
        CehType::create(['title' => $request->title]);

        return redirect('/cehtypes');
    }

    public function editType($id, Request $request){
        CehType::find($id)->update(['title' => $request->title]);

        return redirect('/cehtypes');
    }

    public function deleteType($id){
        CehType::destroy($id);

        return redirect('/cehtypes');
    }

}