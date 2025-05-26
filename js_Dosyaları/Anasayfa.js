let anasayfa = 0;
let haberler = document.querySelectorAll(".haber").length;
const rightButton = document.querySelector(".right");
rightButton.addEventListener("click", () => {
    anasayfa++;
    const swiper = document.querySelector(".swiper");
    swiper.classList.add("transition");
    swiper.classList.remove("no-transition");
    if (anasayfa > haberler - 1) anasayfa = haberler - 1;
    const haber = document.querySelectorAll(".haber")[anasayfa].offsetWidth;
    swiper.style.transform = `translate3D(-${haber * anasayfa}px, 0, 0)`;
});
const leftButton = document.querySelector(".left");
leftButton.addEventListener("click", () => {
    anasayfa--;
    const swiper = document.querySelector(".swiper");
    swiper.classList.add("transition");
    swiper.classList.remove("no-transition");
    if (anasayfa < 0) anasayfa = 0;
    const haber = document.querySelectorAll(".haber")[anasayfa].offsetWidth;
    swiper.style.transform = `translate3D(${-haber * anasayfa}px, 0, 0)`;
});
window.addEventListener("resize", () => {
    const haber = document.querySelectorAll(".haber")[anasayfa].offsetWidth;
    const swiper = document.querySelector(".swiper");
    swiper.classList.remove("transition");
    swiper.classList.add("no-transition");
    swiper.style.transform = `translate3D(${-haber * anasayfa}px, 0, 0)`;
});

