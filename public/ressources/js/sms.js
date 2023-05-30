
document.addEventListener("DOMContentLoaded", () => {
    let sms = document.querySelectorAll(".sms");
    let supprimer = document.querySelectorAll(".supprimer");
    let submitVal = document.querySelector("#submitVal");
    let canc = document.querySelector(".canc");
    sms.forEach(msg => {
        msg.addEventListener("click", () => {
            let data = {
                id: msg.value,
            }
            data = JSON.stringify(data);
            let option = {
                header: {
                    content: "application/json"
                },
                body: data,
                method: "post"
            }
            fetch("?ajax=contact-controller&action=get-one-contact-by-fetch", option).then(response => response.json()).then(response => {
                document.querySelector(".user_name").innerHTML = response[0].contact_name;
                document.querySelector(".user_email").innerHTML = response[0].contact_email;
                document.querySelector(".user_text").innerHTML = response[0].contact_body;
                document.querySelector("#id").value = response[0].contact_id;
                document.querySelector("#email").value = response[0].contact_email;
            })
        })
    })

    submitVal.addEventListener("click", (e) => {
        e.preventDefault()
        if (document.querySelector("#sujet").value !== "" && document.querySelector("#chat").value !== "") {
            let data = {
                id: document.querySelector("#id").value,
                mail: document.querySelector("#email").value,
                subject: document.querySelector("#sujet").value,
                message: document.querySelector("#chat").value
            }
            data = JSON.stringify(data);
            let option = {
                header: {
                    content: "application/json"
                },
                body: data,
                method: "post"
            }
            fetch("?ajax=contact-controller&action=send-message", option).then(response => response.json()).then(response => {
                redirect(response);
            })
        }
    })

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
            fetch("?ajax=contact-controller&action=delete-one-contact", option)
            parent.remove();
        })
    })

    function redirect(url) {
        window.location.href = url;
    }
})