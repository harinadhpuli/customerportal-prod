jQuery(document).ready(function ($) {



  // Initiate superfish on nav menu

  $('.nav-menu').superfish({

    animation: {

      opacity: 'show'

    },

    speed: 400

  });



  // Mobile Navigation

  if ($('#nav-menu-container').length) {

    var $mobile_nav = $('#nav-menu-container').clone().prop({

      id: 'mobile-nav'

    });

    $mobile_nav.find('> ul').attr({

      'class': '',

      'id': ''

    });

    $('body').append($mobile_nav);

    $('body').prepend('<button type="button" id="mobile-nav-toggle"><i class="fa fa-bars"></i></button>');

    $('body').append('<div id="mobile-body-overly"></div>');

    $('#mobile-nav').find('.menu-has-children').prepend('<i class="fa fa-chevron-down"></i>');



    $(document).on('click', '.menu-has-children i', function (e) {

      $(this).next().toggleClass('menu-item-active');

      $(this).nextAll('ul').eq(0).slideToggle();

      $(this).toggleClass("fa-chevron-up fa-chevron-down");

    });



    $(document).on('click', '#mobile-nav-toggle', function (e) {

      $('body').toggleClass('mobile-nav-active');

      $('#mobile-nav-toggle i').toggleClass('fa-times fa-bars');

      $('#mobile-body-overly').toggle();

    });



    $(document).click(function (e) {

      var container = $("#mobile-nav, #mobile-nav-toggle");

      if (!container.is(e.target) && container.has(e.target).length === 0) {

        if ($('body').hasClass('mobile-nav-active')) {

          $('body').removeClass('mobile-nav-active');

          $('#mobile-nav-toggle i').toggleClass('fa-times fa-bars');

          $('#mobile-body-overly').fadeOut();

        }

      }

    });

  } else if ($("#mobile-nav, #mobile-nav-toggle").length) {

    $("#mobile-nav, #mobile-nav-toggle").hide();

  }



  /* Menu Active based on URL */

 setTimeout(function(){ 

   activateMenu();

     }, 3);

  /* Menu Active based on URL  End*/



  //activate the menu

function activateMenu(){

  var path = window.location.href;

  path = path.replace(/\/$/, "");	

  var result= path.split('/');

  var Param1 = result[result.length-1];

  //var right_first_part=path.substring(0,path.lastIndexOf("/"));

  sidebarMenu(Param1);

}

function sidebarMenu(fileName){



  $(".navbar-nav li a").each(function () {

     

      var href = $(this).attr('href');

      var hrefFileName = href.substr(0,href.lastIndexOf("/"));

      if(hrefFileName == ""){

          hrefFileName = href;

      }

     

      if (fileName === hrefFileName) {

       

         $(this).closest('li').addClass('active');

         if($(this).closest('ul').parent( "li" ).length > 0){

            $(this).closest('li').closest('ul').parent('li').addClass('active');

                if($(this).closest('ul').parent( "li" ).closest('ul').parent('li').length > 0){

                      $(this).closest('ul').parent( "li" ).closest('ul').parent('li').addClass('active');

                      if($(this).closest('ul').parent( "li" ).closest('ul').parent('li').closest('ul').parent('li').length > 0){

                      $(this).closest('ul').parent( "li" ).closest('ul').parent('li').closest('ul').parent('li').addClass('active');

                }

                }

         }

      }

  });



  }







});

