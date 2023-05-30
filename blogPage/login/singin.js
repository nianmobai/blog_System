//get the num login
const Login_Interface = '';
const Login_Frequency_Interface = '';

$('#confirm').bind('click', function () {
    let num = Get_LoginFrequencyLeft();
    PutMessage(num);
}).mousedown(function () {
    $('#confirm').css('background-color', 'rgba(0,0,0,0.5)');
    //button style change
}).mouseup(function () {
    //return back
    $(this).css('background-color', 'white');
});

function PutMessage(login_left) {
    console.log('putmessage');
    if (login_left <= 0) {
        Notice("登录失败超过五次，请一小时后再次尝试");
        return;
    }
    //begin login
    let login_result = {
        lr:null,
        left:null,
        script:null,
        error_mes:null
    };

    let account_input = null;
    let password_input = null;

    account_input = $('#ac-input').val();
    password_input = $('#ps-input').val();

    console.log('账号为' + account_input);
    console.log('密码为' + password_input);

    if (account_input == null || account_input == "") {//
        Notice("请输入登录账号");
        return;
    }
    else if (password_input == null || password_input == "") {//
        Notice("请输入密码");
        return;
    }
    else {
        let package_login = {
            account:null,
            password:null
        }

        //packed
        package_login["account"] = account_input;
        package_login["password"] = password_input;

        $.ajax({
            type: "POST",
            url: Login_Interface,
            data: JSON.stringify(package_login),
            dataType: "dataType",
            success: function (data, status) {
                let response = JSON.parse(data);
                login_result['lr'] = response['result'];
                login_result['script'] = response['script'];
                login_result['left'] = response['left'];
                if (login_result['lr'] == true) { //login successfully
                    //run the script conveyed by backside
                    let func = new Function(login_result['script']);
                    func();//change page
                }
                else { //login failed
                    if(login_result['error_mes'] == 1){
                        Notice("用户不存在，还有" + login_result['left'] + "次机会");
                    }
                    else if(login_result['error_mes'] == 2){
                        Notice("密码错误，还有" + login_result['left'] + "次机会");
                    }
                }
            },
            error:function(){
               alert("服务器错误");
            }
        });
    }
    return login_result;
}

function Notice(mes) {
    console.log("message output:" + mes);
    $('#notice').text(mes).animate({ opacity: 1 }, 500);
    setTimeout(function () { $('#notice').animate({ opacity: 0 }, 500); }, 1500);
    return;
}

function Get_LoginFrequencyLeft() {
    let num = 5;//default value
    $.ajax({
        type: "GET",
        url: Login_Frequency_Interface,
        dataType: "text",
        success: function (response) {
            num = JSON.parse(response);
        },
        error:function(){
            alert("服务器连接错误");
        }
    });
    return num;
}