var mainDiv, errorP, changePasswordAction, editProfileOption;
var changeProfileOptions = ['change_password', 'change_profile_picture'];
let displayId, houseOption, houseInfo; //for home
let reviewsDisplayDiv, reviewsWriteDiv;//reviews

var params = {
    'login': ['email', 'password'],
    'register': ['email', 'firstname', 'lastname', 'password']
};
var postData ={};

var apiPath = function(api){
    path = 'static/api/' + api + '.php';
    return path;
}

window.onload = function(){
    mainDiv = document.getElementById('main');
    loadPage('home');
}

function loadPage(page){
    xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function (){
        if(this.readyState == 4 && this.status == 200){
            mainDiv.innerHTML = xhr.responseText;
            if(page == 'login' || page == 'register'){
                errorP = document.getElementById('error');
            }
            if(page == 'edit_profile'){
                changePasswordAction = document.getElementById('edit-profile-action');
                editProfileOption = document.getElementById('edit-profile-option');
                //changePasswordAction.value = '';
                changeProfileView();
            }
            if(page == 'home'){
                houseOption = document.getElementById('house-option');
                displayInfo();
                reviewsDisplayDiv = document.getElementById('reviews-display');
                reviewsWriteDiv = document.getElementById('reviews-write');
                displayReviews();
            }
        }
    }
    path = page + '.php';
    xhr.open("GET", path, true);
    xhr.send();
}

function login(){
    let loginData = prepareData('login');
    if(loginData == false){
        return;
    }
        var xhr = new XMLHttpRequest();
        xhr.open('POST', apiPath('login'), true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            // do something to response
            if(xhr.status == 200){
                console.log('set_cookie');
                setCookie('token', this.responseText, 1);
                window.location.href = window.location.href;
            } else if(xhr.status == 501){
                errorP.innerHTML = this.responseText;
            }
        };
        xhr.send(loginData);
}

function register(){
    let registerData = prepareData('register');
    if(registerData == false){
        return;
    }
    if(checkPass() == false){
        return;
    }
    var xhr = new XMLHttpRequest();
    xhr.open('POST', apiPath('register'), true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if(this.responseText.length == 0){
            loadPage('login');
        }else{
            errorP.innerHTML = this.responseText;
        }
    };
    xhr.send(registerData);
}

function checkPass(){
    let password = document.getElementById('password').value
    let conf_pass = document.getElementById('confirm-password').value;
    if(password.length < 8){
        errorP.innerHTML = 'Password less than 8 characters';
        return false;
    }else{
        if(conf_pass != password){
            errorP.innerHTML = 'Passwords do not match.';
            return false;
        }else{
            return true;
        }
    }
}

function prepareData(action){
    inputIds = params[action];
    let values = [];
    for(let i=0; i<inputIds.length; i++){
        let value = document.getElementById(inputIds[i]).value;
        if(value.length != 0){
            values[i] = inputIds[i] + '=' + value;
        }else{
            errorP.innerHTML = 'Empty fields.';
            return false;
        }
    }
    return values.join('&');
}
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function deleteCookie(cname) {
    cvalue = null;
    var d = new Date();
    d.setTime(d.getTime());
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function logout(){
    deleteCookie('token');
    window.location.href = window.location.href;
}

////profile functions
function changeRegno(){
    var regno = document.getElementById('reg-no').value;
    if(regno.length < 10){
        document.getElementById('error').innerHTML = 'Reg. No less than 10 characters';
        return;
    }
    let data = "reg_no=" + regno;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', apiPath('change_regno'), true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if(this.status == 200){
            logout();
            alert('Registration No. changed, Login again.');
        }else{
            document.getElementById('error').innerHTML ='Error change password';
        }
    };
    xhr.send(data);

}
function changeProfileView(){
    if(editProfileOption.value.length == 0){
        editProfileOption.value = 0;
    }
    page = changeProfileOptions[editProfileOption.value];
    xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function (){
        if(this.readyState == 4 && this.status == 200){
            changePasswordAction.innerHTML = this.responseText;
        }
    };
    path = page + '.php';
    xhr.open("GET", path, true);
    xhr.send();
}
function changePassword(){
    var password = document.getElementById('password').value;
    if(password.length < 8){
        document.getElementById('error').innerHTML = 'Password less than 8 characters.';
        return;
    }
    if(document.getElementById('conf-password').value != password){
        document.getElementById('error').innerHTML = "Passwords do not match.";
        return;
    }
    let data = "password=" + password;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', apiPath('change_password'), true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if(this.status == 200){
            logout();
            alert('Password changed, login again.');
        }else{
            document.getElementById('error').innerHTML =this.responseText;
        }
    };
    xhr.send(data);
}

//Home info

function displayInfo(){
    let data = "house_id=" + houseOption.value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', apiPath('house_info'), true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        houseInfo = this.responseText;
        houseInfo = JSON.parse(houseInfo);
        createDisplayView(houseInfo);
    };
    xhr.send(data);
}

function createDisplayView(info){
    removeChildren('home-pic');
    removeChildren('home-info');
    if(info['pic_url'].length > 5){ //Account for no pic
        for(let i=0; i<JSON.parse(info['pic_url']).length; i++){
            let imagePath = 'static/images/houses/' + JSON.parse(info['pic_url'])[i];
            let name = info['name'];
            imageView(imagePath);
        }
    }

    nameView(info['name']);

    createDescription();
    descriptionView("Type: " + info['type']);
    descriptionView("Location: " + info['location']);
    descriptionView("Rent: " + "Ksh. " + info['rent']);
    descriptionView("Vacancy: " + info['vacancy']);
    descriptionView("Contact Owner: " + info['owner_contact']);
    addButtton();
}

function removeChildren(id){
    tag = document.getElementById(id);
    while(tag.firstChild != null){
        tag.firstChild.remove();
    }
}

function imageView(path){
    let img = document.createElement('img');
    img.setAttribute('src', path);
    img.setAttribute('class', 'house-img')
    //img.style.height = '100px';
    document.getElementById('home-pic').append(img);
}
function nameView(name){
    var pTag = document.createElement('p');
    pTag.innerHTML = name;
    document.getElementById('home-info').append(pTag);
}
function createDescription(){
    ulTag = document.createElement('ul');
    ulTag.setAttribute('id', 'detail-ul');

    document.getElementById('home-info').append(ulTag);
}
function descriptionView(description){
    var liTag = document.createElement('li');
    liTag.innerHTML = description;

    document.getElementById('detail-ul').append(liTag);
}
function addButtton(){
    let spanTag = document.createElement('span');
    spanTag.setAttribute('id', 'span-book');

    let btnTag = document.createElement('button');
    btnTag.setAttribute("onclick", "bookHouse()");
    btnTag.setAttribute('id', 'btn-book');
    btnTag.innerHTML = 'BOOK HOUSE';

    spanTag.appendChild(btnTag);
    document.getElementById('home-info').appendChild(spanTag);

}
//reviews
function displayReviews(){
    xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function (){
        if(this.readyState == 4 && this.status == 200 && this.responseText.length > 10){
            createReviewDisplay(this.responseText);
        }
    }
    xhr.open("GET", 'static/api/get_reviews.php', true);
    xhr.send();
}
function createReviewDisplay(review_info){
    review_info = JSON.parse(review_info);
    removeChildren('reviews-display');
    for(let i=review_info.length-1; i>=0; i--){
        reviewProcessor(review_info[i]);
    }
}
function reviewProcessor(review){
    let img = document.createElement('img');
    img.setAttribute("src", 'static/images/users/' + review['pic']);
    img.setAttribute('class', 'reviewer-img');
    let pName = document.createElement('p');
    pName.setAttribute('class', 'reviewer-name');
    pName.innerHTML = review['name'];
    let reviewerDiv = document.createElement('div');
    reviewerDiv.append(img);
    reviewerDiv.append(pName);

    let pReview = document.createElement('p');
    pReview.setAttribute('class', 'review-p');
    pReview.innerHTML = review['content'];

    let singleReviewDiv = document.createElement('div');
    singleReviewDiv.setAttribute('class', 'single-review');
    singleReviewDiv.append(reviewerDiv);
    singleReviewDiv.append(pReview);
    reviewsDisplayDiv.append(singleReviewDiv);
}

//Add review
function addReview(){
    let content = document.getElementById('review-input').value;
    if(content.length < 1){
        return;
    }
    content = "content=" + content;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', apiPath('add_review'), true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        console.log(this.responseText);
        if(this.status == 200){
            loadPage('home');
        }
    };
    xhr.send(content);
}

//Enable booking
function bookHouse(){
    //document.getElementById('btn-book').remove();
    let data = "house_id=" + houseOption.value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'book.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        removeChildren('home-pic');
        createFormView(this.responseText);
    };
    xhr.send(data);
}
function createFormView(form){
    let homePicDiv = document.getElementById('home-pic');
    homePicDiv.innerHTML = form;
}
function terminateTransaction(param){
    let data = "reference=" + param;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', apiPath('delete_book'), true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if(this.status == 200){
            displayInfo();
        }else{
            loadPage('home')
        }
    };
    xhr.send(data);
}