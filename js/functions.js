function deleteConfirm(){
    confirm("Are you sure to permanently delete the selected records?");
}

function textOnly(ele){

    var regpattern = /[^a-z\s]/gi;
    ele.value = ele.value.replace(regpattern, "");

}

function noSpecialChar(ele){

}

function numericOnly(ele){
    var regpattern = /[^0-9]/gi;
    ele.value = ele.value.replace(regpattern, "");
}

function usernameChars(ele){
    var regpattern = /[^a-z0-9]/gi;
    ele.value = ele.value.replace(regpattern, "");
}

function regValidate(id, confpass){

    var pw = document.getElementById(id).value;
    var confpw = document.getElementById(confpass).value
    console.log(confpw);

    // check if password is at least 8 characters
    if(pw.length < 8){
        alert("Password length should be at least 8 characters!");
        return false;
    }else if(confpw != pw){
        alert("Confirm password doesn't match!");
        return false;
    }else{
        return confirm("Proceed registration?");
    }

}

function updateValidate(id, confpass){
    var pw = document.getElementById(id).value;
    var confpw = document.getElementById(confpass).value
    
    console.log(confpw);

    // check if user is attempting to change the account password
    if(confirm("Proceed updating?")){
        if(pw.length > 0){
            // check if password is at least 8 characters
            if(pw.length < 8){
                alert("Password length should be at least 8 characters!");
                return false;
            }else if(confpw != pw){
                alert("Confirm password doesn't match!");
                return false;
            }else{
                return true;
            }
        }
    }else{
        return false;
    }
    
}

function makeTestCharFilter(ele){
    var regpattern = /[\:\~]/gi;
    ele.value = ele.value.replace(regpattern, "");
}
