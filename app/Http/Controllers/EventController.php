<?php

namespace App\Http\Controllers;

use DateTime;
use DateInterval;
use App\Models\Event;
use DatePeriod;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\Caster\RedisCaster;

class EventController extends Controller
{
    //
    public function index(Request $request)
    {
        $recurrence_type = config('constants.recurrence.type');
        $recurrence_frequency = config('constants.recurrence.frequency');
        $recurrence_type_keys = array_keys($recurrence_type);
        $recurrence_frequency_keys = array_keys($recurrence_frequency);
        $events = Event::whereIn('recurrence_type',$recurrence_type_keys)->WhereIn('recurrence_frequency', $recurrence_frequency_keys)->latest()->paginate(10);
        return view('index',compact('events','recurrence_type','recurrence_frequency'));
    }

    public function create(Request $request)
    {
        $recurrence_type = config('constants.recurrence.type');
        $recurrence_frequency = config('constants.recurrence.frequency');
        return view('create-edit',compact('recurrence_type','recurrence_frequency'));
    }

    public function edit(Request $request,$id)
    {
        $recurrence_type = config('constants.recurrence.type');
        $recurrence_frequency = config('constants.recurrence.frequency');
        $recurrence_type_keys = array_keys($recurrence_type);
        $recurrence_frequency_keys = array_keys($recurrence_frequency);
        $data = Event::where('id',$id)->whereIn('recurrence_type',$recurrence_type_keys)->WhereIn('recurrence_frequency', $recurrence_frequency_keys)->first();
        if(empty($data)){
            return redirect()->back()->with('error',__('message.something_went_wrong'));
        }
        return view('create-edit',compact('recurrence_type','recurrence_frequency','id','data'));
    }

    public function store(Request $request)
    {
        $id = $request->post('id') ?? null;
        $request->validate([
            'title' => 'required|max:255',
            'start_date' => 'required',
            'end_date' => 'required|after_or_equal:start_date',
            'recurrence_type' => 'required',
            'recurrence_frequency' => 'required'
        ]);
        $data = $request->except('id','_token');
        $response = Event::updateOrCreate([
            'id' => $id,
        ], $data);

        if($response){
            if(empty($id)){
                return redirect()->route('event.index')->with('success',__('message.created_success',['Name' => 'Event']));
            }else{
                return redirect()->route('event.index')->with('success',__('message.update_success',['Name' => 'Event']));
            }
        }else{
            return redirect()->back()->withInput()->with('error',__('message.something_went_wrong'));
        }
    }

    public function show(Request $request,$id)
    {
        $recurrence_type = config('constants.recurrence.type');
        $recurrence_frequency = config('constants.recurrence.frequency');
        $recurrence_type_keys = array_keys($recurrence_type);
        $recurrence_frequency_keys = array_keys($recurrence_frequency);
        $event = Event::where('id',$id)->whereIn('recurrence_type',$recurrence_type_keys)->WhereIn('recurrence_frequency', $recurrence_frequency_keys)->first();
        if(empty($event)){
            return redirect()->back()->with('error',__('message.something_went_wrong'));
        }
        $data = array();
        $start_date = new DateTime($event->start_date);
        $end_date = new DateTime($event->end_date);
        $frequency = '';
        switch($event->recurrence_type){
            case 1:
                // every 
                $frequency = '+1';
                break;
            case 2:
                // every other
                $frequency = '+2';
                break;
            case 3:
                // every third
                $frequency = '+3';
                break;
            case 4:
                //every forth
                $frequency = '+4';
                break;
        }
        switch($event->recurrence_frequency){
            case 1:
                //day
                $frequency .= ' Day';
                break;
            case 2:
                //week
                $frequency .= ' Week';
                break;
            case 3:
                //month
                $frequency .= ' Month';
                break;
            case 4:
                //year
                $frequency .= ' Year';
                break;
        }
        $interval = DateInterval::createFromDateString($frequency);
        if(config('constants.recurrence.include_last_occrence')){
            $end_date = $end_date->modify($frequency);
        }
        $period = new DatePeriod($start_date,$interval,$end_date);
        foreach($period as $p){
            array_push($data,['date' => $p->format('Y-m-d'),'day' => date('l',strtotime($p->format('Y-m-d')))]);
        }
        return view('show',compact('event','data'));
    }

    public function destroy(Request $request,$id)
    {
        $data = Event::find($id);
        if($data->delete()){
            return response()->json(
                [
                    'status' => TRUE,
                    'message' => __('message.destory_success',['Name' => 'Event'])
                ]
            );
        }else{
            return response()->json(
                [
                    'status' => FALSE,
                    'message' => __('message.something_went_wrong')
                ]
            );
        }
    }
}
