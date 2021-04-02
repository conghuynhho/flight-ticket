/**
 * Created with Notepad.
 * User: Mr.Lak
 * Date: 6/26/13
 * Time: 2:03 PM
 */


function validate(value){
    if($.trim(value)=="")
        return 0; /*Gia tri rong*/

}

function isNotNull(value){
    value= $.trim(value);
    if(value!=="" && value!="undefined"){
        return true;
    }else{
        return false;
    }
}

function isErrStringLenght(value,max,min){
    result = false;
    value= $.trim(value);

    if(value.length > max || value.length < min ){
        result = true;
    }
    return result;
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

function isMatch(value1,value2){
     val1= $.trim(value1);
     val2= $.trim(value2);
    if(val1 == val2){
        return true;
    }else{
        return false;
    }
}