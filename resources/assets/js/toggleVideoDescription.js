$('[id=toggleVideoDescription]').click(function(e) {
    var description = document.getElementById("videoDescription");
    var icon = document.getElementById("toggleVideoDescriptionIcon");
    if (description.style.display === "none") {
        description.style.display = "block";
        icon.innerHTML = 'expand_less';
    } else {
        description.style.display = "none";
        icon.innerHTML = 'expand_more';
    }
});