// YEAR FUNCTION //
var d = new Date();
var n = d.getFullYear();
document.getElementById("year").innerHTML = "&copy; 2017-"+n;

// GO BACK FUNCTION //
function goBack() {
    window.history.back();
};

// Show or hide the sticky footer button
$(window).scroll(function() {
	if ($(this).scrollTop() > 500) {
		$('.go-top').fadeIn(500);
	} else {
		$('.go-top').fadeOut(500);
	}
});

// Animate the scroll to top
$('.go-top').click(function(event) {
	event.preventDefault();
	
	$('html, body').animate({scrollTop: 0}, 300);
})

// top scroll horizontal bar  //
window.onscroll = function() {myFunction()};

function myFunction() {
  var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
  var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
  var scrolled = (winScroll / height) * 100;
  document.getElementById("myBar").style.width = scrolled + "%";
};