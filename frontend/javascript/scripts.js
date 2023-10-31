//Login and Register functions

//  Form validation for login
function checkLoginCredentials(){
    
    var cleanLoginUsername = document.getElementById('username_login').value;
    var cleanLoginPassword = document.getElementById('password_login').value;
    
    var loginUsername = cleanLoginUsername.trim();
    var loginPassword = cleanLoginPassword.trim();

    if (loginUsername != "" && loginPassword != ""){
        sendLoginCredentials(loginUsername, loginPassword);
    }else{
        if(loginUsername == ""){
            turnFieldToRedColorBorder(loginUsername);
        }
        if(loginPassword == ""){
            turnFieldToRedColorBorder(loginPassword);
        }
        if (loginUsername == "" && loginPassword == ""){
            turnFieldToRedColorBorder(loginUsername);
            turnFieldToRedColorBorder(loginPassword);
        }
    }
}

// This function sends a AJAX request for login 
function sendLoginCredentials(username, password){
    
    var httpReq = createRequestObject();
    httpReq.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            
            document.getElementById("loginButtonId").innerHTML = "Login";
            
            if(this.responseText == true){
                window.location = "../php/home.php";
            }else{
                window.location = "loginRegisterPage.html";
            }
            
        }else{
            document.getElementById("loginButtonId").innerHTML = "Loading...";
        }
    }
    httpReq.open("GET", "../php/functionCases.php?type=Login&username=" + username + "&password=" + password);
    httpReq.send(null);
}

//  Form validation for registration
function checkRegistrationCredentials(){
    
    //  Taking Form input
    var cleanUsername = document.getElementById("id_username").value;
    var cleanPassword = document.getElementById("id_password").value;
    var cleanConfirmPassword = document.getElementById("id_confirm_password").value;
    
    //  Cleaning form input
    var username = cleanUsername.trim();
    var password = cleanPassword.trim();
    var confirmPassword = cleanConfirmPassword.trim();
    
    
    if (username != "" && password != "" && confirmPassword != ""){
        sendRegister(username, password);
    }else{
        alert("Information not good");
    }

}

//  This function sends a AJAX request for Register new user
function sendRegister(username, password){
    
    var httpReq = createRequestObject();
    httpReq.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            
            document.getElementById("registerButtonId").innerHTML = "Register";
            //  var response = JSON.parse(this.responseText);
            if(this.responseText == true){
                alert("User Registered");
            }else{
                alert("Problems registering a new user");
            }
        }else{
            document.getElementById("registerButtonId").innerHTML = "Loading...";
        }
    }
    httpReq.open("GET", "../php/functionCases.php?type=RegisterNewUser&username=" + username + "&password=" + password);
    httpReq.send(null);
}

// Checks for existing username
function checkForExistingUsername(){
    
    var cleanUsername = document.getElementById("id_username").value;
    var username = cleanUsername.trim();
    
    var httpReq = createRequestObject();
    httpReq.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            
            if(this.responseText == false){
                alert("User exists");
            }else{
                alert("You can register");
            }
            
        }
    }
    httpReq.open("GET", "../php/functionCases.php?type=UsernameVerification&username=" + username);
    httpReq.send(null);
}
