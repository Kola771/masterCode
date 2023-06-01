
document.addEventListener("DOMContentLoaded", () => {
    let answers = document.querySelectorAll(".answer");
    let upCom = document.querySelectorAll(".upCom");
    let upPost = document.querySelectorAll(".upPost");
    let commentPost = document.getElementById("commentPost");
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
            text.value = up.parentElement.parentElement.parentElement.children[2].textContent.trim();
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
                        text.value = up.parentElement.parentElement.parentElement.children[2].textContent.trim();
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
            
            })
        }
    })

})