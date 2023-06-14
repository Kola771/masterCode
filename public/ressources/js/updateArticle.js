document.addEventListener("DOMContentLoaded", () => {
    let namefile = document.getElementById("name-file");
    let modifier = document.getElementById("modifier");
    modifier.addEventListener("click", (e) => {
        e.preventDefault();
        let myContent = tinymce.get("mytextarea").getContent();
        let etat = document.getElementById("etat");
        let title = document.getElementById("title");
        let img = document.getElementById("dropzone-file").files[0];
        if ((etat.value !== "defaut") && (title.value !== "") && (myContent !== "")) {
            if (img !== undefined) {
                let data = {
                    title: title.value,
                    id: modifier.value
                }
                data = JSON.stringify(data);
                let option = {
                    header: {
                        content: 'application/json'
                    },
                    body: data,
                    method: "post"
                }
                fetch('?ajax=article-controller&action=verify-up-art', option).then(response => response.json()).then(response => {
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
                        fetch('?ajax=article-controller&action=verify-img-up-art&img=' + namefile.value, option).then(response => response.json()).then(res => {
                            let data = {
                                title: title.value,
                                state: etat.value,
                                code_html: myContent,
                                img: res,
                                id: modifier.value
                            }
                            data = JSON.stringify(data);
                            let option = {
                                header: {
                                    content: 'application/json'
                                },
                                body: data,
                                method: "post"
                            }
                            fetch('?ajax=article-controller&action=update-one-article', option)
                            history.back();
                        })
                    } else {
                        alert("Un article porte déjà cet titre !!!")
                    }
                })
            } else {
                let data = {
                    title: title.value,
                    id: modifier.value
                }
                data = JSON.stringify(data);
                let option = {
                    header: {
                        content: 'application/json'
                    },
                    body: data,
                    method: "post"
                }
                fetch('?ajax=article-controller&action=verify-up-art', option).then(response => response.json()).then(response => {
                    if (response === "good") {
                        let data = {
                            title: title.value,
                            state: etat.value,
                            code_html: myContent,
                            id: modifier.value
                        }
                        data = JSON.stringify(data);
                        let option = {
                            header: {
                                content: 'application/json'
                            },
                            body: data,
                            method: "post"
                        }
                        fetch('?ajax=article-controller&action=update-one-article-with-out-img', option)
                        history.back();
                    } else {
                        alert("Un article porte déjà cet titre !!!")
                    }
                })
            }
        }
    })
})