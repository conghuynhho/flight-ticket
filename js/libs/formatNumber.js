/*
 	convert a string to number
*/
function unformatNumber(str, grp_sep, dec_sep){
	//var grp_sep = String(document.getElementById('grp_seperator').value);
	//var dec_sep = String(document.getElementById('dec_seperator').value);
	str = String(str);
	str = str.replace(grp_sep, '');
	str = str.replace(grp_sep, '');
	str = str.replace(grp_sep, '');
	str = str.replace(grp_sep, '');
	str = str.replace(dec_sep, '.');
	num = Number(str);
	return num;
}

/*
	convert number to a string
*/
function formatNumber(number, decimals, dec_point, thousands_sep){
	//var decimals = parseInt(document.getElementById('sig_digits').value);
	//var dec_point = String(document.getElementById('dec_seperator').value);
	//var thousands_sep = String(document.getElementById('grp_seperator').value);
	// http://kevin.vanzonneveld.net
	// + original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
	// + improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	// + bugfix by: Michael White (http://crestidg.com)
	// + bugfix by: Benjamin Lupton
	// + bugfix by: Allan Jensen (http://www.winternet.no)
	// + revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
	// * example 1: number_format(1234.5678, 2, '.', '');
	// * returns 1: 1234.57				  
	var n = number, c = isNaN(decimals = Math.abs(decimals)) ? 2 : decimals;
	var d = dec_point == undefined ? "," : dec_point;
	var t = thousands_sep == undefined ? "." : thousands_sep, s = n < 0 ? "-" : "";
	var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;  
	return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}