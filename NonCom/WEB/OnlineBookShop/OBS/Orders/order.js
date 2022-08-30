function clear(elem) {
    let temp=elem.childNodes.length;
  for (let i=0; i <temp ; i++) {
      elem.childNodes[0].remove();
  }
    
}

function GetShop(){
    let input="Y";
      input=encodeURIComponent(input);
        var xhr=new XMLHttpRequest();
      xhr.open('POST','/Orders/purchase.php');
      
      xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
          xhr.onreadystatechange=function(){
            if(xhr.readyState===4 && xhr.status===200)
                {
                    var res=$.parseJSON(xhr.responseText);
                    ShowShop(res);
    
                }
        }
    
  xhr.send("Shop="+input);
  
}

function ShowShop(Array)
{
  var space=document.querySelector('.CartProducts')
    clear(space);
   for(let i=0;i<Array.length;i++)
        {
            let div = document.createElement('div');
            div.className = "product"; //
            
            let imageDiv = document.createElement('div');
            imageDiv.className = "img_box";
            let image = document.createElement('img');
            image.src = "data:image/jpeg;base64," + Array[i]['Image'];
            image.style.width="172px";
            image.style.height="310px";
            
            let buy = document.createElement("div");
            buy.className = "buy";
            buy.style.display="flex";
            
            let price = document.createElement("div");
            price.className = "price";
            price.innerHTML = Array[i]['Price']+" Р";
            
            
            let name = document.createElement("div");
            name.className = "name";
             name.innerHTML = Array[i]['Name'];
             name.id = Array[i]['Article'];
            
            imageDiv.appendChild(image);
            div.appendChild(imageDiv);
            buy.appendChild(price)
            div.appendChild(buy);
            div.appendChild(name);
            space.appendChild(div);
        }
        
}

function return_to_main()
{
    window.location.href = '../..';
}

document.addEventListener("click", function(e) {
  
  if(e.target.classList.contains('name')) {
       let input=e.target.id;
      
      input=encodeURIComponent(input);
        var xhr=new XMLHttpRequest();
      xhr.open('POST','/BookPage/createID.php');
      
      xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
          xhr.onreadystatechange=function(){
            if(xhr.readyState===4 && xhr.status===200)
                {
                    var res=$.parseJSON(xhr.responseText);
                        window.location.href = '/BookPage/book.php';
    
                }
        }
    
  xhr.send("Book="+input);
       
      
       
  }
});
