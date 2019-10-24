<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Chat Box</title>
    <meta name="viewpot" content="width=device, initial-scal=1" />
    <link href="" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
</head>
<body>
    <span class="top"></span>
    <div class="container-fluid bg-wight chatbox rounded">
        <div class="row h-100">
            <div class="col-md-4 pr-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-7">
                        </div>
                        <div class="col-md-5">
                            </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <input type="text" placeholder="Search or Start new chat" class="form-control form-rounded"
                        </li>
                        <li class="list-group-item list-group-item-action" onclick="StartChat(id)">
                            <div class="row">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-10" style="cursor: pointer;">
                                    <div class="name"></div>
                                    <div class="under-name"></div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8 pl-0">
                <div id="chatPanel" class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-6">
                                    <div class="name"></div>
                                    <div class="under-name"></div>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    </div>
                    <div class="card-body" id="messages">
                        <div class="row">
                            <div class="col-2 col-sm-1 col-md-1">
                            </div>
                            <div class="col-6 col-sm-7 col-md-7">
                                <p class="receive">text from user
                                    <span class="time float-right">1:28 PM</span>
                                </p>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-6 col-sm-7 col-md-7">
                                <p class="sent float-right">text from user
                                    <span class="time float-right">1:28 PM</span>
                                </p>
                            </div>
                            <div class="col-2 col-sm-1 col-md-1">
                            </div>
                            </div>
                    </div>
                    <div class="card-footer">
                            <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-10">
                                        <input id="textMessage" type="text" placeholder="Type here" class="form-control form-rounded">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="submit" onclick="sendMessage()" class="btn btn-primary">send</button>
                                    </div>
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
</body>
</html>