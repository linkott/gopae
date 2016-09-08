$(document).ready(function(){
   $("#linkRefreshCaptcha").on('click', function (){
       reloadCaptcha();
   });

    $("#UserGroupsUser_username").bind('keyup blur', function() {
        keyText(this, true);
    });

   $("#UserGroupsUser_username").val("");
   $("#UserGroupsUser_password").val("");
   $("#UserGroupsUser_verifyCode").val("");
   
});

function reloadCaptcha(){
    jQuery('#siimage').attr('src', '/login/captcha/sid/' + Math.random());
    $("#UserGroupsUser_verifyCode").val("");
}