document.forms.addForm.onsubmit = function (e) {
    e.preventDefault();
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'AddNewBook.php');
    var formData = new FormData(document.forms.addForm);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {

            if (xhr.responseText == "OK")
                console.log("OK");
            else {
                console.log(xhr.responseText);
            }
        }
    }

    xhr.send(formData);
    location.reload();
}


function return_to_main() {
    window.location.href = '../..';
}
