/* =========================
   MOBILE MENU
========================= */

const menuToggle = document.querySelector(".menu-toggle");
const navLinks = document.querySelector(".nav-links");

menuToggle.addEventListener("click", () => {
    navLinks.classList.toggle("open");
});


/* Close menu when clicking a link */

document.querySelectorAll(".nav-link").forEach(link => {

    link.addEventListener("click", () => {
        navLinks.classList.remove("open");
    });

});


/* =========================
   DARK / LIGHT MODE
========================= */

const themeToggle = document.querySelector(".theme-toggle");

const savedTheme = localStorage.getItem("theme");

if (savedTheme === "light") {
    document.body.classList.add("light");
    themeToggle.textContent = "☾";
}

themeToggle.addEventListener("click", () => {

    document.body.classList.toggle("light");

    const isLight =
        document.body.classList.contains("light");

    themeToggle.textContent = isLight ? "☾" : "☀";

    localStorage.setItem(
        "theme",
        isLight ? "light" : "dark"
    );

});


/* =========================
   SCROLL REVEAL
========================= */

const revealElements =
    document.querySelectorAll(".reveal");

const observer = new IntersectionObserver(
    (entries, observer) => {

        entries.forEach(entry => {

            if (entry.isIntersecting) {

                entry.target.classList.add("visible");

                observer.unobserve(entry.target);

            }

        });

    },
    {
        threshold: 0.12
    }
);


revealElements.forEach(element => {
    observer.observe(element);
});


/* =========================
   ACTIVE NAVIGATION
========================= */

const sections =
    document.querySelectorAll("section[id]");

const navItems =
    document.querySelectorAll(".nav-link");

window.addEventListener("scroll", () => {

    let current = "";

    sections.forEach(section => {

        const sectionTop =
            section.offsetTop - 150;

        const sectionHeight =
            section.offsetHeight;

        if (
            window.scrollY >= sectionTop &&
            window.scrollY < sectionTop + sectionHeight
        ) {
            current = section.getAttribute("id");
        }

    });

    navItems.forEach(item => {

        item.classList.remove("active");

        if (
            item.getAttribute("href") === `#${current}`
        ) {
            item.classList.add("active");
        }

    });

});


/* =========================
   CURRENT YEAR
========================= */

document.getElementById("year").textContent =
    new Date().getFullYear();


/* =========================
   CONTACT FORM
========================= */

const form =
    document.querySelector(".contact-form");

form.addEventListener("submit", event => {

    event.preventDefault();

    const button =
        form.querySelector("button");

    button.textContent = "Üzenet elküldve ✓";

    button.style.background = "#16a34a";

    form.reset();

    setTimeout(() => {

        button.textContent =
            "Üzenet küldése →";

        button.style.background = "";

    }, 3000);

});


/* =========================
   HERO CARD MOUSE EFFECT
========================= */

const heroCard =
    document.querySelector(".hero-card");

if (window.innerWidth > 900) {

    heroCard.addEventListener("mousemove", event => {

        const rect =
            heroCard.getBoundingClientRect();

        const x =
            event.clientX - rect.left;

        const y =
            event.clientY - rect.top;

        const centerX =
            rect.width / 2;

        const centerY =
            rect.height / 2;

        const rotateX =
            ((y - centerY) / centerY) * -5;

        const rotateY =
            ((x - centerX) / centerX) * 5;

        heroCard.style.transform =
            `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;

    });


    heroCard.addEventListener("mouseleave", () => {

        heroCard.style.transform =
            "rotateX(0) rotateY(0)";

    });

}
