// var html = document.documentElement;
// var body = document.body;

// var scroller = {
//   target: document.querySelector("html"),
//   ease: 0.5, // <= scroll speed
//   endY: 0,
//   y: 0,
//   resizeRequest: 1,
//   scrollRequest: 0,
// };

// var requestId = null;

// TweenLite.set(scroller.target, {
//   rotation: 0.01,
//   force3D: true
// });

// window.addEventListener("load", onLoad);

// function onLoad() {    
//   updateScroller();  
//   window.focus();
//   window.addEventListener("resize", onResize);
//   document.addEventListener("scroll", onScroll); 
// }

// function updateScroller() {
  
//   var resized = scroller.resizeRequest > 0;
    
//   if (resized) {    
//     var height = scroller.target.clientHeight;
//     body.style.height = height + "px";
//     scroller.resizeRequest = 0;
//   }
      
//   var scrollY = window.pageYOffset || html.scrollTop || body.scrollTop || 0;

//   scroller.endY = scrollY;
//   scroller.y += (scrollY - scroller.y) * scroller.ease;

//   if (Math.abs(scrollY - scroller.y) < 0.05 || resized) {
//     scroller.y = scrollY;
//     scroller.scrollRequest = 0;
//   }
  
//   TweenLite.set(scroller.target, { 
//     y: -scroller.y 
//   });
  
//   requestId = scroller.scrollRequest > 0 ? requestAnimationFrame(updateScroller) : null;
// }

// function onScroll() {
//   scroller.scrollRequest++;
//   if (!requestId) {
//     requestId = requestAnimationFrame(updateScroller);
//   }
// }

// function onResize() {
//   scroller.resizeRequest++;
//   if (!requestId) {
//     requestId = requestAnimationFrame(updateScroller);
//   }
// }

document.addEventListener("DOMContentLoaded", function() {
  var coll = document.getElementsByClassName("collapsible");
  var i;

  for (i = 0; i < coll.length; i++) {
    var icon = coll[i].querySelector('.toggle-icon');
    icon.textContent = '+'; // Set initial icon state

    coll[i].addEventListener("click", function() {
      var content = this.nextElementSibling;
      var icon = this.querySelector('.toggle-icon');

      // Toggle active class
      this.classList.toggle("active");

      // Toggle content visibility
      if (content.style.maxHeight) {
        content.style.maxHeight = null;
        icon.textContent = '+';
      } else {
        // Close previously opened items
        closeAllItems();
        // Open current item
        content.style.maxHeight = content.scrollHeight + "px";
        icon.textContent = '-';
      }
    });
  }
});

function closeAllItems() {
  var coll = document.getElementsByClassName("collapsible");
  for (var i = 0; i < coll.length; i++) {
    var content = coll[i].nextElementSibling;
    var icon = coll[i].querySelector('.toggle-icon');
    coll[i].classList.remove("active");
    content.style.maxHeight = null;
    icon.textContent = '+';
  }
}
