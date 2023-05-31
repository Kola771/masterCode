
let redirect = document.querySelector(".redirect");
let categorie = document.querySelector("#categorie");
document.addEventListener("DOMContentLoaded", () => {
    redirect.addEventListener("click", (e) => {
        e.preventDefault();
        if(categorie.value !== "defaut")
        {
            let data = {
                categoryid: categorie.value
            }
            data = JSON.stringify(data);
            let options = {
                header: {
                    content: "application/json"
                },
                body: data,
                method: "post"
            }
            fetch("?ajax=article-controller&action=redirect", options).then(response => response.json()).then(response => {
                window.location.href = response;
            })
        }
    })

    let supprimes = document.querySelectorAll(".supprime");
    supprimes.forEach(sup => {
        sup.addEventListener("click", () => {
            console.log(sup);
        })
    })
})