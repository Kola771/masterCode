document.addEventListener("DOMContentLoaded", () => {
    let valider = document.getElementById("enregistrer");
    valider.addEventListener("click", (e) => {
        e.preventDefault();
        let myContent = tinymce.get("mytextarea").getContent();
        let etat = document.getElementById("etat");
        let title = document.getElementById("title");
        let img = document.getElementById("dropzone-file").files[0];
        if ((etat.value !== "defaut") && (title.value !== "") && (myContent !== "")) {
            let data = {
                title: title.value
            }
            data = JSON.stringify(data);
            let option = {
                header: {
                    content: 'application/json'
                },
                body: data,
                method: "post"
            }
            fetch('?ajax=article-controller&action=verify-title', option).then(response => response.json()).then(response => {
                if (response === "good") {
                    let dataImg = new FormData();
                    dataImg.append("file", img);
                    let option = {
                        header: {
                            content: 'application/json'
                        },
                        body: dataImg,
                        method: "post"
                    }
                    fetch('?ajax=article-controller&action=verify-img-articles', option).then(response => response.json()).then(res => {
                        let data = {
                            title: title.value,
                            state: etat.value,
                            code_html: myContent,
                            img: res
                        }
                        data = JSON.stringify(data);
                        let option = {
                            header: {
                                content: 'application/json'
                            },
                            body: data,
                            method: "post"
                        }
                        let url = window.location.href.split("&");
                        fetch('?ajax=article-controller&action=add-articles&' + url[1], option).then(response => response.json()).then(response => {
                            redirect(response);
                        })
                    })
                }
            })
        }
    })

    function redirect(url) {
        window.location.href = url;
    }
})