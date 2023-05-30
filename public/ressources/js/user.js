document.addEventListener("DOMContentLoaded", () => {
    let deletes = document.querySelectorAll(".supprime");
    deletes.forEach(del => {
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
})