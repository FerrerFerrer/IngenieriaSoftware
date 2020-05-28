jQuery(document).ready(function($){
    
    $('.tab-btn').click(function(e){
       
       id = $(this).attr('id');
       
       $('.tabs li').removeClass('active');
       $(this).parent('li').addClass('active');
       
       $.ajax({
            type:'post',
            url : book_landing_page_ajax.url, 
            data: {  'action' : 'book_landing_page_cat_ajax', 'id' : id },          
            beforeSend: function(){
                $('#loader').fadeIn(500);
            },
            success: function(response){ 
                $('.tab-content').html(response);
            },
            complete: function(){
                $('#loader').fadeOut(500);             
            }            
        });      
        
    });    
    
});
