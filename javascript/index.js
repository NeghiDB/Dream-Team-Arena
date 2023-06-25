function showMenu(){
    document.getElementById(`menu`).style.visibility = "visible";
    document.getElementById(`menubars`).style.visibility = "hidden";
    document.getElementById(`closemenubars`).style.visibility = "visible";
}

function hideMenu(){
    document.getElementById(`menu`).style.visibility = "hidden";
    document.getElementById(`menubars`).style.visibility = "visible";
    document.getElementById(`closemenubars`).style.visibility = "hidden";
}