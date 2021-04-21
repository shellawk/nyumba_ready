var mainDiv, navbarDiv, addPicDiv, houseIdInput;
let formData = [];
var houseId;
var pagePath = function(page){
    return './admin/' + page + '.php';
}

window.onload = function(){
    mainDiv = document.getElementById('main');
    navbarDiv = document.getElementById('navbar');
    addPicDiv = document.getElementById('add-pic');
    getLoadPage(navbarDiv, 'navbar');
    getLoadPage(mainDiv, 'houses');
}
function loadUserPage(){
    getLoadPage(mainDiv, 'users');
}
function loadHousePage(){
    getLoadPage(mainDiv, 'houses');
}
function loadBookPage(){
    getLoadPage(mainDiv, 'records');
}
var apiPath = function(api){
    path = 'static/api/' + api + '.php';
    return path;
}
function getLoadPage(div, page){
    xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function (){
        if(this.readyState == 4 && this.status == 200){
            div.innerHTML = this.responseText;
        }
        if(page == 'houses'){
            addPicDiv = document.getElementById('add-pic');
        }
    }
    xhr.open("GET", pagePath(page), true);
    xhr.send();
}
function removeUser(id){
    var xhr = new XMLHttpRequest();
    let data = "user_id=" + id;
    xhr.open('POST', apiPath('remove_user'), true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if(this.status == 200){
            document.getElementById('msg-p').innerHTML = this.responseText;
                getLoadPage(mainDiv, 'users');
        }
    };
    xhr.send(data);
}
//Add house
function prepareFormData(){
    let dataLst = ['name', 'type', 'location', 'rent', 'vacancy', 'owner_contact'];
    formData = [];

    for(let i=0; i<dataLst.length; i++){
        if(document.getElementById(dataLst[i]).value.length == 0){return false;}
        formData[i] = dataLst[i] + "=" + document.getElementById(dataLst[i]).value;
    }
    formData = formData.join('&');
    return true;
}
function addHouse(){
    if(prepareFormData() == false){
        document.getElementById('msg-p').innerHTML = "Incomplete Form.";
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open('POST', apiPath('add_house'), true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if(this.status == 200){
            loadHousePage();
            document.getElementById('msg-p').innerHTML = this.responseText;
        }
    };
    xhr.send(formData);
}
//remove house
function removeHouse(id){
    let data = "house_id=" + id;
    xhr.open('POST', apiPath('remove_house'), true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if(this.status == 200){
            loadHousePage();
        }
    };
    xhr.send(data);
}
//add pic
function addPic(id){
    houseId = id;
    xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function (){
        if(this.readyState == 4 && this.status == 200){
            addPicDiv = document.getElementById('add-pic');
            addPicDiv.innerHTML = this.responseText;
            document.getElementById('house_id').value = id;
            console.log(document.getElementById('house_id').value);
        }
    }
    xhr.open("GET", pagePath('add_pic'), true);
    xhr.send();
    
}
function removeRecord(param){
    let data = "reference=" + param;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', apiPath('delete_book'), true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if(this.status == 200){
            loadBookPage();
        }
    };
    xhr.send(data);
}
//Logout
function deleteCookie(cname) {
    cvalue = null;
    var d = new Date();
    d.setTime(d.getTime());
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function logout(){
    deleteCookie('auth_token');
    window.location.href = './admin';
}