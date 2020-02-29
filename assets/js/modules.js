$("#header").load("assets/includes/header.html");


$(document).ready(function(){
    $(document).on("mouseover", '.navbar-leftblock .dropdown', function(event) { 
       $('.dropdown').removeClass('open');
       $(this).addClass('open');
    });
    $(document).on("mouseover", '.content-page', function(event) { 
      
        $('.dropdown').removeClass('open');
       
     });
}); 
