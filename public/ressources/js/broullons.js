document.addEventListener("DOMContentLoaded", () => {
    let supprimes = document.querySelectorAll(".supprime");
    let publier = document.querySelectorAll(".publier");
    supprimes.forEach(sup => {
        sup.addEventListener("click", () => {
            let data = {
                id: sup.value,
            }
            data = JSON.stringify(data);
            let option = {
                header: {
                    content: "application/json"
                },
                body: data,
                method: "post"
            }
            console.log(data);
        })
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