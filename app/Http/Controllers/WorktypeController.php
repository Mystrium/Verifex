<?php
namespace App\Http\Controllers;

use App\Models\WorkType;
use App\Models\CehType;
use App\Models\RoleItem;
use App\Models\Item;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class WorktypeController extends BaseController {

    public function view(){
        $worktypes = WorkType::all();
        $cehtypes = CehType::all();
        $workitems = RoleItem::all();
        $items = Item::all();
        return view('worktype')
            ->withWorktypes($worktypes)
            ->withCehtypes($cehtypes)
            ->withRoleitems($workitems)
            ->withItems($items);
    }

    public function add(Request $request){
        $newtype = WorkType::create([
            'title' => $request->title,
            'cehtype_id' => $request->type,
            'min_pay' => $request->minpay
        ]);

        if($request->items){
            for($i=0; $i<count($request->items); $i++){
                RoleItem::create([
                    'role_id' => $newtype->id,
                    'item_id' => $request->items[$i], 
                ]);
            }
        }
        return redirect('/worktypes');
    }

    public function edit($id, Request $request){
        WorkType::find($id)->update([
            'title' => $request->title,
            'unit_id' => $request->unit,
            'hascolor' => $request->hascolor,
            'price' => $request->price,
            'url_photo' => $request->photo,
            'url_instruction' => $request->instruction,
            'description' => $request->description
        ]);

        return redirect('/worktypes');
    }

    public function delete($id){
        WorkType::destroy($id);

        return redirect('/worktypes');
    }

}