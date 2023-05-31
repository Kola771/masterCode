document.addEventListener("DOMContentLoaded", () => {
    let supprimes = document.querySelectorAll(".supprime");
    let publier = document.querySelectorAll(".publier");
    let redirect = document.querySelector(".redirect");
    supprimes.forEach(sup => {
        sup.addEventListener("click", () => {
            redirect.value = sup.value;
        })
    })

    redirect.addEventListener("click", () => {
        let data = {
            id: redirect.value,
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
    
    publier.forEach(pub => {
        pub.addEventListener("click", () => {
            let parent = pub.parentElement.parentElement.parentElement;
            let data = {
                id: pub.value,
            }
            data = JSON.stringify(data);
            let option = {
                header: {
                    content: "application/json"
                },
                body: data,
                method: "post"
            }
            fetch("?ajax=article-controller&action=update-state", option)
            parent.remove();
        })
    })
})