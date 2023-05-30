
document.addEventListener("DOMContentLoaded", () => {
    let validation = document.getElementById("validation_category");
    let editer = document.querySelectorAll(".editer");
    let supprimer = document.querySelectorAll(".supprimer");

    let modif = document.querySelector(".modif");
    validation.addEventListener("click", (e) => {
        e.preventDefault();
        let category_name = document.getElementById("category_name").value;
        let category_description = document.getElementById("category_description").value;
        if ((category_name.trim() !== "") && (category_description.trim() !== "")) {
            let img = document.getElementById("dropzone-file").files[0];

            let data = {
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

            fetch("?ajax=category-controller&action=verify-category", option).then(response => response.json()).then(response => {
                if (response === "good") {
                    let formData = new FormData();
                    formData.append("file", img);
                    let option = {
                        header: {
                            content: "application/json"
                        },
                        body: formData,
                        method: "post"
                    }
                    fetch("?ajax=category-controller&action=verify-img-category", option).then(response => response.json()).then(res => {
                        if (response !== "Image non correcte") {
                            let data = {
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
                            fetch("?ajax=category-controller&action=add-category", option).then(response => response.json()).then(resp => {
                                redirect(resp);
                            })
                        }
                    })
                }
            })
        }
    })

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
            if(response === "good")
            {
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
                        fetch("?ajax=category-controller&action=update-category", option).then(response => response.json()).then(resp => {
                            redirect(resp);
                        })
                    }
                })
            }
        })
    });

    supprimer.forEach(el => {
        el.addEventListener("click", (e) => {
            e.preventDefault();
            let parent = el.parentElement.parentElement.parentElement;
            let data = {
                id: el.value
            }
            data = JSON.stringify(data);
            let option = {
                header: {
                    content: "application/json"
                },
                body: data,
                method: "post"
            }
            fetch("?ajax=category-controller&action=delete-one-category", option)
            parent.remove();
        })
    })

    function redirect(url) {
        window.location.href = url;
    }

})