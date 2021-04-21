function login(){
    let username = document.getElementById('username').value;
    let password = document.getElementById('password').value;

    if(username.length == 0 || password.length == 0){
        document.getElementById('error-login').innerHTML = 'Empty field';
        return;
    }
    let data = "username=" + username + "&password=" + password;
    xhr = new XMLHttpRequest();
    xhr.open('POST', 'static/api/admin_login.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if(this.status == 200 && this.responseText != '0'){
           setCookie('auth_token', this.responseText, 1);
           window.location.href = "./admin";
        }
    };
    xhr.send(data);
}
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}