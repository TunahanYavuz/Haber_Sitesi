document.addEventListener("DOMContentLoaded",()=>{
    let lastScrollPosition = 0;
    window.addEventListener("scroll", () => {
        const navElement = document.querySelector(".nav")
        const currentScrollPosition = window.scrollY || document.documentElement.scrollTop;
        if (currentScrollPosition > lastScrollPosition && window.scrollY > 65) {
            navElement.style.transition = "transform 0.5s ease-in-out";
            navElement.style.transform = "translateY(-80px)";
        } else {
            navElement.style.transform = "translateY(0px)";
        }
        lastScrollPosition = currentScrollPosition;
    });
    let lastSidebarPosition = 0;
    const others = document.querySelector("#diger");
    others.addEventListener("click", () => {
        const sidebar = document.querySelector(".sidebar");
        const sidebarWidth = sidebar.offsetWidth;
        if(!sidebar.classList.contains("transition")) sidebar.classList.add("transition");
        if (lastSidebarPosition === 0) {
            sidebar.style.transform = "translateX(0px)";
            lastSidebarPosition = 1;
        } else {
            sidebar.style.transform = `translateX(-${sidebarWidth + 3}px)`;
            lastSidebarPosition = 0;
        }
    });
    document.addEventListener("click", (event) => {
        const sidebar = document.querySelector(".sidebar");
        if (!sidebar.contains(event.target) && !others.contains(event.target)) {
            sidebar.style.transform = `translateX(-101%)`;
            lastSidebarPosition = 0;
        }
    });
    window.addEventListener("resize", () => {
        const sidebar = document.querySelector(".sidebar");
        const sidebarWidth = sidebar.offsetWidth;
        if (lastSidebarPosition === 0){
            sidebar.classList.remove("transition");
            sidebar.style.transform = `translateX(-${sidebarWidth + 3}px)`;
        }
    })

})