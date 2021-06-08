const radiobtns = document.querySelectorAll("input[type=radio]");
var checkboxes=[]
let selectedCheck=[]
let selectedRadio=[]


/* FILTER */
function deleteFromArrayByID(Array,id)
{
    for(let i=0;i<Array.length;i++)
              {
                  if(Array[i].id==id)
                      {
                          Array.splice(i,1);
                          break;
                      }
              }
}


function clear(elem) {
    let temp=elem.childNodes.length;
  for (let i=0; i <temp ; i++) {
      elem.childNodes[0].remove();
  }
    
}


function showProducts(Array)
{
    var space=document.querySelector('.sorted')
    clear(space);
    for(let i=0;i<Array.length;i++)
        {
            
            let div = document.createElement('div');
            div.className = "product"; //
            
            let imageDiv = document.createElement('div');
            imageDiv.className = "img_box";
            let image = document.createElement('img');
            image.src="data:image/jpeg;base64,"+Array[i]['Image'];
            image.style.width="172px";
            image.style.height="310px";
            
            let buy = document.createElement("div");
            buy.className = "buy";
            buy.style.display="flex";
            
            let price = document.createElement("div");
            price.className = "price";
            price.innerHTML = Array[i]['Price']+" Р";
            
            let cart = document.createElement("button");
            cart.className = "cart";
            cart.id=Array[i]['Article'];
            cart.innerHTML='<i class="fa fa-shopping-cart"></i>';
            
            let name = document.createElement("div");
            name.className = "name";
            name.innerHTML = Array[i]['Name'];
            name.id=Array[i]['Article'];
            
            imageDiv.appendChild(image);
            div.appendChild(imageDiv);
            buy.appendChild(price);
            buy.appendChild(cart);
            div.appendChild(buy);
            div.appendChild(name);
            space.appendChild(div);
        }
}


function check()
{
      let flag=false;   
    selectedCheck=[];
     for(let k=0;k<checkboxes.length;k++)
         {
             if(checkboxes[k].checked)
                 {
                     flag=true;
                     
                    for(let i=0;i<selectedRadio.length;i++)
                        {
                           if(selectedRadio[i]['Subgenre']==checkboxes[k].value)
                                selectedCheck.push(selectedRadio[i]);  
                        }
                 }
         }
      if(flag==false)
         selectedCheck=selectedRadio;
     showProducts(selectedCheck);   
}


function hideRadio()
{
    
radiobtns.forEach(function(radiobtn) {
  radiobtn.addEventListener('change', function() {
     
      if(radiobtn.checked)
          {
              
             let hide=document.querySelectorAll('.block');
              for(let i =0;i<hide.length;i++)
                  {
                      if(!hide[i].classList.contains('const'))
                      hide[i].style.display='none';
                  }
              let check=document.querySelectorAll(`input[type='checkbox']`);
                for(let i =0;i<check.length;i++)
                    {
                        check[i].checked='';
                    }
             document.querySelectorAll(`.${radiobtn.value}`)[1].style.display='block';
            let title=document.querySelector(`.${radiobtn.value}`).textContent;
             document.querySelector('.about_text').textContent=title;  
              Filter('Radio=',radiobtn.value);
          
               
          }
  })
})
}
      

hideRadio();


function Filter(Type,Value){
       var input=Value;
        checkboxes = document.querySelectorAll(`input[name=${Value}]`);
          input=encodeURIComponent(input);
        var xhr=new XMLHttpRequest();
      xhr.open('POST','Main/bookFilter.php');
      
      xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
          xhr.onreadystatechange=function(){
            if(xhr.readyState===4 && xhr.status===200)
                {
                    var res=$.parseJSON(xhr.responseText);
                    if(res.length)
                        {
                          selectedRadio=res;  
                          showProducts(res);  
                        }
                        
                }
        }
    
  xhr.send(Type+input);
}


document.forms.subfilter.onsubmit=function(e)
    {
        e.preventDefault();
        var xhr=new XMLHttpRequest();
        xhr.open('POST','Main/bookFilter.php');
        var formData=new FormData(document.forms.subfilter);
        
        xhr.onreadystatechange=function(){
            if(xhr.readyState===4 && xhr.status===200)
                {
                    var res=$.parseJSON(xhr.responseText);
                    if(res.length)
                        {
                          showProducts(res);  
                        }
                    else
                        {
                          document.querySelector('.sorted').textContent="По вашему запросу ничего не нашлось(";
                            
                        }
                        
                }
        }
        xhr.send(formData);
    }


document.addEventListener("click", function(e) {
  
  if (e.target.classList.contains('fa')) {
      let parent=e.target.parentElement;
      let input=parent.id;
      
      input=encodeURIComponent(input);
        var xhr=new XMLHttpRequest();
      xhr.open('POST','Cart/refCart.php');
      
      xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
          xhr.onreadystatechange=function(){
            if(xhr.readyState===4 && xhr.status===200)
                {
                    var res=$.parseJSON(xhr.responseText);
    
                }
        }
    
  xhr.send("Add="+input);
  }
   else if(e.target.classList.contains('name')) {
       let input=e.target.id;
      
      input=encodeURIComponent(input);
        var xhr=new XMLHttpRequest();
      xhr.open('POST','BookPage/createID.php');
      
      xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
          xhr.onreadystatechange=function(){
            if(xhr.readyState===4 && xhr.status===200)
                {
                    var res=$.parseJSON(xhr.responseText);
                        window.location.href = 'BookPage/book.php';
    
                }
        }
    
  xhr.send("Book="+input);
       
      
       
  }
});

/* SIGN */
class Forma{
    constructor(options) {
    this.name = options.name;
    this.value=options.value;
   
  }
}


let FieldsArray=[]


function signup_click()
{
    var modal=document.getElementById('sign_up');
    modal.style.display='inline';
    var close=document.getElementsByClassName('close')[0];
    close.onclick=function(){
        modal.style.display='none';
    }
    window.onclick=function(event){
    if(event.target==modal)
        {
            modal.style.display='none';
        }
}
}


function signin_click()
{
    var modal=document.getElementById('sign_in');
    modal.style.display='inline';
    var close=document.getElementsByClassName('close')[1];
    close.onclick=function(){
        modal.style.display='none';
    }
    window.onclick=function(event){
    if(event.target==modal)
        {
            modal.style.display='none';
        }
}
}



    document.forms.signup_form.onsubmit=function(e)
    {
        e.preventDefault();
        var xhr=new XMLHttpRequest();
        xhr.open('POST','Sign/signup.php');
        var formData=new FormData(document.forms.signup_form);
        
        xhr.onreadystatechange=function(){
            if(xhr.readyState===4 && xhr.status===200)
                {
                 
                    if(xhr.responseText=="OK")
                        whatErrUp("Регистрация успешно завершена!");
                    else
                    {
                        whatErrUp(xhr.responseText);
                    }
                }
        }
        
        xhr.send(formData);

    }
    
   
 function whatErrUp(jserr)
{
    var error=document.querySelector('.Uperrors');
    if(jserr=="Регистрация успешно завершена!")
      error.style.color='green';
    error.textContent=jserr;
    error.style.display='block';
    
}


function whatErrIn(jserr)
{
    var error=document.querySelector('.Inerrors');
    error.textContent=jserr;
    error.style.display='block';
    
}


document.forms.signin_form.onsubmit=function(e)
    {
        e.preventDefault();
        var xhr=new XMLHttpRequest();
        xhr.open('POST','Sign/signin.php');
        var formData=new FormData(document.forms.signin_form);
        
        xhr.onreadystatechange=function(){
            if(xhr.readyState===4 && xhr.status===200)
                {
                    var res=$.parseJSON(xhr.responseText);
                    if(res[0]=="OK")
                        {
                           var modal=document.getElementById('sign_in');
                        modal.style.display='none';
                        window.location.reload();    
                        }
                    else if(res==""){
                        
                    }
                    else{
                         whatErrIn(res);
                    }
                }
        }
        
        xhr.send(formData);

    }




function profile_click()
{
    window.location.href = 'Profile/account.php';
    
}


function exit_click()
      {
          var input='GO!';
          input=encodeURIComponent(input);
        var xhr=new XMLHttpRequest();
      xhr.open('POST','Sign/exit.php');
      
      xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
          xhr.onreadystatechange=function(){
            if(xhr.readyState===4 && xhr.status===200)
                {
                    if(xhr.responseText=="OK!")
                        {
                            window.location.reload(); 
                        }
                        
                }
        }
    
  xhr.send('our_inp='+input);

 }
