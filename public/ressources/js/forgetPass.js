
document.addEventListener("DOMContentLoaded", () => {
    let v_email = document.getElementById("validation_email");
    let v_pass = document.getElementById("validation_password");
    let email_error = document.getElementById("email_error");
    let email_code_error = document.getElementById("email_code_error");
    let pas_error = document.getElementById("pas_error");
    let c_pas_error = document.getElementById("c_pas_error");

    v_email.addEventListener("click", (e) => {
        let email = document.getElementById("useremail").value;
        e.preventDefault();
        if (email !== "") {
            let data = {
                email: email
            }
            data = JSON.stringify(data);
            let option = {
                header: {
                    content: "application/json"
                },
                body: data,
                method: "post"
            };
            fetch("?ajax=forget-controller&action=verify-email-inputs", option).then(response => response.json()).then(response => {
                if (response == "valid_email_input") {
                    fetch("?ajax=forget-controller&action=verify-email", option).then(response => response.json()).then(response => {
                        if (response == "email_valid") {
                            fetch("?ajax=forget-controller&action=update", option).then(response => response.json()).then(response => {
                                if (response === null) {
                                    document.getElementById("useremail").setAttribute("readonly", "");
                                    email_error.style.display = "none";
                                    document.querySelector(".forget1").style.display = "block";
                                    v_email.style.display = "none";
                                }
                                else {
                                    console.log("Une erreur est subvenue, veuilez réessayer!!");
                                }
                            })
                        } else {
                            email_error.style.display = "block";
                            email_error.textContent = "Email non-correct !!";
                        }
                    })
                } else {
                    email_error.style.display = "block";
                    email_error.textContent = "Veuillez bien remplir le champs!!";
                }
            })
        } else {
            email_error.style.display = "block";
            email_error.textContent = "Veuillez bien remplir le champs!!";
        }
    })

    let code_email = document.getElementById("email_code");
    code_email.addEventListener("keyup", (e) => {
        let email = document.getElementById("useremail").value;
        let email_code = document.getElementById("email_code").value
        if (email_code.trim() !== "") {
            let data = {
                email: email,
                email_code: email_code
            }
            data = JSON.stringify(data);
            let option = {
                header: {
                    content: "application/json"
                },
                body: data,
                method: "post"
            }
            fetch("?ajax=forget-controller&action=code-email", option).then(response => response.json()).then(response => {
                if (response === "good") {
                    email_code_error.style.display = "none";
                    document.getElementById("email_code").setAttribute("readonly", "");
                    document.querySelector(".forget2").style = "display:block";
                    document.querySelector(".forget3").style = "display:block";
                    document.querySelector(".forget4").style = "display:block";
                } else {
                    email_code_error.style.display = "block";
                    email_code_error.textContent = "Le code n'est pas correct !!!";
                }
            })
        }
    })

    v_pass.addEventListener("click", (e) => {
        e.preventDefault();
        let pass = document.getElementById("mdp").value;
        let new_pass = document.getElementById("new_mdp").value;
        let email = document.getElementById("useremail").value;
        if ((pass !== "")) {
            if ((new_pass !== "")) {
                let data = {
                    email: email,
                    pass: pass,
                    new_pass: new_pass
                }
                data = JSON.stringify(data);
                let option = {
                    header: {
                        content: "application/json"
                    },
                    body: data,
                    method: "post"
                }
                fetch("?ajax=forget-controller&action=new-empty-pass", option).then(response => response.json()).then(response => {
                    if (response === "valid_input") {
                        fetch("?ajax=forget-controller&action=verify-pass-word", option).then(response => response.json()).then(response => {
                            if (response === "password_identique") {
                                fetch("?ajax=forget-controller&action=pass-word", option).then(response => response.json()).then(response => {
                                    if (response === "password_respect") {
                                        fetch("?ajax=forget-controller&action=update-pass", option).then(response => response.json()).then(response => {
                                            if (response === "bad") {
                                                pas_error.style.display = "none"
                                                c_pas_error.style.display = "block"
                                                c_pas_error.textContent = "Une erreur est subvenue lors de l'éxécution. Veuillez essayer plus !!!"
                                            } else {
                                                redirect(response);
                                            }
                                        })
                                    } else {
                                        pas_error.style.display = "none"
                                        c_pas_error.style.display = "block"
                                        c_pas_error.textContent = "Minimum 8 caractères mélangés avec des chiffres pour le mot de passe !!"
                                    }
                                })
                            } else {
                                pas_error.style.display = "none"
                                c_pas_error.style.display = "block"
                                c_pas_error.textContent = "Les mots de passe ne sont pas identiques !!!"
                            }
                        })
                    } else {
                        pas_error.style.display = "none"
                        c_pas_error.style.display = "block"
                        c_pas_error.textContent = "Veuillez bien remplir les champs !!"
                    }
                })
            } else {
                pas_error.style.display = "none"
                c_pas_error.style.display = "block"
                c_pas_error.textContent = "Confirmez le nouveau mot de passe !!"
            }
        } else {
            c_pas_error.style.display = "none"
            pas_error.style.display = "block"
            pas_error.textContent = "Entrez votre nouveau mot de passe !!"
        }
    })

    function redirect(url) {
        window.location.href = url;
    }
})