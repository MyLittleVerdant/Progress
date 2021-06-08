function Find(){
    var cookies=readCookie('book');
       var input=cookies;
       
          input=encodeURIComponent(input);
        var xhr=new XMLHttpRequest();
      xhr.open('POST','/BookPage/TakeBook.php');
      
      xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
          xhr.onreadystatechange=function(){
            if(xhr.readyState===4 && xhr.status===200)
                {
                    var res=$.parseJSON(xhr.responseText);
                    FillBook(res);
                }
        }
    
  xhr.send("Take="+input);
}

function FillBook(Array)
{
    let img_box=document.querySelector('.preview');

    let image = document.createElement('img');
    //image.src="/Assets/images/"+Array['Article']+".jpg";
    image.src = "data:image/jpeg;base64," + Array['Image'];
    image.style.width="250px";
    image.style.height="390px";
    img_box.appendChild(image);
    
    document.querySelector('.title').textContent=Array['Name'];
    document.querySelector('.value').textContent=Array['Price']+" Р";
    let temp=document.querySelector('.button_add');
    temp.id = Array['Article'];

    document.querySelector('.text').textContent = Array['Description'];
    document.querySelector('.author').textContent = Array['Author'];
    
}

function readCookie(name) {

	var name_cook = name+"=";
	var spl = document.cookie.split(";");
	
	for(var i=0; i<spl.length; i++) {
	
		var c = spl[i];
		
		while(c.charAt(0) == " ") {
		
			c = c.substring(1, c.length);
			
		}
		
		if(c.indexOf(name_cook) == 0) {
			
			return c.substring(name_cook.length, c.length);
			
		}
		
	}
	
	return null;
	
}

function return_to_main()
{
    window.location.href = '../..';
}

document.addEventListener("click", function(e) {
  
  if (e.target.classList.contains('btn')) {
      let input=e.target.id;
      
      input=encodeURIComponent(input);
        var xhr=new XMLHttpRequest();
      xhr.open('POST','../Cart/refCart.php');
      
      xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
          xhr.onreadystatechange=function(){
            if(xhr.readyState===4 && xhr.status===200)
                {
                    var res=$.parseJSON(xhr.responseText);
    
                }
        }
    
  xhr.send("Add="+input);
  }
})