<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\User;
use App\ChangeOrder;
use Validator;
use Session;
use DB;
use Mail;

class ChangeOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function sendChangeOrder(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'order_details' => 'required',
            'leadinstaller_signature' => 'required|min:3'         
        ]);
        if ($validator->fails()) {
            return redirect('workcenter/projects/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        } else {

            $changeOrder = new ChangeOrder();
            $changeOrder->project_id = $request->project_id;
            $changeOrder->client_id = $request->client_id;
            $changeOrder->user_id = $request->user_id;
            $changeOrder->clientName = $request->clientName;
            $changeOrder->leadInstaller = $request->leadInstaller;
            $changeOrder->order_details = $request->order_details;
            $changeOrder->leadinstaller_signature = $request->leadinstaller_signature;
            // $changeOrder->clientemail = $request->clientEmail;

            // dd($changeOrder);
            $changeOrder->save();

            if ($changeOrder->save())
            {
                    $data = array(
                            'clientName' => $request->clientName,
                            'clientEmail' => $request->clientEmail,
                            'leadInstaller' => $request->leadInstaller,
                            'email' => $request->supervisorEmail,
                            'subject' => $request->subject,
                            'bodyMessage' => $request->order_details
                            );
                            // dd($data);
                        Mail::send('workcenter.emails.changeOrderEmail', $data, function($message) use($data) {
                            $message->from($data['email']);
                            $message->to($data['clientEmail']);
                            $message->subject($data['subject']);
                        });
            }

            Session::flash('success', 'Change Order request sent successfuly!');
            return redirect()->route('projects.show', $id);

        }

    }

    public function getChangeOrders($id)
    {
        $project = Project::findOrFail($id);
        $changeOrders = ChangeOrder::where('project_id', $id)->get();
        
        return view('workcenter.projects.changeOrders', compact('project', 'changeOrders'));
    }

    public function viewChangeOrder($id)
    {
        $changeOrder = ChangeOrder::findOrFail($id);
        $project_id = ChangeOrder::pluck('project_id', 'id')->get($id);
        return view('workcenter.projects.viewChangeOrder', compact('changeOrder', 'project_id'));
    }

    public function editChangeOrder($id)
    {
        $changeOrder = ChangeOrder::findOrFail($id);
        $project_id = ChangeOrder::pluck('project_id', 'id')->get($id);
        return view('workcenter.projects.editChangeOrder', compact('changeOrder', 'project_id'));
    }

    public function updateChangeOrder(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'order_details' => 'required',
            'clientName' => 'sometimes',
            'leadInstaller' => 'sometimes',
            'leadinstaller_signature' => 'required|min:3'
        ]);
        if ($validator->fails()) {
            return redirect('workcenter/projects/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        } else {

            $changeOrder = ChangeOrder::findOrFail($id);
            $changeOrder->project_id = $request->project_id;
            $changeOrder->client_id = $request->client_id;
            $changeOrder->user_id = $request->user_id;
            $changeOrder->clientName = $request->clientName;
            $changeOrder->leadInstaller = $request->leadInstaller;
            $changeOrder->order_details = $request->order_details;
            $changeOrder->leadinstaller_signature = $request->leadinstaller_signature;
            // $changeOrder->clientemail = $request->clientEmail;

            // dd($changeOrder);
            $changeOrder->save();

            if ($changeOrder->save())
            {
                    $data = array(
                            'clientName' => $request->clientName,
                            'clientEmail' => $request->clientEmail,
                            'leadInstaller' => $request->leadInstaller,
                            'email' => $request->supervisorEmail,
                            'subject' => $request->subject,
                            'bodyMessage' => $request->order_details
                            );
                            // dd($data);
                        Mail::send('workcenter.emails.changeOrderEmail', $data, function($message) use($data) {
                            $message->from($data['email']);
                            $message->to($data['clientEmail']);
                            $message->subject(['Change Order Request']);
                            // $message->subject($data['subject']);
                        });
            }

            Session::flash('success', 'Change Order Updated successfuly!');
            return redirect()->route('projects.viewChangeOrder', $id);

        }
    }

    public function destroyChangeOrder($id)
    {
        $changeOrder = ChangeOrder::findOrFail($id);
        $project_id = ChangeOrder::pluck('project_id', 'id')->get($id);

        $changeOrder->delete();

        Session::flash('success', 'Change Order Deleted!');
        return redirect()->route('projects.changeOrders', $project_id);
        
    }
}
