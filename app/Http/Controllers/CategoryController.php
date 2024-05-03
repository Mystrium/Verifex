<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends BaseController {
    public function view(Request $request){
        $colors = Category::where('title', 'like', '%' . ($request->search??'') . '%')
            ->orderBy('id', 'desc')
            ->get();
        return view('category')
            ->withSearch($request->search)
            ->withCategoryes($colors);
    }


    public function add(Request $request){
        Category::create([
            'title' => $request->title, 
            'description' => $request->descr
        ]);

        return redirect()->back();
    }

    public function edit($id, Request $request){
        Category::find($id)->update([
            'title' => $request->title, 
            'description' => $request->descr
        ]);

        return redirect()->back();
    }

    public function delete($id){
        $mess = '';
        try {
            Category::destroy($id);
        } catch(\Illuminate\Database\QueryException $ex) {
            $mess = $ex->getCode();
        }
        return back()->with('msg', $mess);
    }

}