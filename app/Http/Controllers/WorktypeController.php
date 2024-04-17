<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\TransactionType;
use App\Models\RoleItem;
use App\Models\WorkType;
use App\Models\CehType;
use App\Models\Item;

class WorktypeController extends BaseController {
    public function view() {
        $perm = TransactionType::all();
        $workitems = RoleItem::select('role_id', 'items.id', 'title')
            ->join('items', 'items.id', '=', 'role_items.item_id')
            ->get();
        $worktypes = WorkType::select('work_types.*', 'ceh_types.title as cehtype')
            ->join('ceh_types', 'ceh_types.id', '=', 'work_types.cehtype_id')
            ->get();

        return view('worktypes/index')
            ->withPermisions($perm)
            ->withWorkitems($workitems)
            ->withWorktypes($worktypes);
    }

    public function new() {
        $cehtypes = CehType::all();
        $items = Item::all();
        $perm = TransactionType::all();
        return view('worktypes/new')
            ->withCehtypes($cehtypes)
            ->withPermisions($perm)
            ->withItems($items)
            ->withAct('add');
    }

    public function add(Request $request){
        $newtype = WorkType::create([
            'title' => $request->title,
            'cehtype_id' => $request->type,
            'min_pay' => $request->minpay,
            'operations' => implode(',', $request->operations)
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

    public function edit($id) {
        $toedit = WorkType::find($id);
        $workitems = RoleItem::select('item_id')->where('role_id', '=', $id)->get();
        $workitems2 = [];
        foreach($workitems as $item)
            $workitems2[] = $item->item_id;
        $cehtypes = CehType::all();
        $items = Item::all();
        $perm = TransactionType::all();
        return view('worktypes/new')
            ->withItems($items)
            ->withEdit($toedit)
            ->withWorkitems($workitems2)
            ->withCehtypes($cehtypes)
            ->withPermisions($perm)
            ->withAct('update');
    }

    public function update($id, Request $request){
        WorkType::find($id)->update([
            'title' => $request->title,
            'cehtype_id' => $request->type,
            'min_pay' => $request->minpay,
            'operations' => implode(',', $request->operations)
        ]);

        RoleItem::where('role_id', '=', $id)->delete();
        if($request->items){
            for($i=0; $i<count($request->items); $i++){
                RoleItem::create([
                    'role_id' => $id,
                    'item_id' => $request->items[$i], 
                ]);
            }
        }

        return redirect('/worktypes');
    }

    public function delete($id){
        WorkType::destroy($id);

        return redirect('/worktypes');
    }

}