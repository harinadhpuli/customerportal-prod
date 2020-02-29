$(document).ready(function () {

  // Active nav bar button 
$(document).on('mouseover','body', function(){
  $('.navbar-nav li.footagebtn').addClass('active');
});

  //add Active Class to all filter box buttons
  $(document).on('click', '.filter-box ul li a', function () {

    $(this).toggleClass('active');
  });
  // Active class for color list 
  $(document).on('click', '.colorlist li .colortile', function () {
    $(this).toggleClass('selected');
  });

  // responsive-calendar 
  $(".responsive-calendar").responsiveCalendar({
    time: '2018-09',
    events: {
      "2018-09-10": { "customClass": "events" },
      "2018-09-12": { "customClass": "events" },
      "2018-09-15": { "customClass": "events" },
      "2018-05-12": {}
    }
  });
  // Event show select

  $(document).on('click', '.eventsqueelist .eventrow .icon-checkbox', function () {
    $(this).toggleClass('select');
    $(this).parent('li').toggleClass('active');
    eventCommonCheck();
  });

  // Multi action select bar 
  function eventCommonCheck() {
    var check = false;
    var countVal = 0;
    $(".eventrow ul li").each(function () {
      if ($(this).hasClass('active')) {
        check = true;
        countVal++;
      }
    });
    console.log(countVal);
    if (check) {
      $('.mutiselect-actbar').show();
      $('.share-btn').attr('data-count', countVal);
      $('.footage-action-row').hide();
      
    }
    else {
      $('.mutiselect-actbar').hide();
      $('.footage-action-row').show();
    }
  }

  //close
  $(document).on('click', '.actclose', function () {
    $(".eventrow ul li").removeClass('active');
    $('.mutiselect-actbar').hide();
    $('.footage-action-row').show();
    $('.eventsqueelist .eventrow .icon-checkbox').removeClass('select');
  });
  $(document).on('click', '.share-btn', function () {
    $('.header-share').show();
    $('#share-preview-count').html($(this).attr('data-count'));
  });
  $(document).on('click', '.sharealllinks', function () {
    $('.header-share-all').show();
 
  });


  $(document).on('click', '.header-share .actclose', function () {
    $('.header-share').hide();
  });

  
  $(document).on('click', '.header-share-all .actclose', function () {
    $('.header-share-all').hide();
  }); 

  $(document).on('click', '.timeslider-handle', function () {
    $(this).hide();
    $('#timeslider').show();
    $('.content-page').addClass('slideLeftAct');
    $('.content-page').addClass('slideInRight');
    $('#cover').show();
  });

  $(document).on('click', '#timeslider .now', function () {
    $('#timeslider').hide();
    $('.content-page').removeClass('slideLeftAct');
    $('.content-page').removeClass('slideInRight');
    $('#cover').hide();
    $('.timeslider-handle').show();
  });

  $(document).on('click', '#cover', function () {
    $(this).hide();
    $('#timeslider').hide();
    $('.content-page').removeClass('slideLeftAct');
    $('.content-page').removeClass('slideInRight');
    $('.timeslider-handle').show();
  });
  
  //Footage Filter 

$('.footsearchFilter').hide();
  $(document).on('focus','.footageSearch', function(){
    $(this).addClass('focused');
    console.log(0);
    $('.footsearchFilter').show();

  });

  $(document).on('mouseover','.footageSearch', function(){
   
    if($('.footageSearch').hasClass('focused'))
    {
      $('.footsearchFilter').show();
    }
   

  });

  $(document).on('click', '.footsearchFilter .dropdown-menu li', function(e){
    var finalValue="";
    e.stopPropagation();
    $(this).prop('checked',false);
    if($(this).closest('.dropdown-menu').hasClass('colorlist') || $(this).closest('.dropdown-menu').hasClass('timeList')){
      $(this).closest('.dropdown-menu').find('li').removeClass('active');
      $(this).closest('li').addClass('active');
    }else{
      if(!$(this).hasClass('active')){
        $(this).addClass('active');
        $(this).find('input[type="checkbox"]').prop('checked',true);
      }else{
        $(this).removeClass('active');
        $(this).find('input[type="checkbox"]').prop('checked',false);
      }
    }
 
    //data binding to search box
    $('.footsearchFilter .dropdown-menu li').each(function(){
      if($(this).hasClass('active')){
        finalValue+=$(this).attr('data-value')+"+";
      }
    });
    //search icon change
    $('.footageSearch').val(finalValue.substr(0,finalValue.length-1));
    if(finalValue.substr(0,finalValue.length-1) !=""){
      if(!$('.icon').find('i').hasClass('fa-close')){
        $('.icon').find('i').addClass('fa-close');
        $('.icon').find('i').removeClass('fa-search');
      }
    }else{
      if(!$('.icon').find('i').hasClass('fa-search')){
        $('.icon').find('i').removeClass('fa-close');
        $('.icon').find('i').addClass('fa-search');
      }
    }
  });

   // Date and Time Picker Inst
   $(function () {
      $('.datetimepicker').datetimepicker({
        format: "dd MM yyyy - hh:ii",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });
      
  });

$(document).on("click", "#submit_btn", function(event){
  var rangVal= $('.footageSearch').val();
  var fromDate=$('.fromdate').val();
  var toDate=$('.todate').val();

  $('.footageSearch').val(rangVal+' '+fromDate+' to '+toDate);
});

//removing the footage search data
$(document).on('click','.icon .fa-close',function(){
  $('.footageSearch').val("");
  $('.icon').find('i').toggleClass('fa-close fa-search');
  $('.footsearchFilter .dropdown-menu li').each(function(){
    $(this).removeClass('active');
  });
}); 

// filter dropdown

$(document).on('click', '.footsearchFilter .dropdown-menu', function(e) {
  e.stopPropagation();
});

}); 

