function validate(form_id,email) {
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    var address = document.forms[form_id].elements[email].value;
    if (document.getElementById("email").value == ""){
        alert('Введите email');
        return false;
    }
    if(reg.test(address) == false) {
        alert('Введите корректный e-mail');
        return false;
    }
    if (document.getElementById("passform").value == ""){
        alert('Введите пароль');
        return false;
    }
}
