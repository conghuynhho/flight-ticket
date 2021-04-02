<?php
/**
 * Created by Notepad.
 * User: Lak
 * Date: 10/29/13
 */
?>
<?php
$GLOBALS['way_flight_list'] = array('0' => 'Khứ hồi','1' => 'Một chiều');
$GLOBALS['CODECITY'] = array(	 
	"HAN" => "Hà Nội",
    "HPH" => "Hải Phòng",
    "VDO" => "Vân Đồn",
    "DIN" => "Điện Biên",
    "VII" => "Vinh",
    "HUI" => "Huế",
    "VDH" => "Đồng Hới",
    "DAD" => "Đà Nẵng",
    "PXU" => "Pleiku",
    "TBB" => "Tuy Hòa",
    "SGN" => "Hồ Chí Minh",
    "NHA" => "Nha Trang",
	"CXR" => "Nha Trang",
    "DLI" => "Đà Lạt",
    "PQC" => "Phú Quốc",
    "VCL" => "Tam Kỳ",
    "UIH" => "Quy Nhơn",
    "VCA" => "Cần Thơ",
    "VCS" => "Côn Đảo",
    "BMV" => "Ban Mê Thuột",
    "VKG" => "Rạch Giá",
    "CAH" => "Cà Mau",
    "THD" => "Thanh Hóa",
);
$GLOBALS['NATION'] = array(	 
	"HAN" => "Việt Nam",
    "HPH" => "Việt Nam",
    "VDO" => "Việt Nam",
    "DIN" => "Việt Nam",
    "VII" => "Việt Nam",
    "HUI" => "Việt Nam",
    "VDH" => "Việt Nam",
    "DAD" => "Việt Nam",
    "PXU" => "Việt Nam",
    "TBB" => "Việt Nam",
    "SGN" => "Việt Nam",
    "NHA" => "Việt Nam",
	"CXR" => "Việt Nam",
    "DLI" => "Việt Nam",
    "PQC" => "Việt Nam",
    "VCL" => "Việt Nam",
    "UIH" => "Việt Nam",
    "VCA" => "Việt Nam",
    "VCS" => "Việt Nam",
    "BMV" => "Việt Nam",
    "VKG" => "Việt Nam",
    "CAH" => "Việt Nam",
    "THD" => "Việt Nam",
);
$GLOBALS['AIRPORT'] = array( 
	"HAN" => "Nội Bài (HAN)",
    "HPH" => "Cát Bi (HPH)",
    "VDO" => "Vân Đồn (VDO)",
    "DIN" => "Điện Biên Phủ (DIN)",
    "VII" => "Vinh (VII)",
    "HUI" => "Phú Bài (HUI)",
    "VDH" => "Đồng Hới (VDH)",
    "DAD" => "Đà Nẵng (DAD)",
    "PXU" => "Pleiku (PXU)",
    "TBB" => "Tuy Hòa (TBB)",
    "SGN" => "Tân Sơn Nhất (SGN)",
    "NHA" => "Cam Ranh (CXR)",
	"CXR" => "Cam Ranh (CXR)",
    "DLI" => "Liên Khương (DLI)",
    "PQC" => "Phú Quốc (PQC)",
    "VCL" => "Chu Lai (VCL)",
    "UIH" => "Phù Cát (UIH)",
    "VCA" => "Cần Thơ (VCA)",
    "VCS" => "Côn Đảo (VCS)",
    "BMV" => "Buôn Ma Thuột",
    "VKG" => "Rạch Giá (VKG)",
    "CAH" => "Cà Mau (CAH)",
    "THD" => "Sao Vàng (THD)",
);

$GLOBALS['FULL_AIRPORT_GROUP'] = array(
    array(
        'name' => 'VIỆT NAM',
        'airports' => array(
            'SGN' => 'Hồ Chí Minh (SGN)',
            'HAN' => 'Hà Nội (HAN)',
            'HPH' => 'Hải Phòng (HPH)',
            'VDO' => 'Vân Đồn (VDO)',
            'DAD' => 'Đà Nẵng (DAD)',
            'VCA' => 'Cần Thơ (VCA)',
            'PQC' => 'Phú Quốc (PQC)',
            'CXR' => 'Nha Trang (CXR)',
            'DLI' => 'Đà Lạt (DLI)',
            'THD' => 'Thanh Hóa (THD)',
            'VII' => 'Vinh (VII)',
            'HUI' => 'Huế (HUI)',
            'VDH' => 'Đồng Hới (VDH)',
            'VCL' => 'Chu Lai (VCL)',
            'UIH' => 'Quy Nhơn (UIH)',
            'TBB' => 'Tuy Hòa (TBB)',
            'PXU' => 'Pleiku (PXU)',
            'BMV' => 'Ban Mê Thuột (BMV)',
            'VCS' => 'Côn Đảo (VCS)',
            'VKG' => 'Rạch Giá (VKG)',
            'CAH' => 'Cà Mau (CAH)',
            'DIN' => 'Điện Biên (DIN)',
        ),
    ),
    array(
        'name' => 'ĐÔNG NAM Á',
        'airports' => array(
            'BKK' => 'Bangkok (BKK)',
            'CNX' => 'Chiang Mai (CNX)',
            'CGK' => 'Jakarta (CGK)',
            'KUL' => 'Kuala Lumpur (KUL)',
            'LPQ' => 'Luang Prabang (LPQ)',
            'MNL' => 'Manila (MNL)',
            'PNH' => 'Phnom Penh (PNH)',
            'HKT' => 'Phuket (HKT)',
            'REP' => 'Siem Reap (REP)',
            'KOS' => 'Sihanoukville (KOS)',
            'SIN' => 'Singapore (SIN)',
            'VTE' => 'Vientiane (VTE)',
            'RGN' => 'Yangon (RGN)',
        ),
    ),
    array(
        'name' => 'ĐÔNG BẮC Á',
        'airports' => array(
            'PEK' => 'Beijing (PEK)',
            'PUS' => 'Busan (PUS)',
            'CTU' => 'Chengdu (CTU)',
            'FUK' => 'Fukuoka (FUK)',
            'CAN' => 'Guangzhou (CAN)',
            'HGH' => 'Hàng Châu (HGH)',
            'HKG' => 'Hong Kong (HKG)',
            'KHH' => 'Kaohsiung (KHH)',
            'NGO' => 'Nagoya (NGO)',
            'KIX' => 'Osaka (KIX)',
            'ICN' => 'Seoul (ICN)',
            'SHA' => 'Shanghai (SHA)',
            'TPE' => 'Taipei (TPE)',
            'TNN' => 'Tainan (TNN)',
            'RMQ' => 'Taichung (RMQ)',
            'HND' => 'Tokyo Haneda (HND)',
            'NRT' => 'Tokyo Narita (NRT)',
            'PVG' => 'Shanghai Pudong (PVG)',
            'DXB' => 'Dubai (DXB)',
            'DEL' => 'Indira Gandhi (DEL)',
            'XMN' => 'Xiamen Gaoqi (XMN)',
            'SZX' => 'Shenzhen Bao\'an (SZX)',
            'DPS' => 'Ngurah Rai (DPS)',
            'KMG' => 'Kunming Changshui (KMG)',
        ),
    ),
    array(
        'name' => 'CHÂU ÂU',
        'airports' => array(
            'AMS' => 'Amsterdam (AMS)',
            'BCN' => 'Barcelona (BCN)',
            'FRA' => 'Frankfurt (FRA)',
            'GVA' => 'Geneva (GVA)',
            'LGW' => 'London (LGW)',
            'LYS' => 'Lyon (LYS)',
            'MAD' => 'Madrid (MAD)',
            'MRS' => 'Marseille (MRS)',
            'MPL' => 'Montpellier (MPL)',
            'SVO' => 'Moscow (SVO)',
            'NCE' => 'Nice (NCE)',
            'CDG' => 'Paris (CDG)',
            'PRG' => 'Prague (PRG)',
            'ROM' => 'Rome (ROM)',
            'TLS' => 'Toulouse (TLS)',
            'VIE' => 'Vienna (VIE)',
            'ZRH' => 'Zurich (ZRH)',
            'LHR' => 'Heathrow (LHR)',
            'CPH' => 'Copenhagen (CPH)',
            'WAW' => 'Warsaw Chopin (WAW)',
            'MUC' => 'Munich (MUC)',
            'HEL' => 'Helsinki (HEL)',
        ),
    ),
    array(
        'name' => 'CHÂU MỸ',
        'airports' => array(
            'ATL' => 'Atlanta Hartsfield (ATL)',
            'AUS' => 'Austin (AUS)',
            'BOS' => 'Boston, Logan (BOS)',
            'CHI' => 'Chicago IL (CHI)',
            'DFW' => 'Dallas Fort Worth (DFW)',
            'DEN' => 'Denver (DEN)',
            'HNL' => 'Honolulu (HNL)',
            'LAX' => 'Los Angeles (LAX)',
            'MIA' => 'Miami (MIA)',
            'MSP' => 'Minneapolis/St.Paul (MSP)',
            'JFK' => 'New York (JFK)',
            'PDX' => 'Portland (PDX)',
            'SFO' => 'San Francisco (SFO)',
            'SEA' => 'Seattle, Tacoma (SEA)',
            'STL' => 'St Louis, Lambert (STL)',
            'WAS' => 'Washington (WAS)',
            'IAH' => 'George Bush (IAH)',
            'IAD' => 'Dulles (IAD)',
            'PHX' => 'Phoenix Sky Harbor (PHX)',
            'PHL' => 'Philadelphia (PHL)',
            'TPA' => 'Tampa (TPA)',
            'SAN' => 'San Diego (SAN)',
        ),
    ),
    array(
        'name' => 'CHÂU ÚC',
        'airports' => array(
            'SYD' => 'Sydney (SYD)',
            'MEL' => 'Melbourne (MEL)',
            'MEB' => 'Melbourne (MEB)',
            'BNE' => 'Brisbane (BNE)',
            'PER' => 'Perth (PER)',
            'ADL' => 'Adelaide (ADL)',
            'DRW' => 'Darwin (DRW)',
            'CNS' => 'Cairns (CNS)',
            'OOL' => 'Gold Coast (OOL)',
            'AKL' => 'Auckland (AKL)',
            'WLG' => 'Wellington (WLG)',
            'CHC' => 'Christchurch (CHC)',
            'PMR' => 'Palmerston North (PMR)',
        ),
    ),
    array(
        'name' => 'CHÂU PHI',
        'airports' => array(
            'JNB' => 'Johannesburg (JNB)',
            'CPT' => 'Murtala Muhammed (CPT)',
        ),
    ),
);

$GLOBALS['FULL_AIRPORT_GROUP_VN_DESKTOP'] = array(
    array(
        'label' => 'Việt Nam',
        'airports' => array(
            'HAN' => 'Hà Nội (HAN)',
            'HPH' => 'Hải Phòng (HPH)',
            'DAD' => 'Đà Nẵng (DAD)',
            'HUI' => 'Huế (HUI)',
            'VII' => 'Vinh (VII)',
            'CXR' => 'Nha Trang (CXR)',
            'DLI' => 'Đà Lạt (DLI)',
            'BMV' => 'Ban Mê Thuột (BMV)',
            'PQC' => 'Phú Quốc (PQC)',
            'VCA' => 'Cần Thơ (VCA)',
            'SGN' => 'Hồ Chí Minh (SGN)',
            'VCS' => 'Côn Đảo (VCS)',
            'VKG' => 'Rạch Giá (VKG)',
            'CAH' => 'Cà Mau (CAH)',
            'PXU' => 'Pleiku (PXU)',
            'UIH' => 'Quy Nhơn (UIH)',
            'TBB' => 'Tuy Hòa (TBB)',
            'THD' => 'Thanh Hóa (THD)',
            'VCL' => 'Chu Lai (VCL)',
            'VDH' => 'Đồng Hới (VDH)',
            'DIN' => 'Điện Biên (DIN)',
            'VDO' => 'Vân Đồn (VDO)',

        ),
    ),
);

$GLOBALS['FULL_AIRPORT_GROUP_INTER_DESKTOP'] = array(
    array(
        'label' => 'Quốc Tế',
        'airports' => array(
            'BKK' => 'Bangkok (BKK)',
            'CNX' => 'Chiang Mai (CNX)',
            'CGK' => 'Jakarta (CGK)',
            'KUL' => 'Kuala Lumpur (KUL)',
            'LPQ' => 'Luang Prabang (LPQ)',
            'MNL' => 'Manila (MNL)',
            'PNH' => 'Phnom Penh (PNH)',
            'HKT' => 'Phuket (HKT)',
            'REP' => 'Siem Reap (REP)',
            'KOS' => 'Sihanoukville (KOS)',
            'SIN' => 'Singapore (SIN)',
            'VTE' => 'Vientiane (VTE)',
            'RGN' => 'Yangon (RGN)',
            'PEK' => 'Beijing (PEK)',
            'PUS' => 'Busan (PUS)',
            'CTU' => 'Chengdu (CTU)',
            'FUK' => 'Fukuoka (FUK)',
            'CAN' => 'Guangzhou (CAN)',
            'HGH' => 'Hàng Châu (HGH)',
            'HKG' => 'Hong Kong (HKG)',
            'KHH' => 'Kaohsiung (KHH)',
            'NGO' => 'Nagoya (NGO)',
            'KIX' => 'Osaka (KIX)',
            'ICN' => 'Seoul (ICN)',
            'SHA' => 'Shanghai (SHA)',
            'TPE' => 'Taipei (TPE)',
            'TNN' => 'Tainan (TNN)',
            'RMQ' => 'Taichung (RMQ)',
            'HND' => 'Tokyo Haneda (HND)',
            'NRT' => 'Tokyo Narita (NRT)',
            
        ),
    ),
);

$GLOBALS['FULL_AIRPORT_GROUP_MOBILE'] = array(
    array(
        'name' => 'VIỆT NAM',
        'rel' => 'vietnamese',
        'airports' => array(
            'HAN' => 'Hà Nội (HAN)',
            'VDO' => 'Vân Đồn (VDO)',
            'HPH' => 'Hải Phòng (HPH)',
            'DIN' => 'Điện Biên (DIN)',
            'SGN' => 'Hồ Chí Minh (SGN)',
            'VCA' => 'Cần Thơ (VCA)',
            'VCS' => 'Côn Đảo (VCS)',
            'PQC' => 'Phú Quốc (PQC)',
            'VKG' => 'Rạch Giá (VKG)',
            'CAH' => 'Cà Mau (CAH)',
            'DAD' => 'Đà Nẵng (DAD)',
            'THD' => 'Thanh Hóa (THD)',
            'VII' => 'Vinh (VII)',
            'HUI' => 'Huế (HUI)',
            'VDH' => 'Đồng Hới (VDH)',
            'VCL' => 'Chu Lai (VCL)',
            'UIH' => 'Quy Nhơn (UIH)',
            'TBB' => 'Tuy Hòa (TBB)',
            'CXR' => 'Nha Trang (CXR)',
            'PXU' => 'Pleiku (PXU)',
            'DLI' => 'Đà Lạt (DLI)',
            'BMV' => 'Ban Mê Thuột (BMV)',
        ),
    ),
    array(
        'name' => 'ĐÔNG NAM Á',
        'rel' => 'southeast-asia',
        'airports' => array(
            'BKK' => 'Bangkok (BKK)',
            'CNX' => 'Chiang Mai (CNX)',
            'CGK' => 'Jakarta (CGK)',
            'KUL' => 'Kuala Lumpur (KUL)',
            'LPQ' => 'Luang Prabang (LPQ)',
            'MNL' => 'Manila (MNL)',
            'PNH' => 'Phnom Penh (PNH)',
            'HKT' => 'Phuket (HKT)',
            'REP' => 'Siem Reap (REP)',
            'KOS' => 'Sihanoukville (KOS)',
            'SIN' => 'Singapore (SIN)',
            'VTE' => 'Vientiane (VTE)',
            'RGN' => 'Yangon (RGN)',
        ),
    ),
    array(
        'name' => 'ĐÔNG BẮC Á',
        'rel' => 'northeast-asia',
        'airports' => array(
            'PEK' => 'Beijing (PEK)',
            'PUS' => 'Busan (PUS)',
            'CTU' => 'Chengdu (CTU)',
            'FUK' => 'Fukuoka (FUK)',
            'CAN' => 'Guangzhou (CAN)',
            'HGH' => 'Hàng Châu (HGH)',
            'HKG' => 'Hong Kong (HKG)',
            'KHH' => 'Kaohsiung (KHH)',
            'NGO' => 'Nagoya (NGO)',
            'KIX' => 'Osaka (KIX)',
            'ICN' => 'Seoul (ICN)',
            'SHA' => 'Shanghai (SHA)',
            'TPE' => 'Taipei (TPE)',
            'TNN' => 'Tainan (TNN)',
            'RMQ' => 'Taichung (RMQ)',
            'HND' => 'Tokyo Haneda (HND)',
            'NRT' => 'Tokyo Narita (NRT)',
            'PVG' => 'Shanghai Pudong (PVG)',
            'DXB' => 'Dubai (DXB)',
            'DEL' => 'Indira Gandhi (DEL)',
            'XMN' => 'Xiamen Gaoqi (XMN)',
            'SZX' => 'Shenzhen Bao\'an (SZX)',
            'DPS' => 'Ngurah Rai (DPS)',
            'KMG' => 'Kunming Changshui (KMG)',
        ),
    ),
    array(
        'name' => 'CHÂU ÂU',
        'rel' => 'europe',
        'airports' => array(
            'AMS' => 'Amsterdam (AMS)',
            'BCN' => 'Barcelona (BCN)',
            'FRA' => 'Frankfurt (FRA)',
            'GVA' => 'Geneva (GVA)',
            'LGW' => 'London (LGW)',
            'LYS' => 'Lyon (LYS)',
            'MAD' => 'Madrid (MAD)',
            'MRS' => 'Marseille (MRS)',
            'MPL' => 'Montpellier (MPL)',
            'SVO' => 'Moscow (SVO)',
            'NCE' => 'Nice (NCE)',
            'CDG' => 'Paris (CDG)',
            'PRG' => 'Prague (PRG)',
            'ROM' => 'Rome (ROM)',
            'TLS' => 'Toulouse (TLS)',
            'VIE' => 'Vienna (VIE)',
            'ZRH' => 'Zurich (ZRH)',
            'LHR' => 'Heathrow (LHR)',
            'CPH' => 'Copenhagen (CPH)',
            'WAW' => 'Warsaw Chopin (WAW)',
            'MUC' => 'Munich (MUC)',
            'HEL' => 'Helsinki (HEL)',
        ),
    ),
    array(
        'name' => 'CHÂU MỸ',
        'rel' => 'americas',
        'airports' => array(
            'ATL' => 'Atlanta Hartsfield (ATL)',
            'AUS' => 'Austin (AUS)',
            'BOS' => 'Boston, Logan (BOS)',
            'CHI' => 'Chicago IL (CHI)',
            'DFW' => 'Dallas Fort Worth (DFW)',
            'DEN' => 'Denver (DEN)',
            'HNL' => 'Honolulu (HNL)',
            'LAX' => 'Los Angeles (LAX)',
            'MIA' => 'Miami (MIA)',
            'MSP' => 'Minneapolis/St.Paul (MSP)',
            'JFK' => 'New York (JFK)',
            'PDX' => 'Portland (PDX)',
            'SFO' => 'San Francisco (SFO)',
            'SEA' => 'Seattle, Tacoma (SEA)',
            'STL' => 'St Louis, Lambert (STL)',
            'WAS' => 'Washington (WAS)',
            'IAH' => 'George Bush (IAH)',
            'IAD' => 'Dulles (IAD)',
            'PHX' => 'Phoenix Sky Harbor (PHX)',
            'PHL' => 'Philadelphia (PHL)',
            'TPA' => 'Tampa (TPA)',
            'SAN' => 'San Diego (SAN)',
        ),
    ),
    array(
        'name' => 'CHÂU ÚC',
        'rel' => 'australia',
        'airports' => array(
            'SYD' => 'Sydney (SYD)',
            'MEL' => 'Melbourne (MEL)',
            'MEB' => 'Melbourne (MEB)',
            'BNE' => 'Brisbane (BNE)',
            'PER' => 'Perth (PER)',
            'ADL' => 'Adelaide (ADL)',
            'DRW' => 'Darwin (DRW)',
            'CNS' => 'Cairns (CNS)',
            'OOL' => 'Gold Coast (OOL)',
            'AKL' => 'Auckland (AKL)',
            'WLG' => 'Wellington (WLG)',
            'CHC' => 'Christchurch (CHC)',
            'PMR' => 'Palmerston North (PMR)',
        ),
    ),
    array(
        'name' => 'CHÂU PHI',
        'rel' => 'africa',
        'airports' => array(
            'JNB' => 'Johannesburg (JNB)',
            'CPT' => 'Murtala Muhammed (CPT)',
        ),
    ),
);

$GLOBALS['itinerary'] = array('0' => 'Bay thẳng',
    '1' => '1 điểm dừng',);
$GLOBALS['BOOKINGSTATUS'] = array('1' => 'Chưa xác nhận',
    '2' => 'Đang chờ thanh toán',
    '3' => 'Đã xác nhận',
    '4' => 'Đã Hủy',
    '6' => 'Đã gọi',
    '7' => 'Đã xuất vé',
    '8' => 'Hoàn tất',
);
$GLOBALS['payment_type']=array(
    '1' => 'Tại nhà',
    '2' => 'Tại văn phòng',
    '3' => 'Chuyển khoản',
    '4' => 'Ngân lượng',
    '5' => 'Đại lý'
);

/***
 * @param $date
 * @return array
 * Liet Ke +-3 Ngay So Voi Ngay Hien Tai
 */
function date_of_currentdate($date) // date format: dd/mm/yyyy
{

    $arr = array();

    $curDay = (int)date('d');
    $curMonth = (int)date('m');
    $curYear = (int)date('Y');

    $partofdate = explode('/',$date);
    $partDay = (int)$partofdate[0];
    $partMonth = (int)$partofdate[1];
    $partYear = (int)$partofdate[2];

    if($partDay == $curDay){
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay+0),$partYear));
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay+1),$partYear));
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay+2),$partYear));
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay+3),$partYear));
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay+4),$partYear));
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay+5),$partYear));
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay+6),$partYear));
    }
    elseif($partDay - $curDay == 1){
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay-1),$partYear));
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay+0),$partYear));
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay+1),$partYear));
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay+2),$partYear));
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay+3),$partYear));
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay+4),$partYear));
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay+5),$partYear));
    }
    elseif($partDay - $curDay == 2){
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay-2),$partYear));
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay-1),$partYear));
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay+0),$partYear));
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay+1),$partYear));
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay+2),$partYear));
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay+3),$partYear));
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay+4),$partYear));
    }
    else{
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay-3),$partYear));
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay-2),$partYear));
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay-1),$partYear));
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay+0),$partYear));
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay+1),$partYear));
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay+2),$partYear));
        $arr[] = date('d/m/Y',mktime(0,0,0,$partMonth,($partDay+3),$partYear));
    }

    return $arr;
}

/***
 * @param $day dd/mm/yyyy
 * @return mixed
 * Tra Ve Thu Trong Tuan Cua Ngay Truyen Vao
 */
function echoDate($day){ // $day format : dd/mm/yyyy
    $date = explode('/',$day);
    $dd   = $date[0];
    $mm   = $date[1];
    $yyyy = $date[2];
    $date = date("D",strtotime($dd.'-'.$mm.'-'.$yyyy));
    $arrdate = array(
        "Mon" => "Thứ 2",
        "Tue" => "Thứ 3",
        "Wed" => "Thứ 4",
        "Thu" => "Thứ 5",
        "Fri" => "Thứ 6",
        "Sat" => "Thứ 7",
        "Sun" => "Chủ nhật",);

    return $arrdate[$date];
}

/***
 * @param $code
 * @return string
 *Tra Ve Full Name Cua Thanh Pho o VN
 */
function getCityVn($code){
    if($GLOBALS['CODECITY'][$code])
        return $GLOBALS['CODECITY'][$code];
    else
        return "";
}
/***
 * @param $code
 * @return string
 * Tra Ve Full Name Cua Thanh Pho O Quoc Te
 */
function getCityName($code){
    $name = '';
	$result = get_airport_from_ws($code, 1);
	if($result['data'] && count($result['data']) > 0){
		$name = $result['data'][0]['value'];
	}
	return $name;
}

/***
 * @param $city
 * @return mixed
 * Tra Ve Ten Country cua City(Code)
 */
function getCountryByCity($city){
    $string = file_get_contents(get_stylesheet_directory()."/flight_config/airports.json");
    $json_a=json_decode($string,true);
    $count_arr = count($json_a);
    $tcity=strtolower(trim($city));
    for($i = 0; $i < $count_arr; $i++){
        if (strpos(strtolower($json_a[$i]['location']),$tcity) !==false) {
            return $json_a[$i]['location'];
        }
    }
    return $city;
}

/***
 * @param $date
 * @return mixed
 * Tra Ve So Thu Tu Cua Ngay Hien Tai Trong Tuan
 */
function getDay($date){
    global $arrday;
    $tempday=date("w",strtotime(date_vn_to_us($date,"/")));
    return $arrday[$tempday];

}

/***
 * @param $str
 * @return string
 * Clear Bien Nguoi Dung Nhap Vao
 */
function clearvar($str){
    return trim(preg_replace('/ */', '', preg_replace('/[^A-Za-z0-9 ]/', '', urldecode(html_entity_decode(strip_tags($str))))));
}

/***
 * @param $price
 * @param $airline
 * @return float|int
 * vietnamairline - jetstar - vietjetair
 * VN : VietNam Airline
 * VJ : Vietjet Air
 * BL : Jetstar
 */
function get_price_child($price,$airline){
    $gia = 0;
    if($airline == 'vietnamairline'){
        $gia = round(($price)* 0.9);
        if($gia%1000!=0)
            $gia=ceil($gia/1000)*1000;
    }elseif($airline == 'jetstar' || $airline == 'vietjetair'){
        $gia = $price;
    }elseif($airline == 'bambooairways'){
        $gia = round(($price)* 0.75);
        if($gia%1000!=0)
            $gia=ceil($gia/1000)*1000;
    }
    return $gia;
}

function get_price_infant($price,$airline){
    $gia = 0;

    if($airline == 'vietnamairline' || $airline == 'P8'){
        $gia = round(($price) * 0.1);
        $gia=ceil($gia/1000)*1000;
    }elseif($airline == 'jetstar' || $airline == 'vietjetair' || $airline == 'bambooairways'){
        $gia = 0;
    }
    return $gia;
}


/**Tinh Thue Phi Nguoi Lon*/
function getTaxFee_adult($price,$airline){
    /***
    VN : VietNam Airline
    VJ : Vietjet Air
    BL : Jetstar
     */
    $thuephi = 0;

    if($airline == 'vietnamairline'){
        $svfee=get_option("opt_svfee_adult_vn");

        $vat=($price * 0.1);
        if( ($vat%1000) != 0 )
            $vat=ceil($vat/1000)*1000;
			
		$svfee=vnasvfee($svfee,$price);

        $thuephi = round($vat + get_option("opt_airfee_adult_vn") + $svfee + get_option("opt_adminfee_adult_vn"));
    }
    elseif($airline == 'jetstar'){
        $srvfee=get_option("opt_svfee_adult_js");
        //if($price<800000)
          //  $srvfee+=30000;
        $thuephi = round(($price * 0.1) + get_option("opt_airfee_adult_js") + $srvfee + get_option("opt_adminfee_adult_js"));  // 20k phí admin
    }
    elseif($airline == 'vietjetair'){
        $srvfee=get_option("opt_svfee_adult_vj");
        //if($price<600000)
          //  $srvfee*=2;
        $thuephi = round(($price * 0.1) + get_option("opt_airfee_adult_vj") + $srvfee + get_option("opt_adminfee_adult_vj"));  // 20k phí admin
    }
    elseif($airline == 'bambooairways'){
        $svfee=get_option("opt_svfee_adult_qh");

        $vat=($price * 0.1);
        if( ($vat%1000) != 0 )
            $vat=ceil($vat/1000)*1000;

        $thuephi = round($vat + get_option("opt_airfee_adult_qh") + $svfee + get_option("opt_adminfee_adult_qh"));
    }

    $thuephi += get_promo_service_fee($price); // Add promo service fee

    return $thuephi;
}

/*Tinh Thue Phi Tre Em*/
function getTaxFee_child($price,$airline){
    $gia = 0;
    if($airline == 'vietnamairline'){
        $baseprice=get_price_child($price,"vietnamairline");

        $vat=$baseprice*0.1;
        if( ($vat%1000) != 0 )
            $vat=ceil($vat/1000)*1000;

        $svfee=get_option("opt_svfee_child_vn");
		$svfee=vnasvfee($svfee,$price);
		
        $gia = round( $vat + get_option("opt_airfee_child_vn") + $svfee + get_option("opt_adminfee_child_vn"));
    }elseif($airline == 'jetstar'){
        $srvfee=get_option("opt_svfee_child_js");
        //if($price<800000)
          //  $srvfee+=30000;
        $gia = round( ( $price * 0.1) + get_option("opt_airfee_child_js") + $srvfee + get_option("opt_adminfee_child_js"));
    }elseif( $airline == 'vietjetair'){
        $srvfee=get_option("opt_svfee_child_vj");
        //if($price<600000)
          //  $srvfee*=2;
        $gia = round(( $price * 0.1) + get_option("opt_airfee_child_vj") + $srvfee + get_option("opt_adminfee_child_vj"));
    }elseif($airline == 'bambooairways'){
        $baseprice=get_price_child($price,"bambooairways");

        $vat=$baseprice*0.1;
        if( ($vat%1000) != 0 )
            $vat=ceil($vat/1000)*1000;

        $svfee=get_option("opt_svfee_child_qh");
		
        $gia = round( $vat + get_option("opt_airfee_child_qh") + $svfee + get_option("opt_adminfee_child_qh"));
    }

    $gia += get_promo_service_fee($price); // Add promo service fee

    return $gia;
}
/*Tinh Thue Phi Tre So Sinh*/
function getTaxFee_infant($price,$airline){
    $gia = 0;
    if($airline == 'vietnamairline'){
        $svfee=get_option("opt_svfee_infant_vn");
        $svfee=vnasvfee($svfee,$price);		
        $baseprice=get_price_infant($price,"vietnamairline");
        $vat=$baseprice*0.1;
        if( ($vat%1000) != 0 )
            $vat=ceil($vat/1000)*1000;
        $gia = round($vat + $svfee + (int)get_option("opt_airfee_infant_vn") + (int)get_option("opt_adminfee_infant_vn"));
    }elseif($airline == 'jetstar'){
        $gia = (int)get_option("opt_airfee_infant_js") + (int)get_option("opt_adminfee_infant_js") + (int)get_option("opt_svfee_infant_js");
    }elseif($airline == 'vietjetair'){
        $gia = (int)get_option("opt_airfee_infant_vj") + (int)get_option("opt_adminfee_infant_vj") + (int)get_option("opt_svfee_infant_vj");
    }elseif($airline == 'bambooairways'){
        $gia = (int)get_option("opt_airfee_infant_qh") + (int)get_option("opt_adminfee_infant_qh") + (int)get_option("opt_svfee_infant_qh");
    }

    $gia += get_promo_service_fee($price); // Add promo service fee

    return $gia;
} 

/*For inter flight*/
function plus_day($current,$day){
    $temp_date=explode("/",$current);
    $temp_mktime=mktime(0, 0, 0, $temp_date[1]  , $temp_date[0]+$day , $temp_date[2]);;
    return date("d/m/Y",$temp_mktime);
}

function sub_day($current,$day){
    $temp_date=explode("/",$current);
    $temp_mktime=mktime(0, 0, 0, $temp_date[1]  , $temp_date[0]-$day , $temp_date[2]);;
    return date("d/m/Y",$temp_mktime);
}

function date_lessthan($date1,$date2){
    $tempdate1=explode(":",$date1);
    $tempdate2=explode(":",$date2);

    if($tempdate1[0]>$tempdate2[0])
        return false;
    if(($tempdate1[0]==$tempdate2[0]) && ($tempdate1[1]>$tempdate2[1]))
        return false;
    return true;
}

function getNextDate($deptime,$arvtime,$depdate){
    if(date_lessthan($deptime,$arvtime)){
        return $depdate;
    }
    else{
        return plus_day($depdate,1);
    }
}
function getNextTime($crtime,$plustime){
    $tempplus=explode(" ",$plustime);
    $tempplusH=substr($tempplus[0],-1);
    $tempplusM=substr($tempplus[1],-1);
    $tempcr=explode(":",$crtime);
    $tempcrH=$tempcr[0];
    $tempcrM=$tempcr[1];
    $tempnextH=($tempcrH+$tempplusH)>=24?(($tempcrH+$tempplusH)-24):($tempcrH+$tempplusH);
    if(($tempplusM+$tempcrM)>60){
        $tempnextM=($tempplusM+$tempcrM)-60;
        $tempnextH+=1;
        $tempnextH=($tempnextH>=24)?24-$tempnextH:$tempnextH;

    }else{
        $tempnextM=$tempplusM+$tempcrM;
    }
    return $tempnextH.":".$tempnextM;
}

function cal_time($deptime,$arvtime){
    $t_arvtime=explode(":",$arvtime);
    $t_deptime=explode(":",$deptime);
    if($t_arvtime[0]<$t_deptime[0]){
        $t_hour=(24-$t_deptime[0])+$t_arvtime[0];
    }else{
        $t_hour=$t_arvtime[0]-$t_deptime[0];
    }

    $t_minus=(60-$t_deptime[1])+$t_arvtime[1];

    if($t_minus>=60){
        $t_minus=$t_minus-60;
    }else{
        $t_hour--;
    }
    return $t_hour."h ".$t_minus."p";
}
/*End for inter flight*/

/***
 * @param $base_price Gia Co Ban
 * @param $pass_type adult,child,infant
 * @param $airline_code
 * @return array(airport_fee,admin_fee,fee,price,tax
 * Get detail flight tra ve mang de dua vao bm
 */
function get_detail_price($base_price,$pass_type,$airline_code){
    switch($pass_type){
        case "adult":
            switch($airline_code){
                case "vietnamairline":

                    $rs["airport_fee"]=get_option("opt_airfee_adult_vn");
                    $rs["admin_fee"]=get_option("opt_adminfee_adult_vn");
                    $svfee=get_option("opt_svfee_adult_vn");
					$svfee=vnasvfee($svfee,$base_price);
                    $rs["fee"]=$svfee;
                    break;
                case "vietjetair":
                    $rs["airport_fee"]=get_option("opt_airfee_adult_vj");
                    $rs["admin_fee"]=get_option("opt_adminfee_adult_vj");

                    $srvfee=get_option("opt_svfee_adult_vj");
                    //if($base_price<600000)
                        //$srvfee*=2;
                    $rs["fee"]=$srvfee;

                    break;
                case "jetstar":
                    $rs["airport_fee"]=get_option("opt_airfee_adult_js");
                    $rs["admin_fee"]=get_option("opt_adminfee_adult_js");
                    $srvfee=get_option("opt_svfee_adult_js");
                    //if($base_price<800000)
                        //$srvfee+=30000;
                    $rs["fee"]=$srvfee;
                    break;
                case "bambooairways":

                    $rs["airport_fee"]=get_option("opt_airfee_adult_qh");
                    $rs["admin_fee"]=get_option("opt_adminfee_adult_qh");
                    $svfee=get_option("opt_svfee_adult_qh");
                    $rs["fee"]=$svfee;
                    break;
            }
            $rs["price"]=$base_price;
            $tax=$base_price*0.1;

            if(($airline_code=="vietnamairline" || $airline_code=="bambooairways") && ($tax%1000!=0))
                $tax=ceil($tax/1000)*1000;
            $rs["tax"]=$tax;
            break;
        case "child":
            switch($airline_code){
                case "vietnamairline":
                    $rs["airport_fee"]=get_option("opt_airfee_child_vn");
                    $rs["admin_fee"]=get_option("opt_adminfee_child_vn");
                    $svfee=get_option("opt_svfee_child_vn");
					$svfee=vnasvfee($svfee,$base_price);

                    $rs["fee"]=$svfee;
                    break;
                case "vietjetair":
                    $rs["airport_fee"]=get_option("opt_airfee_child_vj");
                    $rs["admin_fee"]=get_option("opt_adminfee_child_vj");
                    $rs["fee"]=get_option("opt_svfee_child_vj");
                    break;
                case "jetstar":
                    $rs["airport_fee"]=get_option("opt_airfee_child_js");
                    $rs["admin_fee"]=get_option("opt_adminfee_child_js");
                    $rs["fee"]=get_option("opt_svfee_child_js");
                    break;
                case "bambooairways":
                    $rs["airport_fee"]=get_option("opt_airfee_child_qh");
                    $rs["admin_fee"]=get_option("opt_adminfee_child_qh");
                    $svfee=get_option("opt_svfee_child_qh");

                    $rs["fee"]=$svfee;
                    break;
            }
            $rs["price"]=get_price_child($base_price,$airline_code);

            $tax=round($rs["price"]*0.1);

            if(($airline_code=="vietnamairline" || $airline_code=="bambooairways") && ($tax%1000!=0))
                $tax=ceil($tax/1000)*1000;
            $rs["tax"]=$tax;
            break;
        case "infant":
            switch($airline_code){
                case "vietnamairline":
                    $rs["airport_fee"]=get_option("opt_airfee_infant_vn");
                    $rs["admin_fee"]=get_option("opt_adminfee_infant_vn");
                    $svfee=get_option("opt_svfee_infant_vn");
					$svfee=vnasvfee($svfee,$base_price);

                    $rs["fee"]=$svfee;
                    break;
                case "vietjetair":
                    $rs["airport_fee"]=get_option("opt_airfee_infant_vj");
                    $rs["admin_fee"]=get_option("opt_adminfee_infant_vj");
                    $rs["fee"]=get_option("opt_svfee_infant_vj");
                    break;
                case "jetstar":
                    $rs["airport_fee"]=get_option("opt_airfee_infant_js");
                    $rs["admin_fee"]=get_option("opt_adminfee_infant_js");
                    $rs["fee"]=get_option("opt_svfee_infant_js");
                    break;
                case "bambooairways":
                    $rs["airport_fee"]=get_option("opt_airfee_infant_qh");
                    $rs["admin_fee"]=get_option("opt_adminfee_infant_qh");
                    $svfee=get_option("opt_svfee_infant_qh");

                    $rs["fee"]=$svfee;
                    break;
            }
            $rs["price"]=get_price_infant($base_price,$airline_code);
            if($airline_code == 'jetstar' || $airline_code == 'vietjetair'){
                $rs["tax"]=0;
            }else{


                $tax=round($rs["price"]*0.1);

                if(($airline_code=="vietnamairline" || $airline_code=="bambooairways") && ($tax%1000!=0))
                    $tax=ceil($tax/1000)*1000;

                $rs["tax"]=$tax;
            }
            break;

    }

    $rs['fee'] += get_promo_service_fee($base_price); // Add promo service fee

    return $rs;

}

// ĐIỀU KIỆN HÀNH LÝ CỘNG THÊM LUỢT ĐI
function Dep_addBaggage($airline, $ticketClass = ''){
    $str = '';
    if($airline == 'vietnamairline'){
        $str.= '<tr><td>Xách tay</td><td>Mỗi hành khách được mang tối đa 10 Kg hành lý xách tay.</td></tr>';
        $arrayClassEconomy = array('Economy (EP)-A','Economy (EP)-P','Economy (EP)-G','A','P','G');
        $arrayClassBusiness = array('Business (BF)-C','Business (BF)-J','Business (BC)-D');
        if (in_array($ticketClass, $arrayClassEconomy)) {
            $str.= '<tr>
                        <td>Ký gửi</td>
                        <td><input type="hidden" name="dep_addbaggage[]" value="1">Không mang hành lý ký gửi.</td>
                    </tr>';
        } elseif (in_array($ticketClass, $arrayClassBusiness)) {
            $str.= '<tr>
                        <td>Ký gửi</td>
                        <td><input type="hidden" name="dep_addbaggage[]" value="2">Mỗi người tối đa 32 kg.</td>
                    </tr>';
        } else {
            $str.= '<tr><td>Ký gửi</td><td>Mỗi người tối đa 23 Kg.</td></tr>';
        }
    }
    elseif($airline == 'jetstar'){
        $str = '<tr><td>Xách tay</td><td>Mỗi người tối đa 7 Kg.</td></tr>
				<tr>
					<td>Ký gửi</td>
					<td>
						<select name="dep_addbaggage[]" class="dep_addbaggage">
							<option value="0">Không mang hành lý ký gửi</option>
							<option value="220000">Thêm 15kg hành lý (220.000 VND/Khách)</option>
							<option value="240000">Thêm 20kg hành lý (240.000 VND/Khách)</option>
							<option value="330000">Thêm 25kg hành lý (330.000 VND/Khách)</option>
							<option value="460000">Thêm 30kg hành lý (460.000 VND/Khách)</option>
							<option value="525000">Thêm 35kg hành lý (525.000 VND/Khách)</option>
							<option value="590000">Thêm 40kg hành lý (590.000 VND/Khách)</option>
						</select>
					</td>
				</tr>';
    }
    elseif($airline == 'airmekong'){
        $str = '<tr><td>Xách tay</td><td>Mỗi người tối đa 7 Kg.</td></tr>
				<tr><td>Ký gửi</td><td>Mỗi người tối đa 20 Kg.</td></tr>';
    }
    elseif($airline == 'vietjetair'){
        $str = '<tr><td>Xách tay</td><td>Mỗi người tối đa 7 Kg.</td></tr>
				<tr>
					<td>Ký gửi</td>
					<td>
						<select name="dep_addbaggage[]" class="dep_addbaggage">
							<option value="0">Không mang hành lý ký gửi</option>
							<option value="180000">Thêm 15kg hành lý (180.000 VND/Khách)</option>
							<option value="210000">Thêm 20kg hành lý (210.000 VND/Khách)</option>
							<option value="270000">Thêm 25kg hành lý (270.000 VND/Khách)</option>
							<option value="380000">Thêm 30kg hành lý (380.000 VND/Khách)</option>
							<option value="450000">Thêm 35kg hành lý (450.000 VND/Khách)</option>
							<option value="500000">Thêm 40kg hành lý (500.000 VND/Khách)</option>
							
						</select>
					</td>
				</tr>';
    }
    elseif($airline == 'bambooairways'){

        if($ticketClass == 'Business') {
            $str = '<tr>
            <td>Xách tay</td>
            <td>Mỗi người tối đa 2 kiện (2 x 7kg).</td>
            </tr>';
        }else{
            $str = '<tr>
            <td>Xách tay</td>
            <td>Mỗi người tối đa 7kg.</td>
            </tr>';
        }

        if($ticketClass == 'Business') {
            $baggageSelect = '<select name="dep_addbaggage[]" class="dep_addbaggage">
            <option value="0">Miễn phí 30kg hành lý ký gửi</option>
            <option value="110000">Thêm 35kg hành lý (110.000 VND/Khách)</option>
            <option value="140000">Thêm 40kg hành lý (140.000 VND/Khách)</option>
						</select>';
        }elseif($ticketClass == 'Plus'){
            $baggageSelect = '<select name="dep_addbaggage[]" class="dep_addbaggage">
            <option value="0">Miễn phí 20kg hành lý ký gửi</option>
            <option value="100000">Thêm 25kg hành lý (100.000 VND/Khách)</option>
            <option value="130000">Thêm 30kg hành lý (130.000 VND/Khách)</option>
            <option value="170000">Thêm 35kg hành lý (170.000 VND/Khách)</option>
            <option value="190000">Thêm 40kg hành lý (190.000 VND/Khách)</option>
						</select>';
        }else{
            $baggageSelect = '<select name="dep_addbaggage[]" class="dep_addbaggage">
            <option value="0">Không mang hành lý ký gửi</option>
            <option value="210000">Thêm 20kg hành lý (210.000 VND/Khách)</option>
            <option value="250000">Thêm 25kg hành lý (250.000 VND/Khách)</option>
            <option value="300000">Thêm 30kg hành lý (300.000 VND/Khách)</option>
            <option value="330000">Thêm 35kg hành lý (330.000 VND/Khách)</option>
            <option value="370000">Thêm 40kg hành lý (370.000 VND/Khách)</option>
						</select>';
        }

        $str .= '<tr>
					<td>Ký gửi</td>
					<td>'.$baggageSelect.'</td>
				</tr>';
    }

    echo $str;
}

// ĐIỀU KIỆN HÀNH LÝ LƯỢT VỀ
function Ret_addBaggage($airline, $ticketClass = ''){
    $str = '';
    if($airline == 'vietnamairline'){
        $str.= '<tr><td>Xách tay</td><td>Mỗi hành khách được mang tối đa 10 Kg hành lý xách tay.</td></tr>';
        $arrayClassEconomy = array('Economy (EP)-A','Economy (EP)-P','Economy (EP)-G','A','P','G');
        $arrayClassBusiness = array('Business (BF)-C','Business (BF)-J','Business (BC)-D');
        if (in_array($ticketClass, $arrayClassEconomy)) {
            $str.= '<tr>
                        <td>Ký gửi</td>
                        <td><input type="hidden" name="ret_addbaggage[]" value="1">Không mang hành lý ký gửi.</td>
                    </tr>';
        } elseif (in_array($ticketClass, $arrayClassBusiness)) {
            $str.= '<tr>
                        <td>Ký gửi</td>
                        <td><input type="hidden" name="ret_addbaggage[]" value="2">Mỗi người tối đa 32 kg.</td>
                    </tr>';
        } else {
            $str.= '<tr><td>Ký gửi</td><td>Mỗi người tối đa 23 Kg.</td></tr>';
        }
    }
    elseif($airline == 'jetstar'){
        $str = '<tr><td>Xách tay</td><td>Mỗi người tối đa 7 Kg.</td></tr>
				<tr>
					<td>Ký gửi</td>
					<td>
						<select name="ret_addbaggage[]" class="ret_addbaggage">
							<option value="0">Không mang hành lý ký gửi</option>
							<option value="220000">Thêm 15kg hành lý (220.000 VND/Khách)</option>
							<option value="240000">Thêm 20kg hành lý (240.000 VND/Khách)</option>
							<option value="330000">Thêm 25kg hành lý (330.000 VND/Khách)</option>
							<option value="460000">Thêm 30kg hành lý (460.000 VND/Khách)</option>
							<option value="525000">Thêm 35kg hành lý (525.000 VND/Khách)</option>
							<option value="590000">Thêm 40kg hành lý (590.000 VND/Khách)</option>
						</select>
					</td>
				</tr>';
    }
    elseif($airline == 'airmekong'){
        $str = '<tr><td>Xách tay</td><td>Mỗi người tối đa 7 Kg.</td></tr>
				<tr><td>Ký gửi</td><td>Mỗi người tối đa 20 Kg.</td></tr>';
    }
    elseif($airline == 'vietjetair'){
        $str = '<tr><td>Xách tay</td><td>Mỗi người tối đa 7 Kg.</td></tr>
				<tr>
					<td>Ký gửi</td>
					<td>
						<select name="ret_addbaggage[]" class="ret_addbaggage">
							<option value="0">Không mang hành lý ký gửi</option>
							<option value="180000">Thêm 15kg hành lý (180.000 VND/Khách)</option>
							<option value="210000">Thêm 20kg hành lý (210.000 VND/Khách)</option>
							<option value="270000">Thêm 25kg hành lý (270.000 VND/Khách)</option>
							<option value="380000">Thêm 30kg hành lý (380.000 VND/Khách)</option>
							<option value="450000">Thêm 35kg hành lý (450.000 VND/Khách)</option>
							<option value="500000">Thêm 40kg hành lý (500.000 VND/Khách)</option>
						
						</select>
					</td>
				</tr>';
    }
    elseif($airline == 'bambooairways'){

        if($ticketClass == 'Business') {
            $str = '<tr>
            <td>Xách tay</td>
            <td>Mỗi người tối đa 2 kiện (2 x 7kg).</td>
            </tr>';
        }else{
            $str = '<tr>
            <td>Xách tay</td>
            <td>Mỗi người tối đa 7kg.</td>
            </tr>';
        }

        if($ticketClass == 'Business') {
            $baggageSelect = '<select name="ret_addbaggage[]" class="ret_addbaggage">
            <option value="0">Miễn phí 30kg hành lý ký gửi</option>
            <option value="110000">Thêm 35kg hành lý (110.000 VND/Khách)</option>
            <option value="140000">Thêm 40kg hành lý (140.000 VND/Khách)</option>
						</select>';
        }elseif($ticketClass == 'Plus'){
            $baggageSelect = '<select name="ret_addbaggage[]" class="ret_addbaggage">
            <option value="0">Miễn phí 20kg hành lý ký gửi</option>
            <option value="100000">Thêm 25kg hành lý (100.000 VND/Khách)</option>
            <option value="130000">Thêm 30kg hành lý (130.000 VND/Khách)</option>
            <option value="170000">Thêm 35kg hành lý (170.000 VND/Khách)</option>
            <option value="190000">Thêm 40kg hành lý (190.000 VND/Khách)</option>
						</select>';
        }else{
            $baggageSelect = '<select name="ret_addbaggage[]" class="ret_addbaggage">
            <option value="0">Không mang hành lý ký gửi</option>
            <option value="210000">Thêm 20kg hành lý (210.000 VND/Khách)</option>
            <option value="250000">Thêm 25kg hành lý (250.000 VND/Khách)</option>
            <option value="300000">Thêm 30kg hành lý (300.000 VND/Khách)</option>
            <option value="330000">Thêm 35kg hành lý (330.000 VND/Khách)</option>
            <option value="370000">Thêm 40kg hành lý (370.000 VND/Khách)</option>
						</select>';
        }

        $str .= '<tr>
					<td>Ký gửi</td>
					<td>'.$baggageSelect.'</td>
				</tr>';
    }

    echo $str;
}

function get_city($crtinh=""){
    $tinh=array(
        "TP Ho Chi Minh"=>"TP Hồ Chí Minh",
        "Ha Noi"=>"Hà Nội",
        "Hai Phong"=>"Hải Phòng",
        "Da Nang"=>"Đà Nẵng",
        "Khanh Hoa"=>"Khánh Hòa",
        "Dak Lak"=>"Đắk Lắk",
        "Lam Dong"=>"Lâm Đồng",
        "Thanh Hoa"=>"Thanh Hoá",
        "Thua Thien Hue"=>"Thừa Thiên Huế",
        "Ca Mau"=>"Cà Mau",
        "Can Tho"=>"Cần Thơ",
        "An Giang"=>"An Giang",
        "Bac Kan"=>"Bắc Kạn",
        "Bac Giang"=>"Bắc Giang",
        "Bac Lieu"=>"Bạc Liêu",
        "Bac Ninh"=>"Bắc Ninh",
        "Ben Tre"=>"Bến Tre",
        "Binh Dinh"=>"Bình Định",
        "Binh Duong"=>"Bình Dương",
        "Binh Phuoc"=>"Bình Phước",
        "Binh Thuan"=>"Bình Thuận",
        "Cao Dang"=>"Cao Bằng",
        "Dak Nong"=>"Đắk Nông",
        "Dien Bien"=>"Điện Biên",
        "Dong Nai"=>"Đồng Nai",
        "Dong Thap"=>"Đồng Tháp",
        "Gia Lai"=>"Gia Lai",
        "Ha Giang"=>"Hà Giang",
        "Ha Nam"=>"Hà Nam",
        "Ha Tinh"=>"Hà Tĩnh",
        "Hai Duong"=>"Hải Dương",
        "Hau Giang"=>"Hậu Giang",
        "Hoa Binh"=>"Hoà Bình",
        "Hung Yen"=>"Hưng Yên",
        "Kien Giang"=>"Kiên Giang",
        "Kon Tum"=>"Kon Tum",
        "Lang Son"=>"Lạng Sơn",
        "Lai Chau"=>"Lai Châu",
        "Lao Cai"=>"Lào Cai",
        "Long An"=>"Long An",
        "Nam Dinh"=>"Nam Định",
        "Nghe An"=>"Nghệ An",
        "Ninh Binh"=>"Ninh Bình",
        "Ninh Thuan"=>"Ninh Thuận",
        "Phu Tho"=>"Phú Thọ",
        "Phu Yen"=>"Phú Yên",
        "Quang Binh"=>"Quảng Bình",
        "Quang Nam"=>"Quảng Nam",
        "Quang Ngai"=>"Quảng Ngãi",
        "Quang Ninh"=>"Quảng Ninh",
        "Quang Tri"=>"Quảng Trị",
        "Soc Trang"=>"Sóc Trăng",
        "Tay Ninh"=>"Tây Ninh",
        "Thai Binh"=>"Thái Bình",
        "Thai Nguyen"=>"Thái Nguyên",
        "Tuyen Quang"=>"Tuyên Quang",
        "Tien Giang"=>"Tiền Giang",
        "Tra Vinh"=>"Trà Vinh",
        "Vinh Long"=>"Vĩnh Long",
        "Vinh Phuc"=>"Vĩnh Phúc",
        "Vung Tau"=>"Vũng Tàu",
        "Yen Bai"=>"Yên Bái",
        "Son La"=>"Sơn La",
    );

   // $tinhthanh='<option value="">--Vui lòng chọn--</option>';
    $tinhthanh='';
    foreach($tinh as $key=>$value){
        $tinhthanh.='<option value="'.$key.'"';
        if($crtinh==$key){
            $tinhthanh.='selected="true"';
        }
        $tinhthanh.=' >'.$value.'</option>';
    }
    return $tinhthanh;
}
// DANH SACH CAC QUOC GIA
function listCountry(){
    $str = '<option value="AF">Afghanistan</option>
			<option value="AL">Albania</option>
			<option value="DZ">Algeria</option>
			<option value="AS">American Samoa</option>
			<option value="AD">Andorra</option>
			<option value="AO">Angola</option>
			<option value="AI">Anguilla</option>
			<option value="AQ">Antarctica</option>
			<option value="AG">Antigua and Barbuda</option>
			<option value="AR">Argentina</option>
			<option value="AM">Armenia</option>
			<option value="AW">Aruba</option>
			<option value="AU">Australia</option>
			<option value="AT">Austria</option>
			<option value="AZ">Azerbaijan</option>
			<option value="BS">Bahamas</option>
			<option value="BH">Bahrain</option>
			<option value="BD">Bangladesh</option>
			<option value="BB">Barbados</option>
			<option value="BY">Belarus</option>
			<option value="BE">Belgium</option>
			<option value="BZ">Belize</option>
			<option value="BJ">Benin</option>
			<option value="BM">Bermuda</option>
			<option value="BT">Bhutan</option>
			<option value="BO">Bolivia</option>
			<option value="BA">Bosnia and herzegowina</option>
			<option value="BW">Botswana</option>
			<option value="BV">Bouvet island</option>
			<option value="BR">Brazil</option>
			<option value="IO">British indian ocean territory</option>
			<option value="BN">Brunei darussalam</option>
			<option value="BG">Bulgaria</option>
			<option value="BF">Burkina faso</option>
			<option value="BI">Burundi</option>
			<option value="KH">Cambodia</option>
			<option value="CM">Cameroon</option>
			<option value="CA">Canada</option>
			<option value="CV">Cape verde</option>
			<option value="KY">Cayman islands</option>
			<option value="CF">Central african republic</option>
			<option value="TD">Chad</option>
			<option value="CL">Chile</option>
			<option value="CN">China</option>
			<option value="CX">Christmas island</option>
			<option value="CC">Cocos (keeling) islands</option>
			<option value="CO">Colombia</option>
			<option value="KM">Comoros</option>
			<option value="CG">Congo</option>
			<option value="CD">Congo, the drc</option>
			<option value="CK">Cook islands</option>
			<option value="CR">Costa rica</option>
			<option value="CI">Cote d\'ivoire</option>
			<option value="HR">Croatia (local name: hrvatska)</option>
			<option value="CU">Cuba</option>
			<option value="CY">Cyprus</option>
			<option value="CZ">Czech republic</option>
			<option value="DK">Denmark</option>
			<option value="DJ">Djibouti</option>
			<option value="DM">Dominica</option>
			<option value="DO">Dominican republic</option>
			<option value="">East timor</option>
			<option value="EC">Ecuador</option>
			<option value="EG">Egypt</option>
			<option value="SV">El salvador</option>
			<option value="GQ">Equatorial guinea</option>
			<option value="ER">Eritrea</option>
			<option value="EE">Estonia</option>
			<option value="ET">Ethiopia</option>
			<option value="FK">Falkland islands (malvinas)</option>
			<option value="FO">Faroe islands</option>
			<option value="FJ">Fiji</option>
			<option value="FI">Finland</option>
			<option value="FR">France</option>
			<option value="">France, metropolitan</option>
			<option value="GF">French guiana</option>
			<option value="PF">French polynesia</option>
			<option value="TF">French Southern Territories</option>
			<option value="GA">Gabon</option>
			<option value="GM">Gambia</option>
			<option value="GE">Georgia</option>
			<option value="DE">Germany</option>
			<option value="GH">Ghana</option>
			<option value="GI">Gibraltar</option>
			<option value="GR">Greece</option>
			<option value="GL">Greenland</option>
			<option value="GD">Grenada</option>
			<option value="GP">Guadeloupe</option>
			<option value="GU">Guam</option>
			<option value="GT">Guatemala</option>
			<option value="GN">Guinea</option>
			<option value="GW">Guinea-bissau</option>
			<option value="GY">Guyana</option>
			<option value="HT">Haiti</option>
			<option value="HM">Heard and mc donald islands</option>
			<option value="VA">Holy see (vatican city state)</option>
			<option value="HN">Honduras</option>
			<option value="HK">Hong kong</option>
			<option value="HU">Hungary</option>
			<option value="IS">Iceland</option>
			<option value="IN">India</option>
			<option value="ID">Indonesia</option>
			<option value="IR">Iran (islamic republic of)</option>
			<option value="IQ">Iraq</option>
			<option value="IE">Ireland</option>
			<option value="IL">Israel</option>
			<option value="IT">Italy</option>
			<option value="JM">Jamaica</option>
			<option value="JP">Japan</option>
			<option value="JO">Jordan</option>
			<option value="KZ">Kazakhstan</option>
			<option value="KE">Kenya</option>
			<option value="KI">Kiribati</option>
			<option value="KP">Korea, d.p.r.o.</option>
			<option value="KW">Kuwait</option>
			<option value="KG">Kyrgyzstan</option>
			<option value="LA">Laos</option>
			<option value="LV">Latvia</option>
			<option value="LB">Lebanon</option>
			<option value="LS">Lesotho</option>
			<option value="LR">Liberia</option>
			<option value="LY">Libyan arab jamahiriya</option>
			<option value="LI">Liechtenstein</option>
			<option value="LT">Lithuania</option>
			<option value="LU">Luxembourg</option>
			<option value="MO">Macau</option>
			<option value="MK">Macedonia</option>
			<option value="MG">Madagascar</option>
			<option value="MW">Malawi</option>
			<option value="MY">Malaysia</option>
			<option value="MV">Maldives</option>
			<option value="ML">Mali</option>
			<option value="MT">Malta</option>
			<option value="MH">Marshall islands</option>
			<option value="MQ">Martinique</option>
			<option value="MR">Mauritania</option>
			<option value="MU">Mauritius</option>
			<option value="YT">Mayotte</option>
			<option value="MX">Mexico</option>
			<option value="FM">Micronesia, federated states of</option>
			<option value="MD">Moldova, republic of</option>
			<option value="MC">Monaco</option>
			<option value="MN">Mongolia</option>
			<option value="MS">Montserrat</option>
			<option value="MA">Morocco</option>
			<option value="MZ">Mozambique</option>
			<option value="MM">Myanmar (burma)</option>
			<option value="NA">Namibia</option>
			<option value="NR">Nauru</option>
			<option value="NP">Nepal</option>
			<option value="NL">Netherlands</option>
			<option value="AN">Netherlands Antilles</option>
			<option value="NC">New caledonia</option>
			<option value="NZ">New zealand</option>
			<option value="NI">Nicaragua</option>
			<option value="NE">Niger</option>
			<option value="NG">Nigeria</option>
			<option value="NU">Niue</option>
			<option value="NF">Norfolk island</option>
			<option value="MP">Northern mariana islands</option>
			<option value="NO">Norway</option>
			<option value="OM">Oman</option>
			<option value="PK">Pakistan</option>
			<option value="PW">Palau</option>
			<option value="PA">Panama</option>
			<option value="PG">Papua new guinea</option>
			<option value="PY">Paraguay</option>
			<option value="PE">Peru</option>
			<option value="PH">Philippines</option>
			<option value="PN">Pitcairn</option>
			<option value="PL">Poland</option>
			<option value="PT">Portugal</option>
			<option value="PR">Puerto rico</option>
			<option value="QA">Qatar</option>
			<option value="KR">Republic of korea</option>
			<option value="RE">Reunion</option>
			<option value="RO">Romania</option>
			<option value="RU">Russian federation</option>
			<option value="RW">Rwanda</option>
			<option value="KN">Saint kitts and nevis</option>
			<option value="LC">Saint lucia</option>
			<option value="VC">Saint vincent and the grenadines</option>
			<option value="WS">Samoa</option>
			<option value="SM">San marino</option>
			<option value="ST">Sao tome and principe</option>
			<option value="SA">Saudi arabia</option>
			<option value="SN">Senegal</option>
			<option value="SC">Seychelles</option>
			<option value="SL">Sierra leone</option>
			<option value="SG">Singapore</option>
			<option value="SK">Slovakia (slovak republic)</option>
			<option value="SI">Slovenia</option>
			<option value="SB">Solomon islands</option>
			<option value="SO">Somalia</option>
			<option value="ZA">South africa</option>
			<option value="GS">South georgia and south s.s.</option>
			<option value="ES">Spain</option>
			<option value="LK">Sri lanka</option>
			<option value="SH">St. helena</option>
			<option value="PM">St. pierre and miquelon</option>
			<option value="SD">Sudan</option>
			<option value="SR">Suriname</option>
			<option value="SJ">Svalbard and jan mayen islands</option>
			<option value="SZ">Swaziland</option>
			<option value="SE">Sweden</option>
			<option value="CH">Switzerland</option>
			<option value="SY">Syrian arab republic</option>
			<option value="TW">Taiwan, province of china</option>
			<option value="TJ">Tajikistan</option>
			<option value="TZ">Tanzania, united republic of</option>
			<option value="TH">Thailand</option>
			<option value="TG">Togo</option>
			<option value="TK">Tokelau</option>
			<option value="TO">Tonga</option>
			<option value="TT">Trinidad and tobago</option>
			<option value="TN">Tunisia</option>
			<option value="TR">Turkey</option>
			<option value="TM">Turkmenistan</option>
			<option value="TC">Turks and caicos islands</option>
			<option value="TV">Tuvalu</option>
			<option value="UM">U.s. minor islands</option>
			<option value="UG">Uganda</option>
			<option value="UA">Ukraine</option>
			<option value="AE">United Arab Emirates</option>
			<option value="GB">United kingdom</option>
			<option value="US">United States</option>
			<option value="UY">Uruguay</option>
			<option value="UZ">Uzbekistan</option>
			<option value="VU">Vanuatu</option>
			<option value="VE">Venezuela</option>
			<option value="VN" selected="selected">Việt Nam</option>
			<option value="VG">Virgin islands (british)</option>
			<option value="VI">Virgin islands (u.s.)</option>
			<option value="WF">Wallis and futuna islands</option>
			<option value="EH">Western sahara</option>
			<option value="YE">Yemen</option>
			<option value="">Yugoslavia (serbia and montenegro)</option>
			<option value="ZM">Zambia</option>
			<option value="ZW">Zimbabwe</option>';
    echo $str;
}

function getInfoTicket($airline, $class_ticket){
    $str = '';
    if($airline == 'vietnamairline'){
        if($class_ticket == 'Super Saver'){
            $str = '<tr><td style="width:160px;">Hoàn vé</td><td>Không được phép.</td></tr>
					<tr><td>Thay đổi đặt chỗ</td><td>Không được phép.</td></tr>
					<tr><td>Thay đổi hành trình</td><td>Không được phép.</td></tr>
					<tr><td>Dừng tối đa</td><td>12 tháng.</td></tr>
					<tr><td>Điểm cộng dặm</td><td>Không được phép.</td></tr>';
        }
        elseif($class_ticket == 'Saver'){
            $str = '<tr><td style="width:160px;">Hoàn vé</td><td>Trước ngày khởi hành 300.000đ/vé. Từ ngày khởi hành 600.000đ/vé + chênh lệch giá(nếu có).</td></tr>
					<tr><td>Thay đổi đặt chỗ</td><td>Trước ngày khởi hành 300.000đ/vé. Từ ngày khởi hành 600.000đ/vé + chênh lệch giá(nếu có).</td></tr>
					<tr><td>Thay đổi hành trình</td><td>Trước ngày khởi hành 300.000đ/vé. Từ ngày khởi hành 600.000đ/vé + chênh lệch giá(nếu có).</td></tr>
					<tr><td>Dừng tối đa</td><td>12 tháng.</td></tr>
					<tr><td>Điểm cộng dặm</td><td>Không được phép.</td></tr>';
        }
        else{
            $str = '<tr><td style="width:160px;">Hoàn vé</td><td>Trước ngày khởi hành 300.000đ/vé. Từ ngày khởi hành 600.000đ/vé + chênh lệch giá(nếu có).</td></tr>
					<tr><td>Thay đổi đặt chỗ</td><td>Trước ngày khởi hành 300.000đ/vé. Từ ngày khởi hành 600.000đ/vé + chênh lệch giá(nếu có).</td></tr>
					<tr><td>Thay đổi hành trình</td><td>Trước ngày khởi hành 300.000đ/vé. Từ ngày khởi hành 600.000đ/vé + chênh lệch giá(nếu có).</td></tr>
					<tr><td>Dừng tối đa</td><td>12 tháng.</td></tr>
					<tr><td>Điểm cộng dặm</td><td>0,75 dặm (Hoặc hơn, tùy loại hạng vé).</td></tr>';
        }
    }
    elseif($airline == 'jetstar'){
        if($class_ticket == 'Starter'){
            $str = '<tr><td style="width:160px;">Hoàn vé</td><td>Không được phép.</td></tr>
					<tr><td>Đổi ngày, giờ chuyến bay</td><td>Được phép. Quý khách phải thanh toán phí + chênh lệch giá(nếu có) trong thời hạn thay đổi.</td></tr>
					<tr><td>Thay đổi hành trình</td><td>Không được phép.</td></tr>
					<tr><td>Đổi tên hành khách</td><td>Không được phép.</td></tr>';
        }else{
            $str = '<tr><td style="width:160px;">Hoàn vé</td><td>Không được phép.</td></tr>
					<tr><td>Đổi ngày, giờ chuyến bay</td><td>Được phép. Quý khách phải thanh toán phí + chênh lệch giá(nếu có) trong thời hạn thay đổi.</td></tr>
					<tr><td>Thay đổi hành trình</td><td>Không được phép.</td></tr>
					<tr><td>Đổi tên hành khách</td><td>Không được phép.</td></tr>';
        }

    }
    elseif($airline == 'airmekong'){
        $str = '<tr><td style="width:160px;">Hoàn vé</td><td>Không được phép.</td></tr>
				<tr><td>Đổi ngày, giờ chuyến bay</td><td>Phí 300.000đ/vé. Phí 600.000đ/vé nếu trong vòng 2 tiếng trước giờ khởi hành.</td></tr>
				<tr><td>Thay đổi hành trình</td><td>Phí 300.000đ/vé. Phí 600.000đ/vé nếu trong vòng 2 tiếng trước giờ khởi hành.</td></tr>
				<tr><td>Đổi tên hành khách</td><td>Được phép, phí 300.000đ/lần.</td></tr>
				<tr><td>Chọn chỗ</td><td>Phí 50.000đ/vé.</td></tr>
				<tr><td>Nâng hạng</td><td>Không được phép.</td></tr>';

    }
    elseif($airline == 'vietjetair'){
        $str = '<tr><td style="width:160px;">Hoàn vé</td><td>Không được phép.</td></tr>
				<tr><td>Đổi ngày, giờ chuyến bay</td><td>Thu phí 275.000đ/vé.</td></tr>
				<tr><td>Đổi chuyến bay</td><td>Thu phí 275.000đ/vé.</td></tr>
				<tr><td>Thay đổi hành trình</td><td>Không được phép.</td></tr>
				<tr><td>Đổi tên hành khách</td><td>Được phép, thu phí 275.000đ/vé.</td></tr>
				<tr><td>Thời hạn thay đổi</td><td>Trước 2 ngày so với ngày khởi hành ghi trên vé.</td></tr>';
    }

    echo $str;
}

function format_price($price){
    $number = number_format($price,0,'.',',');
    return $number.' VND';
}
function format_number($num){
    $price=number_format($num,"0",".",",");
    return $price;
}
function format_price_nocrc($price){
    $price=number_format($price,"0",".",",");
    return $price;
}

function utf8convert($str) {
    if(!$str) return false;
    $utf8 = array(
        'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'd'=>'đ|Đ',
        'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'i'=>'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
        'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'y'=>'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    );
    foreach($utf8 as $ascii=>$uni) $str = preg_replace("/($uni)/i",$ascii,$str);
    return $str;
}

function checkactive($dep,$des){

	$jstair = array();
    $jstair["BMV"] = array("SGN", "VII", "HPH", "THD", "VCL", "HAN");
    $jstair["DAD"] = array("SGN", "HAN", "NHA", "CXR", "PQC", "VII", "THD");
    $jstair["HPH"] = array("SGN", "BMV", "VDH");
    $jstair["NHA"] = array("HAN", "SGN", "DAD", "VII", "HUI");
    $jstair["CXR"] = array("HAN", "SGN", "DAD", "VII", "HUI");
    $jstair["VII"] = array("BMV", "SGN", "NHA", "CXR", "DAD");
    $jstair["HAN"] = array("NHA", "CXR", "SGN", "DAD", "PQC", "DLI", "TBB", "VCL", "UIH", "PXU", "BMV");
    $jstair["SGN"] = array("BMV", "DAD", "HAN", "HPH", "HUI", "VII", "PQC", "NHA", "CXR", "THD", "UIH", "VDH", "TBB", "VCL", "PXU", "DLI");
    $jstair["PQC"] = array("SGN", "HAN", "DAD");
    $jstair["THD"] = array("SGN", "BMV", "DAD");
    $jstair["UIH"] = array("SGN", "HAN");
    $jstair["VDH"] = array("SGN", "HPH");
    $jstair["TBB"] = array("SGN", "HAN");
    $jstair["DLI"] = array("HAN", "HUI", "SGN");
    $jstair["VCL"] = array("SGN", "BMV", "HAN");
    $jstair["HUI"] = array("DLI", "CXR", "NHA", "SGN");
    $jstair["PXU"] = array("SGN", "HAN");

    // add flight new vietjetair 10/06/2020
    $vjair = array();
    $vjair["SGN"] = array("HAN", "DAD", "HPH", "NHA", "CXR", "HUI", "VII", "PQC", "UIH", "BMV", "DLI", "THD", "VCL", "VDH", "PXU", "TBB", "VDO");
    $vjair["HAN"] = array("SGN", "DAD", "NHA", "CXR", "DLI", "HUI", "BMV", "VCA", "PQC", "UIH", "VCL", "PXU", "VDH", "TBB");
    $vjair["DAD"] = array("SGN", "HAN", "VCA", "HPH", "NHA", "CXR", "DLI", "BMV", "VII", "PQC", "THD");
    $vjair["NHA"] = array("SGN", "HAN", "HPH", "THD", "DAD", "VCA", "VII");
    $vjair["CXR"] = array("SGN", "HAN", "HPH", "THD", "DAD", "VCA", "VII");
    $vjair["HPH"] = array("SGN", "DAD", "NHA", "CXR", "PXU", "PQC", "DLI", "BMV", "VCA", "UIH");
    $vjair["HUI"] = array("SGN", "HAN");
    $vjair["VII"] = array("SGN", "DLI", "PXU", "BMV", "VCA", "NHA", "CXR", "DAD", "PQC");
    $vjair["DLI"] = array("HAN", "VII", "SGN", "HPH", "VCA", "DAD");
    $vjair["BMV"] = array("SGN", "HAN", "VII", "HPH", "DAD");
    $vjair["UIH"] = array("SGN", "HAN", "HPH");
    $vjair["VCA"] = array("DAD", "HAN", "HPH", "VII", "THD", "NHA", "CXR", "DLI");
    $vjair["PQC"] = array("SGN", "HAN", "HPH", "DAD", "VII");
    $vjair["THD"] = array("SGN", "NHA", "CXR", "VCA", "DAD");
    $vjair["VCL"] = array("SGN", "HAN");
    $vjair["VDH"] = array("SGN", "HAN");
    $vjair["PXU"] = array("SGN", "HPH", "VII", "HAN");
    $vjair["TBB"] = array("SGN", "HAN");
    $vjair["VDO"] = array("SGN");

    // add flight new vna 23/07/2020
    $vna = array();
    $vna["BMV"] = array("DAD", "HAN", "SGN", "VII", "HPH", "VCA", "THD");
    $vna["VII"] = array("DAD", "HAN", "SGN", "BMV", "PQC", "NHA", "CXR", "VCA", "DLI");
    $vna["CAH"] = array("SGN");
    $vna["VCA"] = array("HAN", "PQC", "VCS", "DAD", "HPH", "BMV", "VII", "DLI");
    $vna["VCL"] = array("HAN", "SGN");
    $vna["VCS"] = array("HAN", "VCA", "SGN");
    $vna["DLI"] = array("HAN", "DAD", "SGN", "HPH", "BMV", "PQC", "THD", "VCA", "HUI");
    $vna["DAD"] = array("HAN", "BMV", "DLI", "HPH", "NHA", "CXR", "PXU", "SGN", "VII", "VCA", "PQC", "THD");
    $vna["DIN"] = array("HAN", "HPH");
    $vna["VDH"] = array("HAN", "SGN");
    $vna["HAN"] = array("BMV", "DAD", "DIN", "DLI", "HUI", "NHA", "CXR", "PQC", "PXU", "SGN", "TBB", "UIH", "VCA", "VCL", "VDH", "VII");
    $vna["HPH"] = array("DAD", "SGN", "NHA", "CXR", "DLI", "PQC", "BMV", "VCA", "DIN");
    $vna["SGN"] = array("BMV", "CAH", "DAD", "DLI", "HAN", "HPH", "HUI", "NHA", "CXR", "PQC", "PXU", "TBB", "THD", "UIH", "VCS", "VCL", "VDH", "VII", "VKG", "VDO");
    $vna["HUI"] = array("HAN", "SGN", "DLI");
    $vna["NHA"] = array("HAN", "SGN", "DAD", "HPH", "VII");
    $vna["CXR"] = array("HAN", "SGN", "DAD", "HPH", "VII");
    $vna["PQC"] = array("HAN", "SGN", "VKG", "VCA", "VII", "HPH", "DLI", "DAD");
    $vna["PXU"] = array("HAN", "SGN", "DAD");
    $vna["UIH"] = array("HAN", "SGN");
    $vna["VKG"] = array("PQC", "SGN");
    $vna["THD"] = array("SGN", "BMV", "DAD", "DLI");
    $vna["TBB"] = array("HAN", "SGN");
    $vna["VDO"] = array("SGN");

    // update new 22/06/2020
    $qh = array();
    $qh["SGN"] = array("HAN", "UIH", "THD", "VII", "VDO", "HPH", "DAD", "HUI", "PQC", "VDH", "CXR", "NHA", "BMV", "DLI", "VDH", "PXU");
    $qh["HAN"] = array("SGN", "BMV", "DAD", "VDH", "UIH", "NHA", "CXR", "PQC", "VCA", "VII", "DLI", "PXU", "VCL", "HUI", "TBB", "VCS");
    $qh["HPH"] = array("SGN", "UIH", "VCA", "CXR", "NHA", "BMV", "DAD", "DLI");
    $qh["DAD"] = array("BMV", "DLI", "HAN", "HPH", "SGN", "PXU", "VCA", "CXR", "NHA", "VCS");
    $qh["BMV"] = array("HAN", "VII", "DAD", "HPH", "SGN");
    $qh["VDH"] = array("HAN", "SGN");
    $qh["CXR"] = array("HAN", "HPH", "VII", "DAD", "SGN");
    $qh["NHA"] = array("HAN", "HPH", "DAD", "SGN", "VII");
    $qh["PQC"] = array("HAN", "SGN", "THD");
    $qh["VCA"] = array("HAN", "HPH", "DAD", "VCS");
    $qh["VCL"] = array("HAN");
    $qh["VII"] = array("HAN", "SGN", "BMV", "DLI", "PXU", "CXR", "NHA", "UIH");
    $qh["DLI"] = array("HAN", "VII", "DAD", "SGN", "HPH");
    $qh["PXU"] = array("HAN", "DAD", "VII", "SGN");
    $qh["UIH"] = array("SGN", "HAN", "HPH", "THD", "VII");
    $qh["THD"] = array("SGN", "UIH", "PQC");
    $qh["VDO"] = array("SGN");
    $qh["HUI"] = array("SGN", "HAN");
    $qh["TBB"] = array("HAN");
    $qh["VCS"] = array("VCA", "DAD", "HAN");
	 
    $rs=array();
    $rs['vj']=($vjair[$dep] && in_array($des,$vjair[$dep]))?true:false;
    $rs['vna']=($vna[$dep] && in_array($des,$vna[$dep]))?true:false;
    $rs['js']=($jstair[$dep] && in_array($des,$jstair[$dep]))?true:false;
    $rs['qh']=($qh[$dep] && in_array($des,$qh[$dep]))?true:false;

    return $rs;

}

/**
 * @param $departdate
 * @param string $datesearch
 * @return int Return time exp for seach query in unix timestamp, (24 hour)
 */
function getexpsearch($departdate,$datesearch=""){
    date_default_timezone_set("Asia/Ho_Chi_Minh");
    /*$tmpsdate=explode("/",$departdate);
    $crunixs=mktime(0,0,0,$tmpsdate[1],$tmpsdate[0],$tmpsdate[2]);
    $crunix=mktime(0,0,0,date("n"),date("j"),date("Y"));
    if($crunixs==$crunix)
        return (mktime(23,59,60,date("n"),date("j"),date("Y"))-(4*60*60));
    return (time()+(24*60*60));*/
	return time();
}

/*
 * Cache lai ket qua
 * */
function getexprs($daters){
    date_default_timezone_set("Asia/Saigon");
    $rsdate=explode("/",$daters);
    $unixrsdate=mktime(0,0,0,$rsdate[1],$rsdate[0],$rsdate[2]); /*Ngay tim kiem */
    $crdate=mktime(0,0,0,date("n"),date("j"),date("Y")); /*Ngay hien tai*/
    if($unixrsdate==$crdate){
        /*Tim kiem trong ngay luu lai trong vong 10'*/
        return (time()+(10*60));
    }elseif($unixrsdate<=($crdate+(48*60*60))){
        /*Tu 1-3 Ngay Luu Lai trong 30 Phut*/
        return (time()+(20*60));
    }else{
        /*Tu 3 ngay tro len luu lai trong vong 12 tieng*/
        return (time()+(60*60));
    }
}

function vnasvfee($fee, $price)
{
    return $fee; // Not use this function, may be remove in the future
    $priceArr = array(
        1000000, 1009000, 1035000, 1050000, 1080000, 1099000, 1119000, 1125000, 1199000, 1215000, 1250000, 1260000, 1299000,
        1350000, 1395000, 1400000, 1422000, 1440000, 1450000, 1485000, 1500000, 1575000, 1620000, 1639000, 1665000, 1701000,
        1710000, 1872000, 1890000, 1935000, 1980000, 199000, 2025000, 2045000, 2115000, 2205000, 2250000, 2295000, 2430000,
        249000, 2520000, 2550000, 2583000, 2610000, 2790000, 2835000, 2870000, 2970000, 299000, 320000, 333000, 350000, 3780000,
        399000, 4320000, 450000, 495000, 499000, 500000, 540000, 550000, 555000, 555555, 559000, 569000, 585000, 599000, 600000,
        630000, 650000, 657000, 666000, 679000, 680000, 699000, 700000, 720000, 750000, 756000, 789000, 799000, 800000, 810000,
        846000, 850000, 899000, 900000, 945000, 999000, 999999, 1100000,
    );
    if (in_array($price, $priceArr)) {
        //$fee=$fee*2;
        $fee = $fee + 55000;
    }
    return $fee;
}

function get_airline_code_bm($air){
    switch($air){
        case "VN":
            return "VNA";
            break;
        case "VJ":
            return "VJA";
            break;
        case "BL":
            return "JET";
            break;
        case "P8":
            return "AMK";
            break;
        case "QH":
            return "BBA";
            break;
        default:
            return $air;
            break;
    }
}

function getAirportGroup($airport_select = '', $list_type = '') {
    $html = '';
    foreach ($GLOBALS[$list_type . 'AIRPORT_GROUP'] as $group_items) {
        $html .= '<optgroup label="-----' . $group_items['name'] . '----">';
        foreach ($group_items['airports'] as $code => $airport) {
            $selected = $code == $airport_select ? 'selected="selected"' : '';
            $html .= '<option ' . $selected . ' value="' . $code . '">' . $airport . '</option>';
        }
        $html .= '</optgroup>';
    }
    return $html;
}

function getAirportsDesktop($globalsArray) {
    $html = '';
    foreach ($globalsArray as $selectAirports) {
        foreach ($selectAirports['airports'] as $codeAirports => $nameAirports) {
            $html.= '<a class="tcb-hot-city-box-name" data-city="'.$codeAirports.'">'.$nameAirports.'</a>';

        }
    }
    return $html;
}

function getCityMobile($globalsArray) {
    $html = '';
    foreach ($globalsArray as $valueItems) {
       $html.= '<div class="config-name-country">
                    <h5 class="title-name '.$valueItems['rel'].'">'.$valueItems['name'].'</h5>
                    <div class="'.$valueItems['rel'].'-mobile-click-dropdown abc" rel="'.$valueItems['rel'].'">';
                        $countAirports = count($valueItems['airports']);
                        $dataAirports = array();
                        foreach ($valueItems['airports'] as $keyCodeParent => $valueAirportsParent) {
                            array_push($dataAirports, $valueAirportsParent);
                            foreach ($dataAirports as $keyCodeChild => $valueAirportsChild) {
                                switch(($keyCodeChild + 1) % $countAirports) { 
                                    case 0 :
                                        $class = 'class="last-child"';
                                        break;
                                    case 1 :
                                        $class = 'class="first-child"';
                                        break;
                                    default :
                                        $class = '';
                                }   
                            } 
                            if($keyCodeParent == 'PMR' || $keyCodeParent == 'RGN') {
                                $class = 'class="last-child li-width-100"';
                            }                
            $html.= '<li '.$class.'><a data-city="'.$keyCodeParent.'">'.$valueAirportsParent.'</a></li>';
                        }      
        $html.=     '</div>
                </div>';
    }
    return $html;
}


function get_promo_service_fee($base_price) {
    $service_fee = 0;
    if ($base_price <= 100000) {
        $service_fee += (int) get_option('opt_promo_svfee_1');
    } else if ($base_price > 100000 && $base_price <= 300000) {
        $service_fee += (int) get_option('opt_promo_svfee_2');
    } else if ($base_price > 300000 && $base_price <= 500000) {
        $service_fee += (int) get_option('opt_promo_svfee_3');
    } else {
        $service_fee += 0;
    }

    return $service_fee;
}

?>