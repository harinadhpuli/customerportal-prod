
$(document).ready(function(){
    
  /*  $(".navbar-leftblock .dropdown").hover(            
        function() {
         
            $('.dropdown-menu', this).stop( true, true ).slideDown("fast");
            $(this).toggleClass('open');        
        },
        function() {
            $('.dropdown-menu', this).stop( true, true ).slideUp("fast");
            $(this).toggleClass('open');       
        }
    ); */

/* checkbox All fuction */
$(document).on('click','.checkall', function(){
   checkedAll();
});
$(document).on('click','.rowcheck', function(){
    checkedAllStatus(this);
 });
 function checkedAll(){
    if($('.checkall').is(':checked')){
        $('.rowcheck').prop('checked',true);
    }else{
        $('.rowcheck').prop('checked',false);
    }
 }
 function checkedAllStatus(e){
     var tem =[];
     $( ".rowcheck" ).each(function() {
         if(jQuery.inArray($( this ).prop('checked'),tem)  == -1){
            tem.push($( this ).prop('checked'));
         }
      });
      if(tem.length > 1 || tem.length < 1){
        $('.checkall').prop('checked',false);
      }else{
        $('.checkall').prop('checked',true);
      }
 }
    
});

$('.datepicker').datepicker({ autoclose: true,  todayHighlight: true});
jQuery('.timepicker').timepicker({defaultTIme: false});
$('.adduserFiltering').multiselect({enableFiltering: true});


/* Uplode */
$(function() {

    // We can attach the `fileselect` event to all file inputs on the page
    $(document).on('change', ':file', function() {
      var input = $(this),
          numFiles = input.get(0).files ? input.get(0).files.length : 1,
          label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
      input.trigger('fileselect', [numFiles, label]);
    });
  
    // We can watch for our custom `fileselect` event like this
    $(document).ready( function() {
        $(':file').on('fileselect', function(event, numFiles, label) {
  
            var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;
  
            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }
  
        });
    });
    $(document).on('click','.adduser-card li .adduser-remove-bt', function(){
        var this1=this;
        swal({
            title: "Are you sure delete this user?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, Remove it!",
            closeOnConfirm: false
        },
        function(){
            $(this1).closest('li').remove();
            swal({
                title:"Removed!", 
                text:"The user has been removed.", 
                type:"success",
                confirmButtonClass:"btn-success"
            });
        });
    });
});