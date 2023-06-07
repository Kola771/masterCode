
document.addEventListener("DOMContentLoaded", () => {
    let input = document.getElementById("dtime");
    let conPost = document.querySelector(".conPost");
    input.addEventListener("change", () => {
        let data = {
            value: input.value
        };
        data = JSON.stringify(data);
        let option = {
            header: {
                content: "application/json"
            },
            body: data,
            method: "post"
        }
        fetch("?ajax=comment-controller&action=getAllCommentTriTarById", option).then(response => response.text()).then(response => {
            conPost.innerHTML = response
        })
    })
})