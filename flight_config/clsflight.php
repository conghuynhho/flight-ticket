<?php
/**
 * Created by TRUNG TIN.
 * Date: 9/20/12
 * Time: 3:38 PM
 * Description : CLASS TO GET ALL FLIGHT FROM VNAIRLINE,JETSTAR,AIRMEKONG,VIETJETAIR
 * 08/10 fix loi khong truy van duoc ve di nha trang (CRX or NHA)
 * 11/10 fix loi khong lay duoc ve vietjetair(ko get cookie first)
 * 26/10 fix loi khong lay duoc ve vietjetair(change view state)
 * 07/11 fix loi khong lay duoc ve vietjetair(change view state)
 * 05-04-2013 Loai Bo Gia Ve Vietnam Airline cua hang ve Supper Saver (UWB)
 * 19/04/2013 fix vnairline 0D bang DOMXpath
 * 25/04/2013 Loai bo nhung post toi hang ko co duong bay
 * 08/08/2013 Fix vietjet lay gia chuyen nay dap vao chuyen kia
 */
    class clsflight
{
    protected $_depday;
    protected $_depmonth;
    protected $_depyear;
    protected $_retday;
    protected $_retmonth;
    protected $_retyear;

    protected $_dep;
    protected $_arv;
    protected $_cookie;
    protected $_cookietime;
    protected $_oneway;
    protected $_cookievn;
    protected $_cookiejs;
    protected $_cookievj;


    private $vnactive;
    private $vjactive;
    private $jsactive;


    public $rs;
    public $err;
    public $debug;
    public $debugarr;
    public $isrun;

    public $_htmlvnair;
    public $_htmljetstar;
    protected $_htmlairmekong;
    public $_htmlvietjetair;

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
        $this->_dep=$dep=="NHA"?"CXR":$dep;
    }
    public function setArv($arv){
        $this->_arv=$arv=="NHA"?"CXR":$arv;
    }

    public function setCookie($cookie){
        $this->_cookie=$cookie;
    }
    public function setCookieVn($cookie){
        $this->_cookievn=$cookie;
    }
    public function setCookieVj($cookie){
        $this->_cookievj=$cookie;
    }
    public function setCookiejs($cookie){
        $this->_cookiejs=$cookie;
    }
    public function setLogfile($logfile){
        $this->_logfile=$logfile;
    }
    public function setCookietime($cookietime){
        $this->_cookietime=$cookietime;
    }
    public function setOneway($oneway){
        $this->_oneway=$oneway;
    }

    public function __construct(){
        $this->_depday="30";
        $this->_depmonth="10";
        $this->_depyear="2013";
        $this->_retday="08";
        $this->_retmonth="11";
        $this->_retyear="2013";
        $this->_dep=$this->_dep=="NHA"?"CXR":"SGN";
        $this->_arv=$this->_arv=="NHA"?"CXR":"HAN";
        $this->_cookie="cookiefile.txt";
        $this->_logfile="logfile.txt";
        $this->_cookietime=array();
        $this->_oneway=1;
        $this->_err=false;
        $this->timeprocess=0;
        $this->vnactive=true;
        $this->vjactive=true;
        $this->jsactive=true;
        $this->debug="";
        $this->debugarr=array();
        $this->isrun=array(
            'vn'=>'no',
            'vj'=>'no',
            'js'=>'no'
        );
        ini_set('max_execution_time', 130);
    }

    private function checkactive(){

            $jstair=array();
			$jstair["BMV"]=array("SGN","VII","HPH","THD");
			$jstair["DAD"]=array("SGN","HAN","NHA","CXR","PQC");
			$jstair["HPH"]=array("SGN","BMV");
			$jstair["NHA"]=array("HAN","SGN","DAD");
			$jstair["CXR"]=array("HAN","SGN","DAD");
			$jstair["VII"]=array("BMV","SGN");
			$jstair["HAN"]=array("NHA","CXR","SGN","DAD","PQC","DLI");
			$jstair["SGN"]=array("BMV","DAD","HAN","HPH","HUI","VII","PQC","NHA","CXR","THD","UIH","VDH","TBB","VCL");
			$jstair["PQC"]=array("SGN","HAN","DAD");
			$jstair["THD"]=array("SGN","BMV");
			$jstair["UIH"]=array("SGN");
			$jstair["VDH"]=array("SGN");
			$jstair["TBB"]=array("SGN");
			$jstair["DLI"]=array("HAN");
			$jstair["VCL"]=array("SGN");
		
			$vjair["SGN"]=array("HAN","DAD","HPH","NHA","CXR","HUI","VII","PQC","UIH","BMV","DLI","THD","VCL","VDH");
			$vjair["HAN"]=array("SGN","DAD","NHA","CXR","DLI","HUI","BMV","VCA","PQC","UIH");
			$vjair["DAD"]=array("SGN","HAN","VCA","HPH");
			$vjair["NHA"]=array("SGN","HAN");
			$vjair["CXR"]=array("SGN","HAN");
			$vjair["HPH"]=array("SGN","DAD");
			$vjair["HUI"]=array("SGN","HAN");
			$vjair["VII"]=array("SGN","DLI");
			$vjair["DLI"]=array("HAN","VII","SGN");
			$vjair["BMV"]=array("SGN","HAN");
			$vjair["UIH"]=array("SGN","HAN");
			$vjair["VCA"]=array("DAD","HAN");
			$vjair["PQC"]=array("SGN","HAN");
			$vjair["THD"]=array("SGN");
			$vjair["VCL"]=array("SGN");
			$vjair["VDH"]=array("SGN");
		
			$vna=array();
			$vna["BMV"]=array("DAD","HAN","SGN","VII");
			$vna["VII"]=array("DAD","HAN","SGN","BMV");
			$vna["CAH"]=array("SGN");
			$vna["VCA"]=array("HAN","PQC","VCS");
			$vna["VCL"]=array("HAN","SGN");
			$vna["VCS"]=array("HAN","VCA");
			$vna["DLI"]=array("HAN","DAD","SGN");
			$vna["DAD"]=array("HAN","BMV","DLI","HPH","NHA","CXR","PXU","SGN","VII");
			$vna["DIN"]=array("HAN");
			$vna["VDH"]=array("HAN","SGN");
			$vna["HAN"]=array("BMV","DAD","DIN","DLI","HUI","NHA","CXR","PQC","PXU","SGN","TBB","UIH","VCA","VCL","VDH","VII");
			$vna["HPH"]=array("DAD","SGN");
			$vna["SGN"]=array("BMV","CAH","DAD","DLI","HAN","HPH","HUI","NHA","CXR","PQC","PXU","TBB","THD","UIH","VCS","VCL","VDH","VII","VKG");
			$vna["HUI"]=array("HAN","SGN");
			$vna["NHA"]=array("HAN","SGN","DAD");
			$vna["CXR"]=array("HAN","SGN","DAD");
			$vna["PQC"]=array("HAN","SGN","VKG","VCA");
			$vna["PXU"]=array("HAN","SGN","DAD");
			$vna["UIH"]=array("HAN","SGN");
			$vna["VKG"]=array("PQC","SGN");
			$vna["THD"]=array("SGN");
			$vna["TBB"]=array("HAN");

            $this->vjactive=($vjair[$this->_dep] && in_array($this->_arv,$vjair[$this->_dep]))?true:false;
            $this->vnactive=($vna[$this->_dep] && in_array($this->_arv,$vna[$this->_dep]))?true:false;
            $this->jsactive=($jstair[$this->_dep] && in_array($this->_arv,$jstair[$this->_dep]))?true:false;
        }

    public function getInfo(){
        $arr=array(
            'depcode'=>$this->_dep,
            'arvcode'=>$this->_arv,
            'deptime'=>$this->_depday."-".$this->_depmonth."-".$this->_depyear,
            'rettime'=>$this->_retday."-".$this->_retmonth."-".$this->_retyear,
            'error'=>$this->debug,
            'info'=>$this->debugarr,
            'whatrun'=>$this->isrun
        );
        return $arr;
    }

    public function getFlight(){
        if($this->_dep=="" || $this->_arv=="" || $this->_depday=='00' || $this->_depmonth=='00' || $this->_depyear=="0000")
        {
            return;
        }

        $this->checkactive();
        if(!$this->vnactive && !$this->jsactive && !$this->vjactive)
            return;


        if($this->vnactive){
            $this->postVnairfirst();
            $curl_vnair=$this->postVnair();
        }

        // POST VIETJETAIR FIST DE LAY COOKIE
        if($this->vjactive){
            $curl_vjair=$this->postVietjetair();
        }
        if($this->jsactive){
            $curl_jetstar=$this->postJetstar();
        }


        $mh=curl_multi_init();
        if($this->vnactive){
            curl_multi_add_handle($mh,$curl_vnair);
        }
        if($this->jsactive)
            curl_multi_add_handle($mh,$curl_jetstar);

        if($this->vjactive)
            curl_multi_add_handle($mh,$curl_vjair);

        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while ($running);

        if($this->vnactive){
            $this->_htmlvnair=curl_multi_getcontent($curl_vnair);

            $this->debugarr["vna"]=curl_getinfo($curl_vnair);
            $this->isrun['vn']='run';

            if(curl_errno($curl_vnair)){
                $this->debug.="\nVietNamAirline ErrNo : ".curl_errno($curl_vnair)." - ErrMess : ".curl_error($curl_vnair);
            }

            curl_close($curl_vnair);

            $this->getVnair();
        }

        if($this->jsactive){
            $this->_htmljetstar=curl_multi_getcontent($curl_jetstar);


            $this->debugarr["js"]=curl_getinfo($curl_jetstar);
            $this->isrun['js']='run';

            if(curl_errno($curl_jetstar)){
                $this->debug.="\nJetStar ErrNo : ".curl_errno($curl_jetstar)." - ErrMess : ".curl_error($curl_jetstar);
            }

            curl_close($curl_jetstar);
            $this->getJetstar();
        }

        if($this->vjactive){
            $this->_htmlvietjetair=curl_multi_getcontent($curl_vjair);

            $this->debugarr["vj"]=curl_getinfo($curl_vjair);
            $this->isrun['vj']='run';

            if(curl_errno($curl_vjair)){
                $this->debug.="\nVietJetAir ErrNo : ".curl_errno($curl_vjair)." - ErrMess : ".curl_error($curl_vjair);
            }

            curl_close($curl_vjair);

            $this->getVietjetair();
        }


        #LAY THONG BAO LOI VA GHI VAO LOG
       /* $logerr="";
        if(curl_errno($curl_vnair)){
            $logerr.="\nVietNamAirline ErrNo : ".curl_errno($curl_vnair)." - ErrMess : ".curl_error($curl_vnair);
        }
        if($this->jsactive && curl_errno($curl_jetstar)){
            $logerr.="\nJetStar ErrNo : ".curl_errno($curl_jetstar)." - ErrMess : ".curl_error($curl_jetstar);
        }
        if($this->vjactive && curl_errno($curl_vjair)){
            $logerr.="\nVietJetAir ErrNo : ".curl_errno($curl_vjair)." - ErrMess : ".curl_error($curl_vjair);
        }
        if($logerr!=""){
            $logct="\nLog at ".date("d/m/Y h:i:s");
            $logct.=" From ".$this->_dep." To ".$this->_arv." Deptime ".$this->_depday."/".$this->_depmonth."/".$this->_depyear.", oneway = ".$this->_oneway."\n";
            $logct.=$logerr;
            if(file_exists($this->_logfile)){
                $fh=fopen($this->_logfile,"a");
                fwrite($fh,$logct);
                fclose($fh);
            }
        }*/
        #KET THUC GHI VAO LOG

        curl_multi_close($mh);

    }

    protected function postVnair(){
        $direction=$this->_oneway;

        $prequery="componentTypes=prbar&componentTypes=flomes&componentTypes=password&componentTypes=sbmt&componentTypes=lay&componentTypes=fsc&";
        $queryarr=array(
            "itineraryParts[0].disabled"=>"false",
            "cabin"=>"ECONOMY",
            "passengers.hidden"=>"",
            "promo"=>"",
            "travelOptionsHotelReservation"=>"false",
            "travelOptionsNumberOfRooms"=>"1",
            "travelOptionsCarRental"=>"false",
            "submited"=>"submited",
            "_eventId_next"=>""
        );

        $queryarr["itineraryParts[0].departureAirport"]=$this->_dep; /*dep code*/
        $queryarr["origin[0]"]=$this->_dep; /*dep city*/

        $queryarr["itineraryParts[0].arrivalAirport"]=$this->_arv; /*arv code*/
        $queryarr["destination[0]"]=$this->_arv; /*arv city*/

        $queryarr["itineraryParts[0].date"]=$this->_depyear."/".$this->_depmonth."/".$this->_depday." 00:00"; /*deptime Y/m/d 00:00*/
        $queryarr["dateDepartureText[0]"]=$this->_depday."/".$this->_depmonth."/".$this->_depyear; /*dep date d/m/Y*/

        $queryarr["passengers[ADT]"]="1"; /*So nguoi lon*/
        $queryarr["passengers[CHD]"]="0"; /*So tre em*/
        $queryarr["passengers[INF]"]="0"; /*So tre so sinh*/

        if($direction==1){
            $queryarr["journey"]="ONE_WAY"; /*2 chieu 'ROUND_TRIP', 1 chieu 'ONE_WAY'*/
        }else{
            $queryarr["journey"]="ROUND_TRIP"; /*2 chieu 'ROUND_TRIP', 1 chieu 'ONE_WAY'*/
            $queryarr["itineraryParts[1].date"]=$this->_retyear."/".$this->_retmonth."/".$this->_retday." 00:00"; /*return time Y/m/d 00:00*/
            $queryarr["dateReturnText[0]"]=$this->_retday."/".$this->_retmonth."/".$this->_retyear; /*return date d/m/Y*/
        }

        ////////////////////////////////////////
        //END String param to submit to VIETNAMAIRLINE
        ///////////////////////////////////////
        $str=$prequery.http_build_query($queryarr);
        $url="https://wl-prod.sabresonicweb.com/SSW2010/B3QE/webqtrip.html?execution=e1s1";
        $refer="https://wl-prod.sabresonicweb.com/SSW2010/B3QE/webqtrip.html?execution=e1s1";

        $curl=curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl,CURLOPT_POST,1);
        curl_setopt($curl,CURLOPT_ENCODING,'gzip');
        curl_setopt($curl,CURLOPT_REFERER,$refer);
        curl_setopt($curl,CURLOPT_POSTFIELDS,$str);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT , 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 55);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $this->_cookievn);
        curl_setopt($curl, CURLOPT_COOKIEJAR, $this->_cookievn);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        /*debug*/
        /*curl_setopt($curl, CURLOPT_HEADER, TRUE);
        curl_setopt($curl, CURLINFO_HEADER_OUT, TRUE);*/

        return $curl;
    }

    protected function postJetstar(){
        if($this->_oneway==0){
            $flight_type="RoundTrip";
        }else{
            $flight_type="OneWay";
        }
        $depcode=($this->_dep=="NHA")?"CXR":$this->_dep;
        $arvcode=($this->_arv=="NHA")?"CXR":$this->_arv;

        $url="https://book.jetstar.com/Search.aspx";
        $refer="https://book.jetstar.com/Search.aspx";
        ////////////////////////////////////////
        //String param to submit to jetstar.com
        ///////////////////////////////////////
        $str='ControlGroupSearchView%24AvailabilitySearchInputSearchView%24DropDownListCurrency=';
        $str.='&ControlGroupSearchView%24AvailabilitySearchInputSearchView%24DropDownListFareTypes=I';
        $str.='&ControlGroupSearchView%24AvailabilitySearchInputSearchView%24DropDownListMarketDay1='.$this->_depday; #NGAY DI
        $str.='&ControlGroupSearchView%24AvailabilitySearchInputSearchView%24DropDownListMarketDay2='.$this->_retday; #NGAY VE (NEU LA CHUYEN 2 CHIEU)
        $str.='&ControlGroupSearchView%24AvailabilitySearchInputSearchView%24DropDownListMarketDay3=';
        $str.='&ControlGroupSearchView%24AvailabilitySearchInputSearchView%24DropDownListMarketMonth1='.$this->_depyear."-".$this->_depmonth; #NAM-THANG DI
        $str.='&ControlGroupSearchView%24AvailabilitySearchInputSearchView%24DropDownListMarketMonth2='.$this->_retyear."-".$this->_retmonth; #NAM-THANG VE (NEU 1 CHIEU THI DE MAC DINH LA 1968-1)
        $str.='&ControlGroupSearchView%24AvailabilitySearchInputSearchView%24DropDownListMarketMonth3=';
        $str.='&ControlGroupSearchView%24AvailabilitySearchInputSearchView%24DropDownListPassengerType_ADT=1'; #SO LUONG NGUOI - NGUOI LON
        $str.='&ControlGroupSearchView%24AvailabilitySearchInputSearchView%24DropDownListPassengerType_CHD=0'; # SO LUONG TRE EM
        $str.='&ControlGroupSearchView%24AvailabilitySearchInputSearchView%24DropDownListPassengerType_INFANT=0'; #SO LUONG TRE SO SINH
        $str.='&ControlGroupSearchView%24AvailabilitySearchInputSearchView%24RadioButtonMarketStructure='.$flight_type; #2 CHIEU HAY 1 CHIEU, 2 CHIEU LA RoundTrip
        $str.='&ControlGroupSearchView%24AvailabilitySearchInputSearchView%24TextBoxMarketDestination1='.$arvcode; #DIEM DEN
        $str.='&ControlGroupSearchView%24AvailabilitySearchInputSearchView%24TextBoxMarketDestination2=';
        $str.='&ControlGroupSearchView%24AvailabilitySearchInputSearchView%24TextBoxMarketDestination3=';
        $str.='&ControlGroupSearchView%24AvailabilitySearchInputSearchView%24TextBoxMarketOrigin1='.$depcode; #DIEM DI
        $str.='&ControlGroupSearchView%24AvailabilitySearchInputSearchView%24TextBoxMarketOrigin2=';
        $str.='&ControlGroupSearchView%24AvailabilitySearchInputSearchView%24TextBoxMarketOrigin3=';
        $str.='&ControlGroupSearchView%24ButtonSubmit=';
        $str.='&__VIEWSTATE=';
        $str.='&culture=en-ZA';
        $str.='&date_picker=';
        $str.='&go-booking=';
        $str.='&pageToken=';
        $str.='&ControlGroupSearchView%24AvailabilitySearchInputSearchView%24fromCS=yes';
        ////////////////////////////////////////
        //END String param to submit to jetstar.com
        ///////////////////////////////////////
        $curl=curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_ENCODING,'gzip');
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl,CURLOPT_POST,1);
        curl_setopt($curl,CURLOPT_REFERER,$refer);
        curl_setopt($curl,CURLOPT_POSTFIELDS,$str);
        curl_setopt($curl, CURLOPT_TIMEOUT, 20);
        curl_setopt($curl, CURLOPT_COOKIEJAR, $this->_cookiejs);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $this->_cookiejs);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        return $curl;

    }

    protected function postAirmekong(){
        if($this->_oneway==0){
            $flight_type="RoundTrip";
        }else{
            $flight_type="OneWay";
        }

        $url="https://booking.airmekong.com.vn/ScheduleSelect.aspx";
        $refer="https://booking.airmekong.com.vn/ScheduleSelect.aspx";
        ////////////////////////////////////////
        //String param to submit to https://booking.airmekong.com.vn/ScheduleSelect.aspx
        ///////////////////////////////////////
        $postdata='__EVENTTARGET=';
        $postdata.='&__EVENTARGUMENT=';
        $postdata.='&__VIEWSTATE=';
        $postdata.='&pageToken=';
        $postdata.='&AvailabilitySearchInputScheduleSelectView%24RadioButtonMarketStructure='.$flight_type;
        $postdata.='&originStation1=SGN';
        $postdata.='&AvailabilitySearchInputScheduleSelectView%24TextBoxMarketOrigin1='.$this->_dep;
        $postdata.='&destinationStation1=HAN';
        $postdata.='&AvailabilitySearchInputScheduleSelectView%24TextBoxMarketDestination1='.$this->_arv;
        $postdata.='&AvailabilitySearchInputScheduleSelectView%24DropDownListMarketDay1='.$this->_depday;
        $postdata.='&AvailabilitySearchInputScheduleSelectView%24DropDownListMarketMonth1='.$this->_depyear."-".$this->_depmonth;
        $postdata.='&AvailabilitySearchInputScheduleSelectView%24DropDownListMarketDateRange1=0%7C4';
        $postdata.='&date_picker=2012-09-20';
        $postdata.='&originStation2=';
        $postdata.='&AvailabilitySearchInputScheduleSelectView%24TextBoxMarketOrigin2=Origin...';
        $postdata.='&destinationStation2=';
        $postdata.='&AvailabilitySearchInputScheduleSelectView%24TextBoxMarketDestination2=Destination...';
        $postdata.='&AvailabilitySearchInputScheduleSelectView%24DropDownListMarketDay2='.$this->_retday;
        $postdata.='&AvailabilitySearchInputScheduleSelectView%24DropDownListMarketMonth2='.$this->_retyear."-".$this->_retmonth;
        $postdata.='&AvailabilitySearchInputScheduleSelectView%24DropDownListMarketDateRange2=0%7C4';
        $postdata.='&date_picker=2012-09-24';
        $postdata.='&AvailabilitySearchInputScheduleSelectView%24DropDownListPassengerType_ADT=1';
        $postdata.='&AvailabilitySearchInputScheduleSelectView%24DropDownListPassengerType_CHD=0';
        $postdata.='&AvailabilitySearchInputScheduleSelectView%24DropDownListPassengerType_INFANT=0';
        $postdata.='&AvailabilitySearchInputScheduleSelectView%24DropDownListSearchBy=columnView';
        $postdata.='&AvailabilitySearchInputScheduleSelectView%24ButtonSubmit=Find+Flights';
        $postdata.='&ControlGroupScheduleSelectView%24AvailabilityInputScheduleSelectView%24HiddenFieldTabIndex1=3';
        $postdata.='&ControlGroupScheduleSelectView%24AvailabilityInputScheduleSelectView%24market1=0%7EEPN%7EE61PN%7E6103%7E%7ENone%7EX%7CP8%7E+924%7E+%7E%7ESGN%7E09%2F20%2F2012+17%3A35%7EHAN%7E09%2F20%2F2012+19%3A35';
        $postdata.='&ControlGroupScheduleSelectView%24AgreementInputScheduleSelectView%24CheckBoxAgreement=on';
        ////////////////////////////////////////
        //END String param to submit to https://booking.airmekong.com.vn/ScheduleSelect.aspx
        ///////////////////////////////////////

        $curl=curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_ENCODING,'gzip');
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl,CURLOPT_POST,1);
        curl_setopt($curl,CURLOPT_POSTFIELDS,$postdata);
        curl_setopt($curl,CURLOPT_REFERER,$refer);
        curl_setopt($curl, CURLOPT_TIMEOUT, 20);
        #curl_setopt($curl, CURLOPT_COOKIEFILE, $this->_cookie);
        #curl_setopt($curl, CURLOPT_COOKIEJAR, $this->_cookie);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        return $curl;
    }

    protected function postVietjetair(){

        if($this->_oneway==0){
            $flight_type="RoundTrip";
        }else{
            $flight_type="OneWay";
        }

        ////////////////////////////////////////
        //String param to submit to vietjetair
        ///////////////////////////////////////

        $arrquery=array(
            "blnFares"=>"False",
            "dlstDepDate_Day"=>$this->_depday,
            "dlstDepDate_Month"=>$this->_depyear."/".$this->_depmonth,
            "lstCurrency"=>"VND",
            "lstOrigAP"=>($this->_dep=='NHA'?'CXR':$this->_dep),
            "lstDestAP"=>($this->_arv=='NHA'?'CXR':$this->_arv),
            "lstLvlService"=>1,
            "lstResCurrency"=>"VND",
            "lstRetDateRange"=>0,
            "txtNumAdults"=>1,
            "txtNumChildren"=>0,
            "txtNumInfants"=>0,
        );
        if($flight_type=="RoundTrip"){
            $arrquery["chkRoundTrip"]="on";
            $arrquery["dlstRetDate_Day"]=$this->_retday;
            $arrquery["dlstRetDate_Month"]=$this->_retyear."/".$this->_retmonth;
        }

        $url="https://book.vietjetair.com/ameliapost.aspx?lang=en";
        $refer="http://www.vietjetair.com/Sites/Web/en-US/Home";

        ////////////////////////////////////////
        //String param to submit to vietjetair
        ///////////////////////////////////////
        $curl=curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_ENCODING,'gzip');
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl,CURLOPT_POST,1);
        curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query($arrquery));
        curl_setopt($curl,CURLOPT_REFERER,$refer);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $this->_cookievj);
        curl_setopt($curl, CURLOPT_COOKIEJAR, $this->_cookievj);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_exec($curl);



        $arrquery2=array(
            "__VIEWSTATE"=>"/wEPDwULLTE1MzQ1MjI3MzAPZBYCZg9kFg4CCA8QZGQWAGQCCQ8QZGQWAGQCCw8QZGQWAGQCDQ8QZGQWAGQCEQ8QZGQWAGQCEg8QZGQWAGQCEw8QZGQWAGRk/SLp6eYBboDTdTTmIOra109LSis=",
            "DebugID"=>60,
            "dlstDepDate_Day"=>$this->_depday,
            "dlstDepDate_Month"=>$this->_depyear."/".$this->_depmonth,
            "lstCurrency"=>"VND",
            "lstOrigAP"=>-1,
            "lstDestAP"=>-1,
            "lstLvlService"=>1,
            "lstResCurrency"=>"VND",
            "lstRetDateRange"=>0,
            "txtNumAdults"=>0,
            "txtNumChildren"=>0,
            "txtNumInfants"=>0,
            "txtPromoCode"=>""
        );
        if($flight_type=="RoundTrip"){
            $arrquery2["dlstRetDate_Day"]=$this->_retday;
            $arrquery2["dlstRetDate_Month"]=$this->_retyear."/".$this->_retmonth;
        }

        $url="https://book.vietjetair.com/ameliapost.aspx?lang=en";
        $refer="https://book.vietjetair.com/ameliapost.aspx?lang=en";

        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_REFERER,$refer);
        curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query($arrquery2));


        return $curl;
    }

    protected function getVnair() {
        $direction = $this->_oneway;
        $flight = array();
        if($direction == 1) {
            $flight = $this->_vn_extract_data_oneway($this->_htmlvnair, 'outbound');
        } else {
            $flight['dep'] = $this->_vn_extract_data_oneway($this->_htmlvnair, 'outbound');
			$flight['ret'] = $this->_vn_extract_data_oneway($this->_htmlvnair, 'inbound');
        }
        $this->rs["vietnamairline"] = $flight;
    }
	
	private function _vn_extract_data_oneway($html, $direction = 'outbound')
    {
        $flight_data = array();
        $json_start = '{"rootElement":';
        $json_end = ':"AIR_SELECT_PAGE"}';
        $json_mid = $this->_get_string_between($html, $json_start, $json_end);
        $json_full = $json_start . $json_mid . $json_end;
        $json_data = json_decode($json_full, true);
        $rows = $json_data['rootElement']['children'][1]['children'][0]['children'][5]['model'][$direction . 's'];
        $i = 0;
        foreach ($rows as $row) {
            $segment_info = $row['segments'];
            $route_count = count($segment_info);
			if ($route_count == 1) {
				$best_price = $this->_vn_find_best_price($row['basketsRef']);
				// vietnamairlines.com default datetime format is Y/m/d H:i:s
				$dep_code = $segment_info[0]['departureCode'];
				$arv_code = $segment_info[0]['arrivalCode'];
				$dep_datetime = str_replace('/', '-', $segment_info[0]['departureDate']);
				$dep_date = substr($dep_datetime, 0, strpos($dep_datetime, ' '));
				$dep_time = substr($dep_datetime, strpos($dep_datetime, ' ') + 1, 5);
				$arv_datetime = str_replace('/', '-', $segment_info[0]['arrivalDate']);
				$arv_date = substr($arv_datetime, 0, strpos($arv_datetime, ' '));
				$arv_time = substr($arv_datetime, strpos($arv_datetime, ' ') + 1, 5);
				$flight_no = $segment_info[0]['airlineCodes'][0] . ' ' . $segment_info[0]['flightNumber'][0];

				$flight_data[$i]['dep'] = $dep_code;
				$flight_data[$i]['arv'] = $arv_code;
				$flight_data[$i]['deptime'] = $dep_time;
				$flight_data[$i]['arvtime'] = $arv_time;
				$flight_data[$i]['flightno'] = $flight_no;
				$flight_data[$i]['stop'] = 0;
				$flight_data[$i]['price'] = $best_price['base_price'];
				$flight_data[$i]['class'] = $best_price['ticket_type'] . '-' . $best_price['ticket_class'];
				$i++;
			}
        }
        return $flight_data;
    }
	
	private function _get_string_between($string, $start, $end){
		$string = " ".$string;
		$ini = strpos($string,$start);
		if ($ini == 0) return "";
		$ini += strlen($start);
		$len = strpos($string,$end,$ini) - $ini;
		return substr($string,$ini,$len);
	}
	
	private function _vn_find_best_price($arr)
    {
        $new_arr = array();
        foreach ($arr as $arr_key => $arr_val) {
            $amount = (int)$arr_val['prices']['moneyElements'][0]['moneyTO']['amount'];
            $seat_left = $arr_val['seatsRemaining']['seatsRemaining'];
            $ticket_class = $arr_val['seatsRemaining']['customLabelSuffix'];
            $ticket_type = $arr_val['classOfService'][0] . ' (' . $arr_key . ')';
            $fare_basic = $arr_val['fareBasis'];
            $ref_id = $arr_val['brandedBasketHashRef'];
            $new_arr[$amount]['base_price'] = $amount;
            $new_arr[$amount]['seat_left'] = $seat_left;
            $new_arr[$amount]['ticket_class'] = $ticket_class;
            $new_arr[$amount]['ticket_type'] = $ticket_type;
            $new_arr[$amount]['fare_basic'] = $fare_basic;
            $new_arr[$amount]['ref_id'] = $ref_id;
        }
        ksort($new_arr);
        reset($new_arr);
        $first_key = key($new_arr);
        return $new_arr[$first_key];
    }

    protected function getClass($str){
            $tmp=explode("-",$str);
            return $tmp[2];
        }

    protected function getPrice($price,$code="SGN"){
            $arr=array(
                "HAN"=>60000,
                "SGN"=>60000,
                "DAD"=>60000,
                "HUI"=>60000,
                "NHA"=>60000,
                "HPH"=>60000,
                "DLI"=>60000,
                "VCA"=>60000,
                "PQC"=>60000,
                "BMV"=>60000,
                "SQH"=>50000,
                "DIN"=>50000,
                "VII"=>50000,
                "VDH"=>50000,
                "PXU"=>50000,
                "VCL"=>50000,
                "UIH"=>50000,
                "VCS"=>50000,
                "CAH"=>50000,
                "VKG"=>50000,
                "THD"=>50000,
            );
            $airfee=$arr[$code]?$arr[$code]:60000;

            $price=trim($price);
            $price=str_replace(",","",$price);

           // $baseprice=round(($price-$airfee)/1.1);
		   //$baseprice=$price;

           // $tmpdive=$baseprice%1000;
           // if($tmpdive>0)
           //     $baseprice-=$tmpdive;
           // return $baseprice;
		   if( ($price%1000) != 0 )
            $price=floor($price/1000)*1000;
			
    		return $price;

        }

    protected function getJetstar(){

        if($this->_oneway==0)
            $flight_type="RoundTrip";
        else
            $flight_type="OneWay";

        $flight=array();
        if($flight_type=="OneWay"){

            $parten='/<tr>.*<input\stype=\"radio\"\sid=\"ControlGroupSelectView_AvailabilityInputSelectView_RadioButtonMkt[\d]Fare[\d]{1,3}\"\sname=\"ControlGroupSelectView\$AvailabilityInputSelectView\$market[\d]{1,3}\"[^>]*value=\"([^>]*)\"\sdata-price=\"([\d]{1,20})[.][0]*\"[^>]*>.*<\/tr>/isU';
            preg_match_all($parten,$this->_htmljetstar,$output);
            $count_flight=count($output[1]);

            #$flight["total"]=$count_flight;
            if($count_flight==0)
            {
                #$flight["total"]=$count_flight;
            }else{
                for($i=0;$i<$count_flight;$i++){

                    $str=$output[1][$i];
                    $price=$output[2][$i];
                    $str=explode("|",$str);
                    $str=$str[1];
                    $str=explode("~ ~~",$str);
                    $flightno=str_replace("~","",$str[0]);
                    $str=$str[1];
                    $str=explode("~",$str);
                    $dep=$str[0];
                    $arv=$str[2];
                    $depdate=explode(" ",$str[1]);
                    $deptime=$depdate[1];
                    $depdate=$depdate[0];
                    $arvdate=explode(" ",$str[3]);
                    $arvtime=$arvdate[1];
                    $arvdate=$arvdate[0];

                    $dep=($dep=="CXR")?"NHA":$dep;
                    $arv=($arv=="CXR")?"NHA":$arv;

                    $flight[$i]["dep"]=$dep;
                    $flight[$i]["arv"]=$arv;
                    $flight[$i]["deptime"]=$deptime;
                    $flight[$i]["arvtime"]=$arvtime;
                    $flight[$i]["depdate"]=$depdate;
                    $flight[$i]["arvdate"]=$arvdate;
                    $flight[$i]["flightno"]=$flightno;
                    $flight[$i]["price"]=$price;
                    $flight[$i]["class"]="Starter";
                    $flight[$i]["stop"]=0;
                }
            }

        }else{
            $dom=new DOMDocument();
            @$dom->loadHTML($this->_htmljetstar);
            $finder=new DOMXPath($dom);
            $class="domestic";
            $tables=$finder->query("//table[contains(concat(' ', normalize-space(@class), ' '), ' $class ')]");
            if($tables->length==0){
                #$flight["dep"]["total"]=0;
                #$flight["arv"]["total"]=0;
            }
            $flag=0;#BIEN DE XET XEM DANG O TABLE DEN HAY TABLE DI
            foreach($tables as $table){

                $item=$dom->saveXML($table);
                $parten='/<tr>.*<input\stype=\"radio\"\sid=\"ControlGroupSelectView_AvailabilityInputSelectView_RadioButtonMkt[\d]Fare[\d]{1,3}\"\sname=\"ControlGroupSelectView\$AvailabilityInputSelectView\$market[\d]{1,3}\"[^>]*value=\"([^>]*)\"\sdata-price=\"([\d]{1,20})[.][0]*\"[^>]*>.*<\/tr>/isU';
                preg_match_all($parten,$item,$output);

                if($flag==0){
                    $count_out=count($output[1]);
                    #$flight["dep"]["total"]=$count_out;
                    for($i=0;$i<$count_out;$i++){
                        $str=$output[1][$i];
                        $price=$output[2][$i];
                        $str=explode("|",$str);
                        $str=$str[1];
                        $str=explode("~ ~~",$str);
                        $flightno=str_replace("~","",$str[0]);
                        $str=$str[1];
                        $str=explode("~",$str);
                        $dep=$str[0];
                        $arv=$str[2];
                        $depdate=explode(" ",$str[1]);
                        $deptime=$depdate[1];
                        $depdate=$depdate[0];
                        $arvdate=explode(" ",$str[3]);
                        $arvtime=$arvdate[1];
                        $arvdate=$arvdate[0];

                        $dep=($dep=="CXR")?"NHA":$dep;
                        $arv=($arv=="CXR")?"NHA":$arv;

                        $flight["dep"][$i]["dep"]=$dep;
                        $flight["dep"][$i]["arv"]=$arv;
                        $flight["dep"][$i]["deptime"]=$deptime;
                        $flight["dep"][$i]["arvtime"]=$arvtime;
                        $flight["dep"][$i]["depdate"]=$depdate;
                        $flight["dep"][$i]["arvdate"]=$arvdate;
                        $flight["dep"][$i]["flightno"]=$flightno;
                        $flight["dep"][$i]["price"]=$price;
                        $flight["dep"][$i]["class"]="Starter";
                        $flight["dep"][$i]["stop"]=0;


                    }
                }else{
                    $count_in=count($output[1]);
                    #$flight["ret"]["total"]=$count_in;
                    for($i=0;$i<$count_in;$i++){
                        $str=$output[1][$i];
                        $price=$output[2][$i];
                        $str=explode("|",$str);
                        $str=$str[1];
                        $str=explode("~ ~~",$str);
                        $flightno=str_replace("~","",$str[0]);
                        $str=$str[1];
                        $str=explode("~",$str);
                        $dep=$str[0];
                        $arv=$str[2];
                        $depdate=explode(" ",$str[1]);
                        $deptime=$depdate[1];
                        $depdate=$depdate[0];
                        $arvdate=explode(" ",$str[3]);
                        $arvtime=$arvdate[1];
                        $arvdate=$arvdate[0];

                        $dep=($dep=="CXR")?"NHA":$dep;
                        $arv=($arv=="CXR")?"NHA":$arv;

                        $flight["ret"][$i]["dep"]=$dep;
                        $flight["ret"][$i]["arv"]=$arv;
                        $flight["ret"][$i]["deptime"]=$deptime;
                        $flight["ret"][$i]["arvtime"]=$arvtime;
                        $flight["ret"][$i]["depdate"]=$depdate;
                        $flight["ret"][$i]["arvdate"]=$arvdate;
                        $flight["ret"][$i]["flightno"]=$flightno;
                        $flight["ret"][$i]["price"]=$price;
                        $flight["ret"][$i]["class"]="Starter";
                        $flight["ret"][$i]["stop"]=0;
                    }
                }

                $flag++;
            }
        }


        $this->rs["jetstar"]=$flight;

    }

    protected function getAirmekong(){
        if($this->_oneway==1)
            $flight_type="OneWay";
        else
            $flight_type="RoundTrip";
        $flight=array();

        if($flight_type=="OneWay"){
            $dom=new DOMDocument();
            @$dom->loadHTML($this->_htmlairmekong);
            $finder=new DOMXPath($dom);
            $class="w98 availabilityTable";
            $tables=$finder->query("//table[contains(concat(' ', normalize-space(@class), ' '), ' $class ')]");

            if($tables->length==0){
                $this->rs["airmekong"]=array();
                return;
            }

            $table=$tables->item(0);

            $partern='/<tr[^>]*>\s*<td\sclass=\"left\sfootnote\">.*<input.*<\/tr>/isU';
            $strsearch=$dom->saveXML($table);
            preg_match_all($partern,$strsearch,$output);
            $count_out=count($output[0]);
            #$flight["total"]=$count_out;

            for($i=0;$i<$count_out;$i++)
            {
                $strsearch=$output[0][$i];

                $parterndetail='/<p><input\sid="ControlGroupScheduleSelectView_AvailabilityInputScheduleSelectView_[\d|\w]*\"[^>]*type=\"radio\"\sname=\"ControlGroupScheduleSelectView\$AvailabilityInputScheduleSelectView\$market[\d]\"\svalue=\"(.*)\"\/*>([\d|\.]*)<\/p>/isU';
                $parternnote='/<a[^>]*\shref=\"javascript:;\"\sonmouseover=\"fixedtooltip\(\'(.*)\',\sthis,\sevent,\s\'auto\'\)\"[^>]*\">/isU';

                preg_match_all($parterndetail,$strsearch,$details);
                preg_match_all($parternnote,$strsearch,$notes);

                if(count($notes[1])>0)
                {
                    $stops=1;
                    $note=$notes[1][0];
                }else{
                    $stops=0;
                    $note="";
                }

                $detail=end($details[1]);
                $price=end($details[2]);

                $detail=explode("|",$detail);

                $class=$detail[0];
                $detail=$detail[1];

                $class=explode("~~",$class);
                $class=$class[0];
                $class=explode("~",$class);
                $class=$class[1];
                switch($class){
                    case "D":
                        $class="Full Deluxe";
                        break;
                    case "I":
                        $class="Deluxe Saver";
                        break;
                    case "WT":
                    case "B":
                        $class="Super Flex";
                        break;
                    case "N":
                    case "L":
                    case "W":
                    case "M":
                    case "W":
                    case "H":
                    case "ML":
                    case "LL":
                    case "NL":
                    case "HL":
                        $class="Eco Flex";
                        break;
                    case "EPN":
                    case "T":
                    case "TL":
                        $class="Promo.";
                        break;
                    default:
                        $class=$class."Unknown";
                }

                $detail=explode("^",$detail);
                if(count($detail)==2){

                    $detail1=explode("~ ~~",$detail[0]);
                    $flightno=str_replace("~","",$detail1[0]);
                    $detail1=explode("~",$detail1[1]);
                    $dep=$detail1[0];
                    $deptime=explode(" ",$detail1[1]);
                    $depdate=$deptime[0];
                    $deptime=$deptime[1];

                    $detail2=explode("~ ~~",$detail[1]);
                    $flightno.="-".str_replace("~","",$detail2[0]);

                    $detail2=explode("~",$detail2[1]);
                    $arv=$detail2[2];
                    $arvtime=explode(" ",$detail2[3]);

                    $arvdate=$arvtime[0];
                    $arvtime=$arvtime[1];


                }else{

                    $detail=$detail[0];
                    $detail=explode("~ ~~",$detail);
                    $flightno=str_replace("~","",$detail[0]);
                    $detail=explode("~",$detail[1]);
                    $dep=$detail[0];
                    $arv=$detail[2];

                    $deptime=explode(" ",$detail[1]);
                    $arvtime=explode(" ",$detail[3]);

                    $depdate=$deptime[0];
                    $deptime=$deptime[1];

                    $arvdate=$arvtime[0];
                    $arvtime=$arvtime[1];

                }

                $price=str_replace(".","",$price);

                $flight[$i]["dep"]=$dep;
                $flight[$i]["arv"]=$arv;
                $flight[$i]["deptime"]=$deptime;
                $flight[$i]["arvtime"]=$arvtime;
                $flight[$i]["depdate"]=$depdate;
                $flight[$i]["arvdate"]=$arvdate;
                $flight[$i]["flightno"]=$flightno;
                $flight[$i]["price"]=$price;
                $flight[$i]["class"]=$class;
                $flight[$i]["stop"]=$stops;
                $flight[$i]["note"]=$note;

            }

        }else{ #2 CHIEU

            $dom=new DOMDocument();
            @$dom->loadHTML($this->_htmlairmekong);
            $finder=new DOMXPath($dom);
            $class="w98 availabilityTable";
            $tables=$finder->query("//table[contains(concat(' ', normalize-space(@class), ' '), ' $class ')]");

            if($tables->length==0){
                #$flight["dep"]["total"]=0;
                #$flight["arv"]["total"]=0;
            }else{

                $flag=0;
                foreach ($tables as $table) {

                    $partern='/<tr[^>]*>\s*<td\sclass=\"left\sfootnote\">.*<input.*<\/tr>/isU';
                    $strsearch=$dom->saveXML($table);
                    preg_match_all($partern,$strsearch,$output);
                    $count_out=count($output[0]);

                    if($flag==0){ #CHUYEN DI
                        #$flight["dep"]["total"]=$count_out;
                        for($i=0;$i<$count_out;$i++)
                        {
                            $strsearch=$output[0][$i];

                            $parterndetail='/<p><input\sid="ControlGroupScheduleSelectView_AvailabilityInputScheduleSelectView_[\d|\w]*\"[^>]*type=\"radio\"\sname=\"ControlGroupScheduleSelectView\$AvailabilityInputScheduleSelectView\$market[\d]\"\svalue=\"(.*)\"\/>([\d|\.]*)<\/p>/isU';
                            $parternnote='/<a[^>]*\shref=\"javascript:;\"\sonmouseover=\"fixedtooltip\(\'(.*)\',\sthis,\sevent,\s\'auto\'\)\"[^>]*\">/isU';

                            preg_match_all($parterndetail,$strsearch,$details);
                            preg_match_all($parternnote,$strsearch,$notes);

                            if(count($notes[1])>0)
                            {
                                $stops=1;
                                $note=$notes[1][0];
                            }else{
                                $stops=0;
                                $note="";
                            }

                            $detail=end($details[1]);
                            $price=end($details[2]);

                            $detail=explode("|",$detail);

                            $class=$detail[0];
                            $detail=$detail[1];

                            $class=explode("~~",$class);
                            $class=$class[0];
                            $class=explode("~",$class);
                            $class=$class[1];
                            switch($class){
                                case "D":
                                    $class="Full Deluxe";
                                    break;
                                case "I":
                                    $class="Deluxe Saver";
                                    break;
                                case "WT":
                                case "B":
                                    $class="Super Flex";
                                    break;
                                case "N":
                                case "L":
                                case "W":
                                case "M":
                                case "W":
                                case "H":
                                case "ML":
                                case "LL":
                                case "NL":
                                case "HL":
                                    $class="Eco Flex";
                                    break;
                                case "EPN":
                                case "T":
                                case "TL":
                                    $class="Promo.";
                                    break;
                                default:
                                    $class=$class."Unknown";
                            }

                            $detail=explode("^",$detail);
                            if(count($detail)==2){

                                $detail1=explode("~ ~~",$detail[0]);
                                $flightno=str_replace("~","",$detail1[0]);
                                $detail1=explode("~",$detail1[1]);
                                $dep=$detail1[0];
                                $deptime=explode(" ",$detail1[1]);
                                $depdate=$deptime[0];
                                $deptime=$deptime[1];

                                $detail2=explode("~ ~~",$detail[1]);
                                $flightno.="-".str_replace("~","",$detail2[0]);

                                $detail2=explode("~",$detail2[1]);
                                $arv=$detail2[2];
                                $arvtime=explode(" ",$detail2[3]);

                                $arvdate=$arvtime[0];
                                $arvtime=$arvtime[1];


                            }else{

                                $detail=$detail[0];
                                $detail=explode("~ ~~",$detail);
                                $flightno=str_replace("~","",$detail[0]);
                                $detail=explode("~",$detail[1]);
                                $dep=$detail[0];
                                $arv=$detail[2];

                                $deptime=explode(" ",$detail[1]);
                                $arvtime=explode(" ",$detail[3]);

                                $depdate=$deptime[0];
                                $deptime=$deptime[1];

                                $arvdate=$arvtime[0];
                                $arvtime=$arvtime[1];

                            }

                            $price=str_replace(".","",$price);

                            $flight["dep"][$i]["dep"]=$dep;
                            $flight["dep"][$i]["arv"]=$arv;
                            $flight["dep"][$i]["deptime"]=$deptime;
                            $flight["dep"][$i]["arvtime"]=$arvtime;
                            $flight["dep"][$i]["depdate"]=$depdate;
                            $flight["dep"][$i]["arvdate"]=$arvdate;
                            $flight["dep"][$i]["flightno"]=$flightno;
                            $flight["dep"][$i]["price"]=$price;
                            $flight["dep"][$i]["class"]=$class;
                            $flight["dep"][$i]["stop"]=$stops;
                            $flight["dep"][$i]["note"]=$note;



                        }
                    }else{ #CHUYEN VE
                        #$flight["ret"]["total"]=$count_out;
                        for($i=0;$i<$count_out;$i++)
                        {
                            $strsearch=$output[0][$i];

                            $parterndetail='/<p><input\sid="ControlGroupScheduleSelectView_AvailabilityInputScheduleSelectView_[\d|\w]*\"[^>]*type=\"radio\"\sname=\"ControlGroupScheduleSelectView\$AvailabilityInputScheduleSelectView\$market[\d]\"\svalue=\"(.*)\"\/>([\d|\.]*)<\/p>/isU';
                            $parternnote='/<a[^>]*\shref=\"javascript:;\"\sonmouseover=\"fixedtooltip\(\'(.*)\',\sthis,\sevent,\s\'auto\'\)\"[^>]*\">/isU';

                            preg_match_all($parterndetail,$strsearch,$details);
                            preg_match_all($parternnote,$strsearch,$notes);


                            if(count($notes[1])>0)
                            {
                                $stops=1;
                                $note=$notes[1][0];
                            }else{
                                $stops=0;
                                $note="";
                            }

                            $detail=end($details[1]);
                            $price=end($details[2]);

                            $detail=explode("|",$detail);

                            $class=$detail[0];
                            $detail=$detail[1];

                            $class=explode("~~",$class);
                            $class=$class[0];
                            $class=explode("~",$class);
                            $class=$class[1];
                            switch($class){
                                case "D":
                                    $class="Full Deluxe";
                                    break;
                                case "I":
                                    $class="Deluxe Saver";
                                    break;
                                case "WT":
                                case "B":
                                    $class="Super Flex";
                                    break;
                                case "N":
                                case "L":
                                case "W":
                                case "M":
                                case "H":
                                case "W":
                                case "ML":
                                case "LL":
                                case "NL":
                                case "HL":
                                    $class="Eco Flex";
                                    break;
                                case "EPN":
                                case "T":
                                case "TL":
                                    $class="Promo.";
                                    break;
                                default:
                                    $class=$class."Unknown";
                            }

                            $detail=explode("^",$detail);
                            if(count($detail)==2){

                                $detail1=explode("~ ~~",$detail[0]);
                                $flightno=str_replace("~","",$detail1[0]);
                                $detail1=explode("~",$detail1[1]);
                                $dep=$detail1[0];
                                $deptime=explode(" ",$detail1[1]);
                                $depdate=$deptime[0];
                                $deptime=$deptime[1];

                                $detail2=explode("~ ~~",$detail[1]);
                                $flightno.="-".str_replace("~","",$detail2[0]);

                                $detail2=explode("~",$detail2[1]);
                                $arv=$detail2[2];
                                $arvtime=explode(" ",$detail2[3]);
                                $arvdate=$arvtime[0];
                                $arvtime=$arvtime[1];


                            }else{

                                $detail=$detail[0];
                                $detail=explode("~ ~~",$detail);
                                $flightno=str_replace("~","",$detail[0]);
                                $detail=explode("~",$detail[1]);
                                $dep=$detail[0];
                                $arv=$detail[2];

                                $deptime=explode(" ",$detail[1]);
                                $arvtime=explode(" ",$detail[3]);

                                $depdate=$deptime[0];
                                $deptime=$deptime[1];

                                $arvdate=$arvtime[0];
                                $arvtime=$arvtime[1];

                            }

                            $price=str_replace(".","",$price);

                            $flight["ret"][$i]["dep"]=$dep;
                            $flight["ret"][$i]["arv"]=$arv;
                            $flight["ret"][$i]["deptime"]=$deptime;
                            $flight["ret"][$i]["arvtime"]=$arvtime;
                            $flight["ret"][$i]["depdate"]=$depdate;
                            $flight["ret"][$i]["arvdate"]=$arvdate;
                            $flight["ret"][$i]["flightno"]=$flightno;
                            $flight["ret"][$i]["price"]=$price;
                            $flight["ret"][$i]["class"]=$class;
                            $flight["ret"][$i]["stop"]=$stops;
                            $flight["ret"][$i]["note"]=$note;
                        }

                    }
                    $flag++;
                }
            }
        }
        $this->rs["airmekong"]=$flight;

    }

    protected function getVietjetair(){
		if($this->_oneway == 1)
			$flight_type="OneWay";
		else
			$flight_type="RoundTrip";
		$flight=array();
	
		if($flight_type=="OneWay"){
			#LAY TABLE CHUA DU LIEU
			$strsearch=$this->_htmlvietjetair;
			$parterndep='/<tr class="gridFlight[^>]*id=\"gridTravelOptDep[^>]*>.*<\/tr>\s+<\/table>\s+<\/td>\s+<\/tr>/isU';
			preg_match_all($parterndep,$strsearch,$arrdep);
	
			$count_dep=count($arrdep[0]);
			#$flight["total"]=$count_dep;
			$irs=0;
			for($i=0;$i<$count_dep;$i++){
				#CHUYEN DI
	
				$parterndetail='/<td[^>]*?class=\"SegInfo\"\s*>(\d{2}\:\d{2}.*)<br\s*\/>.*?<\/td>\s+<td[^>]*?class=\"SegInfo\"\s*>(\d{2}\:\d{2}.*)<br\s*\/>.*?<\/td>\s+<td[^>]*?class=\"SegInfo\"\s*>(.*?)<br\s*\/>.*?<\/td>/is';
				$parternprice='/<input[^>]*id=\"gridTravelOptDep\"\sname=\"gridTravelOptDep\"\svalue=\"(.*)\"[^>]*\/>\s*([\d|\,]*)\s*<\/td>/isU';
	
				preg_match_all($parterndetail,$arrdep[0][$i],$details);
				
				$replace_vnd=str_replace('VND','',$arrdep[0][$i]);
				preg_match_all($parternprice,$replace_vnd,$prices);
	
				if(!preg_match_all($parternprice,$replace_vnd,$prices)){
					continue;
				}
	
				$dep=str_replace("&nbsp;"," ",$details[1][0]);
				$arv=str_replace("&nbsp;"," ",$details[2][0]);
	
				$dep=explode(" ",$dep);
				$deptime=$dep[0];
				$dep=$dep[1];
	
				$arv=explode(" ",$arv);
				$arvtime=$arv[0];
				$arv=$arv[1];
	
				$flightno=$details[3][0];
	
	
				$price=str_replace(",","",$prices[2][0]);
				$class=$prices[1][0];
	
				$class=explode(",",$class);
				$class=$class[1];
				$class=explode("_",$class);
				$class=$class[1];
	
	
				$dep=($dep=="CXR")?"NHA":$dep;
				$arv=($arv=="CXR")?"NHA":$arv;
	
				$flight[$irs]["dep"]=$dep;
				$flight[$irs]["arv"]=$arv;
				$flight[$irs]["deptime"]=$deptime;
				$flight[$irs]["arvtime"]=$arvtime;
				$flight[$irs]["flightno"]=strip_tags($flightno);
				$flight[$irs]["price"]=$price;
				$flight[$irs]["class"]=$class;
				$flight[$irs]["stop"]="0";
				$irs++;
			}
		}else{
			$strsearch=$this->_htmlvietjetair;
			#GET TABLE CHUA CHUYEN DI VI KHI HET CHUYEN(2 CHIEU) NO SE LAY LUON TR O DUOI
			$parterntable='/<div id=\"travOpsMain\">.*<\/td>\s+<\/tr>\s+<\/table>\s+<\/div>/isU';
			if(preg_match($parterntable,$strsearch,$divtable)){
				$tabledep=$divtable[0];
			}
			#KET THUC GET TABLE CHUYEND DI
			$parterndep='/<tr class="gridFlight[^>]*id="gridTravelOptDep[^>]*>.*<\/tr>\s+<\/table>\s+<\/td>\s+<\/tr>/isU';
			$parternret='/<tr class="gridFlight[^>]*id="gridTravelOptRet[^>]*>.*<\/tr>\s+<\/table>\s+<\/td>\s+<\/tr>/isU';
	
			preg_match_all($parterndep,$tabledep,$arrdep);
			preg_match_all($parternret,$strsearch,$arrret);
	
			$count_dep=count($arrdep[0]);
			$count_ret=count($arrret[0]);
			#$flight["dep"]["total"]=$count_dep;
			#$flight["ret"]["total"]=$count_ret;
			$irs=0;
			for($i=0;$i<$count_dep;$i++){
				#CHUYEN DI
				$parterndetail='/<td[^>]*?class=\"SegInfo\"\s*>(\d{2}\:\d{2}.*)<br\s*\/>.*?<\/td>\s+<td[^>]*?class=\"SegInfo\"\s*>(\d{2}\:\d{2}.*)<br\s*\/>.*?<\/td>\s+<td[^>]*?class=\"SegInfo\"\s*>(.*?)<br\s*\/>.*?<\/td>/is';
				$parternprice='/<input[^>]*id=\"gridTravelOptDep\"\sname=\"gridTravelOptDep\"\svalue=\"(.*)\"[^>]*\/>\s*([\d|\,]*)\s*<\/td>/isU';
	
				preg_match_all($parterndetail,$arrdep[0][$i],$details);
				
				$replace_vnd=str_replace('VND','',$arrdep[0][$i]);
				preg_match_all($parternprice,$replace_vnd,$prices);
	
				if(!preg_match_all($parternprice,$replace_vnd,$prices)){
					continue;
				}
	
				$dep=str_replace("&nbsp;"," ",$details[1][0]);
				$arv=str_replace("&nbsp;"," ",$details[2][0]);
	
				$dep=explode(" ",$dep);
				$deptime=$dep[0];
				$dep=$dep[1];
	
				$arv=explode(" ",$arv);
				$arvtime=$arv[0];
				$arv=$arv[1];
	
				$flightno=$details[3][0];
				$price=str_replace(",","",$prices[2][0]);
				$class=$prices[1][0];
	
				$class=explode(",",$class);
				$class=$class[1];
				$class=explode("_",$class);
				$class=$class[1];
	
				$dep=($dep=="CXR")?"NHA":$dep;
				$arv=($arv=="CXR")?"NHA":$arv;
	
				$flight["dep"][$irs]["dep"]=$dep;
				$flight["dep"][$irs]["arv"]=$arv;
				$flight["dep"][$irs]["deptime"]=$deptime;
				$flight["dep"][$irs]["arvtime"]=$arvtime;
				$flight["dep"][$irs]["flightno"]=strip_tags($flightno);
				$flight["dep"][$irs]["price"]=$price;
				$flight["dep"][$irs]["class"]=$class;
				$flight["dep"][$irs]["stop"]="0";
				$irs++;
			}
			$irs=0;
			for($i=0;$i<$count_ret;$i++){
				#CHUYEN VE
	
				$parterndetail='/<td[^>]*?class=\"SegInfo\"\s*>(\d{2}\:\d{2}.*)<br\s*\/>.*?<\/td>\s+<td[^>]*?class=\"SegInfo\"\s*>(\d{2}\:\d{2}.*)<br\s*\/>.*?<\/td>\s+<td[^>]*?class=\"SegInfo\"\s*>(.*?)<br\s*\/>.*?<\/td>/is';
				$parternprice='/<input[^>]*id=\"gridTravelOptRet\"\sname=\"gridTravelOptRet\"\svalue=\"(.*)\"[^>]*\/>\s*([\d|\,]*)\s*<\/td>/isU';
	
				preg_match_all($parterndetail,$arrret[0][$i],$details);
				
				$replace_vnd=str_replace('VND','',$arrret[0][$i]);
				preg_match_all($parternprice,$replace_vnd,$prices);
	
				if(!preg_match_all($parternprice,$replace_vnd,$prices)){
					continue;
				}
	
				$dep=str_replace("&nbsp;"," ",$details[1][0]);
				$arv=str_replace("&nbsp;"," ",$details[2][0]);
	
				$dep=explode(" ",$dep);
				$deptime=$dep[0];
				$dep=$dep[1];
	
				$arv=explode(" ",$arv);
				$arvtime=$arv[0];
				$arv=$arv[1];
	
				$flightno=$details[3][0];
				$price=str_replace(",","",$prices[2][0]);
				$class=$prices[1][0];
	
				$class=explode(",",$class);
				$class=$class[1];
				$class=explode("_",$class);
				$class=$class[1];
	
				$dep=($dep=="CXR")?"NHA":$dep;
				$arv=($arv=="CXR")?"NHA":$arv;
	
				$flight["ret"][$irs]["dep"]=$dep;
				$flight["ret"][$irs]["arv"]=$arv;
				$flight["ret"][$irs]["deptime"]=$deptime;
				$flight["ret"][$irs]["arvtime"]=$arvtime;
				$flight["ret"][$irs]["flightno"]= strip_tags($flightno);
				$flight["ret"][$irs]["price"]=$price;
				$flight["ret"][$irs]["class"]=$class;
				$flight["ret"][$irs]["stop"]="0";
				$irs++;
			}
		}
		$this->rs["vietjetair"]=$flight;
	}

    protected function  postVietjetfirst(){
        $cookie_file_path=$this->_cookievj;
        $url="https://book.vietjetair.com/ViewFlights.aspx?lang=en&sesid=";
        $curl=curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_ENCODING,'gzip');
        curl_setopt($curl,CURLOPT_NOBODY,true);
        curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_file_path);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($curl);
        curl_close($curl);

    }

    protected function postVnairfirst(){
        $cookie_file_path=$this->_cookievn;
        $url="https://wl-prod.sabresonicweb.com/SSW2010/B3QE/webqtrip.html?execution=e1s1";

        $curl=curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl,CURLOPT_ENCODING,'gzip');
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_file_path);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($curl);
        curl_close($curl);

    }

    protected function  postjetstarfirst(){
        $cookie_file_path=$this->_cookiejs;
        $url="https://book.jetstar.com/";
        $curl=curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_ENCODING,'gzip');
        curl_setopt($curl,CURLOPT_NOBODY,true);
        curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_file_path);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($curl);
        curl_close($curl);

    }

}
