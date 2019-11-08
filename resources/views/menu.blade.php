@extends('adminlte::page')

@section('title', 'menu')

@section('content_header')

    <h1>Menu List</h1>

@stop

@section('content')


    <div class="box box-success">
        <div class="box-header with-border"><h3 class="box-title">Add Menu</h3></div>
            <div class="box-body">
                <form id="addMenu" class="form-inline" method="POST" action="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-xs-2">
                            <label class="bmd-label-floating">Name</label>
                            <input id="name" type="text" class="form-control" name="name" placeholder="Name"
                                required autofocus>
                        </div>
                        <div class="col-xs-2">
                            <label class="bmd-label-floating">Description</label>
                            <textarea id="description" type="text" class="form-control" name="description" placeholder="Desciption"
                                required autofocus></textarea>
                        </div>
                        <div class="col-xs-2">
                            <label class="bmd-label-floating">Price</label>
                            <input id="price" type="number" class="form-control" name="price" placeholder="price" required autofocus>                            
                        </div>
                        <div class="col-xs-2">
                            <label class="bmd-label-floating">Portion</label>
                            <input id="portion" type="number" class="form-control" name="portion" placeholder="Portion" required autofocus>
                        </div>
                        <div class="col-xs-2">
                            <label class="bmd-label-floating">difficulty</label>
                            <select name="difficulty">
                                <option value="easy">Easy</option>
                                <option value="medium">Medium</option>
                                <option value="difficult">Difficult</option>
                            </select>
                        </div>
                        <div class="col-xs-2">
                            <label class="bmd-label-floating">Cook Time</label>
                            <input id="cooktime" type="number" class="form-control" name="cooktime" placeholder="Cook Time" required autofocus>
                        </div>
                    </div>
                    <div class="row"><div class="col-xs-12"><label class="bmd-label-floating"><u>ingredients</u></label></div></div>
                    <div class="row">                        
                        <div class="col-xs-2">
                            <label class="bmd-label-floating">item1</label>                          
                            <input id="item1" type="text" class="form-control" name="item1" placeholder="item1" required autofocus>
                        </div>
                        <div class="col-xs-2">                        
                            <label class="bmd-label-floating">amount1</label>                          
                            <input id="amount1" type="number" class="form-control" name="amount1" placeholder="amount1" required autofocus>
                        </div>
                        <div class="col-xs-2">
                            <label class="bmd-label-floating">item2</label>                          
                            <input id="item2" type="text" class="form-control" name="item2" placeholder="item2" required autofocus>
                        </div>
                        <div class="col-xs-2">
                            <label class="bmd-label-floating">amount2</label>                          
                            <input id="amount2" type="number" class="form-control" name="amount2" placeholder="amount2" required autofocus>
                        </div>
                        <div class="col-xs-2">
                            <label class="bmd-label-floating">item3</label>                          
                            <input id="item3" type="text" class="form-control" name="item3" placeholder="item3" required autofocus>
                        </div>
                        <div class="col-xs-2">
                            <label class="bmd-label-floating">amount3</label>                          
                            <input id="amount3" type="number" class="form-control" name="amount3" placeholder="amount3" required autofocus>
                        </div>
                    </div><hr />
                    <div class="row">
                        <div class="col-xs-8"></div>
                        <div class="col-xs-2">
                            <label class="bmd-label-floating">Picture</label>
                            <input type="file" id="image" accept="menu/*">
                        </div>
                        <input id="category" type="hidden" class="form-control" name="category" value ="{{$id}}">
                        <div class="col-xs-2">
                            <button id="submitMenu" type="button" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    <div class="box">
<div class="box-body">
    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Portion</th>
            <th>Cook Time</th>
            <th>Difficulty</th>
            <th>item1</th>
            <th>amount1</th>
            <th>item2</th>
            <th>amount2</th>
            <th>item2</th>
            <th>amount2</th>
            <th width="180" class="text-center">Action</th>
        </tr>
        <tbody id="tbody">

        </tbody>
    </table>
</div>
</div>
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
    firebase.database().ref('menu/').orderByChild('category').equalTo('{{$id}}').on('value', function (snapshot) {
        var value = snapshot.val();
        var htmls = [];
        $.each(value, function (index, value) {
            if (value) {
                htmls.push('<tr>\
        		<td>' + value.name + '</td>\
                <td>' + value.description + '</td>\
                <td>' + value.price + '</td>\
                <td>' + value.portion + '</td>\
                <td>' + value.cooktime + '</td>\
                <td>' + value.difficulty + '</td>\
                <td>' + value.ingredients.item1 + '</td>\
                <td>' + value.ingredients.amount1 + '</td>\
                <td>' + value.ingredients.item2 + '</td>\
                <td>' + value.ingredients.amount2 + '</td>\
                <td>' + value.ingredients.item3 + '</td>\
                <td>' + value.ingredients.amount3 + '</td>\
        		<td><button data-toggle="modal" data-target="#update-modal-menu" class="btn btn-info updateData_menu" data-id="' + index + '">Update</button>\
        		<button data-toggle="modal" data-target="#remove-modal" class="btn btn-danger removeData_menu" data-id="' + index + '">Delete</button></td>\
        	</tr>');
            }
            lastIndex = index;
        });
        $('#tbody').html(htmls);
        $("#submitUser").removeClass('desabled');
    });
    // Add Data
    $('#submitMenu').on('click', function () {
        var values = $("#addMenu").serializeArray(); 
        if(values[0].value == ""){
            alert("Please enter "+values[0].name);
        } else if(values[1].value == ""){
            alert("Please enter "+values[1].name);
        } else if(values[2].value == ""){
            alert("Please enter "+values[2].name);
        } else if(values[3].value == ""){
            alert("Please enter "+values[3].name);
        } else if(values[5].value == ""){
            alert("Please enter "+values[5].name);
        } else if(values[6].value == ""){
            alert("Please enter "+values[6].name);
        } else if(values[7].value == ""){
            alert("Please enter "+values[7].name);
        } else {      
        var name = values[0].value;
        var description = values[1].value;
        var price = parseFloat(values[2].value);        
        var portion = parseInt(values[3].value);
        var difficulty = values[4].value;
        var cooktime = parseInt(values[5].value);
        var item1 = values[6].value;
        var amount1 = parseInt(values[7].value);
        var item2 = values[8].value;
        var amount2 = parseInt(values[9].value);
        var item3 = values[10].value;
        var amount3 = parseInt(values[11].value);
        var category = ((values[12].value) ? values[12].value :'{{$id}}'); 
        var userID = lastIndex + 1;        
        var image=document.getElementById("image").files[0];        
        if(image){            
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
                    portion: portion, 
                    difficulty: difficulty,
                    cooktime: cooktime,                    
                    image: downlaodURL,
                    ingredients : {
                        item1 : item1,
                        amount1 : amount1,
                        item2 : item2,
                        amount2 : amount2,
                        item3 : item3,
                        amount3 : amount3,
                    }
                });
                $('#gif').css('visibility', 'hidden');
            });
        });               
        // Reassign lastID value
        lastIndex = userID;
        $("#addMenu input").val("");
        $("#description").val("");
        } else {
            alert("Please upload an image");
        }
        }
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
            <div class="form-group">\
		        <label for="Portion" class="col-md-12 col-form-label">Portion</label>\
		        <div class="col-md-12">\
		            <input id="portion" type="text" class="form-control" name="portion" value="' + ((values.portion)? values.portion: "") + '" required autofocus>\
		        </div>\
		    </div>\
            <div class="form-group">\
		        <label for="difficulty" class="col-md-12 col-form-label">difficulty</label>\
		        <div class="col-md-12">\
                        <select name="difficulty">\
                                <option value="easy" ' + ((values.PurchaseStatus == "easy") ? selected="selected" : "") + '>Easy</option>\
                                <option value="medium" ' + ((values.PurchaseStatus == "medium") ? selected="selected" : "") + '>Medium</option>\
                                <option value="difficult" ' + ((values.PurchaseStatus == "difficult") ? selected="selected" : "") + '>Difficult</option>\
                            </select>\
		        </div>\
		    </div>\
            <div class="form-group">\
		        <label for="cooktime" class="col-md-12 col-form-label">Cook Time</label>\
		        <div class="col-md-12">\
		            <input id="cooktime" type="text" class="form-control" name="cooktime" value="' + ((values.cooktime)? values.cooktime: "") + '" required autofocus>\
		        </div>\
		    </div>\
            <div class="col-md-12"><label class="bmd-label-floating"><u>ingredients</u></label></div>\
            <div class="form-group">\
                <label for="item1" class="col-md-2 col-form-label">item1</label>\
                <div class="col-md-3">\
                    <input id="item1" type="text" class="form-control" name="item1" value="' + ((values.ingredients.item1) ? values.ingredients.item1 : "") + '" autofocus>\
                </div>\
                <label for="amount1" class="col-md-2 col-form-label">amount1</label>\
                <div class="col-md-3">\
                    <input id="price" type="text" class="form-control" name="amount1" value="' + ((values.ingredients.amount1) ? values.ingredients.amount1 : "") + '" autofocus>\
                </div>\
            </div>\
            <div class="form-group">\
            <label for="item2" class="col-md-2 col-form-label">item2</label>\
            <div class="col-md-3">\
		            <input id="item2" type="text" class="form-control" name="item2" value="' + ((values.ingredients.item2) ? values.ingredients.item2 : "") + '" required autofocus>\
		        </div>\
		        <label for="amount2" class="col-md-2 col-form-label">amount2</label>\
		        <div class="col-md-3">\
                    <input id="amount2" type="text" class="form-control" name="amount2" value="' + ((values.ingredients.amount2) ? values.ingredients.amount2 : "") + '" required autofocus>\
                </div>\
            </div>\
            <div class="form-group">\
                <label for="item3" class="col-md-2 col-form-label">item3</label>\
		        <div class="col-md-3">\
		            <input id="item3" type="text" class="form-control" name="item3" value="' + ((values.ingredients.item3) ? values.ingredients.item3 : "") + '" required autofocus>\
		        </div>\
		        <label for="amount3" class="col-md-2 col-form-label">amount3</label>\
		        <div class="col-md-3">\
		            <input id="amount3" type="text" class="form-control" name="amount3" value="' + ((values.ingredients.amount3) ? values.ingredients.amount3 : "") + '" required autofocus>\
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
        var MenuID = $('#Menu_id').val();
        var img = $('#selected_img').val();  
        if(values[0].value == ""){
            alert("Please enter "+values[0].name);
        } else if(values[1].value == ""){
            alert("Please enter "+values[1].name);
        } else if(values[2].value == ""){
            alert("Please enter "+values[2].name);
        } else if(values[3].value == ""){
            alert("Please enter "+values[3].name);
        } else if(values[5].value == ""){
            alert("Please enter "+values[5].name);
        } else if(values[6].value == ""){
            alert("Please enter "+values[6].name);
        } else if(values[7].value == ""){
            alert("Please enter "+values[7].name);
        } else {                   
        var postData = {
            name: values[0].value,
            description: values[1].value,
            price: values[2].value,
            portion : parseInt(values[3].value),
            difficulty : values[4].value,
            cooktime : parseInt(values[5].value),
            ingredients : {
                item1 : values[6].value,
                amount1 : parseInt(values[7].value),
                item2 : values[8].value,
                amount2 : (values[9].value) ? parseInt(values[9].value) : 0,
                item3 : values[10].value,
                amount3 : (values[11].value) ? parseInt(values[11].value) : 0
            },
            category: values[12].value,
            available: true,
            image: ((values[13].value) ? values[13].value : ''),            
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
                    image: downlaodURL
                    };
                var updates = {};
                updates['/menu/' + MenuID] = postData;
                firebase.database().ref('menu/' + MenuID).update(postData);
            });
        });  
        }  
        $("[data-dismiss=modal]").trigger({ type: "click" });
        // location.reload();
        $("#update-modal-menu").modal('hide');
        }
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
    $('.sidebar-menu li:eq(2)').addClass('active');
</script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

@stop
