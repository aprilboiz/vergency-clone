function validateForm(){
    let first_name = document.forms["register-form"]["customer[first_name]"].value;
    let last_name = document.forms["register-form"]["customer[last_name]"].value;
    let phone_number = document.forms["register-form"]["customer[phone_number]"].value;
    let email = document.forms["register-form"]["customer[email]"].value;
    let password = document.forms["register-form"]["customer[password]"].value;
    let password_retype = document.forms["register-form"]["customer[password_retype]"].value;

    let dob = document.forms["register-form"]["customer[dob]"].value;
    
    let gender = document.forms["register-form"]["customer[gender]"];

    let noti = "";
    let notiZone = document.getElementById("noti-zone");


    // check if the name is valid
    if (first_name.length <= 3){
        noti += "Name is too short!"+"<br>";
    }

    // check if the phone number is valid
    let phonePattern = /^\d{10}$/;
    if (!phonePattern.test(phone_number)) {
        noti += "Phone number must be 10 digits and can't be characters!"+"<br>";
    }

    // check if the email is valid
    let emailPattern = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    if (!emailPattern.test(email)) {
        noti += "Email is not valid!"+"<br>";
    }

    // check if the password is valid
    if (password.length < 8) {
        noti += "Password must be at least 8 characters long!"+"<br>";
    }else{
        if (password != password_retype){
            noti += "Password are not match!"+"<br>";
        }
    }

    // check for radio buttons are checked or not
    if (gender.value.length == 0){
        noti += "Gender is not checked!"+"<br>";
    }

    // check for age
    dob = new Date(dob);
    let currentDate = new Date();
    let age = currentDate.getFullYear() - dob.getFullYear();
    let monthDiff = currentDate.getMonth() - dob.getMonth();
    if (monthDiff < 0 || (monthDiff === 0 && currentDate.getDate() < dob.getDate())) {
        age--;
    }
    
    if (age < 14){
        noti += "Your age is not enough to register!"+"<br>";
    }


    if (noti.length > 0){
        notiZone.innerHTML = noti;
        notiZone.style.color = "red";
        return false;
    }
    return true;

}