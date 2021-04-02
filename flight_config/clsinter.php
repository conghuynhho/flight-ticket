<?php
/**
 * Created by TRUNG TIN.
 * Date: 01/09/13
 * Time: 3:38 PM
 * Description : CLASS TO GET ALL FLIGHT FOR INTERNATIONAL
 * $err code : 28 time out
 * $err code : 0 la ok ,all fine
 */
class clsflight
{
    protected $_depday;
    protected $_depmonth;
    protected $_depyear;
    protected $_retday;
    protected $_retmonth;
    protected $_retyear;

    protected $_adult;
    protected $_child;
    protected $_infant;

    protected $_isadult;
    protected $_ischild;
    protected $_isinfant;

    protected $_html;


    protected $_dep;
    protected $_arv;
    protected $_cookie;
    protected $_cookietime;
    protected $_return;

    public $rs;
    public $err;
    public $errstr;

    public $totaltime;
    public $timeprocess;

    protected $_logfile;



    public function setDepday($day){
            $this->_depday=$day;
    }
    public function setDepmonth($month){
        $month=intval($month);
        if($month>0 && $month<10)
            $this->_depmonth="0".$month;
        else
            $this->_depmonth=$month;
    }
    public function setDepyear($year){
        $this->_depyear=$year;
    }

    public function setRetday($day){
            $this->_retday=$day;
    }
    public function setRetmonth($month){
        $month=intval($month);
        if($month>0 && $month<10)
            $this->_retmonth="0".$month;
        else
            $this->_retmonth=$month;
    }
    public function setRetyear($year){
        $this->_retyear=$year;
    }

    public function setDep($dep){
        $this->_dep=$dep;
    }
    public function setArv($arv){
        $this->_arv=$arv;
    }

    public function setCookie($cookie){
        $this->_cookie=$cookie;
    }
    public function setLogfile($logfile){
        $this->_logfile=$logfile;
    }
    public function setCookietime($cookietime){
        $this->_cookietime=$cookietime;
    }
    public function setReturn($return){
        if($return==2)
            $this->_return=1;
        else
            $this->_return=0;
    }


    #Set So Nguoi Di
    public function setAdult($adult){
        $this->_adult=$adult;
        if($this->_adult>0)
            $this->_isadult=1;
    }
    public function setChild($child){
        $this->_child=$child;
        if($this->_child>0)
            $this->_ischild=1;
    }
    public function setInfant($infant){
        $this->_infant=$infant;
        if($this->_infant>0)
            $this->_isinfant=1;
    }

    public function __construct(){
        $this->_depday="30";
        $this->_depmonth="05";
        $this->_depyear="1013";
        $this->_retday="04";
        $this->_retmonth="06";
        $this->_retyear="2013";
        $this->_dep="SGN";
        $this->_arv="SYD";
        $this->_cookie="cookiefile.txt";
        $this->_cookie="logfile.txt";
        $this->_cookietime=array();
        $this->_return=0;
        $this->_err=false;
        $this->timeprocess=0;
        $this->_adult=1;
        $this->_child=0;
        $this->_infant=0;
        $this->_isadult=1;
        $this->_ischild=0;
        $this->_isinfant=0;
    }

    public function getFlight(){

        $url="https://abacuswebstart.abacus.com.sg/cong-nghe-so-viet/flight-search-process.aspx";
        $refer="http://abacuswebstart.abacus.com.sg/cong-nghe-so-viet/flight-search.aspx?fare=FAREX";

        ##################################
        ###String parameter###############
        ##################################
        $str="&from1=".$this->_dep;
        $str.="&to1=".$this->_arv;
        $str.="&departureDate1=".$this->_depyear."-".$this->_depmonth."-".$this->_depday."+09%3A01%3A00";
        if($this->_return){ #if 2 chieu
            $str.="&from2=".$this->_arv;
            $str.="&to2=".$this->_dep;
            $str.="&departureDate2=".$this->_retyear."-".$this->_retmonth."-".$this->_retday."+09%3A01%3A00";
        }
        $str.="&tripType=".($this->_return?2:1); #=1 neu 1 chieu, 2 neu 2 chieu
        $str.="&adult=".$this->_adult;
        $str.="&child=".$this->_child;
        $str.="&infant=".$this->_infant;
        $str.="&student=0";
        $str.="&seaman=0";
        $str.="&seniorCitizen=0";
        $str.="&labour=0";
        $str.="&class=Y";
        $str.="&flightType=2";
        $str.="&prefAirline=";
        $str.="&fareType=FAREX";

        ##################################
        ###end String parameter###########
        ##################################






        $curl=curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl,CURLOPT_POST,1);
        curl_setopt($curl,CURLOPT_ENCODING,'gzip');
        curl_setopt($curl,CURLOPT_REFERER,$refer);
        curl_setopt($curl,CURLOPT_POSTFIELDS,$str);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $this->_cookie);
        curl_setopt($curl, CURLOPT_COOKIEJAR, $this->_cookie);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_exec($curl);


        $str="action_type=SEARCH&page=1&pagesize=100";
        $url="https://abacuswebstart.abacus.com.sg/cong-nghe-so-viet/ajax-flight.aspx";
        $refer="http://abacuswebstart.abacus.com.sg/cong-nghe-so-viet/flight-result.aspx";

        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl,CURLOPT_POST,1);
        curl_setopt($curl,CURLOPT_ENCODING,'gzip');
        curl_setopt($curl,CURLOPT_REFERER,$refer);
        curl_setopt($curl,CURLOPT_POSTFIELDS,$str);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $this->_cookie);
        curl_setopt($curl, CURLOPT_COOKIEJAR, $this->_cookie);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);


        $this->_html=curl_exec($curl);
        $this->err=curl_errno($curl);
        $this->errstr=curl_error($curl);



        /*echo 'error:' . curl_error($curl);
        echo 'error code:' . curl_errno($curl);

        $info = curl_getinfo($curl);
        print_r($info);
        echo $this->_html;*/




        curl_close($curl);

        $this->rs=$this->regexhtml();
        return $this->rs;
    }

    function regexhtml(){

        $j=0; #index mang flight
        $flight=array();

        $strsearch=$this->_html;

        #Tach Tung Chuyen bay Ra Dua Vao Bien $rs
        $partern='/<div class=\'flightResult\'>.*?<\/table>\s*?<\/div>/is';
        preg_match_all($partern,$strsearch,$rs);




        foreach ($rs[0] as $item) {
        //echo "hehehe".$item;

            if(!$this->_return){ # if 1 chieu

                //Lay Thong Tin Tong Quan
                $pt="/alt='([\w|\d]{2,3})'><\/img><\/div>";
                $pt.=".*";
                /*Lay ma san bay di , sb den, gio di, gio den*/
                $pt.="<td><b>([\w]{3})\s([\d]{2}\.[\d]{2})<\/b>.*?<td><b>([\w]{3})\s([\d]{2}\.[\d]{2})<\/b><\/td>";
                /*lay so chang dung va thoi gian bay*/
                $pt.="\s*<td[^>]*align='center'><strong>(.*)<\/strong><\/td>\s*<td[^>]*align='center'><strong>(.*)<\/strong><\/td>";
                $pt.=".*";
                /*Lay mo ta hanh trinh*/
                $pt.="<\/tr>\s*<\/table>\s*<\/td>\s*<\/tr>\s*<tr>\s*<td><\/td>\s*<td>(.*)<a id='aFlightDetail";
                $pt.=".*";
                /*Lay chi tiet hanh trinh*/
                $pt.="<td class='flightDetail'><div(.*)<\/div><\/td>\s*<\/tr>\s*<\/table>";
                $pt.=".*";
                /*Lay thue phi tung loai tuy theo tre em, nguoi lon hay tre so sinh*/
                if($this->_isadult)
                    $pt.="<tr>\s*<td\sclass='textleft'>[\d]\sAdult<\/td>\s*<td\sclass='textright'>(.*)<\/td>\s*<\/tr>\s*";
                if($this->_ischild)
                    $pt.="<tr>\s*<td\sclass='textleft'>[\d]\sChild<\/td>\s*<td\sclass='textright'>(.*)<\/td>\s*<\/tr>\s*";
                if($this->_isinfant)
                    $pt.="<tr>\s*<td\sclass='textleft'>[\d]\sInfant<\/td>\s*<td\sclass='textright'>(.*)<\/td>\s*<\/tr>\s*";

                $pt.="<tr>\s*<td\sclass='textleft'>Est. Taxes<\/td>\s*<td\sclass='textright'>(.*)<\/td>\s*<\/tr>\s*";
                $pt.=".*";
                $pt.="<tr>\s*<td\sclass='textleft'>Total<\/td>\s*<td\sclass='textright'>(.*)<\/td>\s*<\/tr>\s*";
                $pt.=".*";
                $pt.="/isU";
                preg_match_all($pt,$item,$itemrs);
                /*echo "<pre>";
                print_r($itemrs);
                echo "</pre>";*/




                if($itemrs[6][0]=="Direct"){
                    $stop=0;
                }else{
                    $tempstop=explode(" ",$itemrs[6][0]);
                    $stop=$tempstop[0];
                }


                //Lay Thong Tin Hanh Trinh
                $ptjou="/<div>\s*<b>([\w|\s]*)\((.*)\)\s*to\s+([\w|\s]*)\s\((.*)\)<\/b><br\s\/>";
                $ptjou.=".*";
                $ptjou.="Depart\s([\d]{2}\.[\d]{2})\s*Arrive\s([\d]{2}\.[\d]{2})<br\s\/>\s*Duration:\s(.*)<br\s\/>\s*<\/div>";
                $ptjou.=".*";
                if($stop>=1){

                    $ptjou.="<div><b>Layover.*\(.*\)\s(.*)<\/b>\s*<\/div>";
                    $ptjou.=".*";
                    $ptjou.="<div>\s*<b>([\w|\s]*)\((.*)\)\s*to\s*([\w|\s]*)\s\((.*)\)<\/b><br\s\/>";
                    $ptjou.=".*";
                    $ptjou.="Depart\s([\d]{2}\.[\d]{2})\s*Arrive\s([\d]{2}\.[\d]{2})<br\s\/>\s*Duration:\s(.*)<br\s\/>";
                    $ptjou.=".*";
                }
                if($stop>=2){

                    $ptjou.="<div><b>Layover.*\(.*\)\s(.*)<\/b>\s*<\/div>";
                    $ptjou.=".*";
                    $ptjou.="<div>\s*<b>([\w|\s]*)\((.*)\)\s*to\s*([\w|\s]*)\s\((.*)\)<\/b><br\s\/>";
                    $ptjou.=".*";
                    $ptjou.="Depart\s([\d]{2}\.[\d]{2})\s*Arrive\s([\d]{2}\.[\d]{2})<br\s\/>\s*Duration:\s(.*)<br\s\/>";
                    $ptjou.=".*";
                }
                if($stop>=3){
                    $ptjou.="<div><b>Layover.*\(.*\)\s(.*)<\/b>\s*<\/div>";
                    $ptjou.=".*";
                    $ptjou.="<div>\s*<b>([\w|\s]*)\((.*)\)\s*to\s*([\w|\s]*)\s\((.*)\)<\/b><br\s\/>";
                    $ptjou.=".*";
                    $ptjou.="Depart\s([\d]{2}\.[\d]{2})\s*Arrive\s([\d]{2}\.[\d]{2})<br\s\/>\s*Duration:\s(.*)<br\s\/>";
                    $ptjou.=".*";
                }
                $ptjou.="/isU";
                preg_match_all($ptjou,$itemrs[9][0],$jours);
                //print_r($jours);




                //Lay aircode
                $ptimg="/<img[^>]*alt='([\w|\d]{2,3})'>/isU";
                preg_match_all($ptimg,$item,$imgrs);
                //print_r($imgrs);


                //lay flightn no
                $ptal="/<br\s\/>([\w|\s]*)\s([\d]{1,5})\s+.*/isU";
                preg_match_all($ptal,$itemrs[8][0],$alrs);
                //print_r($alrs);

                if(count($imgrs[1])==1){
                    for($i=0;$i<=$stop;$i++){
                        $flight[$j]["int"][$i]["airline"]=trim($alrs[1][0]);
                        $flight[$j]["int"][$i]["airline_code"]=$imgrs[1][0]." ".$alrs[2][$i];
                    }

                }elseif(count($imgrs[1])==($stop+1)){
                    for($i=0;$i<=$stop;$i++){
                        $flight[$j]["int"][$i]["airline"]=trim($alrs[1][$i]);
                        $flight[$j]["int"][$i]["airline_code"]=$imgrs[1][$i]." ".$alrs[2][$i];
                    }
                }elseif((count($imgrs[1])<count($alrs[1])) && count($alrs[1])==($stop+1) ){
                    $tempcode=0;
                    for($i=0;$i<=$stop;$i++){
                        $flight[$j]["int"][$i]["airline"]=trim($alrs[1][$i]);
                        if($i>0 && (trim($alrs[1][$i])==trim($alrs[1][$i-1]))){
                            $flight[$j]["int"][$i]["airline_code"]=$imgrs[1][$tempcode]." ".$alrs[2][$i];
                        }elseif($i==0){
                            $flight[$j]["int"][$i]["airline_code"]=$imgrs[1][$tempcode]." ".$alrs[2][$i];
                        }else{
                            $flight[$j]["int"][$i]["airline_code"]=$imgrs[1][++$tempcode]." ".$alrs[2][$i];
                        }
                    }
                }
                elseif(count($imgrs[1])==count($alrs[1]) && (count($imgrs[1])<($stop+1)) ){
                    $tempcode=0;
                    $ptintno="/.*to.*\s[\d]{2,5}\s/isU";
                    preg_match_all($ptintno,$itemrs[8][0],$intnors);
                    for($i=0;$i<count($imgrs[1]);$i++){
                        $flag=1;
                        $count_to=substr_count($intnors[0][$i],"to ");
                        while($flag<=$count_to){
                            $flight[$j]["int"][$tempcode]["airline"]=trim($alrs[1][$i]);
                            $flight[$j]["int"][$tempcode]["airline_code"]=$imgrs[1][$i]." ".$alrs[2][$i];
                            $tempcode++;
                            $flag++;
                        }
                    }
                }






                //Gan Vao Bien Ket Qua
                $flight[$j]["airline_code"]=$itemrs[1][0];
                $flight[$j]["airline_name"]=trim($alrs[1][0]);
                $flight[$j]["dep_time"]=$itemrs[3][0];
                $flight[$j]["arv_time"]=$itemrs[5][0];
                $flight[$j]["stop"]=$stop;
                $flight[$j]["total_time"]=$itemrs[7][0];
                if($this->_isadult)
                    $flight[$j]["price_adult"]=$itemrs[10][0];
                if($this->_ischild)
                    $flight[$j]["price_child"]=$itemrs[10+$this->_isadult][0];
                if($this->_isinfant)
                    $flight[$j]["price_infant"]=$itemrs[10+$this->_isadult+$this->_ischild][0];

                $flight[$j]["price_tax"]=$itemrs[10+$this->_isadult+$this->_ischild+$this->_isinfant][0];
                $flight[$j]["price_total"]=$itemrs[11+$this->_isadult+$this->_ischild+$this->_isinfant][0];

                //hanh trinh

                $flight[$j]["int"][0]["dep"]=$jours[1][0];
                $flight[$j]["int"][0]["dep_airport"]=$jours[2][0];
                $flight[$j]["int"][0]["dep_time"]=$jours[5][0];
                $flight[$j]["int"][0]["arv"]=trim($jours[3][0]);
                $flight[$j]["int"][0]["arv_airport"]=$jours[4][0];
                $flight[$j]["int"][0]["arv_time"]=$jours[6][0];
                $flight[$j]["int"][0]["total_time"]=$jours[7][0];
                if($stop>0){
                    $flight[$j]["int"][0]["layover_time"]=trim($jours[8][0]);
                    $flight[$j]["int"][1]["dep"]=$jours[9][0];
                    $flight[$j]["int"][1]["dep_airport"]=$jours[10][0];
                    $flight[$j]["int"][1]["dep_time"]=$jours[13][0];
                    $flight[$j]["int"][1]["arv"]=trim($jours[11][0]);
                    $flight[$j]["int"][1]["arv_airport"]=$jours[12][0];
                    $flight[$j]["int"][1]["arv_time"]=$jours[14][0];
                    $flight[$j]["int"][1]["total_time"]=$jours[15][0];
                }
                if($stop>1){
                    $flight[$j]["int"][1]["layover_time"]=trim($jours[16][0]);
                    $flight[$j]["int"][2]["dep"]=$jours[17][0];
                    $flight[$j]["int"][2]["dep_airport"]=$jours[18][0];
                    $flight[$j]["int"][2]["dep_time"]=$jours[21][0];
                    $flight[$j]["int"][2]["arv"]=trim($jours[19][0]);
                    $flight[$j]["int"][2]["arv_airport"]=$jours[20][0];
                    $flight[$j]["int"][2]["arv_time"]=$jours[22][0];
                    $flight[$j]["int"][2]["total_time"]=$jours[23][0];
                }
                if($stop>2){
                    $flight[$j]["int"][2]["layover_time"]=trim($jours[24][0]);
                    $flight[$j]["int"][3]["dep"]=$jours[25][0];
                    $flight[$j]["int"][3]["dep_airport"]=$jours[26][0];
                    $flight[$j]["int"][3]["dep_time"]=$jours[29][0];
                    $flight[$j]["int"][3]["arv"]=trim($jours[27][0]);
                    $flight[$j]["int"][3]["arv_airport"]=$jours[28][0];
                    $flight[$j]["int"][3]["arv_time"]=$jours[30][0];
                    $flight[$j]["int"][3]["total_time"]=$jours[31][0];
                }

            }else{ #if 2 chieu

                ###################################################
                #Lay Gia Va Tach Chuyen Di Chuyen Ve Ra 2 Phan Rieng
                ###################################################
                $pt1="/";
                $pt1.="(<table.*<\/table>\s*<div\sclass='flightDelimeter'>)"; #Table chuyen di
                $pt1.="(<\/div>\s*<table.*<\/tr>\s*<\/table>\s*<\/td>\s*<td[^>]*class='flightResultPricePn')"; #Table chuyen ve

                if($this->_isadult){
                    $pt1.=".*";
                    $pt1.="[\d]{1}\sAdult<\/td>\s*<td\sclass='textright'>(.*)<\/td>";
                }
                if($this->_ischild){
                    $pt1.=".*";
                    $pt1.="[\d]{1}\sChild<\/td>\s*<td\sclass='textright'>(.*)<\/td>";
                }
                if($this->_isinfant){
                    $pt1.=".*";
                    $pt1.="[\d]{1}\sInfant<\/td>\s*<td\sclass='textright'>(.*)<\/td>";
                }

                $pt1.=".*";
                $pt1.="Est. Taxes<\/td>\s*<td\sclass='textright'>(.*)<\/td>"; #Thue
                $pt1.=".*";
                $pt1.="Total<\/td>\s*<td\sclass='textright'>(.*)<\/td>"; #Tong
                $pt1.="/isU";
                preg_match_all($pt1,$item,$itemrs);

                /*echo "<pre>";
                print_r($itemrs);
                echo "</pre>";*/


                ###################################################################################################################
                #Lay Thong Tin Co Ban Chuyen Di####################################################################################
                ###################################################################################################################
                //echo $itemrs[1][0];
                $pt2="/";
                $pt2.=".*alt='(.*)'>"; #lay code hang hang khong dau tien
                $pt2.=".*";
                $pt2.="<td><b>([\w]{3,4})\s([\d]{2}\.[\d]{2})<\/b>"; #Ma San bay di va gio di
                $pt2.=".*";
                $pt2.="<td><b>([\w]{3,4})\s([\d]{2}\.[\d]{2})<\/b><\/td>"; #Ma San bay den va gio den
                $pt2.="\s*<td[^>]*><strong>(.*)<\/strong><\/td>"; #Lay So Diem Dung
                $pt2.="\s*<td[^>]*><strong>(.*)<\/strong><\/td>"; #Lay Tong Thoi Gian Chuyen Bay
                $pt2.=".*";
                $pt2.="<div>&nbsp;<\/div>(.*)<div>&nbsp;<\/div>\s*<a id='aFlightDetail"; #Lay doan chua thong tin hanh trinh co hang hang khong
                $pt2.=".*";
                $pt2.="<td\sclass='flightDetail'><div(.*)<b>Total trip time"; #Lay doan chua thong tin hanh trinh khong co hang hang khong
                $pt2.="/isU";
                preg_match_all($pt2,$itemrs[1][0],$itemrs2);
                //print_r($itemrs2);

                #####################
                ####Lay So Diem Dung
                #####################
                if($itemrs2[6][0]=="Direct"){
                    $stop1=0;
                }else{
                    $tempstop=explode(" ",$itemrs2[6][0]);
                    $stop1=$tempstop[0];
                }


                #####################
                #Hanh Trinh Chuyen Di
                #####################
                //echo $itemrs2[9][0];
                $pt2jou="/";
                $pt2jou.=".*<b>(.*)\((.*)\)"; #Thanh Pho Di Va San bay di
                $pt2jou.="\s*to\s*";
                $pt2jou.="(.*)\((.*)\)<\/b>"; #Thanh pho den va noi den
                $pt2jou.=".*";
                $pt2jou.="Depart\s([\d]{2}\.[\d]{2})"; #Gio Di
                $pt2jou.="\s*Arrive\s([\d]{2}\.[\d]{2})<br\s\/>"; #Gio Den
                $pt2jou.="\s*Duration:\s(.*)<br\s\/>"; #Tong Thoi Gian

                if($stop1>=1){
                    $pt2jou.=".*Layover.*\)(.*)<\/b>"; #Thoi gian nghi giua chuyen
                    $pt2jou.=".*<b>(.*)\((.*)\)"; #Thanh Pho Di Va San bay di
                    $pt2jou.="\s*to\s*";
                    $pt2jou.="(.*)\((.*)\)<\/b>"; #Thanh pho den va noi den
                    $pt2jou.=".*";
                    $pt2jou.="Depart\s([\d]{2}\.[\d]{2})"; #Gio Di
                    $pt2jou.="\s*Arrive\s([\d]{2}\.[\d]{2})<br\s\/>"; #Gio Den
                    $pt2jou.="\s*Duration:\s(.*)<br\s\/>"; #Tong Thoi Gian
                }

                if($stop1>=2){
                    $pt2jou.=".*Layover.*\)(.*)<\/b>"; #Thoi gian nghi giua chuyen
                    $pt2jou.=".*<b>(.*)\((.*)\)"; #Thanh Pho Di Va San bay di
                    $pt2jou.="\s*to\s*";
                    $pt2jou.="(.*)\((.*)\)<\/b>"; #Thanh pho den va noi den
                    $pt2jou.=".*";
                    $pt2jou.="Depart\s([\d]{2}\.[\d]{2})"; #Gio Di
                    $pt2jou.="\s*Arrive\s([\d]{2}\.[\d]{2})<br\s\/>"; #Gio Den
                    $pt2jou.="\s*Duration:\s(.*)<br\s\/>"; #Tong Thoi Gian
                }

                if($stop1>=3){
                    $pt2jou.=".*Layover.*\)(.*)<\/b>"; #Thoi gian nghi giua chuyen
                    $pt2jou.=".*<b>(.*)\((.*)\)"; #Thanh Pho Di Va San bay di
                    $pt2jou.="\s*to\s*";
                    $pt2jou.="(.*)\((.*)\)<\/b>"; #Thanh pho den va noi den
                    $pt2jou.=".*";
                    $pt2jou.="Depart\s([\d]{2}\.[\d]{2})"; #Gio Di
                    $pt2jou.="\s*Arrive\s([\d]{2}\.[\d]{2})<br\s\/>"; #Gio Den
                    $pt2jou.="\s*Duration:\s(.*)<br\s\/>"; #Tong Thoi Gian
                }

                $pt2jou.="/isU";
                preg_match_all($pt2jou,$itemrs2[9][0],$jours);
                //print_r($jours);


                ##########################
                #Lay Code Hang Hang Khong
                ##########################
                //echo $itemrs[1][0];
                $ptimg="/<img[^>]*alt='([\w|\d]{2,3})'/isU";
                preg_match_all($ptimg,$itemrs[1][0],$depaircoders);
                //print_r($depaircoders);


                #####################################
                #Lay Flight no va Ten hang Hang Khong
                #####################################
                //echo $itemrs2[8][0];
                $ptal="/<br\s\/>([\w|\s]*)\s([\d]{1,5})\s+.*/isU";
                preg_match_all($ptal,$itemrs2[8][0],$depflightrs);
                //print_r($depflightrs);

                ########################################################
                #Gan Ten Hang Hang Khong Va Ma Chuyen bay Vao Hanh Trinh
                ########################################################
                if(count($depaircoders[1])==1){
                    for($i=0;$i<=$stop1;$i++){
                        $flight[$j]["dep"]["int"][$i]["airline"]=trim($depflightrs[1][0]);
                        $flight[$j]["dep"]["int"][$i]["airline_code"]=$depaircoders[1][0]." ".$depflightrs[2][$i];
                    }
                }elseif(count($depaircoders[1])==($stop1+1)){
                    for($i=0;$i<=$stop1;$i++){
                        $flight[$j]["dep"]["int"][$i]["airline"]=trim($depflightrs[1][$i]);
                        $flight[$j]["dep"]["int"][$i]["airline_code"]=$depaircoders[1][$i]." ".$depflightrs[2][$i];
                    }
                }elseif((count($depaircoders[1])<count($depflightrs[1])) && count($depflightrs[1])==($stop1+1) ){
                    $tempcode=0;
                    for($i=0;$i<=$stop1;$i++){
                        $flight[$j]["dep"]["int"][$i]["airline"]=trim($depflightrs[1][$i]);
                        if($i>0 && (trim($depflightrs[1][$i])==trim($depflightrs[1][$i-1]))){
                            $flight[$j]["dep"]["int"][$i]["airline_code"]=$depaircoders[1][$tempcode]." ".$depflightrs[2][$i];
                        }elseif($i==0){
                            $flight[$j]["dep"]["int"][$i]["airline_code"]=$depaircoders[1][$tempcode]." ".$depflightrs[2][$i];
                        }else{
                            $flight[$j]["dep"]["int"][$i]["airline_code"]=$depaircoders[1][++$tempcode]." ".$depflightrs[2][$i];
                        }
                    }
                }
                elseif(count($depaircoders[1])==count($depflightrs[1]) && (count($depaircoders[1])<($stop1+1)) ){

                    $tempcode=0;
                    $ptintno="/.*to.*\s[\d]{2,5}\s/isU";
                    preg_match_all($ptintno,$itemrs2[8][0],$intnors);

                    for($i=0;$i<count($depaircoders[1]);$i++){
                        $flag=1;
                        $count_to=substr_count($intnors[0][$i],"to ");
                        while($flag<=$count_to){
                            $flight[$j]["dep"]["int"][$tempcode]["airline"]=trim($depflightrs[1][$i]);
                            $flight[$j]["dep"]["int"][$tempcode]["airline_code"]=$depaircoders[1][$i]." ".$depflightrs[2][$i];
                            $tempcode++;
                            $flag++;
                        }
                    }
                }

                #############################
                #Gan Thong Tin Vao Chuyen di
                #############################
                $flight[$j]["dep"]["airline_code"]=$itemrs2[1][0];
                $flight[$j]["dep"]["airline_name"]=trim($depflightrs[1][0]);
                $flight[$j]["dep"]["dep_time"]=$itemrs2[3][0];
                $flight[$j]["dep"]["arv_time"]=$itemrs2[5][0];
                $flight[$j]["dep"]["stop"]=$stop1;
                $flight[$j]["dep"]["total_time"]=$itemrs2[7][0];

                //hanh trinh
                $flight[$j]["dep"]["int"][0]["dep"]=$jours[1][0];
                $flight[$j]["dep"]["int"][0]["dep_airport"]=$jours[2][0];
                $flight[$j]["dep"]["int"][0]["dep_time"]=$jours[5][0];
                $flight[$j]["dep"]["int"][0]["arv"]=trim($jours[3][0]);
                $flight[$j]["dep"]["int"][0]["arv_airport"]=$jours[4][0];
                $flight[$j]["dep"]["int"][0]["arv_time"]=$jours[6][0];
                $flight[$j]["dep"]["int"][0]["total_time"]=$jours[7][0];
                if($stop1>0){
                    $flight[$j]["dep"]["int"][0]["layover_time"]=trim($jours[8][0]);
                    $flight[$j]["dep"]["int"][1]["dep"]=$jours[9][0];
                    $flight[$j]["dep"]["int"][1]["dep_airport"]=$jours[10][0];
                    $flight[$j]["dep"]["int"][1]["dep_time"]=$jours[13][0];
                    $flight[$j]["dep"]["int"][1]["arv"]=trim($jours[11][0]);
                    $flight[$j]["dep"]["int"][1]["arv_airport"]=$jours[12][0];
                    $flight[$j]["dep"]["int"][1]["arv_time"]=$jours[14][0];
                    $flight[$j]["dep"]["int"][1]["total_time"]=$jours[15][0];
                }
                if($stop1>1){
                    $flight[$j]["dep"]["int"][1]["layover_time"]=trim($jours[16][0]);
                    $flight[$j]["dep"]["int"][2]["dep"]=$jours[17][0];
                    $flight[$j]["dep"]["int"][2]["dep_airport"]=$jours[18][0];
                    $flight[$j]["dep"]["int"][2]["dep_time"]=$jours[21][0];
                    $flight[$j]["dep"]["int"][2]["arv"]=trim($jours[19][0]);
                    $flight[$j]["dep"]["int"][2]["arv_airport"]=$jours[20][0];
                    $flight[$j]["dep"]["int"][2]["arv_time"]=$jours[22][0];
                    $flight[$j]["dep"]["int"][2]["total_time"]=$jours[23][0];
                }
                if($stop1>2){
                    $flight[$j]["dep"]["int"][2]["layover_time"]=trim($jours[24][0]);
                    $flight[$j]["dep"]["int"][3]["dep"]=$jours[25][0];
                    $flight[$j]["dep"]["int"][3]["dep_airport"]=$jours[26][0];
                    $flight[$j]["dep"]["int"][3]["dep_time"]=$jours[29][0];
                    $flight[$j]["dep"]["int"][3]["arv"]=trim($jours[27][0]);
                    $flight[$j]["dep"]["int"][3]["arv_airport"]=$jours[28][0];
                    $flight[$j]["dep"]["int"][3]["arv_time"]=$jours[30][0];
                    $flight[$j]["dep"]["int"][3]["total_time"]=$jours[31][0];
                }



                ########################################################################################################
                #Get Thong Tin Chuyen Ve################################################################################
                ########################################################################################################

                ###########################
                #Lay Thong Tin Co Ban ($pt2)
                ###########################
                preg_match_all($pt2,$itemrs[2][0],$itemrs2);

                #####################
                ####Lay So Diem Dung
                #####################
                if($itemrs2[6][0]=="Direct"){
                    $stop1=0;
                }else{
                    $tempstop=explode(" ",$itemrs2[6][0]);
                    $stop1=$tempstop[0];
                }

                #####################
                #Hanh Trinh Chuyen Ve
                #####################
                $pt2jou="/";
                $pt2jou.=".*<b>(.*)\((.*)\)"; #Thanh Pho Di Va San bay di
                $pt2jou.="\s*to\s*";
                $pt2jou.="(.*)\((.*)\)<\/b>"; #Thanh pho den va noi den
                $pt2jou.=".*";
                $pt2jou.="Depart\s([\d]{2}\.[\d]{2})"; #Gio Di
                $pt2jou.="\s*Arrive\s([\d]{2}\.[\d]{2})<br\s\/>"; #Gio Den
                $pt2jou.="\s*Duration:\s(.*)<br\s\/>"; #Tong Thoi Gian

                if($stop1>=1){
                    $pt2jou.=".*Layover.*\)(.*)<\/b>"; #Thoi gian nghi giua chuyen
                    $pt2jou.=".*<b>(.*)\((.*)\)"; #Thanh Pho Di Va San bay di
                    $pt2jou.="\s*to\s*";
                    $pt2jou.="(.*)\((.*)\)<\/b>"; #Thanh pho den va noi den
                    $pt2jou.=".*";
                    $pt2jou.="Depart\s([\d]{2}\.[\d]{2})"; #Gio Di
                    $pt2jou.="\s*Arrive\s([\d]{2}\.[\d]{2})<br\s\/>"; #Gio Den
                    $pt2jou.="\s*Duration:\s(.*)<br\s\/>"; #Tong Thoi Gian
                }

                if($stop1>=2){
                    $pt2jou.=".*Layover.*\)(.*)<\/b>"; #Thoi gian nghi giua chuyen
                    $pt2jou.=".*<b>(.*)\((.*)\)"; #Thanh Pho Di Va San bay di
                    $pt2jou.="\s*to\s*";
                    $pt2jou.="(.*)\((.*)\)<\/b>"; #Thanh pho den va noi den
                    $pt2jou.=".*";
                    $pt2jou.="Depart\s([\d]{2}\.[\d]{2})"; #Gio Di
                    $pt2jou.="\s*Arrive\s([\d]{2}\.[\d]{2})<br\s\/>"; #Gio Den
                    $pt2jou.="\s*Duration:\s(.*)<br\s\/>"; #Tong Thoi Gian
                }
                if($stop1>=3){
                    $pt2jou.=".*Layover.*\)(.*)<\/b>"; #Thoi gian nghi giua chuyen
                    $pt2jou.=".*<b>(.*)\((.*)\)"; #Thanh Pho Di Va San bay di
                    $pt2jou.="\s*to\s*";
                    $pt2jou.="(.*)\((.*)\)<\/b>"; #Thanh pho den va noi den
                    $pt2jou.=".*";
                    $pt2jou.="Depart\s([\d]{2}\.[\d]{2})"; #Gio Di
                    $pt2jou.="\s*Arrive\s([\d]{2}\.[\d]{2})<br\s\/>"; #Gio Den
                    $pt2jou.="\s*Duration:\s(.*)<br\s\/>"; #Tong Thoi Gian
                }
                $pt2jou.="/isU";
                preg_match_all($pt2jou,$itemrs2[9][0],$jours);

                ##########################
                #Lay Code Hang Hang Khong
                ##########################
                preg_match_all($ptimg,$itemrs[2][0],$depaircoders);



                #####################################
                #Lay Flight no va Ten hang Hang Khong
                #####################################
                preg_match_all($ptal,$itemrs2[8][0],$depflightrs);
                //print_r($flightrs);

                ########################################################
                #Gan Ten Hang Hang Khong Va Ma Chuyen bay Vao Hanh Trinh
                ########################################################
                if(count($depaircoders[1])==1){
                    for($i=0;$i<=$stop1;$i++){
                        $flight[$j]["arv"]["int"][$i]["airline"]=trim($depflightrs[1][0]);
                        $flight[$j]["arv"]["int"][$i]["airline_code"]=$depaircoders[1][0]." ".$depflightrs[2][$i];
                    }
                }elseif(count($depaircoders[1])==($stop1+1)){
                    for($i=0;$i<=$stop1;$i++){
                        $flight[$j]["arv"]["int"][$i]["airline"]=trim($depflightrs[1][$i]);
                        $flight[$j]["arv"]["int"][$i]["airline_code"]=$depaircoders[1][$i]." ".$depflightrs[2][$i];
                    }
                }elseif((count($depaircoders[1])<count($depflightrs[1])) && count($depflightrs[1])==($stop1+1) ){
                    $tempcode=0;
                    for($i=0;$i<=$stop1;$i++){
                        $flight[$j]["arv"]["int"][$i]["airline"]=trim($depflightrs[1][$i]);
                        if($i>0 && (trim($depflightrs[1][$i])==trim($depflightrs[1][$i-1]))){
                            $flight[$j]["arv"]["int"][$i]["airline_code"]=$depaircoders[1][$tempcode]." ".$depflightrs[2][$i];
                        }elseif($i==0){
                            $flight[$j]["arv"]["int"][$i]["airline_code"]=$depaircoders[1][$tempcode]." ".$depflightrs[2][$i];
                        }else{
                            $flight[$j]["arv"]["int"][$i]["airline_code"]=$depaircoders[1][++$tempcode]." ".$depflightrs[2][$i];
                        }
                    }
                }
                elseif(count($depaircoders[1])==count($depflightrs[1]) && (count($depaircoders[1])<($stop1+1)) ){

                    $tempcode=0;
                    $ptintno="/.*to.*\s[\d]{2,5}\s/isU";
                    preg_match_all($ptintno,$itemrs2[8][0],$intnors);
                    for($i=0;$i<count($depaircoders[1]);$i++){
                        $flag=1;
                        $count_to=substr_count($intnors[0][$i],"to ");
                        while($flag<=$count_to){
                            $flight[$j]["arv"]["int"][$tempcode]["airline"]=trim($depflightrs[1][$i]);
                            $flight[$j]["arv"]["int"][$tempcode]["airline_code"]=$depaircoders[1][$i]." ".$depflightrs[2][$i];
                            $tempcode++;
                            $flag++;
                        }
                    }
                }


                #############################
                #Gan Thong Tin Vao Ket Qua Chuyen Ve
                #############################
                $flight[$j]["arv"]["airline_code"]=$itemrs2[1][0];
                $flight[$j]["arv"]["airline_name"]=trim($depflightrs[1][0]);
                $flight[$j]["arv"]["dep_time"]=$itemrs2[3][0];
                $flight[$j]["arv"]["arv_time"]=$itemrs2[5][0];
                $flight[$j]["arv"]["stop"]=$stop1;
                $flight[$j]["arv"]["total_time"]=$itemrs2[7][0];

                //hanh trinh
                $flight[$j]["arv"]["int"][0]["dep"]=$jours[1][0];
                $flight[$j]["arv"]["int"][0]["dep_airport"]=$jours[2][0];
                $flight[$j]["arv"]["int"][0]["dep_time"]=$jours[5][0];
                $flight[$j]["arv"]["int"][0]["arv"]=trim($jours[3][0]);
                $flight[$j]["arv"]["int"][0]["arv_airport"]=$jours[4][0];
                $flight[$j]["arv"]["int"][0]["arv_time"]=$jours[6][0];
                $flight[$j]["arv"]["int"][0]["total_time"]=$jours[7][0];
                if($stop1>0){
                    $flight[$j]["arv"]["int"][0]["layover_time"]=$jours[8][0];
                    $flight[$j]["arv"]["int"][1]["dep"]=$jours[9][0];
                    $flight[$j]["arv"]["int"][1]["dep_airport"]=$jours[10][0];
                    $flight[$j]["arv"]["int"][1]["dep_time"]=$jours[13][0];
                    $flight[$j]["arv"]["int"][1]["arv"]=trim($jours[11][0]);
                    $flight[$j]["arv"]["int"][1]["arv_airport"]=$jours[12][0];
                    $flight[$j]["arv"]["int"][1]["arv_time"]=$jours[14][0];
                    $flight[$j]["arv"]["int"][1]["total_time"]=$jours[15][0];
                }
                if($stop1>1){
                    $flight[$j]["arv"]["int"][1]["layover_time"]=$jours[16][0];
                    $flight[$j]["arv"]["int"][2]["dep"]=$jours[17][0];
                    $flight[$j]["arv"]["int"][2]["dep_airport"]=$jours[18][0];
                    $flight[$j]["arv"]["int"][2]["dep_time"]=$jours[21][0];
                    $flight[$j]["arv"]["int"][2]["arv"]=trim($jours[19][0]);
                    $flight[$j]["arv"]["int"][2]["arv_airport"]=$jours[20][0];
                    $flight[$j]["arv"]["int"][2]["arv_time"]=$jours[22][0];
                    $flight[$j]["arv"]["int"][2]["total_time"]=$jours[23][0];
                }
                if($stop1>2){
                    $flight[$j]["arv"]["int"][2]["layover_time"]=$jours[24][0];
                    $flight[$j]["arv"]["int"][3]["dep"]=$jours[25][0];
                    $flight[$j]["arv"]["int"][3]["dep_airport"]=$jours[26][0];
                    $flight[$j]["arv"]["int"][3]["dep_time"]=$jours[29][0];
                    $flight[$j]["arv"]["int"][3]["arv"]=trim($jours[27][0]);
                    $flight[$j]["arv"]["int"][3]["arv_airport"]=$jours[28][0];
                    $flight[$j]["arv"]["int"][3]["arv_time"]=$jours[30][0];
                    $flight[$j]["arv"]["int"][3]["total_time"]=$jours[31][0];
                }

                ####################
                #Gan Gia Vao Ket Qua
                ####################
                if($this->_isadult)
                    $flight[$j]["price_adult"]=$itemrs[3][0];
                if($this->_ischild)
                    $flight[$j]["price_child"]=$itemrs[3+$this->_isadult][0];
                if($this->_isinfant)
                    $flight[$j]["price_infant"]=$itemrs[3+$this->_isadult+$this->_ischild][0];

                $flight[$j]["price_tax"]=$itemrs[3+$this->_isadult+$this->_ischild+$this->_isinfant][0];
                $flight[$j]["price_total"]=$itemrs[4+$this->_isadult+$this->_ischild+$this->_isinfant][0];
            }

            $j++;
        }

        return $flight;

    }

}
