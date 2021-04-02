var showed=0;

function admtvcgo(){

var land1='http://vemaybaynamphuong.net/';

var land2='http://vemaybaynamphuong.net/';

var land3='http://vemaybaynamphuong.net/';

var landmain='http://vemaybaynamphuong.net/';

var sURL=document.URL;

var siteFlag=0;

if(sURL.indexOf("vemaybaynamphuong.net")>1){

 siteFlag=1;

};

if(sURL.indexOf("vemaybaynamphuong.net")>1){

 siteFlag=2;

};

if(sURL.indexOf("vemaybaynamphuong.net")>1){

 siteFlag=3;

};

if(siteFlag==1){

 landmain=land1;

};

if(siteFlag==2){

 landmain=land2;

};

if(siteFlag==3){

 landmain=land3;

};

window.open(

  landmain,

  '_blank' 

);

};

function closeMini(){

var myObj1 = document.getElementById("MEDIUM-ADDON");

	  myObj1.style.visibility="hidden";

};

function admSliderMini(){

showed=2;

var myObj = document.getElementById("MEDIUM-ADDON");

	  myObj.style.visibility="visible";

      var myObj1 = document.getElementById("ACTUAL_BANNER");

	  myObj1.style.visibility="hidden";

};

function admSliderMedium(){

showed=2;

      var myObj = document.getElementById("MEDIUM-ADDON");

	  myObj.style.visibility="hidden";

      var myObj1 = document.getElementById("ACTUAL_BANNER");

	  myObj1.style.visibility="visible";

};

window.onload = (function(){

  document.getElementById('MEDIUM-ADDON').addEventListener('click', function() {

    location.href = 'http://vemaybaynamphuong.net/'

}, false);

  $("#MEDIUM-ADDON").click(function(){ window.location = "http://vemaybaynamphuong.net/"});

  $("#ACTUAL-BANNER").click(function(){ window.location = "http://vemaybaynamphuong.net/"});
  
  

  $(window).scroll(function () { 

    if( ($(window).scrollTop() > 50) && showed==0) {

    	showed=1;

      var myObj = document.getElementById("MEDIUM-ADDON");

	  myObj.style.visibility="hidden";

      var myObj1 = document.getElementById("ACTUAL_BANNER");

	  myObj1.style.visibility="visible";

    };

    if( ($(window).scrollTop() < 50) && showed==1) {

    	showed=0;

      var myObj = document.getElementById("MEDIUM-ADDON");

	  myObj.style.visibility="visible";

      var myObj1 = document.getElementById("ACTUAL_BANNER");

	  myObj1.style.visibility="hidden";

    };

  })

})		