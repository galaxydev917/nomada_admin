@extends('adminlte::page')

@section('title', 'order')

@section('content_header')

    <h1>Order List</h1>

@stop

@section('content')
<div class="box">
<div class="box-body">
    <table class="table table-bordered">
        <tr>
            <th>Customer Name</th>
            <th>Mobile Number</th>
            <th>Total</th>
            <th>Order Date</th>
            <th>Status</th>
            <th>Delivery Guy</th>
            <th width="180" class="text-center">Action</th>
        </tr>
        <tbody id="tbody">

        </tbody>
    </table>
</div>
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
    var employeeList = [];
    var ref = firebase.database().ref('employee/');
    ref.once('value', function(snapshot){       
        snapshot.forEach(function(childSnapshot) {
        var childKey = childSnapshot.key;
        var childData = childSnapshot.val();
        if(childData.status == 'Active'){
            employeeList[childKey] = childData;
        }
        //employeeList +='<option value="' + childKey + '">' + childData.name + '</option>';        
        });      
    });
    // Get Data
    firebase.database().ref('orders/').orderByChild('orderTime').on('value', function (snapshot) {
        var value = snapshot.val();
        var htmls = [];
        $.each(value, function (index, value) {
            if (value) {
                var theDate = new Date(value.orderTime);
                var dateString = theDate.toLocaleDateString() +' '+ theDate.toLocaleTimeString();                
                htmls.push('<tr>\
        		<td>' + value.name + '</td>\
                <td>' + value.phone + '</td>\
                <td>' + value.totalPrice + '</td>\
                <td>' + dateString + '</td>\
                <td>' + value.PurchaseStatus + '</td>\
                <td>' + ((value.deliveryName) ? value.deliveryName : '') + '</td>\
        		<td><button data-toggle="modal" data-target="#update-modal" class="btn btn-info updateData" data-id="' + index + '">Update Status</button>\
        	</tr>');
            }
            lastIndex = index;
        });
        $('#tbody').html(htmls.reverse());
        $("#submitUser").removeClass('desabled');
    });
    // Update Data
    var updateID = 0;
    $('body').on('click', '.updateData', function () {
        updateID = $(this).attr('data-id');        
        firebase.database().ref('orders/' + updateID).on('value', function (snapshot) {
            var values = snapshot.val();
            var data = '';
            for (i in employeeList) {
                if(employeeList[i].id == values.deliveryId){
                    data += '<option value="'+employeeList[i].id+'" data-delivery="'+employeeList[i].name +'" selected = "selected">'+employeeList[i].name+'</option>';
                } else {
                    data += '<option value="'+employeeList[i].id+'" data-delivery="'+employeeList[i].name + '">'+employeeList[i].name+'</option>';
                }
            }
            var updateData = '<div class="form-group">\
		        <label for="price" class="col-md-12 col-form-label">Status</label>\
		        <div class="col-md-12">\
                    <select id=status class="form-control" name="PurchaseStatus">\
                        <option value="Pending" ' + ((values.PurchaseStatus == "Pending") ? selected="selected" : "") + '>Pending</option>\
                        <option value="On the Way" ' + ((values.PurchaseStatus == "On the Way") ? selected="selected" : "") + '>On the Way</option>\
                        <option value="Delivered" ' + ((values.PurchaseStatus == "Delivered") ? selected="selected" : "") + '>Delivered</option></select>\
		        </div>\
		    </div>\
            <div class="form-group">\
		        <label for="price" class="col-md-12 col-form-label">Assign Order To</label>\
		        <div class="col-md-12">\
                    <select id=delivery_guy class="form-control" name="delivery_guy" ' + ((values.PurchaseStatus == "Delivered") ? disabled="disabled" : "") + '>'+data+'\
                    </select></div>\
                </div>';                
            $('#updateBody').html(updateData);
        });
    });
    $('.updateCustomer').on('click', function () {
        var values = $(".users-update-record-model").serializeArray();
        var status = $("#delivery_guy").find('option:selected').attr("data-delivery");
        var postData = {
            PurchaseStatus: values[0].value,
            deliveryId: values[1].value,
            deliveryName: status,
        };
        var updates = {};
        updates['/orders/' + updateID] = postData;
        firebase.database().ref('orders/' + updateID).update(postData);
        $("#update-modal").modal('hide');
        $("[data-dismiss=modal]").trigger({ type: "click" });
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

@stop
