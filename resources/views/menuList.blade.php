@extends('adminlte::page')

@section('title', 'menu_list')

@section('content_header')

    <h1>List of Menu</h1>

@stop

@section('content')

    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th width="180" class="text-center">Action</th>
        </tr>
        <tbody id="tbody">

        </tbody>
    </table>

<!-- Update Model -->
<div id="update-modal-menu" data-backdrop="static" data-keyboard="false" class="modal fade" role="dialog" aria-labelledby="custom-width-modalLabel"
        aria-hidden="true">
    <form action="" method="POST" class="menu-update-record-model form-horizontal" enctype="multipart/form-data">
    <div class="modal-dialog modal-dialog-centered" style="width:55%;">
        <div class="modal-content" style="overflow: hidden;">
            <div class="modal-header">
                <h4 class="modal-title" id="custom-width-modalLabel">Update</h4>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body" id="updateMenuBody">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light"
                        data-dismiss="modal">Close
                </button>
                <button type="button" class="btn btn-success updateMenu">Update
                </button>
            </div>
        </div>
    </div>
    </form>
</div>

<!-- Delete Model -->
<form action="" method="POST" class="menu-remove-record-model">
    <div id="remove-modal" data-backdrop="static" data-keyboard="false" class="modal fade" role="dialog" aria-labelledby="custom-width-modalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" style="width:55%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="custom-width-modalLabel">Delete</h4>
                    <button type="button" class="close remove-data-from-delete-form" data-dismiss="modal"
                            aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <p>Do you want to delete this record?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form"
                            data-dismiss="modal">Close
                    </button>
                    <button type="button" class="btn btn-danger waves-effect waves-light deleteRecord">Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>


{{--Firebase Tasks--}}
<script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.10.1/firebase.js"></script>
<script>
    Initialize Firebase
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
    // Get Data
    firebase.database().ref('menu/').on('value', function (snapshot) {
        var value = snapshot.val();
        var htmls = [];
        $.each(value, function (index, value) {
            if (value) {
                htmls.push('<tr>\
        		<td>' + value.name + '</td>\
                <td>' + value.description + '</td>\
                <td>' + value.price + '</td>\
        		<td><button data-toggle="modal" data-target="#update-modal-menu" class="btn btn-info updateData_menu" data-id="' + index + '">Update</button>\
        		<button data-toggle="modal" data-target="#remove-modal" class="btn btn-danger removeData_menu" data-id="' + index + '">Delete</button></td>\
        	</tr>');
            }
            lastIndex = index;
        });
        $('#tbody').html(htmls);
        $("#submitUser").removeClass('desabled');
    });
   
    // Update Data
    var updateID = 0;
    $('body').on('click', '.updateData_menu', function () {
        updateID = $(this).attr('data-id');
        firebase.database().ref('menu/' + updateID).on('value', function (snapshot) {
            var values = snapshot.val();
            var updateData_menu_data = '<div class="form-group">\
                <input type="hidden" id="Menu_id" value="'+ updateID+'">\
		        <label for="name" class="col-md-12 col-form-label">Name</label>\
		        <div class="col-md-12">\
		            <input id="name" type="text" class="form-control" name="name" value="' + values.name + '" required autofocus>\
		        </div>\
		    </div>\
            <div class="form-group">\
		        <label for="description" class="col-md-12 col-form-label">Description</label>\
		        <div class="col-md-12">\
		            <input id="description" type="text" class="form-control" name="description" value="' + values.description + '" required autofocus>\
		        </div>\
		    </div>\
            <div class="form-group">\
		        <label for="price" class="col-md-12 col-form-label">Price</label>\
		        <div class="col-md-12">\
		            <input id="price" type="text" class="form-control" name="price" value="' + values.price + '" required autofocus>\
		        </div>\
		    </div>\
            <input id="category" type="hidden" class="form-control" name="category" value="' + values.category + '">\
            <div class="form-group">\
		        <label for="image" class="col-md-12 col-form-label">Picture</label>\
		        <div class="col-md-12">\
                <input type="hidden" name="image" value="' + values.image + '">\
                <input type="file" id="uploadImage" accept="menu/*"><img id="selected_img" src="' + values.image + '" width=100 height=100>\
		        </div>\
		    </div>';
            $('#updateMenuBody').html(updateData_menu_data);
        });
    });
    $('.updateMenu').on('click', function () {
        var values = $(".menu-update-record-model").serializeArray(); 
        console.log(values);
        var MenuID = $('#Menu_id').val();
        var img = $('#selected_img').val();       
        var postData = {
            name: values[0].value,
            description: values[1].value,
            price: values[2].value,
            category: values[3].value,
            available: true,
            image: ((values[4].value) ? values[4].value : ''),            
            };
        var updates = {};
        updates['/menu/' + MenuID] = postData;
        firebase.database().ref().update(updates);
        var uploadImage=document.getElementById("uploadImage").files[0];
        if(uploadImage){
        //now get your image name
        var imageName=uploadImage.name;
        //firebase  storage reference
        //it is the path where yyour image will store
        var storageRef=firebase.storage().ref('menu/'+imageName);
        //upload image to selected storage reference
        var uploadTask=storageRef.put(uploadImage);
        uploadTask.on('state_changed',function (snapshot) {
            //observe state change events such as progress , pause ,resume
            //get task progress by including the number of bytes uploaded and total
            //number of bytes
            var progress=(snapshot.bytesTransferred/snapshot.totalBytes)*100;
            console.log("upload is " + progress +" done");
        },function (error) {
            //handle error here
            console.log(error.message);
        },function () {
        //handle successful uploads on complete

            uploadTask.snapshot.ref.getDownloadURL().then(function (downlaodURL) {
                //get your upload image url here...
                console.log(downlaodURL);
                var postData = {
                    name: values[0].value,
                    description: values[1].value,
                    price: values[2].value,
                    category: values[3].value,
                    available: true,
                    image: downlaodURL
                    };
                var updates = {};
                updates['/menu/' + MenuID] = postData;
                firebase.database().ref().update(updates);
            });
        });  
        }  
        $("[data-dismiss=modal]").trigger({ type: "click" });
        // location.reload();
        $("#update-modal-menu").modal('hide');
    });
    // Remove Data
    $("body").on('click', '.removeData_menu', function () {
        var id = $(this).attr('data-id');
        $('body').find('.menu-remove-record-model').append('<input name="id" type="hidden" value="' + id + '">');
    });
    $('.deleteRecord').on('click', function () {
        var values = $(".menu-remove-record-model").serializeArray();
        var id = values[0].value;
        firebase.database().ref('menu/' + id).remove();
        location.reload();
        $('body').find('.menu-remove-record-model').find("input").remove();
        $("#remove-modal").modal('hide');
    });
    $('.remove-data-from-delete-form').click(function () {
        $('body').find('.menu-remove-record-model').find("input").remove();
    });
</script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

@stop
