@extends('adminlte::page')

@section('title', 'chat')

@section('content_header')

    <h1>Chat conversation</h1>
    <!-- <link href="{{ asset('css/style.css') }}" rel="stylesheet" /> -->
@stop

@section('content')
        <div class="row">
            <div class="col-md-4 col-4 col-sm-3">
                <div class="" style="position:relative; height: 80vh; cursor:pointer; backgroung:#222d32; overflow-x: auto;
    overflow-y: auto;">
                    <ul class="contacts-list" id="listItemChat">
                                                
                    </ul>
                </div>
            </div>
            <div class="col-md-8 pl-0">
                <div id="chatPanel" style="display: none;">
                    <div class="box box-success direct-chat direct-chat-success">
                    <div class="box-header with-border">
                    <h3 class="box-title">Direct Chat</h3>

                    <div class="box-tools pull-right">
                        <!-- <span data-toggle="tooltip" title="" class="badge bg-green" data-original-title="3 New Messages">3</span> -->
                        <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="" data-widget="chat-pane-toggle" data-original-title="Contacts">
                        <i class="fa fa-comments"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button> -->
                    </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                    <!-- Conversations are loaded here -->
                    <div class="direct-chat-messages" id="messagesList" style="height: 60vh;">
                        
                    </div>

                    </div>
                    </div>
                    <div class="box-footer">
                        <div class="input-group">
                            <input id="textMessage" type="text" placeholder="Type here" class="form-control form-rounded">
                            <span class="input-group-btn">
                            <button type="button" onclick="sendMessage()" class="btn btn-success btn-flat">Send</button>
                          </span>
                        </div>                        
                    </div>
                </div>
                <div id="divStart" class="text-center">
                    <i class="fas fa-comments"></i>
                    <h3>Select your friend from list to start chat</h3>
                </div>
            </div>
        <div>
{{-- <div class="container" style="margin-top: 50px;">

    <h4 class="text-center">Converation list</h4><br>
    <table class="table table-bordered">
        <tr>
            <th>List of Users</th>
            <th class="text-center">Action</th>
        </tr>
        <tbody id="tbody">
        @foreach($messages as $index => $message)
        <tr>
        <td>{{$message['fullName']}}</td>
        <td><a href="{{ url('conversation/'.$index) }}" class="btn btn-info">View Conservation</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div> --}}
<script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.10.1/firebase.js"></script>
<script>
    //Initialize Firebase
    var config = {
        apiKey: "{{ config('services.firebase.api_key') }}",
        authDomain: "{{ config('services.firebase.auth_domain') }}",
        databaseURL: "{{ config('services.firebase.database_url') }}",
        storageBucket: "{{ config('services.firebase.storage_bucket') }}",
    };
    firebase.initializeApp(config);
    var database = firebase.database();
    var lastIndex = 0;
    var title = '';
    var currKey = '';
    var currName = '';
    var i = 0;
    // Get Data
    firebase.database().ref('users/').on('value', function (snapshot) {
        var value = snapshot.val();
        var htmls = [];
        // if(snapshot.hasChildren()){
        //     htmls.push('<li class="list-group-item"><input type="text" placeholder="Search or Start new chat" class="form-control form-rounded"></li>');
        // }
        $.each(value, function (index, value) {                                     
            if (value) {                                
                var badge_msg = '';
                // var mostViewedPosts = gotUserData(index);
                //console.log(mostViewedPosts);
                // adaURL.then(function(snapshot) { 
                //     mostViewedPosts = snapshot.val();
                    //badge_msg = ((mostViewedPosts > 0) ? '<span data-toggle="tooltip" title="" class="badge bg-green" data-original-title="'+mostViewedPosts+'">'+mostViewedPosts+'</span>':"");                      
                //     }.bind(this));
               
                htmls.push('<li id="'+value.id+'" class="list-group-item list-group-item-action" onclick="LoadChatMessages('+i+')">\
                <input type="hidden" id="key_val_'+ i+'" value="'+value.id+'" >\
                <input type="hidden" id="key_name_'+ i+'" value="'+value.fullName+'" >\
                <div class="contacts-list-info">\
                    <span class="contacts-list-name" style="color:#999;">'+value.fullName+' '+badge_msg+'</span>\
                    <span class="contacts-list-msg">'+value.email+'</span>\
                </div>\
            </li>');
            }
            i++;
            lastIndex = index;
        });
        $('#listItemChat').html(htmls);
        $("#submitUser").removeClass('desabled');
    });  
    // function gotUserData(userId){          
    //     firebase.database().ref('/messageCount/' + userId + '/ReceivedCount').once('value').then(function(snapshot) { 
    //         return snapshot.val();
    //     })
    // }
    function LoadChatMessages(val) { 
        jQuery($('.list-group-item')).removeClass('active');
        if(val != "welcome"){ 
        var key = document.getElementById('key_val_'+val).value; 
        var name = document.getElementById('key_name_'+val).value; 
        //document.getElementById('chat_user').innerHTML = '<h2>'+name+'</h2>';  
        }
        document.getElementById('chatPanel').removeAttribute('style');
        document.getElementById('divStart').setAttribute('style', 'display: none'); 
        currKey = key; 
        currName = name;   
        // firebase.database().ref('/messageCount/' + key).once('value').then(function(snapshot) { 
        //         if(snapshot.val().sendBy == 'User'){               
        //             firebase.database().ref('messageCount').child(key).set({'ReceivedCount':0, 'sendBy': 'Admin', 'username': name}).then().catch();          
        //         }
        //     }); 
        // firebase.database().ref('messageCount').child(key).set({'ReceivedCount': 0, 'sendBy': 'Admin', 'username': name}).then().catch();
        firebase.database().ref('messages/'+key).on('value', function(snapshot) {
                var value = snapshot.val();      
                var msgList = [];  
                if(snapshot.hasChildren()){       
                $.each(value, function (index, value) {                      
                    var theDate = new Date(value.createdAt);
                    var dateString = theDate.toLocaleDateString() +' '+ theDate.toLocaleTimeString();
                    if (value) {
                    if(value.sendBy === "User") {
                        msgList.push('<div class="direct-chat-msg">\
                      <div class="direct-chat-info clearfix">\
                        <span class="direct-chat-name pull-left">'+ value.userName +'</span>\
                        <span class="direct-chat-timestamp pull-right">'+ dateString +'</span>\
                      </div>\
                      <div class="direct-chat-text">'+ value.message +'</div>\
                    </div>');                        
                    } else {
                        msgList.push('<div class="direct-chat-msg right">\
                      <div class="direct-chat-info clearfix">\
                        <span class="direct-chat-name pull-right">Admin</span>\
                        <span class="direct-chat-timestamp pull-left">'+ dateString +'</span>\
                      </div>\
                      <div class="direct-chat-text">'+ value.message + '</div>\
                    </div>');
                    }
                } 
                });
                } else {
                    msgList.push('<div class="text-center">\
                            <div>\
                                <p>Sorry, No chat history\
                                </p>\
                            </div>\
                            </div>');
                }
                $('#messagesList').html(msgList);
                //document.getElementById(currKey).addclass('active');
                jQuery($('#'+currKey)).addClass('active');   
                document.getElementById('messagesList').scrollTo(0, document.getElementById('messagesList').clientHeight);
            })            
    }  
    function sendMessage(){
        //alert(currKey);
        var msg = document.getElementById('textMessage').value;
        if(msg){ 
            // firebase.database().ref('/messageCount/' + currKey).once('value').then(function(snapshot) { 
            //     if(snapshot.val().sendBy == 'Admin'){               
            //         var mostViewedPosts = snapshot.val().ReceivedCount;
            //         firebase.database().ref('messageCount').child(currKey).set({'ReceivedCount': mostViewedPosts+1, 'sendBy': 'Admin', 'username': 'Admin'}).then().catch();          
            //     }
            // });                       
          
            firebase.database().ref('messages/' + currKey).push({
                message: msg,
                sendBy: "Admin",
                userName: currName, 
                msgStatus: false,           
                createdAt: Date.now()
            });  
            document.getElementById('textMessage').value = '';
            document.getElementById('textMessage').focus();            
            document.getElementById('messagesList').html().scrollTo(0, $('#messagesList')[0].scrollHeight);
            $('#messagesList').html().fadeIn().delay(1000);
        } else {
            alert("Please write something to send");
        }
        firebase.database().ref('messages/'+currKey).on('value', function(snapshot) {
                var value = snapshot.val();      
                var msgList = [];  
                $.each(value, function (index, value) {  
                    var theDate = new Date(value.createdAt);
                    var dateString = theDate.toLocaleDateString() +' '+ theDate.toLocaleTimeString();
                    if (value) {
                    if(value.sendBy === "User") {
                        msgList.push('<div class="row">\
                            <div class="col-2 col-sm-1 col-md-1">\
                            </div>\
                            <div class="col-6 col-sm-7 col-md-7">\
                                <p class="receive">'+ value.message + '\
                                    <span class="time float-right">'+ dateString +'</span>\
                                </p>\
                            </div>\
                        </div>');                        
                    } else {
                        msgList.push('<div class="row justify-content-end">\
                            <div class="col-6 col-sm-7 col-md-7">\
                                <p class="sent float-right">'+ value.message + '\
                                    <span class="time float-right">'+ dateString +'</span>\
                                </p>\
                            </div>\
                            <div class="col-2 col-sm-1 col-md-1">\
                            </div>\
                            </div>');
                    }
                } 
                });                
                $('#messagesList').html(msgList);
    });
}
    // Update Data
    var updateID = 0;
    $('body').on('click', '.updateData', function () {
        updateID = $(this).attr('data-id');
        firebase.database().ref('messages/' + updateID).on('value', function (snapshot) {
            var values = snapshot.val();
            var updateData = '<div class="form-group">\
		        <label for="first_name" class="col-md-12 col-form-label">Name</label>\
		        <div class="col-md-12">\
		            <input id="first_name" type="text" class="form-control" name="fullName" value="' + values.id + '" required autofocus>\
		        </div>\
		    </div>\
		    <div class="form-group">\
		        <label for="category" class="col-md-12 col-form-label">Category</label>\
		        <div class="col-md-12">\
		            <input id="category" type="text" class="form-control" name="category" value="' + values.title + '" required autofocus>\
		        </div>\
		    </div>';
            $('#updateBody').html(updateData);
        });
    });
    $('.updateCustomer').on('click', function () {
        var values = $(".users-update-record-model").serializeArray();
        var postData = {
            id: values[0].value,
            title: values[1].value,
        };
        var updates = {};
        updates['/messages/"' + updateID + '"'] = postData;
        firebase.database().ref().update(updates);
        $("#update-modal").modal('hide');
    });
    // Remove Data
    $("body").on('click', '.removeData', function () {
        var id = $(this).attr('data-id');
        $('body').find('.users-remove-record-model').append('<input name="id" type="hidden" value="' + id + '">');
    });
    $('.deleteRecord').on('click', function () {
        var values = $(".users-remove-record-model").serializeArray();
        var id = values[0].value;
        firebase.database().ref('messages/"' + id + '"').remove();
        $('body').find('.users-remove-record-model').find("input").remove();
        $("#remove-modal").modal('hide');
    });
    $('.remove-data-from-delete-form').click(function () {
        $('body').find('.users-remove-record-model').find("input").remove();
    });
</script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

@stop