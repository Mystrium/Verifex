<?php
namespace App\Http\Controllers;

use App\Models\Ceh;
use App\Models\CehType;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class CehController extends BaseController {

    public function view(Request $request){
        $types = CehType::all();
        if($request->search){
            if($request->search[0] == 0)
                $cehs = Ceh::where('title', 'like', '%' . ($request->search[1]??'') . '%')
                    ->orderBy('id', 'desc')
                    ->get();
            else
                $cehs = Ceh::where([['title', 'like', '%' . ($request->search[1]??'') . '%'], ['type_id', '=', $request->search[0]]])
                    ->orderBy('id', 'desc')
                    ->get();
        } else
            $cehs = Ceh::all();
        return view('ceh')
            ->withSearch($request->search)
            ->withCehs($cehs)
            ->withTypes($types);
    }

    public function add(Request $request){
        Ceh::create(['type_id' => $request->type, 'title' => $request->title??'']);

        return redirect('/cehs');
    }

    public function edit($id, Request $request){
        Ceh::find($id)->update(['type_id' => $request->type, 'title' => $request->title??'']);

        return redirect('/cehs');
    }

    public function delete($id){
        $mess = '';
        try {
            Ceh::destroy($id);
        } catch(\Illuminate\Database\QueryException $ex) {
            $mess = $ex->getCode();
        }
        return back()->with('msg', $mess);
    }

}