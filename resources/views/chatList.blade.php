@extends('layouts.login')

@section('content')
    <div class="container-fluid bg-wight chatbox rounded">
        <div class="row h-100">
            <div class="col-md-4 pr-0">
                <div class="card">
                    <div class="card-header">
                            <div class="col-md-7">
                            </div>
                            <div class="col-md-5">
                                </div>
                        <ul class="list-group list-group-flush" id="listItemChat">
                                                    
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8 pl-0">
                <div id="chatPanel" class="card" style="display: none;">
                    <div class="card-header">
                            <div class="col-md-2"></div>
                            <div class="col-md-6">
                                    <div id="chat_user" class="name"></div>
                                    <div class="under-name"></div>
                            </div>
                            <div class="col-md-4"></div>
                    </div>
                    <div class="card-body" id="messagesList">
                        
                    </div>
                    <div class="card-footer">
                        <div class="col-md-1"></div>
                        <div class="col-md-9">
                            <input id="textMessage" type="text" placeholder="Type here" class="form-control form-rounded">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" onclick="sendMessage()" class="btn btn-primary">send</button>
                        </div>
                    </div>
                </div>
                <div id="divStart" class="text-center">
                    <i class="fas fa-comments"></i>
                    <h3>Select your friend from list to start chat</h3>
                </div>
            </div>
        <div>
    </div>
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
    // Initialize Firebase
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
        if(snapshot.hasChildren()){
            htmls.push('<li class="list-group-item"><input type="text" placeholder="Search or Start new chat" class="form-control form-rounded"></li>');
        }
        $.each(value, function (index, value) {
            if (value) {
                htmls.push('<li id="'+value.id+'" class="list-group-item list-group-item-action" onclick="LoadChatMessages('+i+')">\
                            <input type="hidden" id="key_val_'+ i+'" value="'+value.id+'" >\
                            <input type="hidden" id="key_name_'+ i+'" value="'+value.fullName+'" >\
                            <div class="row">\
                                <div class="col-md-2">\
                                </div>\
                                <div class="col-md-10" style="cursor: pointer;">\
                                    <div class="name">'+value.fullName+'</div>\
                                    <div class="under-name">'+value.email+'</div>\
                                </div>\
                            </div>\
                        </li>');
            }
            i++;
            lastIndex = index;
        });
        $('#listItemChat').html(htmls);
        $("#submitUser").removeClass('desabled');
    });  
    function LoadChatMessages(val) { 
        if(val != "welcome"){ 
        var key = document.getElementById('key_val_'+val).value; 
        var name = document.getElementById('key_name_'+val).value; 
        document.getElementById('chat_user').innerHTML = '<h2>'+name+'</h2>';  
        }
        document.getElementById('chatPanel').removeAttribute('style');
        document.getElementById('divStart').setAttribute('style', 'display: none'); 
        currKey = key; 
        currName = name;       
        firebase.database().ref('messages/'+key).on('value', function(snapshot) {;
                var value = snapshot.val();      
                var msgList = [];  
                if(snapshot.hasChildren()){       
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
                } else {
                    msgList.push('<div class="text-center">\
                            <div>\
                                <p>Sorry, No chat history\
                                </p>\
                            </div>\
                            </div>');
                }
                $('#messagesList').html(msgList);
                document.getElementById('messagesList').scrollTo(0, document.getElementById('messagesList').clientHeight);
            })            
    }  
    function sendMessage(){
        //alert(currKey);
        var msg = document.getElementById('textMessage').value;
        if(msg){
            firebase.database().ref('messages/' + currKey).push({
                message: msg,
                sendBy: "Admin",
                userName: currName, 
                msgStatus: false,           
                createdAt: Date.now()
            });
            document.getElementById('textMessage').value = '';
            document.getElementById('textMessage').focus();
            document.getElementById('messagesList').scrollTo(0, document.getElementById('messagesList').clientHeight);
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

@endsection