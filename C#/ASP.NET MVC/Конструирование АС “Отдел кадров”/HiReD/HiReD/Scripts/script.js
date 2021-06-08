url ="https://localhost:44387/"

document.onload += () => {
    var myModal = document.getElementById('staticBackdrop')
    var myInput = document.getElementById('Input')

    
    myModal.addEventListener('shown.bs.modal', function () {
      myInput.focus()
        
    })
}



function fillChangeModal()
{
    var row = document.getElementsByClassName('table-active');

    if (row[0].cells[3].innerText != "Принят") {
        var id = document.getElementById('id');
        id.value = row[0].cells[0].innerText;

        var Department = document.getElementById('Dep');
        Department.value = row[0].cells[1].innerText;

        var Post = document.getElementById('Post');
        Post.value = row[0].cells[2].innerText;

        var Status = document.getElementById('Status');
        Status.value = row[0].cells[3].innerText;

        var SendPost = Post.value;

        let FIO ;
        if (row[0].cells[4].innerText != "") {
            var arr = row[0].cells[4].innerText.split(' - ');
            FIO = arr[0];
        }
        $('#FIO').load(url + "Recruitment/GetInterVIEW/", { post: SendPost, name: FIO });

        

        
    }
    else {
        var Department = document.getElementById('Dep');
        Department.value = row[0].cells[1].innerText;

        var Post = document.getElementById('Post');
        Post.value = row[0].cells[2].innerText;

        var Status = document.getElementById('Status');
        Status.value = row[0].cells[3].innerText;

        let FIO = document.getElementById('FIO');
        while (FIO.options.length > 0) {
            FIO.options.remove(0);
        }
        
        if (row[0].cells[4].innerText != "") {
            var arr = row[0].cells[4].innerText.split(' - ');
            let newOption = new Option(arr[0], arr[0]);
            FIO.append(newOption);
        }

        var btn = document.getElementsByClassName('Save');
        btn[0].hidden = true;

        
        
        
    }
   
    deleteSpace();

}

function deleteSpace() {
    var select = document.getElementById('FIO');
    
    for (let option of select.options.length) {
        if (option.value = "")
            select.options.remove(option);
    }
}


function addHighlighting() {
    var tableBody = document.getElementById('MainTable').children[1];
    for(var tr of tableBody.children)
        {
            if(tr.cells[3].innerText=="В поиске")
                tr.cells[3].classList.add('table-info')
            else if(tr.cells[3].innerText=="Прошел собеседование")
                tr.cells[3].classList.add('table-warning')
            else if (tr.cells[3].innerText=="Принят")
                tr.cells[3].classList.add('table-success')
                
        }
}

$(document).ready(function () {
    $.fn.dataTable.ext.classes.sPageButton = 'btn btn-success pgn';
    $('#MainTable').DataTable({
        searching: false,
        info: false,
        "pagingType": "simple_numbers",
        "lengthMenu": [4, 10, 25],
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
});

$("#MainTable tbody tr").on('click', function (event) {
    $("#MainTable tbody tr").removeClass('table-active');
    $(this).addClass('table-active');
    var test = null;
});
addHighlighting();


function Change() {
    let EntryArray = [];
   // var ID = document.getElementById('id').value;
    var table = document.getElementsByClassName('recruit');
    EntryArray.push(table[0].children[0].children[0].cells[0].children[0].value) //id
    EntryArray.push(table[0].children[0].children[3].cells[1].children[0].value) //status
    EntryArray.push(table[0].children[0].children[4].cells[1].children[0].value) //man choice

    var request = new XMLHttpRequest();
    request.open('POST', 'https://localhost:44387/Recruitment/EditRecuest');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send('data=' + EntryArray);
    $("#MainTable-body tr").remove(); 
    $('#MainTable-body').load(url + "Recruitment/GetBD/");
    document.location.reload(true);
}

function Add()
{
    let EntryArray = [];
    var table = document.getElementsByClassName('new-request');
    EntryArray.push(table[0].children[0].children[0].cells[1].children[0].value) //status
    EntryArray.push(table[0].children[0].children[1].cells[1].children[0].value) //man choice

    var request = new XMLHttpRequest();
    request.open('POST', 'https://localhost:44387/Recruitment/AddRecuest');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send('data=' + EntryArray);
    document.location.reload(true);
}


