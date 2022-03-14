<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QuickBlox Sign Up</title>
    <link rel="shortcut icon" href="https://quickblox.com/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.css"/>
</head>

<body>

<!-- Modal (login to chat)-->
<div id="loginForm" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <div id="loginFormContainer">
                    <div class="login-form-body">
                        <input type="text" id="inputUserName" class="input-forms" placeholder="Username">
                        <input type="text" id="inputGroupName" class="input-forms" placeholder="User group">
                        <button type="submit" class="btn login-button">Login</button>
                    </div>
                </div>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timeago/1.4.1/jquery.timeago.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/quickblox/2.7.0/quickblox.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.min.js"></script>

<script src="js/helpers.js"></script>
<!--script src="js/connection.js"></script-->
<script src="js/config/apps.js"></script>
<script src="js/config/main.js"></script>



<!-- video conf -->


</body>

</html>


<script>

'use strict';

var currentUser;

$(function() {
    var usersDetails = getUserNameAndGroupFromStorage();
    if(usersDetails && usersDetails.length > 0){
      $('#inputUserName').val(usersDetails[0]);
      $('#inputGroupName').val(usersDetails[1]);
    }

    configureAppAndLoadUser();

    //The following code will enable all popovers in the document:
    $('[data-toggle="popover"]').popover();
});

function configureAppAndLoadUser() {
    if(typeof QBCustomEndpoints !== "undefined"){
        QBCONFIG.endpoints.api = QBCustomEndpoints.qbAPI;
        QBCONFIG.endpoints.chat = QBCustomEndpoints.qbChat;
    }
    console.info("api endpoint: ", QBCONFIG.endpoints.api);
    console.info("chat endpoint: ", QBCONFIG.endpoints.chat);

    QB.init(QBAppCreds.appId, QBAppCreds.authKey, QBAppCreds.authSecret, QBCONFIG);

    QB.createSession(function() {

        // $('#loginForm').modal('show');
        // $('#loginForm .progress').hide();

        $('.login-button').on('click', function() 
		{
            var userName = $('#inputUserName').val().trim(),
                userTag = $('#inputGroupName').val().trim();

            if ((userTag.length < 3) || (userTag.length > 15)) {
                loginError('length should between 3..15 symbols');
                return false;
            }

            if (!userName || !userTag) {
                loginError('Fields "Username" and "Group name" must be filled');
                return false;
            }

            currentUser = {
                'login': userUid() + userName.replace(/\s/g, ''),
                'password': 'webAppPass',
                'full_name': userName,
                'tag_list': userTag
            };

            QB.users.get({
                'login': currentUser.login
            }, function(error, user){
                if (user) {
                    connectToChat();
                } else if (error && error.code === 404) {
                    QB.users.create(currentUser, function(error, user) {
                        if (user) {
                            connectToChat();
                        } else {
                            loginError(error);
                        }
                    });
                } else {
                    loginError(error);
                }

                saveUserNameAndGroupToStorage(userName, userTag);

                $('#inputUserName').val('');
                $('#inputGroupName').val('');
            });
        });


        // can provide username & usergroup via query string for autologin
        //
        var username = getQueryVar('username');
        var usergroup = getQueryVar('usergroup');
        console.info("username: " + username + ", usergroup: " + usergroup);
        //
        if(username && usergroup){
          $('#inputUserName').val(username);
          $('#inputGroupName').val(usergroup);

          $('.login-button').trigger("click");
        }

    });
}

function connectToChat() {
    $('#loginFormContainer').hide();
    $('#loginForm .progress').show();

    QB.login({
        login: currentUser.login,
        password: currentUser.password
    }, function(error, user) {
        if (user) {
            currentUser.id = user.id;
            updateUser(user);
            mergeUsers([{
                user: user
            }]);

            QB.chat.connect({
                userId: currentUser.id,
                password: currentUser.password
            }, function(err, roster) {
                if (err) {
                    console.error("connect to chat error: ", err);
                } else {
                    $('#loginForm').modal('hide');
                    $('.current-user-login').text('Logged as: ' + currentUser.full_name + "(" + currentUser.id + ")");

                    // retrieve dialogs' list
                    retrieveChatDialogs();
                    onUpdateChatDialogs();
                    // setup message listeners
                    setupAllListeners();
                    // setup scroll events handler
                    setupMsgScrollHandler();

                    setupStreamManagementListeners();
                }
            });
        } else {
            loginError(error);
        }
    });
}



</script>