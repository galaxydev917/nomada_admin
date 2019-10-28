@extends('adminlte::page')

@section('title', 'Category')

@section('content_header')

    <h1>List of Categories</h1>

@stop

@section('content')
        <!-- <h5># Add Menu</h5> -->
    <!-- <div class="card card-default">
        <div class="card-body">
            <form id="addCustomer" class="form-inline" method="POST" action="">
                <div class="form-group mb-2">
                    <label for="name" class="sr-only">Name</label>
                    <input id="name" type="text" class="form-control" name="name" placeholder="Name"
                           required autofocus>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="catgory" class="sr-only">Category</label>
                    <select id="category" class="form-control" name="category" required autofocus>                    
                    </select>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="description" class="sr-only">Description</label>
                    <textarea id="description" type="text" class="form-control" name="description" placeholder="desciption"
                           required autofocus></textarea>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="price" class="sr-only">price</label>
                    <input id="price" type="text" class="form-control" name="price" placeholder="price"
                           required autofocus>
                </div>
                <button id="submitCustomer" type="button" class="btn btn-primary mb-2">Submit</button>
            </form>
        </div>
    </div> -->

    <table class="table table-bordered">
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th class="text-center">Action</th>
        </tr>
        <tbody id="tbody">
        @foreach($categories as $index => $category)
        <tr>
        <td>{{$category['id']}}</td>
        <td>{{$category['title']}}</td>
        <td><button data-toggle="modal" data-target="#update-modal-cat" class="btn btn-info updateCatgory" data-id="{{ $index }}">Update</button>
         		 <a class="btn btn-success" href="{{ url('menu/'.$index) }}" data-id="{{ $index }}">Show Menu</a></td></td>
        </tr>
        @endforeach
        </tbody>
    </table>
    
<!-- Update Model -->
<form action="" method="POST" class="category-update-record-model form-horizontal">
    <div id="update-modal-cat" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="width:55%;">
            <div class="modal-content" style="overflow: hidden;">
                <div class="modal-header">
                    <h4 class="modal-title" id="custom-width-modalLabel">Update</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body" id="updateCatBody">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"
                            data-dismiss="modal">Close
                    </button>
                    <button type="button" class="btn btn-success updateCategory">Update
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Delete Model -->
<!-- <form action="" method="POST" class="users-remove-record-model">
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
</form> -->


{{--Firebase Tasks--}}
{{-- <script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.10.1/firebase.js"></script> --}}
<script>
    // Initialize Firebase
    // var config = {
    //     apiKey: "{{ config('services.firebase.api_key') }}",
    //     authDomain: "{{ config('services.firebase.auth_domain') }}",
    //     databaseURL: "{{ config('services.firebase.database_url') }}",
    //     storageBucket: "{{ config('services.firebase.storage_bucket') }}",
    // };
    // firebase.initializeApp(config);
    var database = firebase.database();
    var lastIndex = 0;
    var title = '';
    // Get Data
    // firebase.database().ref('category/').on('value', function (snapshot) {
    //     var value = snapshot.val();
    //     var htmls = [];
    //     $.each(value, function (index, value) {
    //         if (value) {
    //             htmls.push('<tr>\
    //     		<td>' + value.id + '</td>\
    //             <td>' + value.title + '</td>\
    //     		<td><button data-toggle="modal" data-target="#update-modal-cat" class="btn btn-info updateCatgory" data-id="' + index + '">Update</button>\
    //     		 <button class="btn btn-danger" href="http://localhost:8000/menu/' + index + '" data-id="' + index + '">Show Menu</button></td>\
    //     	</tr>');
    //         }
    //         lastIndex = index;
    //     });
    //     //$('#tbody').html(htmls);
    //     $("#submitUser").removeClass('desabled');
    // });
    // Add Data
    // $('#submitCustomer').on('click', function () {
    //     var values = $("#addCustomer").serializeArray();
    //     var id = values[0].value;
    //     var title = values[1].value;
    //     var userID = lastIndex + 1;
    //     console.log(values);
    //     firebase.database().ref('category/' + userID).set({
    //         name: name,
    //         category: category,
    //         description: description,
    //         price: price
    //     });
    //     // Reassign lastID value
    //     lastIndex = userID;
    //     $("#addCustomer input").val("");
    // });
    // Update Data
    var updateID = 0;
    $('body').on('click', '.updateCatgory', function () {
        updateID = $(this).attr('data-id');
        firebase.database().ref('category/' + updateID).on('value', function (snapshot) {
            var values = snapshot.val();
            var updateData_category = '<div class="form-group">\
                <input type="hidden" id="Cat_id" value="'+ updateID+'">\
		        <label for="first_name" class="col-md-12 col-form-label">Name</label>\
		        <div class="col-md-12">\
		            <input id="first_name" type="text" class="form-control" name="id" value="' + values.id + '" required autofocus>\
		        </div>\
		    </div>\
		    <div class="form-group">\
		        <label for="category" class="col-md-12 col-form-label">Category</label>\
		        <div class="col-md-12">\
		            <input id="category" type="text" class="form-control" name="title" value="' + values.title + '" required autofocus>\
		        </div>\
		    </div>';
            $('#updateCatBody').html(updateData_category);
        });
    });
    $('.updateCategory').on('click', function () {
        var values = $(".category-update-record-model").serializeArray();
        var CatupdateID = $('#Cat_id').val();
        var postData = {
            id: values[0].value,
            title: values[1].value,
        };
        var updates = {};
        console.log(updates);
        updates['/category/' + CatupdateID] = postData;
        firebase.database().ref().update(updates);
        location.reload();
        $("#update-modal-cat").modal('hide');
    });
    // Remove Data
    $("body").on('click', '.removeData', function () {
        var id = $(this).attr('data-id');
        $('body').find('.users-remove-record-model').append('<input name="id" type="hidden" value="' + id + '">');
    });
    $('.deleteRecord').on('click', function () {
        var values = $(".users-remove-record-model").serializeArray();
        var id = values[0].value;
        firebase.database().ref('category/' + id).remove();
        $('body').find('.users-remove-record-model').find("input").remove();
        $("#remove-modal").modal('hide');
    });
    $('.remove-data-from-delete-form').click(function () {
        $('body').find('.users-remove-record-model').find("input").remove();
    });
</script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

@stop
