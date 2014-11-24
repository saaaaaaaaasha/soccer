<?php

class Text
{
    static function GetShotName2($str,$russian=true){
        if ($str=="Манчестер Юнайтед") return "МЮ";
        elseif ($str=="Манчестер Сити") return "МС";
        elseif ($str=="Куинз Парк Рейнджерс") return "КПР";
        return $str;
    }

    static function GetShotName($str,$russian=false){
        if ($russian==true){
            if ($str=="Chelsea FC") return "Челси";
            elseif ($str=="Queens Park Rangers FC") return "КПР";
            elseif ($str=="Manchester United FC") return "МЮ";
            elseif ($str=="Burnley FC") return "Барнли";
            elseif ($str=="Leicester City FC") return "Лестер";
            elseif ($str=="Crystal Palace FC") return "Кристал Пэлас";
            elseif ($str=="Aston Villa FC") return "Астон Вилла";
            elseif ($str=="Hull City AFC") return "Халл";
            elseif ($str=="Sunderland AFC") return "Коты";
            elseif ($str=="West Bromwich Albion FC") return "Вест Бром";
            elseif ($str=="Tottenham Hotspur FC") return "Тотенхем";
            elseif ($str=="Liverpool FC") return "Ливерпуль";
            elseif ($str=="Everton FC") return "Эвертон";
            elseif ($str=="Southampton FC") return "Святые";
            elseif ($str=="Manchester City FC") return "М. Сити";
            elseif ($str=="West Ham United FC") return "Вест Хэм";
            elseif ($str=="Swansea City AFC") return "Суонси";
            elseif ($str=="Arsenal FC") return "Арсенал";
            elseif ($str=="Newcastle United FC") return "Ньюкал";
            elseif ($str=="Stoke City FC") return "Стоук";
        }

        if ($str=="Chelsea FC") return "Chelsea";
        elseif ($str=="Queens Park Rangers FC") return "QPR";
        elseif ($str=="Manchester United FC") return "Man. United";
        elseif ($str=="Burnley FC") return "Burnley";
        elseif ($str=="Leicester City FC") return "Leicester";
        elseif ($str=="Crystal Palace FC") return "Crystal Palace";
        elseif ($str=="Aston Villa FC") return "Aston Villa";
        elseif ($str=="Hull City AFC") return "Hull City";
        elseif ($str=="Sunderland AFC") return "Sunderland";
        elseif ($str=="West Bromwich Albion FC") return "West Bromwich";
        elseif ($str=="Tottenham Hotspur FC") return "Tottenham";
        elseif ($str=="Liverpool FC") return "Liverpool";
        elseif ($str=="Everton FC") return "Everton";
        elseif ($str=="Southampton FC") return "South.";
        elseif ($str=="Manchester City FC") return "Man. City";
        elseif ($str=="West Ham United FC") return "West Ham";
        elseif ($str=="Swansea City AFC") return "Swansea";
        elseif ($str=="Arsenal FC") return "Arsenal";
        elseif ($str=="Newcastle United FC") return "Newcastle";
        elseif ($str=="Stoke City FC") return "Stoke";
        return $str;
    }




    static function findMatches($str1,$str2,$step){
        $str1=trim($str1);
        $str1=mb_ereg_replace("[^a-zA-Z]", '', $str1);
        $str1=mb_strtolower($str1);

        $str2=trim($str2);
        $str2=mb_ereg_replace("[^a-zA-Z]", '', $str2);
        $str2=mb_strtolower($str2);

        //$result = $str1." ".$str2;
        //return $result;
        $count=0;
        $len = min(strlen($str1),strlen($str2));
        for($i = 0; $i<$len-1; $i++) {
            if (strpos($str2, substr($str1, $i, $step)) !== false) {
                $count++;
                //break;
            }
        }

        return $count*100/($len-1);
    }

    static function replaceBBCode($text_post){
        $str_search = array(
            //"#\\\n#is",
            "#\[b\](.+?)\[\/b\]#is",
            "#\[i\](.+?)\[\/i\]#is",
            "#\[u\](.+?)\[\/u\]#is",
            "#\[code\](.+?)\[\/code\]#is",
            "#\[quote\](.+?)\[\/quote\]#is",
            "#\[url=(.+?)\](.+?)\[\/url\]#is",
            "#\[url\](.+?)\[\/url\]#is",
            "#\[img\](.+?)\[\/img\]#is",
            "#\[size=(.+?)\](.+?)\[\/size\]#is",
            "#\[color=(.+?)\](.+?)\[\/color\]#is",
            "#\[list\](.+?)\[\/list\]#is",
            "#\[listn](.+?)\[\/listn\]#is",
            "#\[\*\](.+?)\[\/\*\]#"
        );
        $str_replace = array(
            //"<br />",
            "<b>\\1</b>",
            "<i>\\1</i>",
            "<span style='text-decoration:underline'>\\1</span>",
            "<code class='code'>\\1</code>",
            "<table width = '95%'><tr><td>Цитата</td></tr><tr><td class='quote'>\\1</td></tr></table>",
            "<a href='\\1'>\\2</a>",
            "<a href='\\1'>\\1</a>",
            "<img src='\\1' alt = 'Изображение' />",
            "<span style='font-size:\\1px'>\\2</span>",
            "<span style='color:\\1'>\\2</span>",
            "<ul>\\1</ul>",
            "<ol>\\1</ol>",
            "<li>\\1</li>"
        );
        return preg_replace($str_search, $str_replace, $text_post);
    }


    static function replaceSmiles($text_post){
        $smiles_key = array("0:)" ,":pokerface:" ,":)",":*",":D",":o",":p",";)" ,":cry:" ,":love:" ,":sleepy:" ,":snivel:",":glad:",":tongue:",":irate:",":sad:" ,":angry:" ,":cool:" ,":nottalk:" ,":norm:" ,":(" ,":'(",":amaze:",":fine:"  ,":recoil:",":like:" ,":dislike:" );
        $smiles_value = array("12.gif"  ,"8.gif" ,"smile.gif","kiss.gif","glad.gif","surprised.gif","tongue.gif","wink.gif","crying.gif","love.gif","sleepy.gif","snivel.gif","1.gif" ,"2.gif" ,"3.gif"  ,"4.gif" ,"5.gif" ,"6.gif" ,"7.gif" ,"9.gif" ,"10.gif" ,"11.gif" ,"13.gif" ,"14.gif" ,"15.gif"  ,"like.gif" ,"dislike.gif" );
        for ($i = 0; $i < count($smiles_value); $i++)
            $smiles_value[$i] = "<img src='http://updatesite.ru/image/tmpl/smile/".$smiles_value[$i]."' class='smile2' alt='' />"; // Делаем тег img на основании пути к изображению

        return str_replace($smiles_key, $smiles_value, $text_post);
    }


	static function cutText($str,$N,$start=0){
        if (mb_strlen($str)<$N){
            return $str;
        }
        return mb_substr($str, $start, $N,'UTF-8');
    }

    static function getScoreMatch($g1,$g2) {
        if ($g1=="-1" || $g2=="-1") return " vs ";
        return $g1." : ".$g2;
    }
}