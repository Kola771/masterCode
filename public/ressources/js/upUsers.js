document.addEventListener("DOMContentLoaded", () => {

    let allUsers = document.querySelector("#allUsers");
    let post = document.querySelector(".post");
    let poste = document.querySelector("#poste");
    let update = document.querySelector(".update");

    allUsers.addEventListener("change", () => {
        let data = {
            id: allUsers.value,
        }
        data = JSON.stringify(data);
        let option = {
            header: {
                content: "application/json"
            },
            body: data,
            method: "post"
        }
        fetch("?ajax=user-controller&action=get-one-user-fetch", option).then(response => response.json()).then(response => {
            if (response[0].user_role == 0) {
                post.value = "Administrateur";
            } else if (response[0].user_role == 1) {
                post.value = "Utilisateur";
            } else {
                post.value = "Rédacteur";
            }
        })
    })

    update.addEventListener("click", () => {
        let data = {
            id: allUsers.value,
            status: poste.value,
        }
        data = JSON.stringify(data);
        let option = {
            header: {
                content: "application/json"
            },
            body: data,
            method: "post"
        }
        fetch("?ajax=user-controller&action=update-one-user", option)
    })
})