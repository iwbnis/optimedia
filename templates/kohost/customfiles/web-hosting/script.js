const templateGallery = document.querySelector(".templates-gallery");

const popupContainer = document.querySelector(".popup-container");
const btnBuy = document.querySelector(".content-details .btn-buy");
const popupFrame = document.querySelector(".popup-container iframe");
let closePopup = document.getElementById("popup-close");

function closePopupFunc(e) {
    if (e.target.nodeName === "BUTTON" || e.target.classList.contains("popup-container")) {
        popupContainer.classList.remove("active");
        document.body.style.overflow = "auto";
        popupFrame.src = "";
        btnBuy.src = "";
    }
}
closePopup.addEventListener("click", (e) => closePopupFunc(e));
popupContainer.addEventListener("click", (e) => closePopupFunc(e));

templateGallery.addEventListener("click", (e) => {
    let id = e.target.dataset.id;
    if (id) {
        const link = `https://optimedia.tv/reseller-templates/template${id}/`;
        // const link = "https://www.elegantthemes.com/gallery/divi/";
        btnBuy.href = e.target.nextElementSibling.href;
        popupContainer.classList.add("active");
        document.body.style.overflow = "hidden";
        popupFrame.src = link;
    }
});
