Application = function () {
    this.container = $('#content');
    //initialization after page reloading
    this.init = function () {
        var self = this;

        //assign userList with top menu link via ajax
       /* $('#mainmenu a').click(function (event) {
            self.userList();
            event.preventDefault();
        });*/

        //user list page
        this.userList = function () {
            var self = this;
            self.container.html('');
            $.ajax({
                url: '/api/users',
                type: 'GET',
                success: function (users) {
                    if ('errors' in users) {
                        alert(JSON.stringify(users.errors));
                        return;
                    }
                    self.container.append('<input id="add" type=button value=Добавить></input>');
                }
            });
        };


    };

    $(window).scroll(function () {
        if ($(this).scrollTop() > 41) {
            //$('#header2').css()
            $('#header2').css("top","0");
            $('#leftmenu').css("top","41px");               
        } else {
            i = $(this).scrollTop();
            result=41-i;
            result2=85-i;       
            $('#header2').css("top",result);    
            $('#leftmenu').css("top",result2);      
            // бла-бла-бла
        }
    });


    this.init();
}

$(function () {
    new Application();
});



/*
var a = sum(2,2)

var sum = function(x,y) {
    return x+y
}
*/

$(document).ready(function(){
    i = $(window).scrollTop();
    if (i > 41) {
        //$('#header2').css()
        $('#header2').css("top","0");
        $('#leftmenu').css("top","41px");   
    } 

})

Noty = function (content,time) {
    this.container = $('body');
    this.content = content;
    this.time = time;
    this.id='noty0';

    this.init = function () {
        var self = this;
        var n = $( ".noty" ).length;
        self.id='noty'+(n+1);
        //alert(n);
        var bottom=n*70+15;
        self.container.append('<div id="'+self.id+'" class="noty" style="bottom:'+bottom+'px !important">'+self.content+'</div>');




        function deleteNoty(){
            $('#'+self.id).hide('slow', function(){ $('#'+self.id+' ').remove(); });
        }
        setTimeout (deleteNoty, self.time);
    }


    this.noteList = function () {
        var self = this;
    }


    $(document.body).on("click", ".noty", function (event) {
        //$(this).hide('slow', function(){ $(this).remove(); });
        $(this).hide('slow', function(){ $(this).remove(); });        
        event.preventDefault();
    });    

    this.init();
}





function setEqualHeight(columns)  
{  
var tallestcolumn = 0;  
columns.each(  
function()  
{  
currentHeight = $(this).height();  
if(currentHeight > tallestcolumn)  
{  
tallestcolumn  = currentHeight;  
}  
}  
);  
columns.height(tallestcolumn);  
} 

$(document).ready(function(){
    /*$('#openleftmenu').click(function(event){
        $('#leftmenu').show();
        $('#left').hide();
        event.preventDefault();
    }); */
    //setEqualHeight($('#leftmenu,.left-sidebar, .right-sidebar, .container')); 
    
    $('#openleftmenu').click(function(event){
        //alert('1');
        $('#leftmenu').toggle();//show();
        $('.left-sidebar').toggle();//hide();
        event.preventDefault();
    }/*, function() {
        $('#leftmenu').hide();
        $('.left-sidebar').show();  
        event.preventDefault();         
    }*/); 


    var height=$(".mchat_smilespanel").css("height");//,"-"++"")
    if (!height) height=7; else height=height.substr(0, height.length-2); height=+height+7;
    $(".mchat_smilespanel").css("top","-"+height+"px");
    $(".mchat_smiles").click(function() {
        smilespanel();
    });
    
});





function smiles(tx) {
    $('#mchatMsgF').val($('#mchatMsgF').val()+' '+tx+' ');
    $('#mchatMsgF').focus();
    smilespanel();
}

function smilespanel() {
    var cnd=$(".mchat_smiles").attr("rel");
    if (cnd=="close") {
        $(".mchat_smiles").attr("rel","open");
        //$(".mchat_smiles").css("opacity","0.9");
        //$(".mchat_smiles:hover").css("opacity","1");
        $(".mchat_smiles").css("background-position","0 0");
        $(".mchat_smilespanel").css("display","block");
        $(".mchat_smilespanel").animate({"opacity": "1"}, 100);

    } else {
        $(".mchat_smiles").attr("rel","close");
        $(".mchat_smiles").css("background-position","-17px 0");
        //$(".mchat_smiles:hover").css("opacity","1");
        //$(".mchat_smiles").css("opacity","0.5");
        $(".mchat_smilespanel").animate({"opacity": "0"}, 100);
        setTimeout(' $(".mchat_smilespanel").css("display","none");', 100)
    }
}


// Кнопка Наверх
$(function(){ 
    $(window).bind('scroll resize',function(){
        var w = ($(window).width()-$('#main_container').width())/2;
        if(w>=45) {
            //$('div#scrollTop').width(w);
            $('div#scrollTop').width(100);
            ($(window).scrollTop()>0 ) ? $('div#scrollTop').fadeIn() : $('div#scrollTop').fadeOut(); 
        } else {
            $('div#scrollTop').hide();
        }
    });
    $('div#scrollTop').click(function () {$('body,html').animate({scrollTop:0},400); return false;});
});



$(function(){ 
    $('.north').tipsy({gravity: 'n'});
    $('.south').tipsy({gravity: 's'});
    $('.east').tipsy({gravity: 'e'});
    $('.west').tipsy({gravity: 'w'});  

});
