
document.addEventListener("DOMContentLoaded", () => {
    let searchInt = document.getElementById("searchInt");
    let mainArticle = document.querySelector(".mainArticle");
     //au moment où on entre des caractères, la fonction s'exécute en recherchant tout les articles comportants ces caractères dans leur titre
     searchInt.addEventListener("keyup", (e) => {
        e.preventDefault();
        if(searchInt.value.trim() !== "") {
            let data = {
                value: searchInt.value
            }
            data = JSON.stringify(data);
            let option = {
                header: {
                    content: "application/json"
                },
                body: data,
                method: "post"
            }
            fetch("?ajax=article-controller&action=get-titles-article-like", option).then(response => response.text()).then(response => {
                mainArticle.innerHTML = response;
            })
        }
    })
})