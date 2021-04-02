/**
 * Created with Notepad.
 * User: Mr.Lak
 * Date: 6/26/13
 * Time: 2:03 PM
 */

$(document).ready(function(){

})

function parseDate(str) {
    var mdy = str.split('/');
    return new Date(mdy[2], mdy[1], mdy[0]);
}

function comparewithCurrentDate(str){
    var mdy = str.split('/');
    var x=new Date(mdy[2],mdy[1]-1,mdy[0],23,59,59);
    var today = new Date();
    if (x < today)
        return false;
    else
        return true;
}

function compareFromDatewithToDate(date1,date2){
    var mdydate1 = date1.split('/');
    var fromdate = new Date(mdydate1[2],mdydate1[1]-1,mdydate1[0]);

    var mdydate2 = date2.split('/');
    var todate = new Date(mdydate2[2],mdydate2[1]-1,mdydate2[0]);
    if(fromdate > todate)
        return false;
    else
        return true;
}
function CurrentDate(){
    var currentTime = new Date();
    var month = currentTime.getMonth() + 1;
    var day = currentTime.getDate();
    var year = currentTime.getFullYear();
    var strDate = day + "/" + month + "/" + year ;
    return strDate;
}
function checkdate (d, m, y) {
    return m > 0 && m < 13 && y > 0 && y < 32768 && d > 0 && d <= (new Date(y, m, 0)).getDate();
}



/*##################VALIDATION#############################*/
function isNotNull(value){
    value= $.trim(value);
    if(value!=="" && value!="undefined"){
        return true;
    }else{
        return false;
    }
}

function isEmail(value){
    var patt=/^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/;
    if(patt.test(value)){
        return true;
    }else{
        return false;
    }
}

function isPhone(value,from,to){
    value= $.trim(value);
    var patt=/[\d]{from,to}/;
    if(patt.test(value)){
        return true;
    }else{
        return false;
    }
}

function isNum(value){
    var patt=/[\d]+/;
    if(patt.test(value)){
       return true;
    }else
    {
        return false;
    }
}


