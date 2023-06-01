
document.addEventListener("DOMContentLoaded", () => {
    let answers = document.querySelectorAll(".answer");
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
            let title = answer.parentElement.parentElement.children[0].children[0];
            commentPost.value = "@" + title.textContent;
        })
    })

    sendComment.addEventListener("click", (e) => {
        e.preventDefault();
        if(commentPost.value !== "")
        {
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
            console.log(url);
            fetch("?ajax=comment-controller&action=add-comment&" + url, option)
        }
    })
})