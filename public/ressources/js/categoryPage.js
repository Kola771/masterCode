
document.addEventListener("DOMContentLoaded", () => {
    let linkcopy = document.querySelectorAll(".linkcopy");
    let likes = document.querySelectorAll(".like");
    linkcopy.forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault()
            // 1. Si le <link> n'est pas vide
            if (link.value.length) {
                // 2. On copie le texte dans le presse-papier
                navigator.clipboard.writeText(link.value).then(() => {
                    alert("Lien copié !");
                })
            }
        })
    })

    likes.forEach(like => {
        like.addEventListener("click", (e) => {
            e.preventDefault();
            fetch("?ajax=like-controller&action=add-like&articleid=" + like.children[0].value).then(response => response.json()).then(response => {
                like.innerHTML = `<button value='${like.children[0].value}' style='display:none'></button><i class="fal fa-heart"></i> ${response}`;
            })
        })
    })

    let saveData = document.querySelectorAll(".saveData");
    saveData.forEach(datas => {
        datas.addEventListener("click", (e) => {
            e.preventDefault()
            let data = {
                value: datas.value
            }
            data = JSON.stringify(data);
            let option = {
                header: {
                    content: "application/json"
                },
                body: data,
                method: "post"
            }
            fetch("?ajax=data-controller&action=add-data", option).then(response => response.json()).then(response => {
                if (response == "bad") {
                    alert("Vous avez déjà enrégistré cet article !!!");
                } else {
                    alert("Article enrégistré !!!");
                }
            })
        })
    })

    let searchInt = document.getElementById("searchInt");
    let mainArticle = document.querySelector(".mainArticle");
    //au moment où on entre des caractères, la fonction s'exécute en recherchant tout les articles comportants ces caractères dans leur titre
    searchInt.addEventListener("keyup", (e) => {
        e.preventDefault();
        if (searchInt.value.trim() !== "") {
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
            let url = window.location.href.split("&")[1];
            fetch("?ajax=article-controller&action=get-titles-article-like-by-cat&" + url, option).then(response => response.text()).then(response => {
                mainArticle.innerHTML = response;

                let linkcopy = document.querySelectorAll(".linkcopy");
                linkcopy.forEach(link => {
                    link.addEventListener("click", (e) => {
                        e.preventDefault()
                        // 1. Si le <link> n'est pas vide
                        if (link.value.length) {
                            // 2. On copie le texte dans le presse-papier
                            navigator.clipboard.writeText(link.value).then(() => {
                                alert("Lien copié !");
                            })
                        }
                    })
                })

                let likes = document.querySelectorAll(".like");
                likes.forEach(like => {
                    like.addEventListener("click", (e) => {
                        e.preventDefault();
                        fetch("?ajax=like-controller&action=add-like&articleid=" + like.children[0].value).then(response => response.json()).then(response => {
                            like.innerHTML = `<button value='${like.children[0].value}' style='display:none'></button><i class="fal fa-heart"></i> ${response}`;
                        })
                    })
                })

                let saveData = document.querySelectorAll(".saveData");
                saveData.forEach(datas => {
                    datas.addEventListener("click", (e) => {
                        e.preventDefault()
                        let data = {
                            value: datas.value
                        }
                        data = JSON.stringify(data);
                        let option = {
                            header: {
                                content: "application/json"
                            },
                            body: data,
                            method: "post"
                        }
                        fetch("?ajax=data-controller&action=add-data", option).then(response => response.json()).then(response => {
                            if (response == "bad") {
                                alert("Vous avez déjà enrégistré cet article !!!");
                            } else {
                                alert("Article enrégistré !!!");
                            }
                        })
                    })
                })
            })
        }
    })
})