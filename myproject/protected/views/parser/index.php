<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap22.css" />

<?php echo "Hello, julia!"; ?>
<br><br>

<div style="padding:5px;">
<select id="parser_action">
    <option value="1">Команды</option>
    <option value="2">Игроки</option>
</select>
</div>
<div style="padding:5px;">
<input id="parser_uid" value="184"/>
    </div>
<div style="padding:5px;">
    <button id="parsing">ПОЛУЧИТЬ КОНТЕНТ!</button>
    <button id="parsing2">СПАРСИТЬ!</button>
    <button id="parsing3">ПОЛУЧИТЬ ИГРОКОВ!</button>
</div>
<div style="padding:5px;">
<span id="answer"></span><br>
    </div>


<div id='id_team'></div>
<div id='id_stadium'></div>
<div id='id_coach'></div>


<div id="content2" style="display:block;"></div>
<div id="content" style="display:none;"></div>

<div id="content_player" style="display:block;"></div>
<div id="content_coach" style="display:block;"></div>
<div id="content_stadium" style="display:block;"></div>

<script>
    String.prototype.stripTags = function() {
        return this.replace(/<\/?[^>]+>/g, '');
    };
    // For todays date;
    Date.prototype.today = function () {
        return ((this.getDate() < 10)?"0":"") + this.getDate() +"/"+(((this.getMonth()+1) < 10)?"0":"") + (this.getMonth()+1) +"/"+ this.getFullYear();
    }

    // For the time now
    Date.prototype.timeNow = function () {
        return ((this.getHours() < 10)?"0":"") + this.getHours() +":"+ ((this.getMinutes() < 10)?"0":"") + this.getMinutes() +":"+ ((this.getSeconds() < 10)?"0":"") + this.getSeconds();
    }

    function MatchDemo(s)
    {
        var r, re;
        re = /\D+/ig;
        r = s.replace(re, ',');
        return(r);
    }


    function getEngName(str){
        var newstr=str;
        switch (str) {
            case "Название": return "name";
            case "Имя": return "firstname";
            case "Фамилия": return "lastname";
            case "Команда": return "team";
            case "Национальность": return "country";
            case "Дата рождения": return "birth_day";
            case "Название": return "name";
            case "Главный тренер": return "coach";
            case "Год основания": return "founded";
            case "Год открытия": return "founded";
            case "Сайт": return "site";
            case "Телефон": return "phone";
            case "Город": return "city";
            case "Страна": return "country";
            case "Вместимость": return "capacity";
            case "Размеры поля": return "field_size";
            case "Полное имя": return "name";
            case "Город рождения": return "city";
            case "Позиция": return "pos";
            case "Рабочая нога": return "workingleg";
            case "Стоимость": return "price";
            case "Рост": return "growth";
                //Рост/Вес:
            case "Стоимость": return "price";
            case "Вес": return "weight";
            case "Номер": return "number";
            case "Контракт до": return "contract";


        }

        return newstr;
    }



    // ПАРСИНГ ИГРОКОВ
    $(document.body).on("click", "#parsing3", function (event) {
        var action=$("#parser_action").val();
        var uid=$("#parser_uid").val();
        $.ajax({
            url: '<?php echo Yii::app()->createUrl('parser/index'); ?>',  //$('#createurl-add').html(),
            type: 'POST',
            data: "action="+action+"&uid="+uid,
            success: function (html) {
                $("#content").html(html);
                newMessage("parse",0,"Team with id: "+uid);
                $("#content2").html($("#content .page_right_block").children(0).html());
                startParsingPlayer();
                return;
            }
        });
        event.preventDefault();
    })




    function startParsingPlayer(){
        var resultp="";
        var i=0;
//$(".page_right_block .block_body table a").size();
        //size=$(".elm_info_player a").size();
        size=$(".page_right_block .block_body table a").size();
        //$(".elm_info_player a").each(function(){
        $(".page_right_block .block_body table a").each(function(){
            //if (i!=0) return;
            i++;
            if (i%2==0) return;
            var url=$(this).attr("href");
            //alert(url);
            var request = $.ajax({
                url: "<?php echo Yii::app()->createUrl('parser/url'); ?>",
                type: "POST",
                data: "action=2"+i+"&url="+url,
                async: false
            });

            request.done(function( html ) {
                $("#content_player").html(html);
                //$("#answer").append("<br>get successful: <b>2. COACH</b>");
                newMessage("parse",0,"Player with number: "+i);
                $("#content_player").append($("#content_player .block_body").html());
                var j=0;
                if (i%4==0) alert("yes");
                $("#content_player div").each(function(){
                    j++;
                    if (j===1){
                        resultp+="photo["+i+"]="+$("#content_player .profile_foto").children().eq(0).attr("src")+"&";
                        resultp+="rusname["+i+"]="+$("#content_player .profile_info_title").html()+"&";
                    }
                    var class2=$(this).attr("class");
                    if (class2=="profile_info_key") {

                        var temp=$(this).find('b').html();
                        temp=temp.substring(0, temp.length - 1);
                        temp=getEngName(temp);
                        alert(temp);

                        if (temp!=="team" && temp!=="Страна рождения" && temp!=="В аренде"){
                            var value=$(this).next("div").html();
                            if (temp==="birth_day" || temp==="price" || temp==="growth" || temp==="weight") {
                                if (temp=="price"){
                                    value=value.replace(/\,/g, "")
                                }
                                value = value.split(' ')[0];
                                resultp+=temp+'['+i+']'+'='+value+'&';
                            }
                            else if (temp==="Рост/вес"){

                                var s = MatchDemo(value);
                                alert(s);
                                //document.write( MatchDemo(s) )
                                s=s.split(",");
                                resultp+='growth['+i+']'+'='+s[0]+'&';
                                resultp+='weight['+i+']'+'='+s[1]+'&';
                                alert(resultp);
                            }
                            else{
                                value = value.split('&nbsp')[0];
                                resultp+=temp+'['+i+']'+'='+value+'&';
                            }
                        }
                        //alert();
                    }
                })



                //alert("2step");
                return ;//newCoachAdd();
            });

        })
        resultp=resultp.stripTags();
        newMessage("parse",0," All Player ("+(i/2)+")");//resultp);
        alert("start?");
        i=i*2;
        var thisteam=$("#id_team").html();
        var request = $.ajax({
            url: "<?php echo Yii::app()->createUrl('parser/add7'); ?>",
            type: "POST",
            data: "action=7&team="+thisteam+"&count="+(i/2)+"&"+resultp,
            async: false
        });

        request.done(function( html ) {
            alert("you");
            $("body").append(html);
            newMessage("add",0,"All player adding or updating");
            newMessage("add",0,"Relation with players and team");
            //$("#id_stadium").html(html);
            //newRelationship(id_team,id_coach,id_stadium);
            return html;
        });



        //alert(resultp);
    }












    function newStadiumAdd(){
        //alert("3step");
        var result3="";
        $("#content_stadium div").each(function(){
            var class2=$(this).attr("class");
            if (class2=="profile_info_key") {

                var temp=$(this).find('b').html();
                //temp=temp.substring(0, temp.length - 1);
                var value=$(this).next("div").html();
                if (temp==="Команды" || temp==="Погода") {
                    value = value.split(' ')[0];
                }
                else{
                    value = value.split('&nbsp')[0];
                    temp=getEngName(temp);
                    result3+=temp+'='+value+'&';
                }
                //alert();
            }
        })

        result3+="photo="+$("#content_stadium .profile_foto").children().eq(0).attr("src");
        result3+="&name="+$("#content_stadium .profile_info_title").html();

        //result=result.substring(0, result.length - 1);
        result3=result3.stripTags();
        alert(result3);

        var request = $.ajax({
            url: "<?php echo Yii::app()->createUrl('parser/add3'); ?>",
            type: "POST",
            data: "action=4&"+result3,
            async: false
        });

        request.done(function( html ) {
            alert("6step");
            newMessage("add",0,"Stadium with id: "+html);
            $("#id_stadium").html(html);
            newRelationship(id_team,id_coach,id_stadium);
            return html;
        });

    }


    function newStadiumLoad(url){
        //alert(url);
        url2="<?php echo Yii::app()->createUrl('parser/url'); ?>";
        //alert(url2);
        //alert("1step");
        var request = $.ajax({
            url: url2,
            type: "POST",
            data: "action=2&url="+url,
            async: true
        });

        request.done(function( html ) {
            //alert("yes");
            $("#content_stadium").html(html);
            newMessage("parse",0,"Stadium with id: -");
            $("#content_stadium").html($("#content_stadium .block_body").html());
            //alert("yes");
            return newStadiumAdd();
        });
    }


    function newTeamAdd(result){
        //alert("0step");
        var request = $.ajax({
            url: "<?php echo Yii::app()->createUrl('parser/add'); ?>",
            type: "POST",
            data: "action=3&"+result,
            async: false
        });

        request.done(function( html ) {
            newMessage("add",0,"Team with id: "+html);
            $("#id_team").html(html);
            //alert("00step");
            return html;
        });
    }


    function newCoachAdd(){
        //alert("3step");
        var result2="";
        $("#content_coach div").each(function(){
            var class2=$(this).attr("class");
            if (class2=="profile_info_key") {

                var temp=$(this).find('b').html();
                temp=temp.substring(0, temp.length - 1);
                temp=getEngName(temp);
                var value=$(this).next("div").html();
                if (temp==="birth_day") {
                    value = value.split(' ')[0];
                }
                value = value.split('&nbsp')[0];

                result2+=temp+'='+value+'&';
                //alert();
            }
        })

        result2+="photo="+$("#content_coach .profile_foto").children().eq(0).attr("src");
        result2+="&rusname="+$("#content_coach .profile_info_title").html();

        //result=result.substring(0, result.length - 1);
        result2=result2.stripTags();
        //alert(result2);

        var request = $.ajax({
            url: "<?php echo Yii::app()->createUrl('parser/add2'); ?>",
            type: "POST",
            data: "action=2&"+result2,
            async: false
        });

        request.done(function( html ) {
            alert("4step");
            //$("#answer").append("<br>add successful: <b>COACH with id: "+html+"</b>");
            newMessage("add",0,"Coach with id: "+html);
            $("#id_coach").html(html);
            return html;
        });
        /*$.ajax({
            url: '<?php //echo Yii::app()->createUrl('parser/add'); ?>',  //$('#createurl-add').html(),
            type: 'POST',
            data: "action=2&"+result,
            success: function (html) {
                //$("#content_coach").html(html);
                $("#answer").append("<br>add successful: <b>COACH with id: "+html+"</b>");
                //$("#content_coach").html($("#content_coach .block_body"));
                //current_page=$("#yw1 .selected a").html();
                //$(".userlist").load($('#createurl-userpage').html()+current_page+' .userlist');
                return html;//newCoachAdd();
            }
        });

         $("body").append("<div id='id_team'>"+id_team+"</div>");
         $("body").append("<div id='id_stadium'>"+id_stadium+"</div>");
         $("body").append("<div id='id_coach'>"+id_coach+"</div>");

        */


    }

    function newCoachLoad(url){
        //alert(url);
        //alert("1step");
        var request = $.ajax({
            url: "<?php echo Yii::app()->createUrl('parser/url'); ?>",
            type: "POST",
            data: "action=2&url="+url,
            async: false
        });

        request.done(function( html ) {
            $("#content_coach").html(html);
            //$("#answer").append("<br>get successful: <b>2. COACH</b>");
            newMessage("parse",0,"Coach with id: -");
            $("#content_coach").html($("#content_coach .block_body"));
            //alert("2step");
            return newCoachAdd();
        });


        /*
        $.ajax({
            url: '<?php //echo Yii::app()->createUrl('parser/url'); ?>',  //$('#createurl-add').html(),
            type: 'POST',
            data: "action=2&url="+url,
            success: function (html) {
                $("#content_coach").html(html);
                $("#answer").append("<br>get successful: <b>2. COACH</b>");
                $("#content_coach").html($("#content_coach .block_body"));
                //current_page=$("#yw1 .selected a").html();
                //$(".userlist").load($('#createurl-userpage').html()+current_page+' .userlist');
                return newCoachAdd();
            }
        });*/
    }




    function newRelationship(id_team,id_coach,id_stadium){

        var id_team2=$("#id_team").html();
        var id_coach2=$("#id_coach").html();
        var id_stadium2=$("#id_stadium").html();


        var data="action=6&team="+id_team2+"&coach="+id_coach2+"&stadium="+id_stadium2;
        alert(data);
        var request = $.ajax({
            url: "<?php echo Yii::app()->createUrl('parser/add4'); ?>",
            type: "POST",
            data: data,
            async: false
        });

        request.done(function( html ) {
            newMessage("add",0,"Relationship beetwen team, coach and stadium.");
            alert(html);
            return html;
        });
    }

    $(document.body).on("click", "#parsing2", function (event) {
        newMessage("",0,"<hr>");
        var action=$("#parser_action").val();//data("user-id");
        var uid=$("#parser_uid").val();//data("user-id");


        var result="";
        var parse_coach="";
        var parse_stadium="";

        $("#content2 div").each(function(){
            var class2=$(this).attr("class");

            if (class2=="profile_info_key") {
                //
                var temp=$(this).find('b').html();
                temp=temp.substring(0, temp.length - 1);
                if (temp==="Главный тренер"){
                    parse_coach=$(this).next("div").children().eq(0).children().eq(0).attr("href");//html();//.attr("href");
                    //alert(id);
                    //var value=id;//$(this).next("div").html();
                    //value = value.split('&nbsp')[0];
                }
                else if(temp==="Стадион") {
                    parse_stadium=$(this).next("div").children().eq(0).children().eq(0).attr("href");//html();//.attr("href");
                }
                else {
                    temp=getEngName(temp);
                    var value=$(this).next("div").html();
                    value = value.split('&nbsp')[0];
                    result+=temp+'='+value+'&';
                }
            }

        })

        result+="photo="+$("#content2 .profile_foto").children().eq(0).attr("src");
        result+="&rusname="+$("#content2 .profile_info_title").html();



        //result=result.substring(0, result.length - 1);
        result=result.stripTags();
        //alert(result);
        //alert(parse_stadium);

        //var
            id_team=newTeamAdd(result);
       // var
        id_coach=newCoachLoad(parse_coach);
        //var
         id_stadium=newStadiumLoad(parse_stadium);
        //var temp2=newRelationship(id_team,id_coach,id_stadium);

        //alert("0step");



        event.preventDefault();
    })


var id_team;
    var id_coach;
    var id_stadium;


// ПАРСИНГ ОСНОВНОЙ ЧАСТИ КЛУБА
    $(document.body).on("click", "#parsing", function (event) {
        var action=$("#parser_action").val();
        var uid=$("#parser_uid").val();
        $.ajax({
            url: '<?php echo Yii::app()->createUrl('parser/index'); ?>',  //$('#createurl-add').html(),
            type: 'POST',
            data: "action="+action+"&uid="+uid,
            success: function (html) {
                $("#content").html(html);
                newMessage("parse",0,"Team with id: "+uid);
                $("#content2").html($("#content .page_content").children(0).html());
                return;
            }
        });
        event.preventDefault();
    })





    function newMessage(action,space,mess){
        var datetime = new Date().today() + " " + new Date().timeNow();
        var nbsp="";
        for(var i=0; i<space*2;i++) {nbsp+=" ";}
        $("#answer").append("<span>"+datetime+"</span>"+nbsp+": <b>success "+action+"</b> "+mess+"<br>");
        return;
    }

    /*$.ajax({
     url: '<?php// echo Yii::app()->createUrl('parser/index'); ?>',  //$('#createurl-add').html(),
     type: 'POST',
     data: "action="+action+"&uid="+uid,
     success: function (html) {
     $("#content").html(html);
     return;
     }
     });*/
    //user_name = $(this).parent().prev().prev().html();
    // alert(user_name);

    //$("#content").get('http://soccer365.ru/clubs/'+uid+'/');

    /*$.ajax({
     url: 'http://www.soccer365.ru/clubs/'+uid+'/',  //$('#createurl-add').html(),
     type: 'GET',
     //dataType: 'jsonp',
     //data: "action="+action+"&uid="+uid,
     success: function (html) {
     $("#content").html(html);
     alert("yes");
     return;
     }
     });*/
    //current_page=$("#yw1 .selected a").html();
    //$(".userlist").load($('#createurl-userpage').html()+current_page+' .userlist');
    //$("#answer").html("get successful: <b>1. TEAM WITH ID "+uid+"</b>");




</script>
<style>
    #answer{}
    #answer span{color:#999;}

</style>