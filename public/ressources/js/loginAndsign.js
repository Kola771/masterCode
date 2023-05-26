
document.addEventListener("DOMContentLoaded", () => {
    let connexion = document.getElementById("validation_connexion");
    let inscription = document.getElementById("validation_inscription");

    inscription.addEventListener("click", (e) => {
        e.preventDefault();
        let email = document.getElementById("email").value;
        let pseudo = document.getElementById("lastName").value;
        let password = document.getElementById("password").value;
        let confirm = document.getElementById("c_password").value;

        let email_error = document.getElementById("email_error");
        let name_error = document.getElementById("name_error");
        let pas_error = document.getElementById("pas_error");
        let c_pas_error = document.getElementById("c_pas_error");

        if ((pseudo !== "")) {
            if ((email !== "")) {
                if ((password !== "")) {
                    if ((confirm !== "")) {
                        if (password === confirm) {
                            let data = {
                                email: email,
                                pseudo: pseudo,
                                password: password,
                                confirm: confirm
                            }
                            data = JSON.stringify(data);
                            let option = {
                                header: {
                                    content: "application/json"
                                },
                                body: data,
                                method: "post"
                            }
                            fetch("?ajax=user-controller&action=verify-inputs", option).then(response => response.json()).then(response => {
                                if (response == "valid_input") {
                                    fetch("?ajax=user-controller&action=verify-email", option).then(response => response.json()).then(response => {

                                        if (response == "email_valid") {
                                            fetch("?ajax=user-controller&action=verify-password", option).then(response => response.json()).then(response => {
                                                if (response == "password_identique") {
                                                    fetch("?ajax=user-controller&action=pass-word", option).then(response => response.json()).then(response => {
                                                        if (response == "password_respect") {
                                                            fetch("/?ajax=user-controller&action=register", option).then(response => response.json()).then(response => {
                                                                if (response == "bad") {
                                                                    name_error.style.display = email_error.style.display = pas_error.style.display = "none"
                                                                    c_pas_error.style.display = "block"
                                                                    c_pas_error.textContent = "Un utilisateur porte l'une des informations que vous avez entré. Veuillez bien recommencer."
                                                                } else {
                                                                    name_error.style.display = email_error.style.display = pas_error.style.display = "none"
                                                                    c_pas_error.style.display = "block";
                                                                    c_pas_error.style.backgroundColor = "rgb(137 219 137)";
                                                                    c_pas_error.style.color = "#333";
                                                                    c_pas_error.style.padding = ".5em";
                                                                    c_pas_error.textContent = "Compte créé !!"
                                                                    redirect(response);
                                                                }
                                                            })
                                                        } else {
                                                            name_error.style.display = email_error.style.display = pas_error.style.display = "none"
                                                            c_pas_error.style.display = "block"
                                                            c_pas_error.textContent = "Minimum 8 caractères mélangés avec des chiffres pour le mot de passe !!"
                                                        }
                                                    })
                                                } else {
                                                    name_error.style.display = email_error.style.display = pas_error.style.display = "none"
                                                    c_pas_error.style.display = "block"
                                                    c_pas_error.textContent = "Les mots de passe ne sont pas conformes !!"
                                                }
                                            })
                                        } else {
                                            name_error.style.display = pas_error.style.display = c_pas_error.style.display = "none"
                                            email_error.style.display = "block"
                                            email_error.textContent = "L'email n'est pas correct !!"
                                        }
                                    })
                                } else {
                                    name_error.style.display = email_error.style.display = pas_error.style.display = "none"
                                    c_pas_error.style.display = "block"
                                    c_pas_error.textContent = "Veuillez bien remplir les champs !!"
                                }

                            });
                        } else {
                            name_error.style.display = email_error.style.display = pas_error.style.display = "none"
                            c_pas_error.style.display = "block"
                            c_pas_error.textContent = "Les mots de passe ne sont pas conformes !!"
                        }
                    } else {
                        name_error.style.display = email_error.style.display = pas_error.style.display = "none"
                        c_pas_error.style.display = "block"
                        c_pas_error.textContent = "Confirmez le mot de passe !!"
                    }
                } else {
                    name_error.style.display = email_error.style.display = c_pas_error.style.display = "none"
                    pas_error.style.display = "block"
                    pas_error.textContent = "Entrez votre mot de passe !!"
                }
            } else {
                name_error.style.display = pas_error.style.display = c_pas_error.style.display = "none"
                email_error.style.display = "block"
                email_error.textContent = "Entrez votre email !!"
            }
        } else {
            email_error.style.display = pas_error.style.display = c_pas_error.style.display = "none"
            name_error.style.display = "block"
            name_error.textContent = "Entrez votre pseudo !!"
        }
    })

    connexion.addEventListener("click", (e) => {
        e.preventDefault();
        let username = document.getElementById("username").value;
        let pass = document.getElementById("pass").value;
        let check = document.getElementById("check").checked;

        let uname_error = document.getElementById("uname_error");
        let upas_error = document.getElementById("upas_error");

        if ((username !== "")) {
            if ((pass !== "")) {
                if ((check === true)) {
                    let data = {
                        username: username,
                        pass: pass
                    }
                    data = JSON.stringify(data);
                    let option = {
                        header: {
                            content: "application/json"
                        },
                        body: data,
                        method: "post"
                    }
                    fetch("?ajax=login-controller&action=verify-inputs", option).then(response => response.json()).then(response => {
                        if (response == "valid_input") {
                            fetch("?ajax=login-controller&action=verify-account", option).then(response => response.json()).then(response => {
                                if (response == "mot_passe_erroné") {
                                    uname_error.style.display = "none"
                                    upas_error.style.display = "block"
                                    upas_error.textContent = "Mot de pas non-correct !!"
                                }
                                else if (response == "User_not_exist") {
                                    uname_error.style.display = "none"
                                    upas_error.style.display = "block"
                                    upas_error.textContent = "L'utilisateur n'existe pas !!"
                                }
                                else {
                                    redirect(response);
                                }
                            })
                        } else {
                            uname_error.style.display = "none"
                            upas_error.style.display = "block"
                            upas_error.textContent = "Veuillez bien remplir les champs !!"
                        }
                    })
                }
            } else {
                uname_error.style.display = "none"
                upas_error.style.display = "block"
                upas_error.textContent = "Entrez votre mot de passe !!"
            }
        } else {
            upas_error.style.display = "none"
            uname_error.style.display = "block"
            uname_error.textContent = "Entrez votre pseudo ou email !!"
        }
    })

    function redirect(url) {
        window.location.href = url;
    }

})