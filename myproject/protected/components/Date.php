<?php

class Date {


    static function getDayMonth($date) {
        return Date("d.m",strtotime($date));
    }

    private function getRussianMonth($month){
        if($month > 12 || $month < 1) return FALSE;
        $aMonth = array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');
        return $aMonth[$month - 1];
     }

    static function getAge($date) {
        $tmp = explode('-',$date);
        $d = $tmp[2];
        $m = $tmp[1];
        $y = $tmp[0];
        if($m > date('m') || $m == date('m') && $d > date('d'))
            return (date('Y') - $y - 1);
        else
            return (date('Y') - $y);
    }


    static function getRussianDate($date) {
        $tmp = explode('-',$date);
        $day = $tmp[2];
        $month = $tmp[1];
        $year = $tmp[0];

        return $day." ".self::getRussianMonth($month)." ".$year;
    }

    private function getRightName($N,$names) {
        $temp=$names;
        $N2=$N;
        if ($names==5) {
            $temp="секунд";
            if ($N%10==1 && $N%100!=11) $temp.="у";
            else if ($N%10>=2 && $N%10<=4 && ($N%100<10 || $N%100>=20)) $temp.="ы";
            else $temp.="";
        } else if ($names==4) {
            $temp="минут";
            if ($N%10==1 && $N%100!=11) $temp.="у";
            else if ($N%10>=2 && $N%10<=4 && ($N%100<10 || $N%100>=20)) $temp.="ы";
            else $temp.="";
        } else if ($names==3) {
            $temp="час";
            if ($N%10==1 && $N%100!=11) $temp.="";
            else if ($N%10>=2 && $N%10<=4 && ($N%100<10 || $N%100>=20)) $temp.="а";
            else $temp.="ов";
        } else if ($names==2) {
            $temp="дня";
            if ($N%10==1 && $N%100!=11) $temp="день";
            else if ($N%10>=2 && $N%10<=4 && ($N%100<10 || $N%100>=20)) $temp="дня";
            else $temp="дней";
        } else if ($names==1) {
            $temp="месяц";
            if ($N%10==1 && $N%100!=11) $temp.="";
            else if ($N%10>=2 && $N%10<=4 && ($N%100<10 || $N%100>=20)) $temp.="а";
            else $temp.="ев";
        } else if ($names==0) {
            $temp="год";
            if ($N%10==1 && $N%100!=11) $temp.="";
            else if ($N%10>=2 && $N%10<=4 && ($N%100<10 || $N%100>=20)) $temp.="а";
            else $temp="лет";
        }
        return $N2 .' ' . $temp . ' назад';
    }

	static function timeElapsedString($ptime) {
        $a = array( 12 * 30 * 24 * 60 * 60,30 * 24 * 60 * 60,24 * 60 * 60 ,60 * 60 ,60,1);
        //print_r($a);
        $str = "year month day hour minute second";
        $name = explode(' ',$str);
        //$day = new Date();
        //$etime = Math.round(day.getTime()/1000 - ptime);
        //return day.getTime()/1000+" - "+ptime*1000;
        //alert(etime);
        $etime = time() - $ptime;
        if ($etime < 1) return 'только что';

        for($i=0; $i<count($a); $i++) {
            $d = $etime / $a[$i];
            if ($d >= 1) {
                $r = round($d);
                //echo "r=".$r."    i=".$i;
                return self::getRightName($r,$i);
            }
        }
    }
}