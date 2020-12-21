console.log("this is js tut");

const name = document.getElementById('name');
const email = document.getElementById('email');
const contact = document.getElementById('contact');
let validEmail = false;
let validPhone = false;
let validUser = false;

//addeventlistener for name
name.addEventListener('blur', () => {
    console.log('name is blur');
    //validate name
    let regex = /^[a-zA-Z]([0-9a-zA-Z ]){3,10}$/;
    let str = name.value;
    if (regex.test(str)) {
        console.log("Its matched");
        name.classList.remove('is-invalid');
        validUser = true;
    } else {
        console.log("Not matched");
        name.classList.add('is-invalid');
        validUser = false;
    }
});

//addeventlistener for email
email.addEventListener('blur', () => {
    // let regex = /\S+@\S+\.\S+/;
    let regex = /^([_\-\.0-9a-z]+)@([_\-\.0-9a-z]+)\.([a-z]){2,7}$/;
    let str = email.value;
    if (regex.test(str)) {
        console.log("Its matched");
        email.classList.remove('is-invalid');
        validEmail = true;
    }
    else {
        console.log("Its does not match");
        email.classList.add('is-invalid');
        validEmail = false;
    }
});

//addeventlistener for contact
contact.addEventListener('blur', () => {
    let regex = /^[6-9]\d{9}$/;
    let str = contact.value;
    if (contact.test(str)) {
        console.log("Its matched");
        contact.classList.remove('is-invalid');
        validPhone = true;
    }
    else {
        console.log("Its does not match");
        phoneNumber.classList.add('is-invalid');
        validPhone = false;
    }
});