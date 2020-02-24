function display(target) {
  var dots = document.getElementById("dots " + target);
  var moreText = document.getElementById("more " + target);
  var btnText = document.getElementById("myBtn " + target);
  var animationName = "";

  if (dots.style.display === "none") {
    dots.style.display = "inline";
    btnText.innerHTML = "Lire plus";
    $(moreText).fadeOut();
  } else {
    dots.style.display = "none";
    btnText.innerHTML = "Lire moins";
    $(moreText).fadeIn();
  }
}
