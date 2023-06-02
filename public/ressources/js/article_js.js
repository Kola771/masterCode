
document.addEventListener("DOMContentLoaded", () => {
    let redirect = document.querySelector(".redirect");
    let categorie = document.querySelector("#categorie");
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

    let redirects = document.querySelector(".redirects");
    let supprimes = document.querySelectorAll(".supprime");
    supprimes.forEach(sup => {
        sup.addEventListener("click", () => {
            redirects.value = sup.value;
        })
    })
    
    redirects.addEventListener("click", () => {
        let data = {
            id: redirects.value,
        }
        data = JSON.stringify(data);
        let option = {
            header: {
                content: "application/json"
            },
            body: data,
            method: "post"
        }
        fetch("?ajax=article-controller&action=delete-one-article", option)
        window.location.href = window.location.href;
    })
    
})