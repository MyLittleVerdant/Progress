
    document.forms.change_pass.onsubmit=function(e)
    {
        e.preventDefault();
        /*
        var code=document.getElementById('code');
        var usercode=document.getElementById('UserCode');
        if(usercode.value==code.value)
            {
            */
                var xhr=new XMLHttpRequest();
        xhr.open('POST','updatepass.php');
        var formData=new FormData(document.forms.change_pass);
        
        xhr.onreadystatechange=function(){
            if(xhr.readyState===4 && xhr.status===200)
                {
                 var res=$.parseJSON(xhr.responseText);
                    if(res=="OK!")
                        {
                            var temp=document.getElementById('success');
                            temp.style.display="block";
                            temp.textContent ="Успех!";
                        }
                    else{
                        var temp=document.getElementById('success');
                            temp.style.display="block";
                            temp.textContent =res;
                    }
                        
                  
                }
        }
        
        xhr.send(formData);
        /*
            }
        else
            {
                var temp=document.getElementById('success');
                            temp.style.display="block";
                            temp.textContent ="Неверный код!";
            }
*/
    }
    
function getCookie(name) {
  let matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  return matches ? decodeURIComponent(matches[1]) : undefined;
}