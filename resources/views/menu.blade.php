@extends('layouts.login')

@section('content')

<div class="container" style="margin-top: 50px;">

    <h4 class="text-center">Nomada Menu</h4><br>

    <h5># Add Menu</h5>
    <div class="card-default">
        <div class="card-body">
            <img src="{{URL::asset('/images/spinner.gif')}}" id="gif" style="display: block; margin: 0 auto; width: 100px; visibility: hidden;">
            <form id="addCustomer" class="form-inline" method="POST" action="" enctype="multipart/form-data">
                <div class="form-group bmd-form-group col-md-2">
                    <label class="bmd-label-floating"></label>
                    <input id="name" type="text" class="form-control" name="name" placeholder="Name"
                           required autofocus>
                </div>
                <div class="form-group bmd-form-group mx-sm-3 col-md-2">
                    <label class="bmd-label-floating"></label>
                    <textarea id="description" type="text" class="form-control" name="description" placeholder="desciption"
                           required autofocus></textarea>
                </div>
                <div class="form-group bmd-form-group mx-sm-3 col-md-2">
                    <label class="bmd-label-floating"></label>
                    <input id="price" type="text" class="form-control" name="price" placeholder="price"
                           required autofocus>
                </div>
                <div class="form-group bmd-form-group mx-sm-3 col-md-2">
                    <label class="bmd-label-floating">Picture</label>
                    <input type="file" id="image" accept="menu/*">
                </div>
                <input id="category" type="hidden" class="form-control" name="category" value ="{{$id}}">
                <button id="submitCustomer" type="button" class="btn btn-primary col-md-2">Submit</button>
            </form>
        </div>
    </div>

    <br>

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
</div>

<!-- Update Model -->
<form action="" method="POST" class="users-update-record-model form-horizontal">
    <div id="update-modal" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="width:55%;">
            <div class="modal-content" style="overflow: hidden;">
                <div class="modal-header">
                    <h4 class="modal-title" id="custom-width-modalLabel">Update</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body" id="updateBody">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"
                            data-dismiss="modal">Close
                    </button>
                    <button type="button" class="btn btn-success updateCustomer">Update
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Delete Model -->
<form action="" method="POST" class="users-remove-record-model">
    <div id="remove-modal" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel"
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
    // Get Data
    firebase.database().ref('menu/').orderByChild('category').equalTo('{{$id}}').on('value', function (snapshot) {
        var value = snapshot.val();
        var htmls = [];
        $.each(value, function (index, value) {
            if (value) {
                htmls.push('<tr>\
        		<td>' + value.name + '</td>\
                <td>' + value.description + '</td>\
                <td>' + value.price + '</td>\
        		<td><button data-toggle="modal" data-target="#update-modal" class="btn btn-info updateData" data-id="' + index + '">Update</button>\
        		<button data-toggle="modal" data-target="#remove-modal" class="btn btn-danger removeData" data-id="' + index + '">Delete</button></td>\
        	</tr>');
            }
            lastIndex = index;
        });
        $('#tbody').html(htmls);
        $("#submitUser").removeClass('desabled');
    });
    // Add Data
    $('#submitCustomer').on('click', function () {
        var values = $("#addCustomer").serializeArray();
        if(values[0].value && values[1].value && values[2].value && values[3].value){
            $('#gif').css('visibility', 'visible');
        }
        var name = values[0].value;
        var description = values[1].value;
        var price = values[2].value;
        var category = (values[3].value) ? values[3].value :{{$id}}; 
        var userID = lastIndex + 1;
        var image=document.getElementById("image").files[0];
        //now get your image name
        var imageName=image.name;
        //firebase  storage reference
        //it is the path where yyour image will store
        var storageRef=firebase.storage().ref('menu/'+imageName);
        //upload image to selected storage reference

        var uploadTask=storageRef.put(image);

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
                firebase.database().ref('menu').push({
                    name: name,
                    category: category,
                    description: description,
                    price: price,
                    available: true,
                    category: category,
                    image: downlaodURL
                });
                $('#gif').css('visibility', 'hidden');
            });
        });               
        // Reassign lastID value
        lastIndex = userID;
        $("#addCustomer input").val("");
        $("#description").val("");
    });
    // Update Data
    var updateID = 0;
    $('body').on('click', '.updateData', function () {
        updateID = $(this).attr('data-id');
        firebase.database().ref('menu/' + updateID).on('value', function (snapshot) {
            var values = snapshot.val();
            var updateData = '<div class="form-group">\
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
            <div class="form-group">\
		        <label for="pic" class="col-md-12 col-form-label">Picture</label>\
		        <div class="col-md-12">\
		            <input id="image" type="file" class="form-control" name="pic"><img src="' + values.image + '" width=100 height=100>\
		        </div>\
		    </div>\
            <input id="category" type="hidden" class="form-control" name="category" value="' + values.category + '">';
            $('#updateBody').html(updateData);
        });
    });
    $('.updateCustomer').on('click', function () {
        var values = $(".users-update-record-model").serializeArray(); 
        updateID = $(this).attr('data-id');       
        var postData = {
            name: values[0].value,
            description: values[1].value,
            price: values[2].value,
            category: values[4].value,
            available: true,
            image: values[3].value,
            };
        var updates = {};
        updates['/menu/' + updateID] = postData;
        firebase.database().ref().update(updates);
        var image=document.getElementById("image").files[0];
        //now get your image name
        var imageName=image.name;
        //firebase  storage reference
        //it is the path where yyour image will store
        var storageRef=firebase.storage().ref('menu/'+imageName);
        //upload image to selected storage reference

        var uploadTask=storageRef.put(image);

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
                    category: values[4].value,
                    available: true,
                    image: downlaodURL,
                    };
                var updates = {};
                updates['/menu/' + updateID] = postData;
                firebase.database().ref().update(updates);
            });
        });    
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
        firebase.database().ref('menu/' + id).remove();
        $('body').find('.users-remove-record-model').find("input").remove();
        $("#remove-modal").modal('hide');
    });
    $('.remove-data-from-delete-form').click(function () {
        $('body').find('.users-remove-record-model').find("input").remove();
    });
</script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

@endsection