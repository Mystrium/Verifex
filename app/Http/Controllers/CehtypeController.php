<?php
namespace App\Http\Controllers;

use App\Models\CehType;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class CehtypeController extends BaseController {

    public function view(Request $request){
        $types = CehType::where('title', 'like', '%' . ($request->search??'') . '%')->get();
        return view('cehtype')
            ->withSearch($request->search)
            ->withTypes($types);
    }

    public function add(Request $request){
        CehType::create(['title' => $request->title]);

        return redirect('/cehtypes');
    }

    public function edit($id, Request $request){
        CehType::find($id)->update(['title' => $request->title]);

        return redirect('/cehtypes');
    }

    public function delete($id){
        $mess = '';
        try {
            CehType::destroy($id);
        } catch(\Illuminate\Database\QueryException $ex) {
            $mess = $ex->getCode();
        }
        return back()->with('msg', $mess);
    }

}