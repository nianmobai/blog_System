const Auto_Login_Check = "../../backside/login/autologin.php";
const Login_Out = "../../backside/login/logout.php";

Check_LoginStatus();

setInterval(() => {
    Check_LoginStatus();
    return;
}, 10 * 1000);//check login status

$('#logout').bind(eventType, function (e) {
        $.ajax({
            type: "HEAD",
            url: Login_Out,
            success: function (response) {
                return;
            }
        });
});

function Check_LoginStatus(){
    $.ajax({
        type: "HEAD",
        url: Auto_Login_Check,
        success: function (response) {
            return;
        }
    });
    return true;
}