<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;
use App\Project;
use App\InventoryProject;
use DB;
use Validator;
use Session;

class InventoryController extends Controller
{
    public function __construct() {

        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventories = Inventory::orderBy('id', 'asc')->paginate(5);
        return view('workcenter.inventory.index', compact('inventories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('workcenter.inventory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:100',
            'model' => 'required|min:3|max:100',
            'quantity' => 'required|integer',
            'notes' => 'sometimes'
        ]);

        $inventory = new Inventory();
        $inventory->name = $request->name;
        $inventory->model = $request->model;
        $inventory->quantity = $request->quantity;
        $inventory->notes = $request->notes;

        $inventory->save();

        Session::flash('success', 'Inventory Created!');
        return redirect()->route('inventory.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inventory = Inventory::findOrFail($id);
        return view('workcenter.inventory.show', compact('inventory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inventory = Inventory::findOrFail($id);
        return view('workcenter.inventory.edit', compact('inventory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:100',
            'model' => 'required|min:3|max:100',
            'quantity' => 'required|integer',
            'notes' => 'sometimes'
        ]);

        $inventory = Inventory::findOrFail($id);
        $inventory->name = $request->name;
        $inventory->model = $request->model;
        $inventory->quantity = $request->quantity;
        $inventory->notes = $request->notes;

        $inventory->save();

        Session::flash('success', 'Inventory Updated!');
        return redirect()->route('inventory.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        Session::flash('success', 'Inventory Deleted!');
        return redirect()->route('inventory.index');
    }

    public function scheduleEquipment(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'start_date' =>'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after:start-date',
            'quantity' => 'required|integer',
            'notes' => 'sometimes'
        ]);

        if ($validator->fails()) {
            return redirect('workcenter/projects/projectbudget/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        } else {

            $schedule = new InventoryProject();
            
            $schedule->project_id = $request->project_id;
            $schedule->inventory_id = $request->inventory_id;
            $schedule->start_date = $request->start_date;
            $schedule->end_date = $request->end_date;
            $schedule->quantity = $request->quantity;
            $schedule->notes = $request->notes;

            $inventory = Inventory::findOrFail($request->inventory_id);

            if ($request->quantity <= $inventory->quantity) {

                $newquantity = $inventory->quantity - $request->quantity;

                DB::table('inventories')
                    ->where('id', $request->inventory_id)
                    ->update(['quantity' =>  $newquantity]);

                $schedule->save();

                Session::flash('success', 'Inventory/Equipment are scheduled');
                return redirect('workcenter/projects/projectbudget/'.$id);

            } elseif ($request->quantity > $inventory->quantity) {

                return redirect('workcenter/projects/projectbudget/'.$id)->withErrors(["Insufficient Quantity"]);
                        
            }
           
        }
    }

    public function scheduledEquipments($id)
    {
        $equipments = InventoryProject::where('project_id', $id)->get();

        return view('workcenter.projects.projectbudget', compact('equipments'));
    }

    public function destroyScheduledEquipment($id)
    {
        $equipment = InventoryProject::findOrFail($id);
        $current = $equipment->quantity;

        $inventory = Inventory::findOrFail($equipment->inventory_id);
        $oldquantity = $inventory->quantity;

        $newquantity = $current + $oldquantity;

        DB::table('inventories')
                    ->where('id', $inventory->id)
                    ->update(['quantity' =>  $newquantity]);
        
        $equipment->delete();

        Session::flash('success', 'Inventory/Equipment are removed');
        return redirect('workcenter/projects/projectbudget/'.$equipment->project_id);
    }

    public function showScheduledEquipment($id)
    {
        $equipment = InventoryProject::findOrFail($id);
        $inventory = Inventory::findOrFail($equipment->inventory_id);
        $project = Project::findOrFail($equipment->project_id);

        return view('workcenter.inventory.schedule', compact('equipment', 'inventory', 'project'));

    }
}
