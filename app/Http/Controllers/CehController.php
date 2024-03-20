<?php
namespace App\Http\Controllers;

use App\Models\Ceh;
use App\Models\CehType;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class CehController extends BaseController {

    public function view(){
        $types = CehType::all();
        $cehs = Ceh::all();
        return view('ceh')->withCehs($cehs)->withTypes($types);
    }

    public function addCeh(Request $request){
        Ceh::create(['type_id' => $request->type, 'title' => $request->title]);

        return redirect('/cehs');
    }

    public function editCeh($id, Request $request){
        Ceh::find($id)->update(['type_id' => $request->type, 'title' => $request->title]);

        return redirect('/cehs');
    }

    public function deleteCeh($id){
        Ceh::destroy($id);

        return redirect('/cehs');
    }

}