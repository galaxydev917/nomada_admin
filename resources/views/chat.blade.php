<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <title>Naomad Admin Panel</title>

</head>
<body>

<div class="container" style="margin-top: 50px;">

    <h4 class="text-center">Nomada Menu</h4><br>

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

  
  <ul>
  @foreach($messages as $message)
  <li>
			 @if($message['sendBy'] =='User')
             <span>
					<p>{{$message['message']}}</p>
				</span>
            @endif
            @if($message['sendBy'] =='Admin')
				<span>
						<p>{{$message['message']}}</p>
				 </span>
            @endif
				</li>
    @endforeach
  </ul>
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

</body>
</html>