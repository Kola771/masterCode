
document.addEventListener("DOMContentLoaded", () => {
    let answers = document.querySelectorAll(".answer");
    let upCom = document.querySelectorAll(".upCom");
    let upPost = document.querySelectorAll(".upPost");
    let del = document.querySelectorAll(".del");
    let like = document.querySelector(".like");
    let delPost = document.querySelectorAll(".delPost");
    let commentPost = document.getElementById("commentPost");
    let numCom = document.getElementById("numCom");
    let sendComment = document.getElementById("sendComment");
    let childPostParagraph = document.querySelectorAll(".childPost>p");

    childPostParagraph.forEach(paragraph => {
        let text = paragraph.textContent;
        let regex = /@\w+/g;
        let tabs = text.matchAll(regex);
        let tableau = [];
        for (tab of tabs) {
            tableau.push(tab[0]);
        }
        for (let i = 0; i < tableau.length; i++) {
            paragraph.innerHTML = paragraph.innerHTML.replace(tableau[i], `<span style ="font-weight: bold; color: #004E87;">${tableau[i]}</span>`)
        }
    })

    answers.forEach(answer => {
        answer.addEventListener("click", () => {
            let title = answer.parentElement.parentElement.children[0];
            commentPost.value = "@" + title.textContent.trim();
        })
    })

    upCom.forEach(up => {
        up.addEventListener("click", (e) => {
            e.preventDefault()
            up.style.display = "none";
            up.nextElementSibling.style.display = "block";
            let form = up.parentElement.parentElement.parentElement.children[1];
            let text = up.parentElement.parentElement.parentElement.children[1].children[0];
            form.style.display = "block";
            up.parentElement.parentElement.parentElement.children[2].style.display = "none";
            up.parentElement.parentElement.parentElement.children[3].style.display = "none";
            text.innerHTML = up.parentElement.parentElement.parentElement.children[2].textContent.trim();
        })
    })

    upPost.forEach(up => {
        up.addEventListener("click", (e) => {
            e.preventDefault()
            up.style.display = "none";
            up.previousElementSibling.style.display = "block";
            let form = up.parentElement.parentElement.parentElement.children[1];
            let text = up.parentElement.parentElement.parentElement.children[1].children[0];
            form.style.display = "none";
            up.parentElement.parentElement.parentElement.children[2].innerText = text.value;
            up.parentElement.parentElement.parentElement.children[2].style.display = "block";
            up.parentElement.parentElement.parentElement.children[3].style.display = "block";
            let data = {
                body: text.value,
                id: up.value
            }
            data = JSON.stringify(data);
            let option = {
                header: {
                    content: "application/json"
                },
                body: data,
                method: "post"
            }
            fetch("?ajax=comment-controller&action=up-comment", option)
        })
    })

    del.forEach(el => {
        el.addEventListener("click", (e) => {
            e.preventDefault()
            let parent = el.parentElement.parentElement.parentElement.parentElement.parentElement;
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
            fetch("?ajax=comment-controller&action=delete-one-comment", option);
            let number = Number(numCom.innerText.split(" ")[0]) - 1;
            numCom.textContent = number + " posts"
            parent.remove();
        })
    })

    like.addEventListener("click", (e) => {
        e.preventDefault()
        let data = {
            id: like.value
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
        fetch("?ajax=like-controller&action=add-like&" + url, option).then(response => response.json()).then(response => {
            document.getElementById("numLike").textContent = response + " like(s)"
        })
    })

    delPost.forEach(el => {
        el.addEventListener("click", (e) => {
            e.preventDefault()
            let parent = el.parentElement.parentElement.parentElement.parentElement.parentElement;
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
            fetch("?ajax=comment-controller&action=delete-one-comment", option);
            let number = Number(numCom.innerText.split(" ")[0]) - 1;
            numCom.textContent = number + " posts"
            parent.remove();
        })
    })

    sendComment.addEventListener("click", (e) => {
        e.preventDefault();
        if (commentPost.value !== "") {
            let data = {
                body: commentPost.value
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
            let overPost = document.querySelector(".overPost");
            fetch("?ajax=comment-controller&action=add-comment&" + url, option).then(response => response.text()).then(response => {
                commentPost.value = "Laissez un commentaire";
                let numCom = document.getElementById("numCom");
                let number = Number(numCom.innerText.split(" ")[0]) + 1;
                numCom.textContent = number + " posts"

                overPost.innerHTML = response;
                let childPostParagraph = document.querySelectorAll(".childPost>p");
                childPostParagraph.forEach(paragraph => {
                    let text = paragraph.textContent;
                    let regex = /@\w+/g;
                    let tabs = text.matchAll(regex);
                    let tableau = [];
                    for (tab of tabs) {
                        tableau.push(tab[0]);
                    }
                    for (let i = 0; i < tableau.length; i++) {
                        paragraph.innerHTML = paragraph.innerHTML.replace(tableau[i], `<span style ="font-weight: bold; color: #004E87;">${tableau[i]}</span>`)
                    }
                })
                let ans = document.querySelectorAll(".answer");
                ans.forEach(answer => {
                    answer.addEventListener("click", () => {
                        let title = answer.parentElement.parentElement.children[0];
                        commentPost.value = "@" + title.textContent.trim();
                    })
                })
                let upCom = document.querySelectorAll(".upCom");
                let upPost = document.querySelectorAll(".upPost");
                upCom.forEach(up => {
                    up.addEventListener("click", (e) => {
                        e.preventDefault()
                        up.style.display = "none";
                        up.nextElementSibling.style.display = "block";
                        let form = up.parentElement.parentElement.parentElement.children[1];
                        let text = up.parentElement.parentElement.parentElement.children[1].children[0];
                        form.style.display = "block";
                        up.parentElement.parentElement.parentElement.children[2].style.display = "none";
                        up.parentElement.parentElement.parentElement.children[3].style.display = "none";
                        text.innerHTML = up.parentElement.parentElement.parentElement.children[2].textContent.trim();
                    })
                })

                upPost.forEach(up => {
                    up.addEventListener("click", (e) => {
                        e.preventDefault()
                        up.style.display = "none";
                        up.previousElementSibling.style.display = "block";
                        let form = up.parentElement.parentElement.parentElement.children[1];
                        let text = up.parentElement.parentElement.parentElement.children[1].children[0];
                        form.style.display = "none";
                        up.parentElement.parentElement.parentElement.children[2].innerText = text.value;
                        up.parentElement.parentElement.parentElement.children[2].style.display = "block";
                        up.parentElement.parentElement.parentElement.children[3].style.display = "block";
                        let data = {
                            body: text.value,
                            id: up.value
                        }
                        data = JSON.stringify(data);
                        let option = {
                            header: {
                                content: "application/json"
                            },
                            body: data,
                            method: "post"
                        }
                        fetch("?ajax=comment-controller&action=up-comment", option)
                    })
                })
                let del = document.querySelectorAll(".del");
                del.forEach(el => {
                    el.addEventListener("click", (e) => {
                        e.preventDefault()
                        let parent = el.parentElement.parentElement.parentElement.parentElement.parentElement;
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
                        fetch("?ajax=comment-controller&action=delete-one-comment", option);
                        let number = Number(numCom.innerText.split(" ")[0]) - 1;
                        numCom.textContent = number + " posts"
                        parent.remove();
                    })
                })

                let delPost = document.querySelectorAll(".delPost");
                delPost.forEach(el => {
                    el.addEventListener("click", (e) => {
                        e.preventDefault()
                        let parent = el.parentElement.parentElement.parentElement.parentElement.parentElement;
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
                        fetch("?ajax=comment-controller&action=delete-one-comment", option);
                        let number = Number(numCom.innerText.split(" ")[0]) - 1;
                        numCom.textContent = number + " posts"
                        parent.remove();
                    })
                })

            })
        }
    })

})