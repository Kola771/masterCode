
document.addEventListener("DOMContentLoaded", () => {
    let answers = document.querySelectorAll(".answer");
    let commentPost = document.getElementById("commentPost");
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
})