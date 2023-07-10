//get the num login
const Login_Interface = '../../backside/login/login.php';
const Login_Frequency_Interface = '../../backside/login/getltft.php';
const Auto_Login_Interface = '';

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
    //console.log('putmessage');
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

    let account_input = new String;
    let password_input = new String;

    account_input = $('#ac-input').val();
    password_input = $('#ps-input').val();

    if(account_input.length > 15 || password_input.length > 15){
        Notice("格式错误，请输入15位以内的账号和密码");
        return;
    }

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
            async:false,
            success: function (response,status) {
                let data = JSON.parse(response);
                console.log(data);

                if (data['lr'] == true) { //login successfully
                    //run the script conveyed by backside
                    console.log("登录成功");
                    let func = new Function(data['script']);
                    func();//change page
                }
                else { //login failed
                    if(data['left'] == 0){
                        Notice("登录失败超过五次，请一小时后再次尝试");
                        return;
                    }
                    
                    if(data['errormes'] == 1){
                        Notice("用户不存在，还有" + data['left'] + "次机会");
                    }
                    else if(data['errormes'] == 2){
                        Notice("密码错误，还有" + data['left'] + "次机会");
                    }
                }
            },
            error:function(error){
            Notice("服务器链接错误：10001");
            //console.log("获取登录我文件错误");
            }
        });
    }
    return login_result;
}

function Notice(mes) {
    //console.log("message output:" + mes);
    $('#notice').text(mes).animate({ opacity: 1 }, 500);
    setTimeout(function () { $('#notice').animate({ opacity: 0 }, 500); }, 1500);
    return;
}

function Get_LoginFrequencyLeft() {
    let num;
    $.ajax({
        type: "GET",
        url: Login_Frequency_Interface,
        dataType: "json",
        async:false,
        success: function (response) {
            num = JSON.parse(response);
            console.log("剩余登录次数" + num);
        },
        error:function(){
           Notice("服务器链接错误：10001");
           //console.log("获取剩余登录次数文件错误");
        }
    });
    return num;
}