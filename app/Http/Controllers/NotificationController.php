<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class NotificationController extends Controller
{
    //
    public function getNotificationsById($notifiable_id){
        
        $user = User::find($notifiable_id);
        return $user->notifications;
    }


    public function markAsRead(Request $request){

        $request->validate([
            'notification_id' => 'required'
        ]);

        $user = User::find(Auth::user()->user_id);

        foreach ($user->notifications as $notification) {
            if($notification->id == $request->input('notification_id')){

                $notification->markAsRead();

                return $notification;
            }
        }

    }

    public function deleteNotificationById(Request $request){

        $request->validate([
            'notification_id' => 'required'
        ]);

        $user = User::find(Auth::user()->user_id);

        foreach ($user->notifications as $notification) {
            if($notification->id == $request->input('notification_id')){
                $notification->delete();
            }
        }
    }


}


