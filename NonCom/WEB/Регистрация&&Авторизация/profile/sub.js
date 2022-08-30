document.forms.profile_form.onsubmit=function(e)
    {
        e.preventDefault();
        var xhr=new XMLHttpRequest();
        xhr.open('POST','change.php');
        var formData=new FormData(document.forms.profile_form);
        
        xhr.onreadystatechange=function(){
            if(xhr.readyState===4 && xhr.status===200)
                {
                    var res=$.parseJSON(xhr.responseText);
                    if(res=="OK!")
                        {
                            window.location.reload(); 
                        }
                   
                }
        }
        
    
        xhr.send(formData);

    }

function return_to_main()
{
    window.location.href = '../..';
}