<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>DSGN</title>
    
 <!-- Отображение страницы в масштабе 100% --> <meta name="viewport" content="width=device-width,initial-scale=1">
       
<!-- Нормализация стилей -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">  
 
<!-- Собственные стили -->
<link rel="stylesheet" href="css/main.css">

 <!-- Подключение web-шрифтов -->   
<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,300;0,400;0,700;1,400&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.13.0/css/all.css">

<!-- Favicon -->
<link rel="shortcut icon" type="image/x-icon" href="image/Favicon/favicon.ico">
  
   
</head>
<body>

<!-- ..........
   PANEL#1
............-->
   <div class="header">
       <div class="brown_stool">
      
      
         
          <button class="button_print" onclick="printV()">
           <i class="fas fa-print"></i>
       </button>
        
<?php 
if(!isset($_COOKIE['user'])):
           
?>
         <button class="button_sign_in"  onclick="signin_click()">
           Войти
       </button>
       
        
         <button class="button_sign_up" onclick="signup_click()">
           Регистрация
       </button>
<?php else: if(!$_COOKIE['user']!='') ?>
           
            
             
        <button class="button_profile" onclick="profile_click()">
<?php 
echo $_COOKIE['user'];
?>
       </button>
       
        
         <button class="button_exit" onclick="exit_click()">
           Выйти
       </button>
       
       
<?php endif; ?> 
          
         <div id="sign_up" class="modal">
         <div class="errors Uperrors"></div>
         <div class="modal_sign_up">
            
             <span class="close">&times;</span>
             <form name="signup_form" >
        
                <p>Фамилия</p>
                 <p><input type="text"  name="sname"></p>
                 <p>Имя</p>
                 <p><input type="text"  name="name"></p>
                 <p>Отчество</p>
                 <p><input type="text" name="mname"></p>
                 <p>email</p>
                 <p><input type="email"  name="email"></p>
                 <p>Логин</p>
                 <p><input type="text"  name="login"></p>
                 <p>Пароль</p>
                 <p><input type="password"  name="password"></p>
                 <p>Введите пароль еще раз</p>
                 <p><input type="password"  name="password2"></p>
                 <p>Аватар</p>
                 <p><input type="file" name="image"></p>
                 <p><input type="submit" name="do_signup" value="Регистрация"></p>
                 
             </form>
             
             
         </div>
         </div>
         
              <div id="sign_in" class="modal">
              <div class="errors Inerrors"></div>
         <div class="modal_sign_in">
            
             <span class="close">&times;</span>
             <form name="signin_form">
                
                 <p>Логин</p>
                 <p><input type="text" name="login"></p>
                 <p>Пароль</p>
                 <p><input type="password" name="password"></p>
                 <p><input type="submit" value="Вход"></p>
                 <button class="recover" onclick="window.location.href = 'change_pass/ChangePassword.php'">Забыли пароль?</button>
             </form>
                
         </div>
         </div>
          
           <p class="underlogo_text">
               ASSOCIATES<br>STUDIO<br>DESIGN 
           </p>
               <p class="social">
                
                 <a href="#" >
                     <i class="fab fa-facebook-f"></i>
                 </a>
                 
                  <a href="#"><i class="fab fa-twitter"></i></a>
                  
                  <a href="#"><i class="fab fa-linkedin-in"></i></a>
                  
                  
                  <a href="#"><i class="fab fa-google-plus-g"></i></a>
               </p>
           
       
        
      </div>
<!-- ..........
   PANEL#2
............-->
     
     
      <div class="menu">
         <div id="box">
        <a href="#"><p id="bars"><i class="fas fa-bars"></i></p></a>     
         </div>
         
         <p id="address">
             90802 California<br>Long beach<br>PO Box 68789<br>300 East Ocean<br>Boulevard
         </p>
         
          <p id="contacts">
              +64 9 345 6758<br>info@dsgn-studio.com
          </p>
          
      </div> 
          
   </div>
      <!-- ..........
    PANEL#3
............-->
     
     
      <div class="pflex projects"  >
         
          <p id="projects_text"><font color="#000">All</font><br>House<br>Commercial<br>Personal<br>Studio Lab</p>
          
          
          <p id="projects_title">PROJECTS</p>
          
          <div id="filter">
          
          <div class="block">
             <br>Товар<br>
<label><input type="checkbox"  name="goods" value="Chair"> Кресла</label><br>
<label><input type="checkbox" name="goods" value="Stool"> Стулья</label><br>
<label><input type="checkbox" name="goods" value="Various"> Разное</label><br> 
          </div>

<div class="block">
   <br>Год<br>
<label><input type="checkbox" name="year" value="2014"> 2014</label><br>
<label><input type="checkbox" name="year" value="2013"> 2013</label><br>
<label><input type="checkbox" name="year" value="2012"> 2012</label><br> 
<label><input type="checkbox" name="year" value="1970"> 1970</label><br> 
<label><input type="checkbox" name="year" value="*"> *</label><br> 
</div>

<div class="block">
   <br>Цвет<br>
<label><input type="checkbox" name="color" value="Black"> Чёрный</label><br>
<label><input type="checkbox" name="color" value="Yellow"> Жёлтый</label><br>
<label><input type="checkbox" name="color" value="Brown"> Коричневый</label><br>
<label><input type="checkbox" name="color" value="White"> Белый</label><br>
</div>
 
</div>


      </div>
      
<!-- ..........
    PRODUCTS
............-->
     
     <div class="container">
         
     
      <div class="print product fondue" data-goods="Various" data-year="2014" data-color="Yellow"></div>
      
      <div class="print product potter" data-goods="Various" data-year="*" data-color="Black"></div>
      
      <div class="print product tabano" data-goods="Chair" data-year="2014" data-color="Brown"></div>
      
      <div class="print product louis_xx" data-goods="Stool" data-year="2012" data-color="Black"></div>
      
      <div class="print product brown_chair" data-goods="Chair" data-year="2013" data-color="Brown"></div>
      
      <div class="print product fiji" data-goods="Chair" data-year="2012" data-color="Yellow"></div>
      
      <div class="print product sesann" data-goods="Chair" data-year="1970" data-color="Black"></div>
      
      <div class="print product alessi" data-goods="Various" data-year="2013" data-color="White"></div>
      
      
      
     </div>



<!-- ..........
    PANEL#4
............-->
          <!--<p id="fondue_title">FONDUE</p>
          
          <p id="fondue_description"> <b>Project Assistant</b>: Francesco Dompieri<br><b>Material</b>: Glass and Metal<br><b>Typology</b>: Suspension lamp<br><b>Client</b>: David Design<br><b>Year</b>: 2014 </p>
          
       <div id="fondue_linkbox"><a href="#"><p id="fondue_more">VIEW PROJECT</p></a></div>  --> 
      
      
      
<!-- ..........
    PANEL#5
............-->
     
     
      
         
          <!--<p id="potter_title">POTTER</p>
          
          <p id="potter_description"> <b>FOR</b> STELTON<br>Potter focuses on the functional-<br>ity and processof preparing tea.<br>a big sieve allows the flavor of to<br> evenly brewed </p>
          
        <div id="potter_linkbox"><a href="#"><p id="potter_more">VIEW PROJECT</p></a></div>   -->
        
      
      
      
<!-- ..........
    PANEL#6
............-->
     
     
        
          <!--<p id="tabano_title">TABANO</p>
          
          <p id="tabano_description"> <b>DESIGNER</b>: PATRICIA URQUIOLA<br><b>Typology</b>: Armchairs<br><b>Client</b>: B&B ITALIA<br><b>Year</b>: 2014</p>
          
        <div id="tabano_linkbox"><a href="#"><p id="tabano_more">VIEW PROJECT</p></a></div> --> 
          
      
      
      
 <!--..........
    PANEL#7
............-->  
     
           
          
         <!-- <p id="louis_title">louis xx</p>
          
          <p id="louis_description"> <b>designer</b>: philippe starck<br><b>Typology</b>: chairs<br><b>Client</b>: vitra<br><b>Year</b>: 2012</p>
          
        <div id="louis_linkbox"><a href="#"><p id="louis_more">VIEW PROJECT</p></a></div>--> 
          
      
      
      
<!-- ..........
    PANEL#8
............-->  
     
         
          
         <!-- <p id="p22_title">395-396 P22</p>
          
          <p id="p22_description"> <b>Designer</b>: Patrick Norguet<br><b>Typology</b>: ARMchairs<br><b>Client</b>: Cassina<br><b>Year</b>: 2013
          </p>
          
        <div id="p22_linkbox"><a href="#"><p id="p22_more">VIEW PROJECT</p></a></div>--> 
        
      
      
      
<!-- ..........
    PANEL#9
............--> 
     
             
         
          <!--<p id="fiji_title">FIJI</p>
          
          <p id="fiji_description"> <b>designer</b>: Cuno Frommherz<br><b>Typology</b>: armchairs<br><b>Year</b>: 2012
         </p>
          
        <div id="fiji_linkbox"><a href="#"><p id="fiji_more">VIEW PROJECT</p></a></div>--> 
        
      
      
      
<!-- ..........
    PANEL#10
............-->
     
               
          
         <!-- <p id="sesann_title">SEASANN</p>
          
          <p id="sesann_description"> <b>designer</b>: Gianfranco Frattini<br><b>Typology</b>: armchairs<br><b>Client</b>: cassina<br><b>Year</b>: 1970
         </p>
          
        <div id="sesann_linkbox"><a href="#"><p id="sesann_more">VIEW PROJECT</p></a></div>-->
        
      
      
      
<!-- ..........
    PANEL#11
............--> 
     
             
          
         <!-- <p id="alessi_title">ALESSI</p>
          
          <p id="alessi_description"> <b>designer</b>: Piero Lissoni<br><b>Client</b>: Alessi<br><b>Year</b>: 2013
         </p>
          
        <div id="alessi_linkbox"><a href="#"><p id="alessi_more">VIEW PROJECT</p></a></div>--> 
        
      
      
<!-- ..........
    PANEL#12
............--> 
     
             
      <div class="print timeline" >
          <p id="timeline_title"><b>timeline</b></p>
          
          <p id="timeline_description"> 
           2014<br>
           2013<br>
           2012<br>
           2011<br>
           2010
         </p>
      </div>
      
      
<!-- ..........
    PANEL#13
............--> 
     
             
      <div class="studio">
          <p id="studio_title">studio</p>
      </div>
      
      
<!-- ..........
    PANEL#14
............-->  
     
         
      <div class="description">
         
    <p id="desc_txtup">
    Lorem ipsum dolor sit amet, consectetur adipisc-<br>ing elit. Phasellus sollicitudin eros sit amet nulla rhoncus dictum.<br><br>

Nam rhoncus fringilla dolor vitae vulputate.Nullam quis eros lorem. Integer cursus erat a orci congue feugiat. Cras rhoncus mollis libero, id aliquet purus varius sed.
         </p>
          
          <p id="desc_txtdn">
          Aenean ullamcorper porta nisl, ac lobortis elit commodo placerat. <br><br> 

Vivamus eget laoreet enim. Sed nunc dui, egestas vel diam convallis, faucibus iaculis sapien. Sed ut vulputate nisi. <br><br>

Proin tempor risus tellus. Maecenas sit amet fringilla urna, vel iaculis velit. Sed ac felis et sem mollis dictum sed id orci.
         </p>
          
      </div>
      
      
<!-- ..........
    PANEL#15
............--> 
     
             
      <div class="awards">
          <div id="office">
              <img src="image/Content/Office.jpg" alt="Office">
          </div>
          
          <p id="awards_title">awards</p>
          
          <div id="text">
            
             <p id="awards_txt_left">
          Aenean ullamcorper porta<br>nisl,<br>ac lobortis elit<br>commodo placerat.<br>Vivamus 
     </p>
     
     <p id="awards_txt_right">
          Aenean ullamcorper porta<br>nisl,<br>ac lobortis elit<br>commodo placerat.<br>Vivamus 
     </p> 
          </div>
          
      </div>
      
      
<!-- ..........
    PANEL#16
............--> 
     
               
      <div class="staff">
        
         <div id="staff_desc">
            
             <p id="staff_title">
             STAFF. 
          </p>
          
          <p id="staff_txt">
Sit amet laoreet sapien dictum. Sed eget eros<br> augue. Pellentesque tempor mi sit amet nisi tincid-<br>unt tincidunt. Fusce malesuada lectus sed mauris<br> pharetra faucibus.<br><br> 

Aenean diam tortor, hendrerit ac pulvinar vel, con-<br>dimentum ac velit. Phasellus eu odio elit. Aenean<br> volutpat mi quam, ut ornare augue tempus ut.<br><br> 

Morbi sagittis diam mauris, in adipiscing nulla<br> convallis ut.
          </p>
         </div>
          
          
          <div id="employee">
              <img src="image/Content/Staff.jpg" alt="Designers">
          </div>
          
      </div>
      
      
<!-- ..........
    PANEL#17
............-->  
     
           
      <div class="print news" >
          <p id="news_title">news</p>
      </div>
      
      
<!-- ..........
    PANEL#18
............--> 
     
             
      <div class="article pflex" >
        
         <div id="FirstNews">
            
             <p id="News_title">
               Mauris et dui sed justo placerat <br>tristique.   
             </p>
             
             <p id="date">
                 11.07.2014
             </p>
             
             <div id="News_img">
                 <img src="/image/Content/FirstNews.jpg" alt="First News">
             </div>
             
             <p id="News_txt">
                 Maecenas imperdiet nisi lorem, sed fermentum tortor pretium<br> eget. Sed mollis lacus quis nunc cursus cursus. Quisque et magna<br> sit amet sapien fermentum scelerisque eu id massa. Mauris<br> ornare massa vel mauris tempus, vitae tempus urna tincidunt.
             </p>
             
             <div id="More_row">
                
                 <a href="#">
                 
                 <p id="Read_more">
                 Read more
                 </p>
                 
             </a>
             
             </div>
             
             
         </div>
         
         
         <div class="SecondNews">
            
             <p id="News_title">
               Proin vehicula nibh massa <br><br>   
             </p>
             
             <p id="date">
                11.06.2014 
             </p>
             
             <div id="News_img">
                 <img src="/image/Content/SecondNews.jpg" alt="Second News">
             </div>
             
             <p id="News_txt">
                 Maecenas imperdiet nisi lorem, sed fermentum tortor pretium<br> eget. Sed mollis lacus quis nunc cursus cursus. Quisque et magna<br> sit amet sapien fermentum scelerisque eu id massa. Mauris<br> ornare massa vel mauris tempus, vitae tempus urna tincidunt.
             </p>
             
             <div id="More_row">
                
                 <a href="#">
                 
                 <p id="Read_more">
                 Read more
                 </p>
                 
             </a>
             
             </div>
             
         </div>
         
         
      </div>
      
      
    
<!-- ..........
    FOOTER
............-->
<div class="footer pflex">
          <div id="map">
             
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1125.1888360604837!2d34.304230294109495!3d53.304005691912835!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xd1b982a10bf9b173!2z0JHRgNGP0L3RgdC60LjQuSDQs9C-0YHRg9C00LDRgNGB0YLQstC10L3QvdGL0Lkg0YLQtdGF0L3QuNGH0LXRgdC60LjQuSDRg9C90LjQstC10YDRgdC40YLQtdGC!5e0!3m2!1sru!2sru!4v1601225537735!5m2!1sru!2sru" width="750" height="645" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
              
          </div>
          
          <div id="foot_txt">
             
              <p id="footaddress">
             90802 California<br>Long beach<br>PO Box 68789<br>300 East Ocean<br>Boulevard
         </p>
         
          <p id="footcontacts">
              +64 9 345 6758<br>info@dsgn-studio.com
          </p>
          
          <div id="logo">
              
              <img src="/image/Content/FootLogo.jpg" alt="DSGN">
              
          </div>
          
          <p id="copyright">
             © 2014  DSGN. All rights reserved - Designed by theuncreativelab.com
          </p>
          
          </div>
          
          
      </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="./main.js"></script>
</body>
</html>