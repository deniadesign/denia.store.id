// =========================
// DENIADESIGN - script.js
// =========================

// Smooth Scroll Menu
document.querySelectorAll('nav a').forEach(link => {
    link.addEventListener('click', function(e) {

        const target = this.getAttribute('href');

        if(target.startsWith("#")){

            e.preventDefault();

            document.querySelector(target).scrollIntoView({
                behavior:"smooth"
            });

        }

    });
});

// Tombol Belanja Sekarang
const btn = document.querySelector(".btn");

if(btn){

    btn.addEventListener("click", function(e){

        e.preventDefault();

        const produk = document.querySelector("#produk");

        produk.scrollIntoView({
            behavior:"smooth"
        });

    });

}

// Animasi Card Saat Scroll
const cards = document.querySelectorAll(".card");

const observer = new IntersectionObserver(entries=>{

    entries.forEach(entry=>{

        if(entry.isIntersecting){

            entry.target.style.opacity="1";
            entry.target.style.transform="translateY(0)";
        }

    });

},{
    threshold:0.2
});

cards.forEach(card=>{

    card.style.opacity="0";
    card.style.transform="translateY(40px)";
    card.style.transition="0.6s";

    observer.observe(card);

});

// Efek Header Saat Scroll
const header = document.querySelector("header");

window.addEventListener("scroll",()=>{

    if(window.scrollY>50){

        header.style.background="#111";
        header.style.position="fixed";
        header.style.width="100%";
        header.style.top="0";
        header.style.zIndex="999";

    }else{

        header.style.background="transparent";
        header.style.position="relative";

    }

});