<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function create(Request $request){
        $validated = $request->validate([
            'title'=>'required|string|max:255',
            'description'=>'nullable|string',
            'location'=>'required|string',
            'date'=>'required|date',
           'price'=>'required|numeric',
           'image'=>'nullable',
        ]);
        $event = Event::create($validated);
        return response()->json(['msg'=>'created Successfully',
            'event' =>$event ]);
    }
    public function read(){
        $events = Event::all();
        return response()->json($events);
    }
    public function show($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['msg' => 'Event not found'], 404);
        }
        return response()->json($event);
    }
    public function update(Request $request)
    {
        $validated = $request->validate([
            'title'=>'required|string|max:255',
            'description'=>'nullable|string',
            'location'=>'required|string',
            'date'=>'required|date',
            'price'=>'required|numeric',
            'image'=>'nullable',
            ]);
        $events = Event::where("id",$request->id)->update($validated);
        return response()->json(['msg'=>'Updated Successfully']);
    }
    public function delete(Request $request)
    {
        $events = Event::where('id',$request->id)->first();
        $events->delete();
        return response()->json(['msg'=>'Deleted Successfully']);
    }

}
