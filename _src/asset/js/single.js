//@prepros-prepend common.js

/*#########################################################

画面解析後のイベント

#########################################################*/
document.addEventListener("DOMContentLoaded", function(event) {
	// タイトルのアニメーション
	if( !sp ){
		item = document.querySelectorAll(".--js-entrytitle");
		for (var i = 0; i < item.length; i++) {
			item[i].innerHTML = item[i].innerText.replace(/([^\x00-\x80]|\w)/g, "<span class='--js-charanime'>$&</span>");
		}
		anime.timeline({})
			.add({
				targets: '.--js-charanime',
				scale: [4,1],
				opacity: [0,1],
				translateZ: 0,
				easing: "easeInExpo",
				duration: 600,
				delay: function(el, i) {
					return 70*i;
				}
			});
	}
});