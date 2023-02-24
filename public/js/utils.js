function validateLogingForm() {
    const username = document.forms["loginForm"]["email"].value;
    const password = document.forms["loginForm"]["pass"].value;

    const errorMessages = [];
    if (username == "") {
        errorMessages.push("Le nom d'utilisateur est requis.");
    }
    if (password == "") {
        errorMessages.push("Le mot de passe est requis.");
    }
    if (errorMessages.length > 0) {
        var errorMessage = errorMessages.join("<br>");
        document.getElementById("errorMessages").innerHTML = errorMessage;
        return false;
    }

    return true;
}


const form = document.querySelector("#form-account");
console.dir(form);
const nom = document.querySelector("#form-account #nom");
const prenom = document.querySelector("#form-account #prenom");
const email = document.querySelector("#form-account #email");
const password = document.querySelector("#form-account #pass");
const passwordConfirmation = document.querySelector("#form-account #pass-confirmation");

const showError = (input, msg) => {
    const formControl = input.parentElement;
    const small = formControl.querySelector("small");
    // formControl.classList.remove("success");
    formControl.classList.add("error");
    small.textContent = msg;
};

const showSuccess = (input) => {
    const formControl = input.parentElement;
    formControl.classList.remove("error");
    formControl.classList.add("success");
};

const checkEmail = (input) => {
    const re = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
    console.log(re.test(input.value));
    if (re.test(input.value) && !input.parentElement.classList.contains("error")) {
        showSuccess(input);
    } else {
        showError(input, "Email address is invalid. ");
        return false
    }
    return true
};

const checkPasswordMatch = (input1, input2) => {
    if (input1.value !== input2.value) {
        showError(input1, "Passwords must match");
        return false
    } else if (!input1.parentElement.classList.contains("error")) {
        showSuccess(input1);
    }
    return true
};

const getFieldName = (input) => {
    const firstLetter = input.id.charAt(0).toUpperCase();
    return firstLetter + input.id.slice(1);
};

const checkLength = (input, min, max) => {
    if (input.value.length < min || input.value.length > max) {
        showError(
            input,
            `${getFieldName(
                input
            )} must be between ${min} and ${max} characters long`
        );
        return false
    }
    return true
};

const checkRequired = (inputArr) => {
    isConfirmed = true;
    inputArr.forEach((input) => {
        if (input.value.trim() === "") {
            showError(input, `${getFieldName(input)} is required`);
            isConfirmed &&= false;
        } else {
            showSuccess(input);
        }
    });
    return isConfirmed
};

const validateForm = () => {
    const isRequired = checkRequired([nom, prenom, email, password, passwordConfirmation])
    const isLenght = checkLength(password, 8, 30)
    const isEmail = checkEmail(email)
    const isPass = checkPasswordMatch(passwordConfirmation, password);
    return (isRequired && isLenght && isEmail && isPass);
};

