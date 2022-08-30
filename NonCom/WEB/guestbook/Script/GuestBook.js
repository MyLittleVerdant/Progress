document.forms.addForm.onsubmit = async function (e) {
    e.preventDefault();

    const data = new URLSearchParams(new FormData(document.forms.addForm));
    var flag = false;
    var denial = Check();


    if (!denial) {
        //CAPTCHA
        let response = await fetch('/verify_captcha.php', {
            method: 'POST',
            body: data
        })


        let result = await response.json();


        if (result !== "OK") {
            document.querySelector('.test').innerHTML = result;
            flag = false;
        } else {
            document.querySelector('.test').innerHTML = "";
            flag = true;
        }
        //
        if (flag) {
            let response = await fetch('/Script/NewEntry.php', {
                method: 'POST',
                body: data
            })
            let result = await response.json();

            location.reload();
        }
    }

}


function Check()
{
    var errCount = 0;


    //UserName
    if (document.querySelector(' input[name="UsrNm"]').value.length === 0) {
        document.querySelector('.usrn').innerHTML = "Required field!"
        errCount++;
    } else if (!validateName(document.querySelector(' input[name="UsrNm"]').value)) {
        document.querySelector('.usrn').innerHTML = "Incorrect name!"
        errCount++;
    } else {
        document.querySelector('.usrn').innerHTML = "";
    }

    //Email
    if (document.querySelector(' input[name="Email"]').value.length === 0) {
        document.querySelector('.mail').innerHTML = "Required field!"
        errCount++;
    } else if (!validateMail(document.querySelector(' input[name="Email"]').value)) {
        document.querySelector('.mail').innerHTML = "Incorrect email!";
        errCount++;
    } else {
        document.querySelector('.mail').innerHTML = "";
    }


    //MSG
    if (document.querySelector(' input[name="MSG"]').value.length === 0) {
        document.querySelector('.message').innerHTML = "Required field!"
        errCount++;
    } else {
        document.querySelector('.message').innerHTML = ""
    }

    return errCount;
}


function validateMail(email)
{
    var reg = /^([A-Za-z0-9_\-.])+@([A-Za-z0-9_\-.])+\.([A-Za-z]{2,4})$/;
    return reg.test(email);
}

function validateName(usrnm)
{
    var reg = /^[0-9a-zA-Z]+$/i;
    //var reg =/^(?:[в-яёa-z\d]*[а-яёa-z]\d[в-яёa-z\d]*$|[в-яёa-z\d]*\d[в-яёa-z][в-яёa-z\d]*$)/i;


    return reg.test(usrnm);
}


function GetAllEntry()
{
    let input = "Y";
    input = encodeURIComponent(input);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/Script/GetEntries.php');

    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var res = $.parseJSON(xhr.responseText);
            ShowAllEntry(res);
        }
    }

    xhr.send("Info=" + input);

}

function ShowAllEntry(Array)
{
    var table = document.getElementById('AllEntryTable-body');


    for (var i = 0; i < Array.length; i++) {
        var tr = document.createElement('tr');

        var UserId = document.createElement('td');
        UserId.innerHTML = Array[i]['UserName'];
        tr.appendChild(UserId);

        var Email = document.createElement('td');
        Email.innerHTML = Array[i]['E-mail'];
        tr.appendChild(Email);

        var Address = document.createElement('td');
        Address.innerHTML = Array[i]['Homepage'];
        tr.appendChild(Address);

        var Article = document.createElement('td');
        Article.innerHTML = Array[i]['DateTime'];
        tr.appendChild(Article);

        var Name = document.createElement('td');
        Name.innerHTML = Array[i]['Text'];
        tr.appendChild(Name);


        table.appendChild(tr);
    }
    Table();
}


function Table()
{

    $('#AllEntryTable').DataTable({
        columnDefs: [
            {orderable: false, targets: [2, 4]}
        ],
        info: false,
        "pagingType": "simple_numbers",
        "lengthMenu": [25],
        language: {
            "sProcessing": "Подождите...",
            "sLengthMenu": "Записей на странице _MENU_ ",
            "sZeroRecords": "Записи отсутствуют.",
            "sInfo": "Записи с _START_ до _END_ из _TOTAL_ записей",
            "sInfoEmpty": "Записи с 0 до 0 из 0 записей",
            "sInfoFiltered": "(отфильтровано из _MAX_ записей)",
            "sInfoPostFix": "",
            "sSearch": "Поиск:",
            "sUrl": "",
            "oPaginate": {
                "sFirst": "Первая",
                "sPrevious": "Предыдущая",
                "sNext": "Следующая",
                "sLast": "Последняя"
            },
            "oAria": {
                "sSortAscending": ": активировать для сортировки столбца по возрастанию",
                "sSortDescending": ": активировать для сортировки столбцов по убыванию"
            }
        },


    });
}


