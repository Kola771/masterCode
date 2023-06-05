document.addEventListener("DOMContentLoaded", () => {
    let notConnect = document.getElementById("notConnect");
    notConnect.addEventListener("click", (e) => {
        alert("Vous êtes pas connecté !!!");
    })

    
    let like = document.querySelector(".like");
    like.addEventListener("click", (e) => {
        e.preventDefault();
        alert("Vous êtes pas connecté(e) !!!");
    })
})