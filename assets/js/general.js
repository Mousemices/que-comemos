$(function() {
 
 	changeBody();
 	
 	$('.mainButton > button').on('click', function(){
	 	//$(this).text('Mmm, no me apetece. Dame otra propuesta!');
	 	$('.captureButton').show();
	 	$('.tableResults > table').show();
 	});
 	
 	$('.captureButton > button').on('click', function(){
	 	$('.tableWeekPlan').show();
 	});
 
});

var changeBody = function(){
	
	var idRand = Math.floor(Math.random() * 4) + 1;
	var bgBody = "assets/img/bgbody" + idRand + ".jpg";
	$('body').css({'background-position' : 'center top', 'background-repeat' : 'no-repeat', 'background-image' : 'url(' + bgBody + ')'});
	
}