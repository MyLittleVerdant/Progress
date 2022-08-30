////function clear(elem) {
////    let temp=elem.childNodes.length;
////  for (let i=0; i <temp ; i++) {
////      elem.childNodes[0].remove();
////  }
    
////}


function GetAllOrders(){
    let input="Y";
      input=encodeURIComponent(input);
        var xhr=new XMLHttpRequest();
      xhr.open('POST','/Orders List/GetOrdersLIST.php');
      
      xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
          xhr.onreadystatechange=function(){
            if(xhr.readyState===4 && xhr.status===200)
                {
                    var res=$.parseJSON(xhr.responseText);
                    ShowAllOrders(res);
    
                }
        }
    
  xhr.send("Info="+input);
  
}

function ShowAllOrders(Array) {
    var table = document.getElementById('AllOrdersTable-body');
    //clear(table);

    for (var i = 0; i < Array.length; i++) {
        var tr = document.createElement('tr');
     
        var UserId = document.createElement('td');
        UserId.innerHTML = Array[i]['UserID'];
        tr.appendChild(UserId);

        var Email = document.createElement('td');
        Email.innerHTML = Array[i]['Email'];
        tr.appendChild(Email);

        var Address = document.createElement('td');
        Address.innerHTML = Array[i]['Address'];
        tr.appendChild(Address);

        var Article = document.createElement('td');
        Article.innerHTML = Array[i]['Article'];
        tr.appendChild(Article);

        var Name = document.createElement('td');
        Name.innerHTML = Array[i]['Name'];
        tr.appendChild(Name);

        var Price = document.createElement('td');
        Price.innerHTML = Array[i]['Price'];
        tr.appendChild(Price);
       

        table.appendChild(tr);
    }
    Table();
}

function return_to_main()
{
    window.location.href = '../..';
}


    function Table() {
        $.fn.dataTable.ext.classes.sPageButton = ' pgn';
        $('#AllOrdersTable').DataTable({
            info: false,
            "pagingType": "simple_numbers",
            "lengthMenu": [5, 10, 25],
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



