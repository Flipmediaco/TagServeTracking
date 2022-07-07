define([
'jquery'
], function($){
    $(document).ready(function() {
		function getTAGParam(e){e=e.replace(/[\[]/,"\\[").replace(/[\]]/,"\\]");var a=new RegExp("[\\?&]"+e+"=([^&#]*)").exec(location.search);return null===a?"":decodeURIComponent(a[1].replace(/\+/g," "))}
		function setTAGValue(e,t,i){var o="";if(i){var n=new Date;n.setTime(n.getTime()+24*i*60*60*1e3),o="; expires="+n.toUTCString()}t&&(document.cookie=e+"="+(t||"")+o+"; path=/")}
		var tagrid = getTAGParam('tagrid');
		setTAGValue("tagrid",tagrid,30);
    });
});