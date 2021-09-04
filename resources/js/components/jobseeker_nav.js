import $ from "jquery"

import Echo from 'laravel-echo'

require('../bootstrap')

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});


const User = JSON.parse($('#User').val())

new Vue({
    el: '#jobseeker_nav',
    data: {
        unreadNotificationsCount: 0,
        notifications: null,
        hoveredNotif: null,
        notificationCount : 0,
        notificationToggle : false
    },
    methods: {

        redirectRoute(route){
            location.href = route
        },

        toggleNotification(){
            if(this.notificationToggle){
                this.notificationToggle = false
            }else{
                this.notificationToggle = true
            }
        },

        async getNotificationsById(){

            try {
                let notifications = await $.ajax({
                    url: `/DBAPI/notification/getNotificationsById/${User.user_id}`,
                    method: "GET",
                })

                this.notifications = notifications
                this.countNewNotification()
                this.cleanDates()
            } catch (error) {
                console.log(error)
            }
        },

        cleanDates(){
            let notifications = this.notifications
            let newNotifications = []
            notifications.map((val, i) =>{
                let item = val
                let created_at_formatted = moment(val.created_at).format('MMMM DD Y')
                
    
                item.created_at_formatted = created_at_formatted
                newNotifications.push(item)
                
            })

            this.notifications = newNotifications
        },

        setHoveredNotif(id){
            this.hoveredNotif = id
        },

        async  markAsRead(notification_id){
            try {
                
                let notification = await $.ajax({
                    url: '/DBAPI/notification/markAsRead',
                    method: 'POST',
                    data: {
                        notification_id : notification_id
                    }
                })

                // console.log(notification)
                
                this.notifications.map((val, i)=>{
                    if(val.id == notification.id){
                        this.notifications[i].read_at = notification.read_at
                    }
                    
                })

                this.countNewNotification()

            } catch (error) {
                console.log(error)
            }
        },

        async deleteNotificationById(notification_id){

            try {
                
                await $.ajax({
                    url: '/DBAPI/notification/deleteNotificationById',
                    method: "DELETE",
                    data: {
                        notification_id: notification_id
                    }
                })
                

                this.getNotificationsById()

                

            } catch (error) {
                console.log(error)
            }
        },

        getIndexOfNotification(notification_id){
            this.notifications.map((val, i)=>{
                if(this.notification_id == val.id){
                    return i;
                }
            })
        },

        countNewNotification(){
            this.notificationCount = 0
            if(this.notifications.length != 0){
                this.notifications.map((val, i)=>{

                    if(!val.read_at){
                        this.notificationCount++
                    }
                    
                })
            }
            
        }

        
    },
    mounted() {
        this.getNotificationsById()


        try {
            window.Echo.private(`App.Models.User.${User.user_id}`)
            .notification((notification)=>{
                console.log(notification)
                this.getNotificationsById()
            })
        } catch (error) {
            console.log(error)
        }
        
    },
})
