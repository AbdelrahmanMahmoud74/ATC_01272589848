<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function bookEvent($event_id){
        $user = auth()->user();
        $event = Event::find($event_id);
        if(!$event){
            return response()->json(['msg'=>'event not found'],404);
        }
        $booked = Booking::where('user_id',$user->id)
            ->where('event_id',$event_id)
            ->exists();
        if($booked){
            return response()->json(['msg'=>'event already booked'],409);
        }
        Booking::create([
            'user_id'=>$user->id,
            'event_id'=>$event_id,
        ]);
        return response()->json(['msg'=>'event booked successfully']);
    }
    public function mybookings(){
        $user = auth()->user();
        $bookings = Booking::with('event')
            ->where('user_id',$user->id)
            ->get();
        return response()->json($bookings);
    }
}
