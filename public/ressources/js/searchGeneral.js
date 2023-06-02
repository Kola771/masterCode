//Recherche dans les tables suivantes :
// Users
// Articles
// Contacts
// Categories
let input = document.querySelector("#searchGeneral");
let mainContain = document.querySelector(".main-contain");

document.addEventListener("DOMContentLoaded", function () {

    //au moment où on entre des caractères, la fonction s'exécute en recherchant tout les mots comportants ces caractères
    input.addEventListener("keyup", (e) => {
        e.preventDefault();
        if (input.value.trim() !== "") {
            let data = {
                value: input.value
            }
            data = JSON.stringify(data);
            let option = {
                header: {
                    content: "application/json"
                },
                body: data,
                method: "post"
            }
            fetch("?ajax=search&action=search-view", option).then(response => response.text()).then(response => {
                mainContain.innerHTML = response;
                let supprimeUser = document.querySelectorAll(".supprimeUser");
                supprimeUser.forEach(del => {
                    del.addEventListener("click", () => {
                        let parent = del.parentElement.parentElement.parentElement.parentElement;
                        let data = {
                            id: del.value,
                        }
                        data = JSON.stringify(data);
                        let option = {
                            header: {
                                content: "application/json"
                            },
                            body: data,
                            method: "post"
                        }
                        fetch("?ajax=user-controller&action=delete-one-user", option)
                        parent.remove();
                    })
                })

                let supprimerCat = document.querySelectorAll(".supprimerCat");
                supprimerCat.forEach(del => {
                    del.addEventListener("click", () => {
                        let parent = del.parentElement.parentElement.parentElement;
                        let data = {
                            id: del.value,
                        }
                        data = JSON.stringify(data);
                        let option = {
                            header: {
                                content: "application/json"
                            },
                            body: data,
                            method: "post"
                        }
                        fetch("?ajax=user-controller&action=delete-one-user", option)
                        parent.remove();
                    })
                })

                let supprimerCont = document.querySelectorAll(".supprimerCont");
                supprimerCont.forEach(del => {
                    del.addEventListener("click", () => {
                        let parent = del.parentElement.parentElement.parentElement;
                        let data = {
                            id: del.value,
                        }
                        data = JSON.stringify(data);
                        let option = {
                            header: {
                                content: "application/json"
                            },
                            body: data,
                            method: "post"
                        }
                        fetch("?ajax=user-controller&action=delete-one-user", option)
                        parent.remove();
                    })
                })

                let redirect = document.querySelector(".redirect");
                let supprimerArt = document.querySelectorAll(".supprimerArt");
                supprimerArt.forEach(sup => {
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

                let sms = document.querySelectorAll(".sms");
                sms.forEach(msg => {
                    msg.addEventListener("click", () => {
                        let data = {
                            id: msg.value,
                        }
                        data = JSON.stringify(data);
                        let option = {
                            header: {
                                content: "application/json"
                            },
                            body: data,
                            method: "post"
                        }
                        fetch("?ajax=contact-controller&action=get-one-contact-by-fetch", option).then(response => response.json()).then(response => {
                            document.querySelector(".user_name").innerHTML = response[0].contact_name;
                            document.querySelector(".user_email").innerHTML = response[0].contact_email;
                            document.querySelector(".user_text").innerHTML = response[0].contact_body;
                            document.querySelector("#id").value = response[0].contact_id;
                            document.querySelector("#email").value = response[0].contact_email;
                        })
                    })
                })

                let submitVal = document.querySelector("#submitVal");
                submitVal.addEventListener("click", (e) => {
                    e.preventDefault()
                    if (document.querySelector("#sujet").value !== "" && document.querySelector("#chat").value !== "") {
                        let data = {
                            id: document.querySelector("#id").value,
                            mail: document.querySelector("#email").value,
                            subject: document.querySelector("#sujet").value,
                            message: document.querySelector("#chat").value
                        }
                        data = JSON.stringify(data);
                        let option = {
                            header: {
                                content: "application/json"
                            },
                            body: data,
                            method: "post"
                        }
                        fetch("?ajax=contact-controller&action=send-message", option);
                        window.location.href = window.location.href;
                    }
                })

                let editer = document.querySelectorAll(".editer");
                editer.forEach(edit => {
                    edit.addEventListener("click", () => {
                        let data = {
                            id: edit.value
                        }
                        data = JSON.stringify(data);
                        let option = {
                            header: {
                                content: "application/json"
                            },
                            body: data,
                            method: "post"
                        }
                        fetch("?ajax=category-controller&action=search-one-category", option).then(response => response.json()).then(response => {
                            document.querySelector(".elem").removeAttribute("style");
                            document.querySelector("#category_names").value = response[0].category_name;
                            document.querySelector("#category_id").value = response[0].category_id;
                            document.getElementById("category_img").value = response[0].category_img;
                            document.querySelector("#category_descriptions").value = response[0].category_description;
                        })
                    })
                })

                document.querySelector(".fermer").addEventListener("click", () => {
                    document.querySelector(".elem").setAttribute("style", "display:none");
                });

                document.querySelector(".closeFermer").addEventListener("click", () => {
                    document.querySelector(".elem").setAttribute("style", "display:none");
                });

                document.querySelector("#modifer").addEventListener("click", () => {
                    let category_id = document.getElementById("category_id").value;
                    let category_img = document.getElementById("category_img").value;
                    let category_name = document.getElementById("category_names").value;
                    let category_description = document.getElementById("category_descriptions").value;
                    let data = {
                        id: category_id,
                        category_name: category_name
                    }
                    data = JSON.stringify(data);
                    let option = {
                        header: {
                            content: "application/json"
                        },
                        body: data,
                        method: "post"
                    }
                    fetch("?ajax=category-controller&action=verify-up-cat", option).then(response => response.json()).then(response => {
                        if (response === "good") {
                            let img = document.querySelector('#dropzone-files').files[0];
                            let formData = new FormData();
                            formData.append("file", img);
                            let option = {
                                header: {
                                    content: "application/json"
                                },
                                body: formData,
                                method: "post"
                            }
                            fetch("?ajax=category-controller&action=verify-img-up-cat&img=" + category_img, option).then(response => response.json()).then(res => {
                                if (response !== "Image non correcte") {
                                    let data = {
                                        id: category_id,
                                        category_name: category_name,
                                        category_description: category_description,
                                        file: res
                                    }
                                    data = JSON.stringify(data);
                                    let option = {
                                        header: {
                                            content: "application/json"
                                        },
                                        body: data,
                                        method: "post"
                                    }
                                    fetch("?ajax=category-controller&action=update-category", option)
                                    window.location.href = window.location.href;
                                }
                            })
                        }
                    })
                });
            })
        }
    })

})