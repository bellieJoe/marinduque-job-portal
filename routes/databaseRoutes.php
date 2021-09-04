<?php

use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::prefix('DBAPI')->group(function(){
    Route::prefix('notification')->group(function(){
    
        /* 
        @method get
        @desc get notifications by notifiable id
        @url /DBAPI/notification/getNotificationsById/{notifiable_id}
        */
        Route::get('/getNotificationsById/{notifiable_id}', [NotificationController::class , 'getNotificationsById'])->middleware('auth');

        /* 
        @method post
        @desc get mark notification as read by id
        @url /DBAPI/notification/markAsRead/{notifiable_id}
        */
        Route::post('markAsRead', [NotificationController::class, 'markAsRead']);

        /* 
        @method delete
        @desc get mark notification as read by id
        @url /DBAPI/notification/delete
        */
        Route::delete('deleteNotificationById', [NotificationController::class, 'deleteNotificationById']);
    });
    // end of notificaation prefix
});
 

?>