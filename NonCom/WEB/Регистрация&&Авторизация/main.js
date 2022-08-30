    function printV()
       {
           let elements = document.querySelectorAll('.print');
           for (let elem of elements) 
           {
          elem.style.display== 'none' ? elem.style.display = 'block' : elem.style.display = 'none';
        }
           
           let el = document.querySelectorAll('.pflex');
           for (let elem of el) 
           {
          elem.style.display== 'none' ? elem.style.display = 'flex' : elem.style.display = 'none';
        }
           
       }


const checkboxes = document.querySelectorAll("input[type=checkbox]");
const products=document.querySelectorAll(".product");
let enabledSettings = []
let selectedProducts=[]
let GoodsArray=[]
let YearArray=[]
let ColorArray=[]


class MultiMap{
    constructor(options) {
    this.name = options.name;
    this.value=options.value;
   
  }
}


function isCheck(category)
{
let check=document.querySelector(`input[value='${category}']`);
     if (check.checked) 
     {
         console.log('Есть');
         return true;
    }
        return false;

 }  


function RemoveTHEimmunitY(Boxes)
{
    for(let i=0;i<Boxes.length;i++)
        {
            if(Boxes[i].classList.contains('untouch'))
                {
                    Boxes[i].classList.remove('untouch')
                }
        }
}


function deleteFromArrayByValue(Array,desc)
{
    for(let i=0;i<Array.length;i++)
              {
                  if(Array[i].value==desc)
                      {
                          Array.splice(i,1);
                          break;
                      }
              }
}


function deleteFromArrayByClass(Array,Class)
{
    for(let i=0;i<Array.length;i++)
              {
                  if(Array[i].classList.contains(Class))
                      {
                          Array.splice(i,1);
                          break;
                      }
              }
}


function inArray(Array,Class)
{
    for(let i=0;i<Array.length;i++)
              {
                  if(Array[i].classList.contains(Class))
                      {
                          return true;
                          
                      }
              }
    return false;
}


function filter(items)
{
    
    items.forEach(function(item)
      {
        let CatCount=0;
        let flag=0;
        let attr=item.attributes;
        
        if(GoodsArray.length>0)
        {
            CatCount++;
            for(let k=0;k<GoodsArray.length;k++)
               if(attr[2].value==GoodsArray[k].value)
                   {
                       item.classList.remove('hide');
                            flag++;
                       break;
                   }
        }
        if(YearArray.length>0)
            {
                CatCount++;
                for(let k=0;k<YearArray.length;k++)
               if(attr[3].value==YearArray[k].value)
                   {
                       item.classList.remove('hide');
                            flag++;
                       break;
                   }
            }
        if(ColorArray.length>0)
            {
                CatCount++;
                for(let k=0;k<ColorArray.length;k++)
               if(attr[4].value==ColorArray[k].value)
                   {
                       item.classList.remove('hide');
                            flag++;
                       break;
                   }
            }
            if(flag!=CatCount)
                      {
                          item.classList.add('hide')
                          deleteFromArrayByClass(selectedProducts,item.classList[2])
                          
                      }
                      else
                          {
                              if(!inArray(selectedProducts,item.classList[2]))
                              selectedProducts.push(item);
                          }
        
        })
   if(GoodsArray.length==0&&YearArray.length==0&&ColorArray.length==0) 
    {
        items.forEach(function(item){
            item.classList.remove('hide');
        })
        selectedProducts.splice(0,selectedProducts.length);
    }

}


function disable(Array,Category)
{
    
           for(let i=0;i<Array.length;i++)
        {
            let tempItemAttr=Array[i].attributes;
            
            for(let l=0;l<checkboxes.length;l++)
                {
                    let tempBoxAttr=checkboxes[l].attributes
                    
                    for(let k=2;k<5;k++)
                        {
                            
                            if(tempItemAttr[k].value==tempBoxAttr[3].value)
                                {
                                    checkboxes[l].disabled=false;
                                    checkboxes[l].classList.add('untouch')
                                    break;
                                }
                            else 
                                {
                                    if(!checkboxes[l].classList.contains('untouch')&&tempBoxAttr[2].value!=Category)
                                   checkboxes[l].disabled=true; 
                                }
                                
                        }
                    
                }
        } 
  
    
   
}


function check()
{
    
checkboxes.forEach(function(checkbox) {
  checkbox.addEventListener('change', function() {
      let CatCheck;
      if(checkbox.checked)
          {
              //Добавить категорию в массив
              let mapCell=new MultiMap({name:checkbox.name,value:checkbox.value})
              //enabledSettings.push(mapCell);
              CatCheck=checkbox.name;
              if(CatCheck=='goods')
                  GoodsArray.push(mapCell)
              else if(CatCheck=='year')
                  YearArray.push(mapCell)
              else if (CatCheck=='color')
                  ColorArray.push(mapCell)
          }
      else{
          CatCheck=checkbox.name;
          //Убрать категорию из массива
          if(CatCheck=='goods')
          deleteFromArrayByValue(GoodsArray,checkbox.value)
              else if(CatCheck=='year')
          deleteFromArrayByValue(YearArray,checkbox.value)
              else if (CatCheck=='color')
          deleteFromArrayByValue(ColorArray,checkbox.value)
                    
          
          //Разблокировать все чекбоксы 
          for(let i=0;i<checkboxes.length;i++)
                  {
                     checkboxes[i].disabled=false; 
                  }
          
          CatCheck='delete'
      }
      
    
    RemoveTHEimmunitY(checkboxes)
      filter(products)
      for(let i=0;i<checkboxes.length;i++)
          {
              if(checkboxes[i].checked)
                  {
                      let category=checkboxes[i].name;
                      disable(selectedProducts,category)
                  }
          }
      
      
   
  })
})
}


check()

// 4 лаба

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
        xhr.open('POST','signup.php');
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
        xhr.open('POST','signin.php');
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
    window.location.href = 'profile/secretplace.php';
    
}


function exit_click()
      {
          var input='GO!';
          input=encodeURIComponent(input);
        var xhr=new XMLHttpRequest();
      xhr.open('POST','exit.php');
      
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


         
