const NAV_TOGGLER = document.querySelector("#nav-toggler");
const SIDE_NAV = document.querySelector("#sidenav");
const MAIN_CONT = document.querySelector("#main");
function navToggle(){
    if (SIDE_NAV.classList.contains("navbar-slideout")) {
        document.querySelectorAll(".abs-menu-item .text").forEach((elem) => elem.style.display = "none");
        SIDE_NAV.classList.replace("navbar-slideout", "navbar-slidein");
    }
    else {
        document.querySelectorAll(".abs-menu-item .text").forEach((elem) => elem.style.display = "block");
        SIDE_NAV.classList.replace("navbar-slidein", "navbar-slideout");
    }
    if(MAIN_CONT.classList.contains("main-slideout"))
        MAIN_CONT.classList.replace("main-slideout", "main-slidein");
    else
        MAIN_CONT.classList.replace("main-slidein", "main-slideout");
}
NAV_TOGGLER.addEventListener("click", navToggle);

function changeNavStyle(){
    if(window.innerWidth <= 840){
        navToggle()
    }
}
window.addEventListener("load", changeNavStyle);