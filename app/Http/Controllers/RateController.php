<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rate;
use Session;
use Validator;

class RateController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rates = Rate::orderBy('id', 'asc')->paginate(5);
        return view('workcenter.rates.index', compact('rates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('workcenter.rates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'hour' => 'required',
            'facility_management' => 'required',
            'margin' => 'required',
            'quote_time' => 'required',
            'project_management' => 'required',
            'travel' => 'required',
            'truck' => 'required',
            'van' => 'required',
            'fuel' => 'required',
            'hotel' => 'required',
            'perdiem' => 'required',
            'material' => 'required',
            'receiving' => 'required',
            'return' => 'required'            
            
        ]);
        
        if ($validator->fails()) {
            return redirect('workcenter/rates/create')
                        ->withErrors($validator)
                        ->withInput();
        } else {

            $rate = new Rate();
            $rate->hour = $request->hour;
            $rate->facility_management = $request->facility_management;
            $rate->margin = $request->margin;
            $rate->quote_time = $request->quote_time;
            $rate->project_management = $request->project_management;
            $rate->travel = $request->travel;
            $rate->truck = $request->truck;
            $rate->van = $request->van;
            $rate->fuel = $request->fuel;
            $rate->hotel = $request->hotel;
            $rate->perdiem = $request->perdiem;
            $rate->material = $request->material;
            $rate->receiving = $request->receiving;
            $rate->return = $request->return;

            $rate->save();

            Session::flash('success', 'Rates Created!');
            return redirect()->route('rates.index');

        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rate = Rate::findOrFail($id);
        return view('workcenter.rates.show', compact('rate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rate = Rate::findOrFail($id);
        return view('workcenter.rates.edit', compact('rate'));
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
        $validator = Validator::make($request->all(),[
            'hour' => 'required',
            'facility_management' => 'required',
            'margin' => 'required',
            'quote_time' => 'required',
            'project_management' => 'required',
            'travel' => 'required',
            'truck' => 'required',
            'van' => 'required',
            'fuel' => 'required',
            'hotel' => 'required',
            'perdiem' => 'required',
            'material' => 'required',
            'receiving' => 'required',
            'return' => 'required'            
            
        ]);
        
        if ($validator->fails()) {
            return redirect('workcenter/rates/')
                        ->withErrors($validator)
                        ->withInput();
        } else {

            $rate = Rate::findOrFail($id);
            $rate->hour = $request->hour;
            $rate->facility_management = $request->facility_management;
            $rate->margin = $request->margin;
            $rate->quote_time = $request->quote_time;
            $rate->project_management = $request->project_management;
            $rate->travel = $request->travel;
            $rate->truck = $request->truck;
            $rate->van = $request->van;
            $rate->fuel = $request->fuel;
            $rate->hotel = $request->hotel;
            $rate->perdiem = $request->perdiem;
            $rate->material = $request->material;
            $rate->receiving = $request->receiving;
            $rate->return = $request->return;
            // dd($rate);
            $rate->save();

            Session::flash('success', 'Changes Saved!');
            return redirect()->route('rates.index');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rate = Rate::findOrFail($id);
        $rate->delete();

        Session::flash('success', 'Rate Deleted!');
        return redirect()->route('rates.index');

    }
}
