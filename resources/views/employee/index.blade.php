@extends('adminlte::page')

@section('title', 'employee')

@section('content_header')

    <h1>Delivery Guy
    <small class="box-tools pull-right">
    <button type="button" data-target="#insert-modal-employee" class="btn btn-success">Add New</button>
    </small>
    </h1>
@stop

@section('content')

    
    <div class="box">
<div class="box-body">
    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Status</th>
            <th width="180" class="text-center">Action</th>
        </tr>
        <tbody id="tbody">

        </tbody>
    </table>
</div>
</div>
<!-- Insert new record Model -->
<div id="insert-modal-employee" data-backdrop="static" data-keyboard="false" class="modal fade" role="dialog" aria-labelledby="custom-width-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="width:55%;">
        <div class="modal-content" style="overflow: hidden;">
            <div class="modal-header">
                <h4 class="modal-title" id="custom-width-modalLabel">Add New Delivery Guy</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
            <form id="addMenu" role="form" method="POST" action="">
                <div class="form-group">
                    <label class="bmd-label-floating">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Name" required autofocus>
                </div>
                <div class="form-group">
                    <label class="bmd-label-floating">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Email" required autofocus>
                </div>
                <div class="form-group">
                    <label class="bmd-label-floating">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password" required autofocus>
                </div>
                <div class="form-group">
                    <label class="bmd-label-floating">Phone</label>
                    <input type="number" class="form-control" name="phone" placeholder="Phone" required autofocus>
                </div>
                <div class="form-group">
                    <label class="bmd-label-floating">Status</label>
                    <input type="text" class="form-control" name="status" placeholder="Status" required autofocus>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                <button id="submitMenu" type="button" class="btn btn-success">Save</button>
            </div>
            </form>
        </div>
    </div>

</div>
<!-- Update Model -->
<div id="update-modal-employee" data-backdrop="static" data-keyboard="false" class="modal fade" role="dialog" aria-labelledby="custom-width-modalLabel"
        aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="width:55%;">
        <div class="modal-content" style="overflow: hidden;">
            <div class="modal-header">
                <h4 class="modal-title" id="custom-width-modalLabel">Update</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="" method="POST" class="employee-update-record-model form-horizontal">
            <div class="modal-body" id="updateEmployeeBody">

            </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-light"
                        data-dismiss="modal">Close
                </button>
                <button type="button" class="btn btn-success updateEmployee">Update
                </button>
            </div>
        </div>
    </div>
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
    // Get Data
    firebase.database().ref('employee/').on('value', function (snapshot) {
        var value = snapshot.val();
        var htmls = [];
        $.each(value, function (index, value) {
            if (value) {
                htmls.push('<tr>\
        		<td>' + value.name + '</td>\
                <td>' + value.email + '</td>\
                <td>' + value.phone + '</td>\
                <td>' + value.status + '</td>\
        		<td><button data-toggle="modal" data-target="#update-modal-employee" class="btn btn-info updateData_employee" data-id="' + index + '">Update</button>\
        		<button data-toggle="modal" data-target="#remove-modal" class="btn btn-danger removeData_menu" data-id="' + index + '">Delete</button></td>\
        	</tr>');
            }
            lastIndex = index;
        });
        $('#tbody').html(htmls);
        //$("#submitUser").removeClass('desabled');
    });
    // Add Data
    $('#submitMenu').on('click', function () {
        var values = $("#addMenu").serializeArray();        
        var name = values[0].value;
        var email = values[1].value;
        var password = values[2].value;
        var phone = values[3].value; 
        var status = values[4].value;
        var userID = lastIndex + 1; 
        firebase.database().ref('employee').push({
            id: userID,
            name: name,
            email: email,
            password: password,
            phone: phone,
            status: status,
            CurDistWithRest : "",
            TotalDist : "",
            TotalAmount : "",
            TotalCount : 0
        });                     
        // Reassign lastID value
        lastIndex = userID;
        $("#addMenu input").val("");
        $("[data-dismiss=modal]").trigger({ type: "click" });
        $("#insert-modal-employee").modal('hide');
    });
    // Update Data
    var updateID = 0;
    $('body').on('click', '.updateData_employee', function (e) {
        e.preventDefault();
        updateID = $(this).attr('data-id');
        firebase.database().ref('employee/' + updateID).on('value', function (snapshot) {
            var values = snapshot.val();
            var updateData_employee_data = '<div class="form-group">\
                <input type="hidden" id="employee_id" value="'+ updateID+'">\
		        <label for="name" class="col-md-12 col-form-label">Name</label>\
		        <div class="col-md-12">\
		            <input id="name" type="text" class="form-control" name="name" value="' + values.name + '" required autofocus>\
		        </div>\
		    </div>\
            <div class="form-group">\
		        <label for="description" class="col-md-12 col-form-label">Email</label>\
		        <div class="col-md-12">\
		            <input type="email" class="form-control" name="email" value="' + values.email + '" required autofocus>\
		        </div>\
		    </div>\
            <div class="form-group">\
		        <label for="phone" class="col-md-12 col-form-label">Phone</label>\
		        <div class="col-md-12">\
		            <input type="number" class="form-control" name="phone" value="' + values.phone + '" required autofocus>\
		        </div>\
		    </div>\
            <div class="form-group">\
		        <label for="status" class="col-md-12 col-form-label">Status</label>\
		        <div class="col-md-12">\
                <input type="text" class="form-control" name="status" value="' + values.status + '" required autofocus>\
		        </div>\
		    </div>';
            $('#updateEmployeeBody').html(updateData_employee_data);
        });
    });
    $('.updateEmployee').on('click', function () {
        var values = $(".employee-update-record-model").serializeArray(); 
        console.log(values);
        var EmployeeID = $('#employee_id').val();      
        var postData = {
                  
            };
        var updates = {};
        updates['/employee/' + EmployeeID] = postData;
        $("[data-dismiss=modal]").trigger({ type: "click" });
        // location.reload();
        $("#update-modal-employee").modal('hide');
    });
    // Remove Data
    $("body").on('click', '.removeData_menu', function () {
        var id = $(this).attr('data-id');
        $('body').find('.menu-remove-record-model').append('<input name="id" type="hidden" value="' + id + '">');
    });
    $('.deleteRecord').on('click', function () {
        var values = $(".menu-remove-record-model").serializeArray();
        var id = values[0].value;
        firebase.database().ref('employee/' + id).remove();
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
